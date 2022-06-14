<?php

namespace App\Repositories\Brand;

use App\Models\Brand;
use App\Services\Utility;

class BrandRepository implements BrandRepositoryInterface
{

    public function brands()
    {
        $brands=Brand::get();

        if ($brands->isNotEmpty()) {
            return $brands;
        }

        return false;
    }

    public function store($request)
    {
        $brand = new Brand();
        $brand->name = $request->get('name');
         if ($request->hasFile('logo')) {
             $path = Utility::file_upload($request, 'logo', 'brands');

             $brand->logo = $path;
         }

        if ($brand->save()) {
            return $brand;
        }

        return false;
    }

    public function getById($slug)
    {
        $brand = Brand::where("slug",$slug)->first();

        if ($brand) {
            return $brand;
        }

        return false;
    }

    public function update($request)
    {
        $brand = Brand::where("slug",$request->slug)->first();
        $brand->name = $request->get('name');
         if ($request->hasFile('logo')) {
             $old_image = $brand->logo;
             $path = Utility::file_upload($request, 'logo', 'brands');

             if ($path) {
                 $brand->logo = $path;
                if ($old_image) {
                    unlink($old_image);
                }
             }
         }

        if ($brand->save()) {
            return $brand;
        }

        return false;
    }

    public function delete($slug)
    {
        $brand = Brand::where("slug",$slug)->first();
        if ($brand) {
            return $brand->delete();
        }

        return false;
    }
}
