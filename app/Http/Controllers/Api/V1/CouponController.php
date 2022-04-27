<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Coupon;
use App\Model\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function list()
    {
        try {
            $coupon = Coupon::active()->get();
            return response()->json($coupon, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function apply(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if ($validator->errors()->count()>0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        try {
            $coupon = Coupon::active()->where(['code' => $request['code']])->first();
            if (isset($coupon)) {
                if ($coupon['limit'] == null) {
                    return response()->json($coupon, 200);
                } else {
                    $total = Order::where(['user_id' => $request->user()->id, 'coupon_code' => $request['code']])->count();
                    if ($total < $coupon['limit']) {
                        return response()->json($coupon, 200);
                    }else{
                        return response()->json([
                            'errors' => [
                                ['code' => 'coupon', 'message' => trans('custom.coupon_limit_over')]
                            ]
                        ], 401);
                    }
                }

            } else {
                return response()->json([
                    'errors' => [
                        ['code' => 'coupon', 'message' => trans('custom.coupon_not_found')]
                    ]
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }
}
