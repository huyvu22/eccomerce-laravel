<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BrandDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    use \App\Traits\ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(BrandDataTable $dataTable)
    {
//        dd(Gate::allows('brand.view'));
        return $dataTable->render('admin.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('brand.add',Brand::class);
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|max:2048',
            'name' => 'required|max:200',
            'is_featured' => 'required',
            'status' => 'required',
        ]);

        $imagePath= $this->uploadImage( $request, 'logo','uploads');

        $brand= new Brand();

        $brand->logo = $imagePath;
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $brand->is_featured = $request->is_featured;
        $brand->status = $request->status;
        $brand->save();
        toastr('Created Successfully','success');
        return redirect()->route('admin.brand.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        $this->authorize('brand.edit',$brand);
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Brand $brand)
    {
//        $this->authorize('brand.edit',$brand);

        if ($request->has('switch_status')) {
            $brand->status = $request->switch_status;
            $brand->save();
            return response(['message' =>'Status has been updated!']);
        } else {
            $request->validate([
                'logo' => 'nullable|image|max:2048',
                'name' => 'required|max:200',
                'is_featured' => 'required',
                'status' => 'required',
            ]);
            $brand->logo = $this->updateImage($request, 'logo', 'uploads', $brand->logo) ?? $brand->logo;
            $brand->name = $request->name;
            $brand->slug = Str::slug($request->name);
            $brand->is_featured = $request->is_featured;
            $brand->status = $request->status;
            $brand->save();
            toastr('Updated Successfully','success');
            return redirect()->route('admin.brand.index');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $this->authorize('brand.delete',$brand);
       if(Product::find('brand_id', $brand->id)->count() > 0){
           toastr('This brand have products, You can not delete it!!!','error');
           return redirect()->back();
       }
        $brand->delete();
        toastr('Delete Successfully','success');
        return redirect()->back();
    }
}
