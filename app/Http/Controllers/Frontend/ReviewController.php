<?php

namespace App\Http\Controllers\Frontend;

use App\DataTables\UserProductReviewsDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\ProductReviewGallery;
use Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use \App\Traits\ImageUploadTrait;

    public function index(UserProductReviewsDataTable $dataTable)
    {
		return $dataTable->render('frontend.dashboard.review.index');
    }
    public function create(Request $request)
    {
        $request->validate([
            'rating' => 'required',
            'review' => 'max:200',
            'images.*' => 'image',
        ]);

        $checkReviewExists = ProductReview::where(['product_id' => $request->product_id, 'user_id' => Auth::user()->id])->first();
        if ($checkReviewExists){
            toastr()->error('Bạn đã đánh giá sản phẩm này trước đó');
            return redirect()->back();
        }


		$imagePaths = $this -> uploadMultiImage($request,'images','uploads');

     	$productReview = new ProductReview();
        $productReview->rating = $request->rating;
        $productReview->review = $request->review;
        $productReview->product_id = $request->product_id;
        $productReview->vendor_id = $request->vendor_id;
        $productReview->user_id = Auth::user()->id;
        $productReview->status = 1;
        $productReview->save();

        if(!empty($imagePaths)){
            foreach ($imagePaths as $imagePath){
                $reviewGallery = new ProductReviewGallery();
                $reviewGallery->image = $imagePath;
                $reviewGallery->product_review_id = $productReview->id;
                $reviewGallery->save();
            }
        }
        toastr()->success('Cám ơn đã để lại đánh giá');
        return redirect()->back();
    }
}
