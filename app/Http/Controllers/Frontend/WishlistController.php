<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistProduct = Wishlist::with('product')->where(['user_id' => Auth::user()->id])->orderBy('id','DESC')->get();
        return view('frontend.pages.wishlist', compact('wishlistProduct'));
    }

    public function addToWishlist($productId)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'not_authorized',
                'message' => 'Đăng nhập để thêm sản phẩm vào yêu thích!'
            ], 401);
        }

        $wishlist = Wishlist::where(['product_id' => $productId, 'user_id' => Auth::user()->id])->first();
        if ($wishlist) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sản phẩm đã có trong yêu thích'
            ]);
        }

        $newWishlist = new Wishlist();
        $newWishlist->product_id = $productId;
        $newWishlist->user_id = Auth::user()->id;
        $newWishlist->save();

        $count = Wishlist::where('user_id', Auth::user()->id)->count();

        return response()->json([
            'status' => 'success',
            'message' => 'Thêm sản phẩm vào yêu thích',
            'count' => $count
        ]);

    }

    public function destroy($wishlistItemId)
    {
        $wishlistProduct = Wishlist::where(['product_id' => $wishlistItemId, 'user_id' => Auth::user()->id])->first();

        if(!$wishlistProduct){
            abort(404);
        }

        $wishlistProduct->delete();

        toastr()->success('Xóa sản phẩm thành công');
        return redirect()->back();

    }
}
