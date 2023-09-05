<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\HomePageSetting;
use App\Models\Product;
use App\Models\Slider;
use App\Models\SubCategory;
use App\Models\Vendor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status',1)->orderBy('serial','asc')->get();
        $flashSaleDate = FlashSale::first();
        $flashSaleItems = FlashSaleItem::where('show_at_home',1)->where('status',1)->get();
        $popularCategory = HomePageSetting::where('key','popular_category_section')->first();
        $brands = Brand::where('status',1)->get();
        $typeProducts = $this->typeProducts();
        $productSlidersSectionOne = HomePageSetting::where('key','product_sliders_section_one')->first();
        $productSlidersSectionTwo = HomePageSetting::where('key','product_sliders_section_two')->first();
        $productSlidersSectionThree = HomePageSetting::where('key','product_sliders_section_three')->first();

        $homepageBannerSection1 = Advertisement::where('key','homepage_section_banner_1' )->first();
        $homepageBannerSection2 = Advertisement::where('key','homepage_section_banner_2' )->first();
        $homepageBannerSection3 = Advertisement::where('key','homepage_section_banner_3' )->first();
        $homepageBannerSection4 = Advertisement::where('key','homepage_section_banner_4' )->first();

        $blogs = Blog::with(['category','user'])->where('status',1)->orderBy('id','DESC')->take(8)->get();


        return view('frontend.home.home',compact(
            'sliders',
            'flashSaleDate',
            'flashSaleItems',
            'popularCategory',
            'brands',
            'typeProducts',
            'productSlidersSectionOne',
            'productSlidersSectionTwo',
            'productSlidersSectionThree',
            'homepageBannerSection1',
            'homepageBannerSection2',
            'homepageBannerSection3',
            'homepageBannerSection4',
            'blogs'
        ));
    }

    public function typeProducts()
    {
        $typeProducts = [];
        $typeProducts['new_arrival'] = Product::where(['product_type'=>'new_arrival','is_approved'=>1, 'status'=>1])->take(10)->orderBy('id','DESC')->get();
        $typeProducts['top_product'] = Product::where(['product_type'=>'top_product','is_approved'=>1, 'status'=>1])->take(10)->orderBy('id','DESC')->get();
        $typeProducts['featured'] = Product::where(['product_type'=>'featured','is_approved'=>1, 'status'=>1])->take(10)->orderBy('id','DESC')->get();
        $typeProducts['best_product'] = Product::where(['product_type'=>'best_product','is_approved'=>1, 'status'=>1])->take(10)->orderBy('id','DESC')->get();
        return $typeProducts;

    }

    public function vendorPage()
    {
        $vendors = Vendor::where('status',1)->paginate(16);
        return view('frontend.pages.vendor',compact('vendors'));
    }

    public function vendorProductPage(Vendor $vendor)
    {
        $products = Product::where([
            'status' => 1,
            'is_approved' => 1,
            'vendor_id' => $vendor->id
        ])->orderBy('id','DESC')->paginate(12);


        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();

        $productPageBanner = Advertisement::where('key','product_page_banner' )->first();

        return view('frontend.pages.vendor-product',compact('products','categories', 'brands','productPageBanner','vendor'));

    }
}
