<?php

use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\VendorOrderController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\VendorProductImageGalleryController;
use App\Http\Controllers\Backend\VendorProductReviewController;
use App\Http\Controllers\Backend\VendorProductVariantController;
use App\Http\Controllers\Backend\VendorProductVariantItemController;
use App\Http\Controllers\Backend\VendorProfileController;
use App\Http\Controllers\Backend\VendorShopProfileController;
use App\Http\Controllers\Backend\VendorWithdrawController;
use Illuminate\Support\Facades\Route;

//Route::get('vendor/dashboard', [VendorController::class, 'dashboard'])->middleware(['auth','role:vendor'])->name('vendor.dashboard');

Route::get('dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
Route::get('profile',[VendorProfileController::class,'index'])->name('profile');
Route::put('profile',[VendorProfileController::class,'updateProfile'])->name('profile.update');
Route::post('profile',[VendorProfileController::class,'updatePassword'])->name('password.update');

//VendorShopProfile Route
Route::resource('shop-profile', VendorShopProfileController::class);

//VendorShopProfile Route
Route::get('products/get-sub-category/{categoryId}', [VendorProductController::class,'getSubCategory'])->name('get-sub-category');
Route::get('products/get-child-category/{subCategoryId}', [VendorProductController::class,'getChildCategory'])->name('get-child-category');
Route::resource('products', VendorProductController::class);


//VendorProductImageGallery Route
Route::resource('products-image-gallery', VendorProductImageGalleryController::class);

//VendorProductVariant Route
Route::resource('products-variant', VendorProductVariantController::class);

//ProductVariantItem Route
//ver 2
//Route::get('products-variant-item', [ProductVariantItemController::class,'index'])->name('products-variant-item.index');
//ver 1
Route::get('products-variant-item/{productId}/{variantId}', [VendorProductVariantItemController::class,'index'])->name('products-variant-item.index');
Route::get('products-variant-item/create/{productId}/{variantId}', [VendorProductVariantItemController::class, 'create'])->name('products-variant-item.create');
Route::post('products-variant-item', [VendorProductVariantItemController::class,'store'])->name('products-variant-item.store');
Route::get('products-variant-item/{variantItem}', [VendorProductVariantItemController::class,'edit'])->name('products-variant-item.edit');
Route::put('products-variant-item/{variantItem}', [VendorProductVariantItemController::class,'update'])->name('products-variant-item.update');
Route::delete('products-variant-item/{variantItem}', [VendorProductVariantItemController::class,'destroy'])->name('products-variant-item.destroy');

/*Oder Route*/
Route::get('orders', [VendorOrderController::class, 'index'])->name('orders.index');
Route::get('orders/show/{order}', [VendorOrderController::class, 'show'])->name('orders.show');

/* Get Status Order Route*/
Route::get('orders/get-order-status/{id}/{status}',[VendorOrderController::class,'getOrderStatus'])->name('get-order-status');

/*Review Route*/
Route::get('review', [VendorProductReviewController::class, 'index'])->name('review.index');

/*Withdraw Route*/
Route::get('withdraw-request/{id}', [VendorWithdrawController::class, 'showRequest'])->name('withdraw-request.show');
Route::resource('withdraw', VendorWithdrawController::class);
