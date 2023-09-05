<?php

namespace App\Traits;
use Illuminate\Http\Request;
use File;

trait ImageUploadTrait
{
    public function uploadImage(Request $request,$inputName, $path)
    {
        if($request->hasFile($inputName)){

            $image = $request->{$inputName};
            $imageName = 'image_'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path($path),$imageName);

           return $path.'/'.$imageName;

        }
    }

    public function uploadMultiImage(Request $request,$inputName, $path)
    {
        $paths = [];
        if($request->hasFile($inputName)){

            $images = $request->{$inputName};

            foreach ($images as $image){

                $imageName = 'image_'.uniqid().'.'.$image->getClientOriginalExtension();

                $image->move(public_path($path),$imageName);

                $paths[] = $path.'/'.$imageName;
            }
        return $paths;
        }
    }

    public function updateImage(Request $request,$inputName, $path,$oldImage=null)
    {
        if($request->hasFile($inputName)){

            if(File::exists(public_path($oldImage))){
                File::delete(public_path($oldImage));
            }
            $image = $request->{$inputName};
            $imageName = 'image_'.uniqid().'.'.$image->getClientOriginalExtension();

            $image->move(public_path($path),$imageName);

            return $path.'/'.$imageName;

        }
    }

    public function deleteImage($path=null)
    {
        if(File::exists(public_path($path))){
            File::delete(public_path($path));
        }
    }

}
