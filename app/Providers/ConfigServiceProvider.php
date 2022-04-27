<?php

namespace App\Providers;

use App\CentralLogics\Helpers;
use App\Model\BusinessSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $mode = env('APP_MODE');

        try {
            $emailServices = Helpers::get_business_settings('mail_config');
            if ($emailServices) {
                $config = array(
                    'driver' => $emailServices['driver'],
                    'host' => $emailServices['host'],
                    'port' => $emailServices['port'],
                    'username' => $emailServices['username'],
                    'password' => $emailServices['password'],
                    'encryption' => $emailServices['encryption'],
                    'from' => array('address' => $emailServices['email_id'], 'name' => $emailServices['name']),
                    'sendmail' => '/usr/sbin/sendmail -bs',
                    'pretend' => false,
                );
                Config::set('mail', $config);
            }

            $ssl = Helpers::get_business_settings('ssl_commerz_payment');
            if ($ssl) {
                if ($mode == 'live') {
                    $url = "https://securepay.sslcommerz.com";
                    $host = false;
                }else{
                    $url = "https://sandbox.sslcommerz.com";
                    $host = true;
                }
                $config = array(
                    'projectPath' => env('PROJECT_PATH'),
                    'apiDomain' => env("API_DOMAIN_URL", $url),
                    'apiCredentials' => [
                        'store_id' => $ssl['store_id'],
                        'store_password' => $ssl['store_password'],
                    ],
                    'apiUrl' => [
                        'make_payment' => "/gwprocess/v4/api.php",
                        'transaction_status' => "/validator/api/merchantTransIDvalidationAPI.php",
                        'order_validate' => "/validator/api/validationserverAPI.php",
                        'refund_payment' => "/validator/api/merchantTransIDvalidationAPI.php",
                        'refund_status' => "/validator/api/merchantTransIDvalidationAPI.php",
                    ],
                    'connect_from_localhost' => env("IS_LOCALHOST", $host), // For Sandbox, use "true", For Live, use "false"
                    'success_url' => '/success',
                    'failed_url' => '/fail',
                    'cancel_url' => '/cancel',
                    'ipn_url' => '/ipn',
                );
                Config::set('sslcommerz', $config);
            }

            $paypal = Helpers::get_business_settings('paypal');
            if ($paypal) {

                if ($mode == 'live') {
                    $paypal_mode="live";
                }else{
                    $paypal_mode="sandbox";
                }

                $config = array(
                    'client_id' => $paypal['paypal_client_id'], // values : (local | production)
                    'secret' => $paypal['paypal_secret'],
                    'settings' => array(
                        'mode' => env('PAYPAL_MODE', $paypal_mode), //live||sandbox
                        'http.ConnectionTimeOut' => 30,
                        'log.LogEnabled' => true,
                        'log.FileName' => storage_path() . '/logs/paypal.log',
                        'log.LogLevel' => 'ERROR'
                    ),
                );
                Config::set('paypal', $config);
            }

            $razor = Helpers::get_business_settings('razor_pay');
            if ($razor) {
                $config = array(
                    'razor_key' => env('RAZOR_KEY', $razor['razor_key']),
                    'razor_secret' => env('RAZOR_SECRET', $razor['razor_secret'])
                );
                Config::set('razor', $config);
            }

            $paystack = Helpers::get_business_settings('paystack');

            if ($paystack) {
                $config = array(
                    'publicKey' => env('PAYSTACK_PUBLIC_KEY', $paystack['publicKey']),
                    'secretKey' => env('PAYSTACK_SECRET_KEY', $paystack['secretKey']),
                    'paymentUrl' => env('PAYSTACK_PAYMENT_URL', $paystack['paymentUrl']),
                    'merchantEmail' => env('MERCHANT_EMAIL', $paystack['merchantEmail']),
                );
                Config::set('paystack', $config);
            }

            $flutterwave = Helpers::get_business_settings('flutterwave');
            if ($flutterwave) {
                $config = array(
                    'publicKey' => env('FLW_PUBLIC_KEY', $flutterwave['public_key']), // values : (local | production)
                    'secretKey' => env('FLW_SECRET_KEY', $flutterwave['secret_key']),
                    'secretHash' => env('FLW_SECRET_HASH', $flutterwave['hash']),
                );
                Config::set('flutterwave', $config);
            }


        } catch (\Exception $ex) {

        }
    }
}
