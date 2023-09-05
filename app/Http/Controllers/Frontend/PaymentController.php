<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CodSetting;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\PaypalSetting;
use App\Models\Product;
use App\Models\StripeSetting;
use App\Models\Transaction;
use Auth;
use Illuminate\Http\Request;
use Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Cart;
use Stripe\Charge;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function index()
    {
        if(!Session::has('shipping_address')){
          return \redirect()->route('user.checkout');
        }
        return view('frontend.pages.payment');
    }

    public function paymentSuccess()
    {
        return view('frontend.pages.payment-success');
    }

    public function storeOrder($paymentMethod, $paymentStatus,$transactionId,$payAmount)
    {
        //Store order
        $order = new Order();
        $order->invoice_id = rand(1,10000);
        $order->user_id = Auth::user()->id;
        $order->sub_total = getCartTotalRaw();
        $order->amount = getPayAmountRaw();
        $order->currency_name = 'VND';
        $order->currency_icon = 'đ';
        $order->product_quantity = Cart::content()->count();
        $order->payment_method = $paymentMethod;
        $order->payment_status = $paymentStatus;
        $order->order_address = json_encode(Session::get('shipping_address'));
        $order->shipping_method = json_encode(Session::get('shipping_method'));
        $order->coupon = json_encode(Session::get('coupon'));
        $order->order_status = 'pending';
        $order->save();

        //Store order product
        foreach (Cart::content() as $item) {
            $product = Product::find($item->id);

            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $product->id;
            $orderProduct->vendor_id = $product->vendor_id;
            $orderProduct->product_name = $product->name;
            $orderProduct->variants = json_encode($item->options->variants);
            $orderProduct->variant_total = json_encode($item->options->variants_total);
            $orderProduct->unit_price = $item->price;
            $orderProduct->quantity = $item->qty;
            $orderProduct->save();

            //Update product quantity in database
            $productCurrentQuantity = $product->quantity;
            $productUpdateQuantity = $productCurrentQuantity - $item->qty;
            $product->quantity = $productUpdateQuantity;
            $product->save();

        }

        //Store transaction detail
        $transaction  = new Transaction();
        $transaction->order_id = $order->id;
        $transaction->transaction_id = $transactionId;
        $transaction->payment_method = $paymentMethod;
        $transaction->amount = $payAmount;
        $transaction->save();

        //Update quantity in database
        $product = new Product();
//        $product->quantity =

    }

    public function clearSession()
    {
       Cart::destroy();
       Session::forget('shipping_address');
       Session::forget('shipping_method');
       Session::forget('coupon');
    }

    /* Pay with PayPal*/
    public function paypalConfig()
    {
        $paypalSetting = PaypalSetting::first();
        $config = [
            'mode'    => $paypalSetting->mode == 1 ? 'live' : 'sandbox',
            'sandbox' => [
                'client_id'         => $paypalSetting->client_id ,
                'client_secret'     => $paypalSetting->secret_key,
                'app_id'            => '',
            ],
            'live' => [
                'client_id'         => $paypalSetting->client_id ,
                'client_secret'     => $paypalSetting->secret_key,
                'app_id'            => '',
            ],

            'payment_action' =>  'Sale',
            'currency'       => $paypalSetting->currency_name,
            'notify_url'     => '',
            'locale'         => 'en_US',
            'validate_ssl'   =>  true,
        ];
        return $config;
    }

    public function connectPaypalPayment()
    {
        $config = $this->paypalConfig();

        $provider = new PayPalClient($config);

        $provider->getAccessToken();

        $paypalSetting = PaypalSetting::first();
//        $totalPay = round(getPayAmountRaw() * $paypalSetting->currency_rate,2); // 100 -> 100.00
        $totalPay = round(getPayAmountRaw()/23223,2 );

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('user.paypal.success'),
                "cancel_url" => route('user.paypal.cancel')
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => $config['currency'],
                        "value" => $totalPay,
                    ]
                ]
            ]
        ]);

        if (isset($response['id'] )&& $response['id'] != null){
            foreach ($response['links'] as $link){
                if ($link['rel'] === 'approve'){
                    return redirect()->away($link['href']);
                }
            }
        }else {
            return redirect()->route('user.paypal.cancel');
        }


    }

    public function paypalPaymentSuccess(Request $request)
    {
        $config = $this->paypalConfig();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

         if(isset($response['status']) && $response['status'] == 'COMPLETED'){
             $paypalSetting = PaypalSetting::first();
             $totalPay = round(getPayAmountRaw() * $paypalSetting->currency_rate,2); // 100 -> 100.00

             // storeOrder in Database
             $this->storeOrder('paypal',1, $response['id'], $totalPay);
             $this->clearSession();
             return redirect()->route('user.payment.success');
         }else{
             toastr()->error('Thanh toán không thành công!');
             return redirect()->route('user.paypal.cancel');
         }
    }

    public function paypalPaymentCancel()
    {
        toastr()->error('Something went wrong try again');
        return redirect()->route('user.payment');
    }

    /* Pay with Stripe*/

    public function connectStripePayment(Request $request)
    {
        $total = getPayAmountRaw();
        $stripeSetting = StripeSetting::first();
        Stripe::setApiKey($stripeSetting->secret_key);
        $response =  Charge::create(
            [
                'amount' => $stripeSetting->currency_rate * ($total) * 100,
                'currency' => 'USD',
                'source' => $request->stripe_token,
                'description' => "Test Stripe payment"
            ]
        );
        if($response->status == 'succeeded'){
            $this->storeOrder('stripe',1, $response->id, $total);
            $this->clearSession();
            return redirect()->route('user.payment.success');
        }else{
            toastr()->error('Thanh toán không thành công!');
            return redirect()->route('user.paypal.cancel');
        }

    }

    /* Pay with VnPay*/

//    public function vnPayConfig()
//    {
//        return [
//            date_default_timezone_set('Asia/Ho_Chi_Minh'),
//            'vnp_HashSecret' => "MCXMMMPVHKTACIAGMMBQDNQRCGUKRBYK",
//            'vnp_TmnCode' => "BZU9ONFY",
//            'vnp_Url' => "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html",
//            'vnp_Returnurl' => redirect()->route('user.vnpay.return'),
//            'vnp_apiUrl' => "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html",
//            'apiUrl' => "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction",
//            'startTime' => date("YmdHis"),
//            'expire' => date('YmdHis',strtotime('+15 minutes',strtotime(date("YmdHis")))),
//        ];
//    }

//    public function connectVnPayPayment(Request $request)
//    {
//        $config = $this->vnPayConfig();
//        $totalPay = getPayAmountRaw();
//
//        $inputData = array(
//            "vnp_Version" => "2.1.0",
//            "vnp_TmnCode" => $config['vnp_TmnCode'],
//            "vnp_Amount" => $totalPay * 100,
//            "vnp_Command" => "pay",
//            "vnp_CreateDate" => date('YmdHis'),
//            "vnp_CurrCode" => "VND",
//            "vnp_Locale" => 'vn',
//            "vnp_OrderInfo" => "Thanh toán hóa đơn phí dich vụ",
//            "vnp_OrderType" => 'billpayment',
//            "vnp_ReturnUrl" => $config['vnp_Returnurl'],
//            "vnp_TxnRef" => date("YmdHis"),
//        );
//
//        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
//            $inputData['vnp_BankCode'] = $vnp_BankCode;
//        }
//        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
//            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
//        }
//
//        ksort($inputData);
//        $query = "";
//        $i = 0;
//        $hashdata = "";
//        foreach ($inputData as $key => $value) {
//            if ($i == 1) {
//                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
//            } else {
//                $hashdata .= urlencode($key) . "=" . urlencode($value);
//                $i = 1;
//            }
//            $query .= urlencode($key) . "=" . urlencode($value) . '&';
//        }
//
//
//        $vnp_Url = $config['vnp_Url'] . "?" . $query;
//        if (isset($vnp_HashSecret)) {
//            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
//            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
//        }
//
//        $returnData = array('code' => '00'
//        , 'message' => 'success'
//        , 'data' => $vnp_Url
//        );
//        if (isset($_POST['redirect'])) {
//
//            return redirect()->away($vnp_Url);
//        } else {
//            echo json_encode($returnData);
//        }
//
//
//    }

//    public function vnPayReturn(Request $request)
//    {
//        $totalPay = getPayAmountRaw();
//         //storeOrder
//        if($request->vnp_ResponseCode === '00'){
//            $this->storeOrder('vnpay',1, $request->vnp_TransactionNo, $totalPay);
//            $this->clearSession();
//            return redirect()->route('user.payment.success');
//        }
//        return redirect()->route('user.payment');
//
//    }
//
//    public function connectVnPayPayment(Request $request)
//    {
//
//        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
//        $vnp_Returnurl = 'http://ecommerce.test/user/payment';
//        $vnp_TmnCode = "BZU9ONFY";//Mã website tại VNPAY
//        $vnp_HashSecret = "MCXMMMPVHKTACIAGMMBQDNQRCGUKRBYK"; //Chuỗi bí mật
//
//        $vnp_TxnRef = '7486'; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
//        $vnp_OrderInfo ='Thanh toán đơn hàng test';
//        $vnp_OrderType = 'billpayment';
//        $vnp_Amount = 200000 * 100;
//        $vnp_Locale = 'vn';
//        $vnp_BankCode = 'NCB';
//        $vnp_CreateDate = date('YmdHis');
//
//        $inputData = array(
//            "vnp_Version" => "2.1.0",
//            "vnp_TmnCode" => $vnp_TmnCode,
//            "vnp_Amount" => $vnp_Amount,
//            "vnp_Command" => "pay",
//            "vnp_CreateDate" => $vnp_CreateDate,
//            "vnp_CurrCode" => "VND",
//            "vnp_Locale" => $vnp_Locale,
//            "vnp_OrderInfo" => $vnp_OrderInfo,
//            "vnp_OrderType" => $vnp_OrderType,
//            "vnp_ReturnUrl" => $vnp_Returnurl,
//            "vnp_TxnRef" => $vnp_TxnRef,
//        );
//
//        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
//            $inputData['vnp_BankCode'] = $vnp_BankCode;
//        }
//        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
//            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
//        }
//
//        ksort($inputData);
//
//        $query = "";
//        $i = 0;
//        $hashdata = "";
//        foreach ($inputData as $key => $value) {
//            if ($i == 1) {
//                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
//            } else {
//                $hashdata .= urlencode($key) . "=" . urlencode($value);
//                $i = 1;
//            }
//            $query .= urlencode($key) . "=" . urlencode($value) . '&';
//        }
//
//        $vnp_Url = $vnp_Url . "?" . $query;
//
////        $hashdata = http_build_query($inputData);
//        if (isset($vnp_HashSecret)) {
//            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
//            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
//        }
//
////        die($vnp_Url);
//        $returnData = array('code' => '00'
//        , 'message' => 'success'
//        , 'data' => $vnp_Url);
//        if (isset($_POST['redirect'])) {
//            header('Location: ' . $vnp_Url);
//            die();
//        } else {
//            echo json_encode($returnData);
//        }
//
//    }

    public function connectVnPayPayment()
    {
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        /**
         *
         *
         * @author CTT VNPAY
         */
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        /*
        * To change this license header, choose License Headers in Project Properties.
        * To change this template file, choose Tools | Templates
        * and open the template in the editor.
        */

        $vnp_TmnCode = "BZU9ONFY"; //Mã định danh merchant kết nối (Terminal Id)
        $vnp_HashSecret = "MCXMMMPVHKTACIAGMMBQDNQRCGUKRBYK"; //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = url('user/vnpay/checkout');
        //Config input format
        //Expire
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $vnp_TxnRef = 12222; // order_id
        $vnp_Amount = 2000000; // Số tiền thanh toán
        $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD tren E-Shopper",
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire,
            'vnp_BankCode' => 'ncb'
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );

        //echo json_encode($returnData);

//        return $returnData['data']; //chỉ lấy ra $vnp_Url thôi.

        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }

    public function vnPayCheck(Request $request)
    {
        $vnp_ResponseCode = $request->vnp_ResponseCode;
        $vnp_TxnRef = $request->vnp_TxnRef;
        $vnp_Amount = $request->vnp_Amount;
        $data = [
            'vnp_TxnRef' => 43473,
            'vnp_Amount' => 200000,
        ];

        if(!empty($vnp_ResponseCode)){
            if($vnp_ResponseCode == '00'){
                return $request->all();
            }elseif ($payment_id === '2'){
                $data_url = $this->connectVnPayPayment();
                return redirect()->to($data_url);
            }
        }
    }

    /* Pay with COD*/
    public function payWithCod(Request $request)
    {
        $codSetting = CodSetting::first();
        if ($codSetting->status == 0){
            toastr('Vui lòng thử lại sau, xin cảm ơn!', 'error');
            return redirect()->back();
        }

        $total = getPayAmountRaw();
        $this->storeOrder('COD',0, \Str::random(10), $total);
        $this->clearSession();
        return redirect()->route('user.payment.success');
    }
}

