<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    use \App\Traits\ImageUploadTrait;
    public function index()
    {
        $homepageBannerSection1 = Advertisement::where('key','homepage_section_banner_1' )->first();
        $homepageBannerSection2 = Advertisement::where('key','homepage_section_banner_2' )->first();
        $homepageBannerSection3 = Advertisement::where('key','homepage_section_banner_3' )->first();
        $homepageBannerSection4 = Advertisement::where('key','homepage_section_banner_4' )->first();
        $productPageBanner = Advertisement::where('key','product_page_banner' )->first();
        $cartPageBanner = Advertisement::where('key','cart_page_banner' )->first();
		return view('admin.advertisement.index', compact('homepageBannerSection1','homepageBannerSection2','homepageBannerSection3','homepageBannerSection4', 'productPageBanner','cartPageBanner'));
    }

    public function homepageBannerSection1(Request $request)
    {
		$request->validate([
            'banner_image' => 'image',
            'banner_url' => 'required',
        ]);

        //handle upload image
        $imagePath = $this->uploadImage($request, 'banner_image','uploads');
       	$value = [
           'banner_1' => [
				'banner_url' => $request->banner_url,
				'status' => $request->status == 'on' ? 1 : 0,
           ]
       	];

       	if(!empty($imagePath)){
           $value['banner_1']['banner_image'] = $imagePath;
       	}else{
           $data = Advertisement::where('key','homepage_section_banner_1')->first();
           $data = json_decode($data->value,true);
           $value['banner_1']['banner_image'] = $data['banner_1']['banner_image'];
        }
       	Advertisement::updateOrCreate(
            ['key' => 'homepage_section_banner_1'],
            ['value' => json_encode($value)]
        );

        toastr()->success('Updated banner image successfully');
        return redirect()->back();

    }

    public function homepageBannerSection2(Request $request)
    {
        $request->validate([
            'banner_1_image' => 'image',
            'banner_1_url' => 'nullable',
            'banner_2_image' => 'image',
            'banner_2_url' => 'nullable',
        ]);

        //handle upload image
        $imagePathBanner1 = $this->uploadImage($request, 'banner_1_image','uploads');
        $imagePathBanner2 = $this->uploadImage($request, 'banner_2_image','uploads');
        $value = [
            'banner_1' => [
                'banner_url' => $request->banner_1_url,
                'banner_status' => $request->banner_1_status == 'on' ? 1 : 0,
            ],
            'banner_2' => [
                'banner_url' => $request->banner_2_url,
                'banner_status' => $request->banner_2_status == 'on' ? 1 : 0,
            ]
        ];

        if(!empty($imagePathBanner1) ){
            $value['banner_1']['banner_image'] = $imagePathBanner1;

        }else{
            $data = Advertisement::where('key','homepage_section_banner_2')->first();
            $data = json_decode($data->value,true);
            $value['banner_1']['banner_image'] = $data['banner_1']['banner_image'];
        }

        if(!empty($imagePathBanner2)){
            $value['banner_2']['banner_image'] = $imagePathBanner2;
        }else{
            $data = Advertisement::where('key','homepage_section_banner_2')->first();
            $data = json_decode($data->value,true);
            $value['banner_2']['banner_image'] = $data['banner_2']['banner_image'];
        }

        Advertisement::updateOrCreate(
            ['key' => 'homepage_section_banner_2'],
            ['value' => json_encode($value)]
        );

        toastr()->success('Updated banner image successfully');
        return redirect()->back();

    }

    public function homepageBannerSection3(Request $request)
    {
        $request->validate([
            'banner_1_image' => 'image',
            'banner_1_url' => 'nullable',
            'banner_2_image' => 'image',
            'banner_2_url' => 'nullable',
            'banner_3_image' => 'image',
            'banner_3_url' => 'nullable',
        ]);

        //handle upload image
        $imagePathBanner1 = $this->uploadImage($request, 'banner_1_image','uploads');
        $imagePathBanner2 = $this->uploadImage($request, 'banner_2_image','uploads');
        $imagePathBanner3 = $this->uploadImage($request, 'banner_3_image','uploads');
        $value = [
            'banner_1' => [
                'banner_url' => $request->banner_1_url,
                'banner_status' => $request->banner_1_status == 'on' ? 1 : 0,
            ],
            'banner_2' => [
                'banner_url' => $request->banner_2_url,
                'banner_status' => $request->banner_2_status == 'on' ? 1 : 0,
            ],
            'banner_3' => [
                'banner_url' => $request->banner_3_url,
                'banner_status' => $request->banner_3_status == 'on' ? 1 : 0,
            ]
        ];

        if(!empty($imagePathBanner1) ){
            $value['banner_1']['banner_image'] = $imagePathBanner1;

        }else{
            $data = Advertisement::where('key','homepage_section_banner_3')->first();
            $data = json_decode($data->value,true);
            $value['banner_1']['banner_image'] = $data['banner_1']['banner_image'];
        }

        if(!empty($imagePathBanner2)){
            $value['banner_2']['banner_image'] = $imagePathBanner2;
        }else{
            $data = Advertisement::where('key','homepage_section_banner_3')->first();
            $data = json_decode($data->value,true);
            $value['banner_2']['banner_image'] = $data['banner_2']['banner_image'];
        }

        if(!empty($imagePathBanner3)){
            $value['banner_3']['banner_image'] = $imagePathBanner3;
        }else{
            $data = Advertisement::where('key','homepage_section_banner_3')->first();
            $data = json_decode($data->value,true);
            $value['banner_3']['banner_image'] = $data['banner_3']['banner_image'];
        }

        Advertisement::updateOrCreate(
            ['key' => 'homepage_section_banner_3'],
            ['value' => json_encode($value)]
        );

        toastr()->success('Updated banner image successfully');
        return redirect()->back();

    }

    public function homepageBannerSection4(Request $request)
    {
        $request->validate([
            'banner_image' => 'image',
            'banner_url' => 'required',
        ]);

        //handle upload image
        $imagePath = $this->uploadImage($request, 'banner_image','uploads');
        $value = [
            'banner_1' => [
                'banner_url' => $request->banner_url,
                'status' => $request->status == 'on' ? 1 : 0,
            ]
        ];

        if(!empty($imagePath)){
            $value['banner_1']['banner_image'] = $imagePath;
        }else{
            $data = Advertisement::where('key','homepage_section_banner_4')->first();
            $data = json_decode($data->value,true);
            $value['banner_1']['banner_image'] = $data['banner_1']['banner_image'];
        }
        Advertisement::updateOrCreate(
            ['key' => 'homepage_section_banner_4'],
            ['value' => json_encode($value)]
        );

        toastr()->success('Updated banner image successfully');
        return redirect()->back();

    }

    public function productPageBanner(Request $request)
    {
        $request->validate([
            'banner_image' => 'image',
            'banner_url' => 'required',
        ]);

        //handle upload image
        $imagePath = $this->uploadImage($request, 'banner_image','uploads');
        $value = [
            'banner_1' => [
                'banner_url' => $request->banner_url,
                'status' => $request->status == 'on' ? 1 : 0,
            ]
        ];

        if(!empty($imagePath)){
            $value['banner_1']['banner_image'] = $imagePath;
        }else{
            $data = Advertisement::where('key','product_page_banner')->first();
            $data = json_decode($data->value,true);
            $value['banner_1']['banner_image'] = $data['banner_1']['banner_image'];
        }
        Advertisement::updateOrCreate(
            ['key' => 'product_page_banner'],
            ['value' => json_encode($value)]
        );

        toastr()->success('Updated banner image successfully');
        return redirect()->back();
    }

    public function cartPageBanner(Request $request)
    {
        $request->validate([
            'banner_1_image' => 'image',
            'banner_1_url' => 'nullable',
            'banner_2_image' => 'image',
            'banner_2_url' => 'nullable',
        ]);

        //handle upload image
        $imagePathBanner1 = $this->uploadImage($request, 'banner_1_image','uploads');
        $imagePathBanner2 = $this->uploadImage($request, 'banner_2_image','uploads');
        $value = [
            'banner_1' => [
                'banner_url' => $request->banner_1_url,
                'banner_status' => $request->banner_1_status == 'on' ? 1 : 0,
            ],
            'banner_2' => [
                'banner_url' => $request->banner_2_url,
                'banner_status' => $request->banner_2_status == 'on' ? 1 : 0,
            ]
        ];

        if(!empty($imagePathBanner1) ){
            $value['banner_1']['banner_image'] = $imagePathBanner1;

        }else{
            $data = Advertisement::where('key','cart_page_banner')->first();
            $data = json_decode($data->value,true);
            $value['banner_1']['banner_image'] = $data['banner_1']['banner_image'];
        }

        if(!empty($imagePathBanner2)){
            $value['banner_2']['banner_image'] = $imagePathBanner2;
        }else{
            $data = Advertisement::where('key','cart_page_banner')->first();
            $data = json_decode($data->value,true);
            $value['banner_2']['banner_image'] = $data['banner_2']['banner_image'];
        }

        Advertisement::updateOrCreate(
            ['key' => 'cart_page_banner'],
            ['value' => json_encode($value)]
        );

        toastr()->success('Updated banner image successfully');
        return redirect()->back();
    }
}
