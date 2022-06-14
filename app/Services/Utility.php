<?php

namespace App\Services;

class Utility
{
    /**
     * Universal file upload method
     * @param $request    The request object
     * @param $file_name  name of the file input field
     * @param $upload_dir upload directory
     * @return bool/string
     */
    public static function file_upload($request, $file_name, $upload_dir)
    {
        if ($request->hasFile($file_name)) {
            $file = $request->$file_name;
            $filename = time() . '_' . $file->getClientOriginalName();
            $up_path = "uploads/".date('Y-m')."/$upload_dir/";
            $path = $file->move($up_path, $filename);
            if ($file->getError()) {
                $request->session()->flash('warning', $file->getErrorMessage());

                return false;
            }

            return $path;
        }
    }

}
