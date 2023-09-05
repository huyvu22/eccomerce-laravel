<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariantItem;
use Carbon\Carbon;
use Cart;
use Illuminate\Http\Request;
use Session;

class CartController extends Controller
{

    public function cartDetail()
    {
        $cartItems = Cart::content();
        if ($cartItems->count() === 0) {
            toastr()->warning('Cart is empty! Shopping now');
            Session::forget('coupon');
            return redirect()->route('home');
        }

        $cartPageBanner = Advertisement::where('key','cart_page_banner' )->first();
        return view('frontend.pages.cart-detail', compact('cartItems','cartPageBanner'));
    }
    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);

        //Check product quantity in stock
        if($product->quantity === 0){
            return response([
                'status' =>'error',
                'message' =>'Product stock out'
            ]);
        }else if($product->quantity < $request->qty){
            return response([
                'status' =>'error',
                'message' =>'Quantity not available in our stock'
            ]);
        }
        $variants = [];
        $variantTotalAmount = 0;

        if($request->has('variants_items')){
            foreach ($request->variants_items  as $itemId) {
                $variantsItem = ProductVariantItem::find($itemId); // 64Gb, Red
                $variants[$variantsItem->variant->name]['name'] = $variantsItem->name; // $variantsItem->variant->name : Tim dc variant (Color, Bo nho)
                $variants[$variantsItem->variant->name]['price'] = $variantsItem->price;
                $variantTotalAmount += $variantsItem->price;
            }
        }

        $productPrice = 0;
        if(checkDiscount($product)){
            $productPrice += $product->offer_price ;
        }else{
            $productPrice += $product->price ;
        }

        $cartData = [];
        $cartData['id'] = $product->id;
        $cartData['name'] = $product->name;
        $cartData['qty'] = $request->qty;
        $cartData['price'] = $productPrice;
        $cartData['weight'] = 4;
        $cartData['options']['variants'] = $variants;
        $cartData['options']['variants_total'] = $variantTotalAmount;
        $cartData['options']['image'] = $product->thumb_image;
        $cartData['options']['slug'] = $product->slug;

        Cart::add($cartData);

        return response([
            'status' => 'success',
            'message' => 'Added product successfully'
        ]);

    }


    public function updateProductQuantity(Request $request)
    {
        $productId = Cart::get($request->rowId)->id;
        $product = Product::find($productId);

        //Check product quantity in stock
        if($product->quantity === 0){
            return response([
                'status' =>'error',
                'message' =>'Product stock out'
            ]);
        }else if($product->quantity < $request->quantity){
            return response([
                'status' =>'error',
                'message' =>'Quantity not available in our stock'
            ]);
        }

       Cart::update($request->rowId, $request->quantity);
       $productTotal = $this->getProductTotal($request->rowId);

        return response([
            'status' => 'success',
            'message' => 'Product quantity updated successfully',
            'product_total' => $productTotal,
        ]);
    }

    public function getProductTotal($rowId)
    {
       $product = Cart::get($rowId);
       $total = ($product->price + $product->options->variants_total) * $product->qty;
       return $total;
    }

    public function clearCart()
    {
        Cart::destroy();
        return redirect()->route('cart-detail');
    }

    public function removeItem($rowId)
    {
        Cart::remove($rowId);
        toastr()->success('Product removed successfully');
        return redirect()->route('cart-detail');
    }

    public function getCartCount()
    {
        $cartCount = Cart::content()->count();

        return response()->json([
            'count' => $cartCount,
            'message' => 'Cart count fetched successfully.',
        ]);
    }

    public function getCartProducts()
    {
        $cartProducts =  Cart::content();
        return response()->json([
            'cartProducts' => $cartProducts,
            'message' => 'Cart products fetched successfully.',
        ]);
    }

    public function removeSidebarProduct(Request $request)
    {
        Cart::remove($request->rowId);
        $cartCount = Cart::content()->count();
        return response()->json([
            'status' => 'success',
            'message' => ' Products removed successfully.',
            'count' => $cartCount,
        ]);
    }

    public function sidebarCartTotal()
    {
        $total = 0;
        foreach (Cart::content() as $product){
            $total += $this->getProductTotal($product->rowId);
        }
        return response()->json(['total' => $total]);
    }

    public function applyCoupon(Request $request)
    {
        if($request->coupon_code == null){
            return response()->json([
                'status' => 'error',
                'message' => 'Coupon not empty',
            ]);
        }

        $coupon = Coupon::where(['code'=>$request->coupon_code,'status'=>1])->first();
       if($coupon == null){
           return response()->json([
               'status' => 'error',
               'message' => 'Coupon not exist',
           ]);
       }
        if(Carbon::now() < $coupon->start_date || Carbon::now() > $coupon->end_date ){
            return response()->json([
                'status' => 'error',
                'message' => 'Coupon expired',
            ]);
        }

        if($coupon->quantity <= $coupon->total_used) {
            return response()->json([
                'status' => 'error',
                'message' => 'Coupon has been used up',
            ]);
        }

        if ($coupon->discount_type == 'amount'){
            \Session::put('coupon',[
                'coupon_name' => $coupon->name,
                'coupon_code' => $coupon->code,
                'discount_type' => 'amount',
                'discount' => $coupon->discount_value,
            ]);
        }else if($coupon->discount_type == 'percent'){
            \Session::put('coupon',[
                'coupon_name' => $coupon->name,
                'coupon_code' => $coupon->code,
                'discount_type' => 'percent',
                'discount' => $coupon->discount_value
            ]);
        }
        return response()->json([
                'status' => 'success',
                'message' => 'Apply coupon successfully',
        ]);

    }

    public function couponCalculation()
    {
        if(\Session::has('coupon')){
            $coupon = \Session::get('coupon');
            if($coupon['discount_type'] == 'amount'){
                $total = getCartTotalRaw() - $coupon['discount'];
                return response()->json([
                    'status' => 'success',
                    'total' => $total,
                    'discount' => $coupon['discount'],
                ]);
            }else if($coupon['discount_type'] == 'percent'){
                $discount_value = getCartTotalRaw() - ($coupon['discount']/100 *getCartTotalRaw());
                $total = getCartTotalRaw() - $discount_value;
                return response()->json([
                    'status' => 'success',
                    'total' => $total,
                    'discount' => $discount_value,
                ]);
            }
        }else{
            return response()->json([
                'status' => 'success',
                'total' => getCartTotalRaw(),
                'discount' => 0,
            ]);
        }
    }
}
