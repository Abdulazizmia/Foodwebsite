<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\CentralLogics\Helpers;
use App\CentralLogics\SMS_module;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    public function reset_password_request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_or_phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $customer = User::where(['email' => $request['email_or_phone']])
            ->orWhere('phone', 'like', "%{$request['email_or_phone']}%")->first();

        $send_by_phone = Helpers::get_business_settings('phone_verification');

        if (isset($customer)) {
            $token = rand(1000, 9999);
            DB::table('password_resets')->insert([
                'email_or_phone' => $request['email_or_phone'],
                'token' => $token,
                'created_at' => now(),
            ]);

            if ($send_by_phone) {
                $response = SMS_module::send($customer['phone'], $token);
                return response()->json([
                    'message' => $response
                ], 200);
            }

            try {
                Mail::to($customer['email'])->send(new \App\Mail\PasswordResetMail($token));
            } catch (\Exception $exception) {
                return response()->json(['errors' => [
                    ['code' => 'config-missing', 'message' => 'Email configuration issue.']
                ]], 400);
            }

            return response()->json(['message' => 'Email sent successfully.'], 200);
        }
        return response()->json(['errors' => [
            ['code' => 'not-found', 'message' => 'Customer not found!']
        ]], 404);
    }

    public function verify_token(Request $request)
    {
        $data = DB::table('password_resets')->where(['token' => $request['reset_token'], 'email_or_phone' => $request['email_or_phone']])->first();
        if (isset($data)) {
            return response()->json(['message' => "Token found, you can proceed"], 200);
        }
        return response()->json(['errors' => [
            ['code' => 'invalid', 'message' => 'Invalid token.']
        ]], 400);
    }

    public function reset_password_submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_or_phone' => 'required',
            'reset_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $data = DB::table('password_resets')->where(['email_or_phone' => $request['email_or_phone']])
            ->where(['token' => $request['reset_token']])->first();

        if (isset($data)) {

            if ($request['password'] == $request['confirm_password']) {
                $customer = User::where(['email' => $request['email_or_phone']])->orWhere('phone', $request['email_or_phone'])->first();
                $customer->password = bcrypt($request['confirm_password']);
                $customer->save();

                DB::table('password_resets')
                    ->where(['email_or_phone' => $request['email_or_phone']])
                    ->where(['token' => $request['reset_token']])->delete();

                return response()->json(['message' => 'Password changed successfully.'], 200);
            }
            return response()->json(['errors' => [
                ['code' => 'mismatch', 'message' => 'Password did,t match!']
            ]], 401);
        }
        return response()->json(['errors' => [
            ['code' => 'invalid', 'message' => 'Invalid token.']
        ]], 400);
    }
}
