<?php

use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\AddRolePermissionController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AdminListController;
use App\Http\Controllers\Backend\AdminReviewController;
use App\Http\Controllers\Backend\AdminVendorProfileController;
use App\Http\Controllers\Backend\AdvertisementController;
use App\Http\Controllers\Backend\BecomeVendorRequestController;
use App\Http\Controllers\Backend\BlogCategoryController;
use App\Http\Controllers\Backend\BlogCommentController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\CodSettingController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\CustomerListController;
use App\Http\Controllers\Backend\FlashSaleController;
use App\Http\Controllers\Backend\FooterColumnThreeController;
use App\Http\Controllers\Backend\FooterColumnTwoController;
use App\Http\Controllers\Backend\FooterInfoController;
use App\Http\Controllers\Backend\FooterSocialsController;
use App\Http\Controllers\Backend\HomepageSettingController;
use App\Http\Controllers\Backend\ManageUserController;
use App\Http\Controllers\Backend\ModulePermissionController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\PaymentSettingController;
use App\Http\Controllers\Backend\PaypalSettingController;
use App\Http\Controllers\Backend\PermisstionController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductImageGalleryController;
use App\Http\Controllers\Backend\ProductVariantController;
use App\Http\Controllers\Backend\ProductVariantItemController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SellerProductController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\ShippingRuleController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\StripeSettingController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\SubscriblersController;
use App\Http\Controllers\Backend\TermsAndConditionController;
use App\Http\Controllers\Backend\TransactionController;
use App\Http\Controllers\Backend\VendorConditionController;
use App\Http\Controllers\Backend\VendorListController;
use App\Http\Controllers\Backend\VnPaySettingController;
use Illuminate\Support\Facades\Route;

//Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth','role:admin'])->name('admin.dashboard'); //  'role' dc goi trong Kernel.php

Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

//Module Permission Route
Route::resource('modules', ModulePermissionController::class)->middleware('can:module-permission.view');

//Permission Route
Route::resource('permission', PermisstionController::class)->middleware('can:permissions.view');

//Role Route
Route::resource('role', RoleController::class)->middleware('can:role-permission.view');

//Add Role Permission Route
Route::get('add-role-permission/{role}', [AddRolePermissionController::class, 'addRolePermission'])->middleware('can:groups.permission')->name('add-role-permission');
Route::post('add-role-permission/update/{id}', [AddRolePermissionController::class, 'updateRolePermission'])->name('update-role-permission');

//Profile Route
Route::get('profile', [ProfileController::class, 'index'])->name('profile');

Route::post('profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');

//Slider Route
Route::resource('slider', SliderController::class);

//Category Route
Route::resource('category', CategoryController::class);

//Sub Category Route
Route::resource('sub-category', SubCategoryController::class);

//Child Category Route
Route::get('child-category/get-sub-category/{categoryId}', [ChildCategoryController::class,'getSubCategory'])->name('get-sub-category');
Route::resource('child-category', ChildCategoryController::class);

//Brand Route
Route::resource('brand', BrandController::class)->middleware('can:brand.view');

//AdminVendorProfile Route
Route::resource('vendor-profile', AdminVendorProfileController::class);

//Products Route
Route::get('products/get-sub-category/{categoryId}', [ProductController::class,'getSubCategory'])->name('get-sub-category');
Route::get('products/get-child-category/{subCategoryId}', [ProductController::class,'getChildCategory'])->name('get-child-category');
Route::resource('products', ProductController::class)->middleware('can:product.view');

//ProductImageGallery Route
Route::resource('products-image-gallery', ProductImageGalleryController::class);

//ProductVariant Route
Route::resource('products-variant', ProductVariantController::class);


//ProductVariantItem Route
//ver 2
//Route::get('products-variant-item', [ProductVariantItemController::class,'index'])->name('products-variant-item.index');
//ver 1
Route::get('products-variant-item/{productId}/{variantId}', [ProductVariantItemController::class,'index'])->name('products-variant-item.index');
Route::get('products-variant-item/create/{productId}/{variantId}', [ProductVariantItemController::class, 'create'])->name('products-variant-item.create');
Route::post('products-variant-item', [ProductVariantItemController::class,'store'])->name('products-variant-item.store');
Route::get('products-variant-item/{variantItem}', [ProductVariantItemController::class,'edit'])->name('products-variant-item.edit');
Route::put('products-variant-item/{variantItem}', [ProductVariantItemController::class,'update'])->name('products-variant-item.update');
Route::delete('products-variant-item/{variantItem}', [ProductVariantItemController::class,'destroy'])->name('products-variant-item.destroy');

/* Review Route*/
Route::get('review',[AdminReviewController::class,'index'])->name('review.index');
Route::get('review/update-approved/{productId}/{approved}', [AdminReviewController::class,'updateApprove'])->name('review.updateApprove');
Route::delete('review/{productReview}', [AdminReviewController::class,'destroy'])->name('review.destroy');


/* Seller Route*/
Route::get('seller-products', [SellerProductController::class,'index'])->name('seller-products.index');
Route::get('seller-pending-products/update-approved/{productId}/{approved}', [SellerProductController::class,'updateApprove'])->name('seller-pending-products.updateApprove');
//Route::put('seller-pending-products/change-approved', [SellerProductController::class,'updateApprove'])->name('seller-pending-products.updateApprove');
Route::get('seller-pending-products', [SellerProductController::class,'pending'])->name('seller-pending-products.index');


/* Coupon Route*/
Route::resource('coupon',CouponController::class);

/* ShippingRule Route*/
Route::resource('shipping-rule',ShippingRuleController::class);

/* All Payments Route*/
Route::get('payment-settings',[PaymentSettingController::class,'index'])->name('payment-settings.index');
Route::resource('paypal-setting',PaypalSettingController::class);
Route::put('vnpay-setting/{id}',[VnPaySettingController::class,'update'])->name('vnpay-setting.update');
Route::put('stripe-settings/{id}',[StripeSettingController::class,'update'])->name('stripe-settings.update');
Route::put('cod-settings/{id}',[CodSettingController::class,'update'])->name('cod-settings.update');


/* Get Status Order Route*/
Route::get('order/get-order-status/{id}/{status}',[OrderController::class,'getOrderStatus'])->name('get-order-status');

/* Get Status Payment Route*/
Route::get('order/payment-status/{id}/{status}',[OrderController::class,'changePaymentStatus'])->name('payment-status');

/* Custom Order Route*/
Route::get('pending-orders',[OrderController::class,'pendingOrders'])->name('pending-orders');
Route::get('processed-orders',[OrderController::class,'processedOrders'])->name('processed-orders');
Route::get('drop-off-orders',[OrderController::class,'dropOffOrders'])->name('drop-off-orders');
Route::get('shipped-orders',[OrderController::class,'shippedOrders'])->name('shipped-orders');
Route::get('out-of-delivery-orders',[OrderController::class,'outOfDeliveryOrders'])->name('out-of-delivery-orders');
Route::get('delivered-orders',[OrderController::class,'deliveredOrders'])->name('delivered-orders');
Route::get('canceled-orders',[OrderController::class,'canceledOrders'])->name('canceled-orders');

/* Order Route*/
Route::resource('order',OrderController::class);

/* Transaction Route*/
Route::get('transaction',[TransactionController::class, 'index'])->name('transaction.index');
Route::get('orders/show/{order}', [TransactionController::class, 'show'])->name('orders.show');

/* Get Status Transaction Route*/
Route::get('orders/get-order-status/{id}/{status}',[TransactionController::class,'getOrderStatus'])->name('get-order-status'); ///////// ????????


/* Flash sales Route*/
Route::get('flash-sale',[FlashSaleController::class,'index'])->name('flash-sale.index');
Route::put('flash-sale',[FlashSaleController::class,'update'])->name('flash-sale.update');
Route::post('flash-sale/add-product',[FlashSaleController::class,'addProduct'])->name('flash-sale.add-product');
Route::put('flash-sale/switch-status/{flashSaleItem}',[FlashSaleController::class,'switchStatus'])->name('flash-sale.switch-status');
Route::put('flash-sale/switch-show/{flashSaleItem}',[FlashSaleController::class,'switchShowAtHome'])->name('flash-sale.switch-show');
Route::delete('flash-sale/{flashSaleItem}', [FlashSaleController::class,'destroy'])->name('flash-sale.destroy');

/* Setting Route*/
Route::get('settings',[SettingController::class,'index'])->name('setting.index');
Route::post('email-setting-update',[SettingController::class,'emailConfigSettingUpdate'])->name('email-setting-update');
Route::post('general-setting-update',[SettingController::class,'generalSettingUpdate'])->name('general-setting-update');


/* Homepage Route*/
Route::get('homepage-settings',[HomepageSettingController::class,'index'])->name('homepage.index');
Route::get('homepage-settings/get-sub-category/{categoryId}', [HomepageSettingController::class,'getSubCategory'])->name('get-sub-category');
Route::get('homepage-settings/get-child-category/{subCategoryId}', [HomepageSettingController::class,'getChildCategory'])->name('get-child-category');

Route::post('popular-category-section', [HomepageSettingController::class,'updatePopularCategorySection'])->name('popular-category-section');

/* Homepage Route*/
Route::post('product-sliders-section-one',[HomepageSettingController::class,'updateProductSlidersSectionOne'])->name('product-sliders-section-one');
Route::post('product-sliders-section-two',[HomepageSettingController::class,'updateProductSlidersSectionTwo'])->name('product-sliders-section-two');
Route::post('product-sliders-section-three',[HomepageSettingController::class,'updateProductSlidersSectionThree'])->name('product-sliders-section-three');

/* Subscriber Route*/
Route::get('subscriber',[SubscriblersController::class,'index'])->name('subscriber.index');
Route::delete('subscriber/destroy/{id}',[SubscriblersController::class,'destroy'])->name('subscriber.destroy');
Route::post('subscriber-send-mail',[SubscriblersController::class,'sendMail'])->name('subscriber-send-mail');

/* Advertisement Route*/
Route::get('advertisement',[AdvertisementController::class,'index'])->name('advertisement.index');
Route::put('advertisement/homepage-banner-section-1',[AdvertisementController::class,'homepageBannerSection1'])->name('homepage-banner-section-1');
Route::put('advertisement/homepage-banner-section-2',[AdvertisementController::class,'homepageBannerSection2'])->name('homepage-banner-section-2');
Route::put('advertisement/homepage-banner-section-3',[AdvertisementController::class,'homepageBannerSection3'])->name('homepage-banner-section-3');
Route::put('advertisement/homepage-banner-section-4',[AdvertisementController::class,'homepageBannerSection4'])->name('homepage-banner-section-4');
Route::put('advertisement/product-page-banner',[AdvertisementController::class,'productPageBanner'])->name('product-page-banner');
Route::put('advertisement/cart-page-banner',[AdvertisementController::class,'cartPageBanner'])->name('cart-page-banner');

/* Become Vendor Route*/
Route::get('become-request',[BecomeVendorRequestController::class,'index'])->name('become-request.index');
Route::get('become-request/{vendor}/show',[BecomeVendorRequestController::class,'show'])->name('become-request.show');
Route::get('become-request/change-status/{id}/{status}',[BecomeVendorRequestController::class,'getStatus'])->name('become-request.change-status');

/* Customer list Route*/
Route::get('customers',[CustomerListController::class,'index'])->name('customers.index');
Route::put('customers/{user}',[CustomerListController::class,'updateStatus'])->name('customer.update-status');

/* Admin list Route*/
Route::get('admin-list',[AdminListController::class,'index'])->name('admin-list.index');
Route::put('admin-list/{user}',[AdminListController::class,'updateStatus'])->name('admin-list.update-status');
Route::delete('admin-list/{user}',[AdminListController::class,'destroy'])->name('admin-list.destroy');

/* Vendor list Route*/
Route::get('vendors',[VendorListController::class,'index'])->name('vendors.index');
Route::put('vendors/{vendor}',[VendorListController::class,'updateStatus'])->name('vendors.update-status');

/* Manage User Route*/
Route::get('manage-user',[ManageUserController::class,'index'])->name('manage-user.index');
Route::post('manage-user',[ManageUserController::class,'create'])->name('manage-user.create');

/* Vendor Condition Route*/
Route::get('vendor-condition',[VendorConditionController::class,'index'])->name('vendor-condition.index');
Route::put('vendor-condition',[VendorConditionController::class,'update'])->name('vendor-condition.update');

/* Blog Route*/
Route::resource('blog-category', BlogCategoryController::class);
Route::resource('blog', BlogController::class)->middleware('can:blog.view');

/* Blog Comment Route*/
Route::get('blog-comments',[BlogCommentController::class,'index'])->name('blog-comments.index');
Route::delete('blog-comments/{blogComment}',[BlogCommentController::class,'destroy'])->name('blog-comments.destroy');

/* About us Route*/
Route::get('about',[AboutController::class,'index'])->name('about.index');
Route::put('about',[AboutController::class,'update'])->name('about.update');

/* Terms and Condition us Route*/
Route::get('terms-and-condition',[TermsAndConditionController::class,'index'])->name('terms-and-condition.index');
Route::put('terms-and-condition',[TermsAndConditionController::class,'update'])->name('terms-and-condition.update');

/* Footer Route*/
Route::resource('footer-info',FooterInfoController::class);

Route::resource('footer-socials',FooterSocialsController::class);

Route::put('footer-column-2/change-title',[FooterColumnTwoController::class,'changeTitle'])->name('footer-column-2.change-title');
Route::resource('footer-column-2',FooterColumnTwoController::class);

Route::put('footer-column-3/change-title',[FooterColumnThreeController::class,'changeTitle'])->name('footer-column-3.change-title');
Route::resource('footer-column-3',FooterColumnThreeController::class);



