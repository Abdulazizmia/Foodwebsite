<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SenangPayController extends Controller
{
    public function return_senang_pay(Request $request)
    {
        $order = Order::where(['id' => $request['order_id']])->first();
        if ($request['status_id'] == 1) {
            DB::table('orders')
                ->where('id', $request['order_id'])
                ->update([
                    'payment_method'        => 'senang_pay',
                    'transaction_reference' => $request['transaction_id'],
                    'order_status'          => 'confirmed',
                    'order_note'            => 'Senang pay, Hash : ' . $request['hash'],
                    'payment_status'        => 'paid',
                    'updated_at'            => now(),
                ]);
            if ($order->callback != null) {
                return redirect($order->callback . '/success');
            } else {
                return \redirect()->route('payment-success');
            }
        }

        if ($order->callback != null) {
            return redirect($order->callback . '/fail');
        } else {
            return \redirect()->route('payment-fail');
        }
    }
}
