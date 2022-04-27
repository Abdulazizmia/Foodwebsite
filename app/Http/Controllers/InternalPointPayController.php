<?php

namespace App\Http\Controllers;

use App\Model\BusinessSetting;
use App\Model\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InternalPointPayController extends Controller
{
    public function payment(Request $request)
    {
        $order = Order::find($request['order_id']);

        if (isset($order) && $order['payment_status'] == 'unpaid') {

            $user = User::find($order['user_id']);
            $value = BusinessSetting::where(['key' => 'point_per_currency'])->first()->value;
            $order_point = $order['order_amount'] * $value;

            if ($order['order_amount'] <= $order_point) {
                User::where(['id' => $user['id']])->decrement('point', $order_point);
                $tr_ref = 'payment_' . Str::random('15');
                DB::table('orders')
                    ->where('id', $order['id'])
                    ->update([
                        'payment_method' => 'internal_point',
                        'transaction_reference' => $tr_ref,
                        'order_status' => 'confirmed',
                        'payment_status' => 'paid',
                        'updated_at' => now(),
                    ]);
                DB::table('point_transitions')->insert([
                    'user_id' => $user['id'],
                    'description' => 'paid for order ID : ' . $order['id'] . '.',
                    'type' => 'point_out',
                    'amount' => $order_point,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                if ($order->callback != null) {
                    return redirect($order->callback . '/success');
                } else {
                    return \redirect()->route('payment-success');
                }
            }
        }

        if (isset($order) && $order->callback != null) {
            return redirect($order->callback . '/fail');
        } else {
            return \redirect()->route('payment-fail');
        }
    }
}
