<?php

namespace App\Http\Controllers;

use App\CentralLogics\Helpers;
use App\Model\Order;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Paystack;

class PaystackController extends Controller
{
    public function redirectToGateway(Request $request)
    {
        try {
            $order = Order::with(['details'])->where(['id' => $request['orderID']])->first();
            DB::table('orders')
                ->where('id', $order['id'])
                ->update([
                    'payment_method' => 'paystack',
                    'order_status' => 'failed',
                    'transaction_reference' => $request['reference'],
                    'updated_at' => now(),
                ]);

            return Paystack::getAuthorizationUrl()->redirectNow();
        } catch (\Exception $e) {
            Toastr::error('Your currency is not supported by Paystack.');
            return Redirect::back();
        }
    }

    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();
        $order = Order::where(['transaction_reference' => $paymentDetails['data']['reference']])->first();
        if ($paymentDetails['status'] == true) {
            DB::table('orders')
                ->where('transaction_reference', $paymentDetails['data']['reference'])
                ->update(['order_status' => 'confirmed', 'payment_status' => 'paid']);
            try {
                $fcm_token = $order->customer->cm_firebase_token;
                $value = Helpers::order_status_update_message('confirmed');
                if ($value) {
                    $data = [
                        'title' => 'Order',
                        'description' => $value,
                        'order_id' => $order['id'],
                        'image' => '',
                    ];
                    Helpers::send_push_notif_to_device($fcm_token, $data);
                }
            } catch (\Exception $e) {}
            if ($order->callback != null) {
                return redirect($order->callback . '/success');
            }else{
                return \redirect()->route('payment-success');
            }
        } else {
            if ($order->callback != null) {
                return redirect($order->callback . '/fail');
            }else{
                return \redirect()->route('payment-fail');
            }
        }
    }
}
