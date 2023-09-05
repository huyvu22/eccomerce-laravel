<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(SliderDataTable $dataTable)
    {
       return $dataTable->render('admin.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'banner'=>'required|image|max:2048',
            'type'=>'required',
            'title'=>'required|max:200',
            'starting_price'=>'required|integer',
            'btn_url'=>'url',
            'serial'=>'required|integer',
            'status'=>'required',
        ]);
        $slider= new Slider();

        //upload image
       $imagePath= $this->uploadImage( $request, 'banner','uploads');
        $slider->banner = $imagePath;
        $slider->type = $request->type;
        $slider->title = $request->title;
        $slider->starting_price = $request->starting_price;
        $slider->btn_url = $request->btn_url;
        $slider->serial = $request->serial;
        $slider->status = $request->status;
        $slider->save();
        toastr('Created Successfully','success');

        return redirect()->route('admin.slider.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('admin.slider.edit',compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'banner'=>'nullable|image|max:2048',
            'type'=>'required',
            'title'=>'required|max:200',
            'starting_price'=>'required|integer',
            'btn_url'=>'url',
            'serial'=>'required|integer',
            'status'=>'required',
        ]);

        $slider->banner = $this->updateImage($request, 'banner', 'uploads', $slider->banner) ?? $slider->banner;
        $slider->type = $request->type;
        $slider->title = $request->title;
        $slider->starting_price = $request->starting_price;
        $slider->btn_url = $request->btn_url;
        $slider->serial = $request->serial;
        $slider->status = $request->status;
        $slider->save();
        toastr('Update Successfully','success');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        $this->deleteImage($slider->banner);
        toastr('Delete Successfully');
        return redirect()->back();
    }
}
