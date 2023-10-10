<?php
namespace App\Traits;
use Illuminate\Http\Request;

trait ImageUploadTrait{
   

    public function uploadMultipleFiles($request,$path)
    {
        $filesUrls = [];
        foreach($request->file('files') as $file){
            return $file;
            $time = rand();
            $image_changed_name = $time.'.'.strtolower($file->getClientOriginalExtension());
            $file->move(public_path($path), $image_changed_name);
            $filesUrls[] = url($path.".".$image_changed_name);
        }
        return $filesUrls;
    }
}

?>