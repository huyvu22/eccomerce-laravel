<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

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
                'message' => 'Login before adding to wishlist! <a href="'.route('login').'">Login Now !!!</a>'
            ], 401);
        }

        $wishlist = Wishlist::where(['product_id' => $productId, 'user_id' => Auth::user()->id])->first();
        if ($wishlist) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product is already in the wishlist'
            ]);
        }

        $newWishlist = new Wishlist();
        $newWishlist->product_id = $productId;
        $newWishlist->user_id = Auth::user()->id;
        $newWishlist->save();

        $count = Wishlist::where('user_id', Auth::user()->id)->count();

        return response()->json([
            'status' => 'success',
            'message' => 'Wishlist added successfully',
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

        toastr()->success('Product removed successfully');
        return redirect()->back();

    }
}
