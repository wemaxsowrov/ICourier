<?php

namespace Database\Seeders;

use App\Models\Backend\MerchantSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchantSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //======================== ======================== ======================== ======================== ========================
        //======================== ======================== Merchant payment setup   ======================== ========================
        //======================== ======================== ======================== ======================== ========================
        //======================== ======================== ======================== ======================== ========================

        //===== Merchant  payment setup ========================

        //stripe
        MerchantSetting::create(['merchant_id'=>1,'key' => 'stripe_publishable_key',     'value' => 'your publishable key']);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'stripe_secret_key',          'value' => 'your secret key']);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'stripe_status',              'value' => 1]);

        //sslcommerz
        MerchantSetting::create(['merchant_id'=>1,'key' => 'sslcommerz_store_id',        'value' => 'your store id ']);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'sslcommerz_store_password',  'value' => 'your store password']);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'sslcommerz_testmode',        'value' => 1]);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'sslcommerz_status',          'value' => 1]);

        //paypal
        MerchantSetting::create(['merchant_id'=>1,'key' => 'paypal_client_id',              'value' => 'your client id']);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'paypal_client_secret',          'value' => 'your client secret']);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'paypal_mode',                   'value' => 'sendbox']);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'paypal_status',                 'value' => 1]);

        //Razorpay
        MerchantSetting::create(['merchant_id'=>1,'key' => 'razorpay_key',               'value' => '']);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'razorpay_secret',            'value' => '']);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'razorpay_status',            'value' => 1]);


        //skrill
        MerchantSetting::create(['merchant_id'=>1,'key' => 'skrill_merchant_email',         'value' => 'demoqco@sun-fish.com']);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'skrill_status',                 'value' => 1]);


        // //bkash
        MerchantSetting::create(['merchant_id'=>1,'key' => 'bkash_app_id',              'value' => 'application id']);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'bkash_app_secret',          'value' => 'application secret key']);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'bkash_username',            'value' => 'username']);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'bkash_password',            'value' => 'password']);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'bkash_test_mode',           'value' => 1]);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'bkash_status',              'value' => 1]);


        //aamar pay
        MerchantSetting::create(['merchant_id'=>1,'key' => 'aamarpay_store_id',        'value' => 'aamarypay']);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'aamarpay_signature_key',   'value' => '28c78bb1f45112f5d40b956fe104645a']);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'aamarpay_sendbox_mode',    'value' => 1]);
        MerchantSetting::create(['merchant_id'=>1,'key' => 'aamarpay_status',          'value' => 1]);


        //===== Merchant payment  setup ==================================
    }
}
