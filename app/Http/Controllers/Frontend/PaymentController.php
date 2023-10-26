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
use Cart;
use Illuminate\Http\Request;
use Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Charge;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function index()
    {
        if (!Session::has('shipping_address')) {
            return \redirect()->route('user.checkout');
        }
        return view('frontend.pages.payment');
    }

    public function paymentSuccess()
    {
        return view('frontend.pages.payment-success');
    }

    public function vnPaySuccess()
    {
        return view('frontend.pages.payment-vnpay-success');
    }

    public function paymentCancel()
    {
        return view('frontend.pages.payment-cancel');
    }

    public function storeOrder($paymentMethod, $paymentStatus, $transactionId, $payAmount)
    {
        //Store order
        $order = new Order();
        $order->invoice_id = rand(1, 10000);
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
        $transaction = new Transaction();
        $transaction->order_id = $order->id;
        $transaction->transaction_id = $transactionId;
        $transaction->payment_method = $paymentMethod;
        $transaction->amount = $payAmount;
        $transaction->save();

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
            'mode' => $paypalSetting->mode == 1 ? 'live' : 'sandbox',
            'sandbox' => [
                'client_id' => $paypalSetting->client_id,
                'client_secret' => $paypalSetting->secret_key,
                'app_id' => '',
            ],
            'live' => [
                'client_id' => $paypalSetting->client_id,
                'client_secret' => $paypalSetting->secret_key,
                'app_id' => '',
            ],

            'payment_action' => 'Sale',
            'currency' => $paypalSetting->currency_name,
            'notify_url' => '',
            'locale' => 'en_US',
            'validate_ssl' => true,
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

        $totalPay = round(getPayAmountRaw() / 23223, 2);

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('user.paypal.success'),
                "cancel_url" => route('user.payment.cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => $config['currency'],
                        "value" => $totalPay,
                    ],
                ],
            ],
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('user.paypal.cancel');
        }
    }

    public function paypalSuccess(Request $request)
    {
        $config = $this->paypalConfig();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $paypalSetting = PaypalSetting::first();
            $totalPay = round(getPayAmountRaw() * $paypalSetting->currency_rate, 2); // 100 -> 100.00

            // storeOrder in Database
            $this->storeOrder('paypal', 1, $response['id'], $totalPay);
            $this->clearSession();
            toastr()->success('Thanh toán thành công!');
            return redirect()->route('user.payment.success');
        } else {
            toastr()->error('Thanh toán không thành công!');
            return redirect()->route('user.payment.cancel');
        }
    }

    public function paypalCancel()
    {
        toastr()->error('Đã có lỗi xảy ra, vui lòng thử lại sau');
        return redirect()->route('user.payment');
    }

    /* Pay with Stripe*/

    public function connectStripePayment(Request $request)
    {
        $total = getPayAmountRaw();
        $stripeSetting = StripeSetting::first();
        Stripe::setApiKey($stripeSetting->secret_key);
        $response = Charge::create(
            [
                'amount' => $stripeSetting->currency_rate * ($total) * 100,
                'currency' => 'USD',
                'source' => $request->stripe_token,
                'description' => "Test Stripe payment",
            ]
        );
        if ($response->status == 'succeeded') {
            $this->storeOrder('stripe', 1, $response->id, $total);
            $this->clearSession();
            return redirect()->route('user.payment.success');
        } else {
            toastr()->error('Thanh toán không thành công!');
            return redirect()->route('user.payment.cancel');
        }
    }

    /* Pay with VnPay*/

    public function connectVnPayPayment()
    {
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $totalPay = round(getPayAmountRaw());

        $vnp_TmnCode = "BZU9ONFY";
        $vnp_HashSecret = "MCXMMMPVHKTACIAGMMBQDNQRCGUKRBYK";
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = url('user/payment-vnpay-success');
        //Config input format
        //Expire
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $vnp_TxnRef = rand(1, 10000); // order_id
        $vnp_Amount = $totalPay; // Số tiền thanh toán
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
            "vnp_OrderInfo" => "Thanh toan GD tren Shop Now",
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire,
            'vnp_BankCode' => 'ncb',
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
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url,
        );

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
        $vnp_Amount = $request->vnp_Amount;
        $vnp_TransactionNo = $request->vnp_TransactionNo;

        if (!empty($vnp_ResponseCode)) {
            if ($vnp_ResponseCode == '00') {
                $this->storeOrder('vnPay', 1, $vnp_TransactionNo, $vnp_Amount / 100);
                $this->clearSession();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Thanh toán đơn hàng thành công',
                ]);
            } elseif ($payment_id === '2') {
                $data_url = $this->connectVnPayPayment();
                return redirect()->to($data_url);
            }
        }
    }

    /* Pay with COD*/
    public function payWithCod(Request $request)
    {
        $codSetting = CodSetting::first();
        if ($codSetting->status == 0) {
            toastr('Vui lòng thử lại sau, xin cảm ơn!', 'error');
            return redirect()->back();
        }

        $total = getPayAmountRaw();
        $this->storeOrder('COD', 0, \Str::random(10), $total);
        $this->clearSession();
        return redirect()->route('user.payment.success');
    }
}
