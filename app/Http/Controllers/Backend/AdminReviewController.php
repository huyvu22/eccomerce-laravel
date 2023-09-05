<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\AdminReviewDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\ProductReviewGallery;


class AdminReviewController extends Controller
{
    use \App\Traits\ImageUploadTrait;
    public function index(AdminReviewDataTable $dataTable)
    {
        return $dataTable->render('admin.review.index');
    }

    public function updateApprove( $productId, $approved)
    {
        $review = ProductReview::find($productId);
        $review->status = $approved;
        $review->save();
        toastr()->success('Approve Updated successfully');
        return response(
            [
                'status' => '200',
                'message' =>'Updated Successfully'
            ]
        );
    }

    public function destroy(ProductReview $productReview)
    {
        $reviewGalleries = $productReview->reviewGalleries;

        /* Delete review gallery images */
        if($reviewGalleries->count() > 0){
            foreach ($reviewGalleries as $image){
                $this->deleteImage($image->image);
                $image->delete();
            }
        }
        $productReview->delete();
        toastr()->success('Delete Successfully');
        return redirect()->back();
    }
}
