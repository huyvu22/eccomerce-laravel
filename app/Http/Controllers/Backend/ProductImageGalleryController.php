<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductImageGalleryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImageGallery;
use Illuminate\Http\Request;

class ProductImageGalleryController extends Controller
{
    use \App\Traits\ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request, ProductImageGalleryDataTable $dataTable)
    {
        $product = Product::find($request->product);

//        $productIds = ProductImageGallery::where('product_id',$product->id)->get();

        return $dataTable -> render('admin.product.image-gallery.index', compact('product'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'image.*' => 'required|image|max:2048',
        ]);

      $imagePaths = $this->uploadMultiImage($request, 'image','uploads');

      if($imagePaths){
          foreach ($imagePaths as $imagePath){
              $productImageGallery = new ProductImageGallery;
              $productImageGallery -> product_id = $request -> product;
              $productImageGallery -> image = $imagePath;
              $productImageGallery -> save();
          }
          toastr('Upload successful');
      }
          return redirect()->back();

    }

    /**
     * Display the specified resource.
     */
    public function show( ProductImageGalleryDataTable $dataTable, Product $product)
    {
//        return $dataTable -> render('admin.product.image-gallery.index', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productImage = ProductImageGallery::find($id);
        $this->deleteImage($productImage->image);
        $productImage->delete();
        toastr('Deleted successfully');
        return redirect()->back();
    }
}
