<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Frontend\BecomeAVendorRequestController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckOutController;
use App\Http\Controllers\Frontend\FlashSaleController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\ProductDetailController;
use App\Http\Controllers\Frontend\ProductTractController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\SocialiteLoginController;
use App\Http\Controllers\Frontend\UserAddressController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\UserOrderController;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', [HomeController::class, 'index'])->name('home');

/*Route Vendor Page*/
Route::get('vendor', [HomeController::class, 'vendorPage'])->name('vendor.index');
Route::get('vendor-product/{vendor}', [HomeController::class, 'vendorProductPage'])->name('vendor.products');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

//Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth','role:admin'])->name('admin.dashboard'); //  'role' dc goi trong Kernel.php

//Route::get('vendor/dashboard', [VendorController::class, 'dashboard'])->middleware(['auth','role:vendor'])->name('vendor.dashboard');

// Route Login Admin
Route::get('admin/login', [AdminController::class, 'login'])->name('admin.login');

// Route Login User with Google Account
Route::get('/login/google', [SocialiteLoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [SocialiteLoginController::class, 'handleGoogleCallback']);

// Route Login User with Facebook Account
Route::get('/login/facebook', [SocialiteLoginController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/login/facebook/callback', [SocialiteLoginController::class, 'handleFacebookCallback']);
Route::get('/privacy-policy', [SocialiteLoginController::class, 'privacyPolicy']);

/*Route Cart*/
Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('cart-detail', [CartController::class, 'cartDetail'])->name('cart-detail');
Route::post('cart/update-quantity', [CartController::class, 'updateProductQuantity'])->name('cart.update-quantity');
Route::post('clear-cart', [CartController::class, 'clearCart'])->name('clear-cart');
Route::get('cart/remove-item/{rowId}', [CartController::class, 'removeItem'])->name('cart.remove-item');
Route::get('cart-count', [CartController::class, 'getCartCount'])->name('cart-count');
Route::get('cart-products', [CartController::class, 'getCartProducts'])->name('cart-products');
Route::post('cart/remove-sidebar-product', [CartController::class, 'removeSidebarProduct'])->name('cart.remove-sidebar-product');
Route::get('cart/sidebar-product-total', [CartController::class, 'sidebarCartTotal'])->name('cart.sidebar-product-total');

Route::post('apply-coupon', [CartController::class, 'applyCoupon'])->name('apply-coupon');
Route::get('coupon-calculation', [CartController::class, 'couponCalculation'])->name('coupon-calculation');

/*Route Flash Sale*/
Route::get('flash-sale', [FlashSaleController::class, 'index'])->name('flash-sale');

/*Route Product*/
Route::get('products', [ProductDetailController::class, 'products'])->name('products.index');
Route::get('product-detail/{slug}.html', [ProductDetailController::class, 'showProductDetail'])->name('product-detail');
Route::get('change-product-list-view/{type}', [ProductDetailController::class, 'changeListView'])->name('change-product-list-view');
Route::get('buy-product', [ProductDetailController::class, 'buyProduct'])->name('buy-product');

/*Route Newsletter*/
Route::post('newsletter', [NewsletterController::class, 'newsLetter'])->name('newsletter');
Route::get('newsletter-verify/{token}', [NewsletterController::class, 'newsLetterEmailVerify'])->name('newsletter-verify');

/*Route specific Page*/
Route::get('about', [PageController::class, 'about'])->name('about');
Route::get('terms-and-condition', [PageController::class, 'termsAndCondition'])->name('terms-and-condition');
Route::get('contact', [PageController::class, 'contact'])->name('contact');
Route::post('contact', [PageController::class, 'postContactForm'])->name('contact.post');

/*Route Product tract*/
Route::get('product-tract', [ProductTractController::class, 'index'])->name('product-tract.index');
Route::post('product-tract', [ProductTractController::class, 'tract'])->name('product-tract');

/*Route Blog*/
Route::get('blog-detail/{slug}', [BlogController::class, 'blogDetail'])->name('blog-detail');
Route::get('blog', [BlogController::class, 'blog'])->name('blog');

/*Route wishlist require login first*/
Route::get('user/wishlist/add-product/{productId}', [WishlistController::class, 'addToWishlist'])->name('user.wishlist.store');

//Route User
Route::prefix('user')->name('user.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [UserProfileController::class, 'index'])->name('profile');
    Route::post('profile/update', [UserProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('profile/password', [UserProfileController::class, 'updatePassword'])->name('password.update');

    /*UserAddress Route*/
    Route::resource('address', UserAddressController::class);
    Route::get('address/province/{provinceId}', [UserAddressController::class, 'getProvince'])->name('province');
    Route::get('address/district/{districtId}', [UserAddressController::class, 'getDistrict'])->name('district');
    Route::get('address/ward', [UserAddressController::class, 'getWard'])->name('ward');

    /*Checkout Route*/
    Route::get('checkout', [CheckOutController::class, 'index'])->name('checkout');
    Route::post('checkout/address-create', [CheckOutController::class, 'createAddress'])->name('checkout.address-create');
    Route::get('checkout/province/{provinceId}', [CheckOutController::class, 'getProvince'])->name('province');
    Route::get('checkout/district/{districtId}', [CheckOutController::class, 'getDistrict'])->name('district');
    Route::get('checkout/ward', [CheckOutController::class, 'getWard'])->name('ward');
    Route::post('checkout/form-submit', [CheckOutController::class, 'checkOutFormSubmit'])->name('checkout.form-submit');

    /*Payment Route*/
    Route::get('payment', [PaymentController::class, 'index'])->name('payment');
    Route::get('payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('payment-cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');

    /*PayPal Route*/
    Route::get('paypal/payment', [PaymentController::class, 'connectPaypalPayment'])->name('paypal.payment');
    Route::get('paypal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('payment.cancel');

    /*Stripe Route*/
    Route::post('stripe/payment', [PaymentController::class, 'connectStripePayment'])->name('stripe.payment');
    Route::post('stripe/success', [PaymentController::class, 'stripeSuccess'])->name('stripe.success');

    /*VnPay Route*/
    Route::get('vnpay/success', [PaymentController::class, 'vnPaySuccess'])->name('vnpay.success');
    Route::post('vnpay/payment', [PaymentController::class, 'connectVnPayPayment'])->name('vnpay.payment');
    Route::get('vnpay/checkout', [PaymentController::class, 'vnPayCheck'])->name('vnpay.checkout');

    /*COD Route*/
    Route::get('cod/payment', [PaymentController::class, 'payWithCod'])->name('cod.payment');

    /*Oder Route*/
    Route::get('orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/show/{order}', [UserOrderController::class, 'show'])->name('orders.show');

    /*Route Wishlist*/
    Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
//    Route::get('wishlist/add-product/{productId}', [WishlistController::class, 'addToWishlist'])->name('wishlist.store');
    Route::get('wishlist/remove-product/{wishlistItemId}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    /*Route User Reviews*/
    Route::get('reviews', [ReviewController::class, 'index'])->name('review.index');

    /*Route Reviews*/
    Route::post('review', [ReviewController::class, 'create'])->name('review.create');

    /*Route Blog Comment*/
    Route::post('blog-comment', [BlogController::class, 'comment'])->name('blog-comment');

    /* Get Status Order Route*/
    Route::get('orders/get-order-status/{id}/{status}', [UserOrderController::class, 'getOrderStatus'])->name('get-order-status');

    /* Become a Vendor Route*/
    Route::get('become-vendor', [BecomeAVendorRequestController::class, 'index'])->name('become-vendor.index');
    Route::post('become-vendor', [BecomeAVendorRequestController::class, 'create'])->name('become-vendor.create');

});
