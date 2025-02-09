<?php
namespace App\Helpers;

use App\Models\File;

class UploadFile
{
    //upload mas  products  files
    public static function UploadProductFile($file, $path)
    {
        //get only name
        $name = $file->getClientOriginalName();
        // save to storage/app/path as the new $filename
        return $file->storeAs($path, $name, 'public');
    }
    //upload single file
    public static function UploadSinglelFile($file, $path)
    {
        //get only name without ext
        $name = preg_replace('/\..+$/', '', $file->getClientOriginalName());
        //new file name with random value
        $filename = $name . rand() . '.' . $file->getClientOriginalExtension();
        $filename = str_replace(' ', '', $filename);
        // save to storage/app/path as the new $filename
        return $file->storeAs($path, $filename, 'public');
    }

    //upload Multi files
    public static function UploadMultiFiles($files, $pathName, $model_type, $model_id)
    {
        foreach ($files as $file) {
            $OrignalName = $file->getClientOriginalName();
            //get only name without ext
            $name = preg_replace('/\..+$/', '', $file->getClientOriginalName());
            //new file name with random value
            $filename = $name . '.' . $file->getClientOriginalExtension();
            //get new path or uploded file
            $path = $file->storeAs($pathName, $filename, 'public');
            //get size uploded file
            $size = $file->getSize();
            // save files in files modules
            File::create(['name' => $OrignalName, 'path' => $path, 'size' => $size, 'model_type' => $model_type, 'model_id' => $model_id]);
        }
    }
    //Remove single file from storage
    public static function RemoveFile($file = null)
    {
        if (!is_null($file) && file_exists(public_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $file)) {
            unlink(public_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $file);
        }
    }
    //Remove multiple file from storage and File Model
    public static function RemoveMultiFiles($model_type, $model_id)
    {
        $files = File::where('model_id', $model_id)->where('model_type', $model_type)->get();
        foreach ($files as $file) {
            File::where('id', $file->id)->delete();
            self::RemoveFile($file->path);
        }
    }

}
