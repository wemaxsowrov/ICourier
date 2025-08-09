<?php

namespace App\Http\Controllers\Backend;

use App\Enums\PaymentType;
use App\Http\Controllers\Controller;
use App\Models\Backend\Account;
use App\Models\Backend\Merchant;
use Illuminate\Http\Request;
use Obydul\LaraSkrill\SkrillClient;
use Obydul\LaraSkrill\SkrillRequest;
use Redirect;
use App\Models\Backend\MerchantOnlinePayment;
use App\Repositories\Account\AccountInterface;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SkrillController extends Controller
{
    public function __construct(AccountInterface $accountRepo)
    {
        $this->skrilRequest = new SkrillRequest();
        $this->skrilRequest->pay_to_email = globalSettings('skrill_merchant_email');
        $this->skrilRequest->cancel_url  = url('/payment-cancelled');
        $this->skrilRequest->logo_url    = settings()->logo_image;
        $this->accountRepo               = $accountRepo;
    }
    // Make Payment
    private $skrilRequest;
    public function index (){
        $accounts    = $this->accountRepo->getAll();
        return view('backend.merchant_panel.onlinepayment.skrill',compact('accounts'));
    }
    public function makePayment(Request $request)
    {
        // create object instance of SkrillRequest
        $this->skrilRequest->transaction_id  = uniqid(); // generate transaction id
        $this->skrilRequest->amount          = $request->amount;
        $this->skrilRequest->currency        = 'USD';
        $this->skrilRequest->language        = 'EN';
        $this->skrilRequest->prepare_only    = '1';
        $this->skrilRequest->merchant_fields = settings()->name.','.Auth::user()->email;
        $this->skrilRequest->site_name       = settings()->name;
        $this->skrilRequest->customer_email  = Auth::user()->email;
        // create object instance of SkrillClient
        $client = new SkrillClient($this->skrilRequest);
        $sid = $client->generateSID(); //return SESSION ID
        // handle error
        $jsonSID = json_decode($sid);
        if ($jsonSID != null && $jsonSID->code == "BAD_REQUEST")
            return $jsonSID->message;
        // do the payment
            $redirectUrl = $client->paymentRedirectUrl($sid); //return redirect url
        if ($jsonSID != null && $jsonSID->code != "BAD_REQUEST"){
            $this->skrilRequest->return_url  =  $this->storePayment($request,$this->skrilRequest->transaction_id) ;
        }
        return Redirect::to($redirectUrl); // redirect user to Skrill payment page
    }


    private function storePayment($request,$tid=''){
        $paymnet = DB::table('merchant_online_payments')
        ->updateOrInsert([
            'payment_type'   => PaymentType::SKRILL,
            'amount'         => ($request->get('amount') * settings()->excenseRate->exchange_rate),
            'note'           => 'Payment',
            'transaction_id' => $tid,
            'merchant_id'    => Auth::user()->merchant->id,
            'account_id'     => $request->account_id
        ]);
        $amounts  = ($request->get('amount') * settings()->excenseRate->exchange_rate);
        $merchant                   = Merchant::find(Auth::user()->merchant->id);
        $merchant->current_balance  =($merchant->current_balance - $amounts);
        $merchant->save();
        $account                   = Account::find($request->account_id);
        $account->balance          = ($account->balance + $amounts);
        $account->save();
        return url('/payment-completed');
    }


    public function ipn(Request $request)
    {
        // skrill data - get more fields from Skrill Quick Checkout Integration Guide 7.9 (page 23)
        $transaction_id    = $request->transaction_id;
        $mb_transaction_id = $request->mb_transaction_id;
        $invoice_id        = $request->invoice_id; // custom field
        $order_from        = $request->order_from; // custom field
        $customer_email    = $request->customer_email; // custom field
        $biller_email      = $request->pay_from_email;
        $customer_id       = $request->customer_id;
        $amount            = ($request->amount * settings()->excenseRate->exchange_rate);
        $currency          = $request->currency;
        $status            = $request->status;
        // status message
        if ($status == '-2') {
            $status_message = 'Failed';
        } else if ($status == '2') {
            $status_message = 'Processed';
        } else if ($status == '0') {
            $status_message = 'Pending';
        } else if ($status == '-1') {
            $status_message = 'Cancelled';
        }
        // now store data to database
        $skrill_ipn = new MerchantOnlinePayment();
        $skrill_ipn->transaction_id = $transaction_id;
        $skrill_ipn->invoice_id = $invoice_id;
        $skrill_ipn->order_from = $order_from;
        $skrill_ipn->customer_email = $customer_email;
        $skrill_ipn->biller_email = $biller_email;
        $skrill_ipn->customer_id = $customer_id;
        $skrill_ipn->amount = $amount;
        $skrill_ipn->currency = $currency;
        $skrill_ipn->status = $status_message;
        $skrill_ipn->created_at = Date('Y-m-d H:i:s');
        $skrill_ipn->updated_at = Date('Y-m-d H:i:s');
        $skrill_ipn->save();
    }

    public function paymentCompleted(){
        Toastr::success('Payment successfully completed.',__('message.success'));
        return redirect()->route('online.payment.index');
    }
   public function  PaymentCancelled(){
       Toastr::error(__('parcel.error_msg'),__('message.error'));
        return redirect()->route('skrill.index');
   }
}
