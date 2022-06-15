<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Services\Utility;

class ProductRepository implements ProductRepositoryInterface
{

    public function products()
    {
        $products=Product::get();

        if ($products->isNotEmpty()) {
            return $products;
        }

        return false;
    }

    public function store($request)
    {
        $product = new Product();
        $product->name = $request->get('name');
         if ($request->hasFile('logo')) {
             $path = Utility::file_upload($request, 'logo', 'products');

             $product->logo = $path;
         }

        if ($product->save()) {
            return $product;
        }

        return false;
    }

    public function getById($slug)
    {
        $product = Product::where("slug",$slug)->first();

        if ($product) {
            return $product;
        }

        return false;
    }

    public function update($request)
    {
        $product = Product::where("slug",$request->slug)->first();
        $product->name = $request->get('name');
         if ($request->hasFile('logo')) {
             $old_image = $product->logo;
             $path = Utility::file_upload($request, 'logo', 'products');

             if ($path) {
                 $product->logo = $path;
                if ($old_image) {
                    unlink($old_image);
                }
             }
         }

        if ($product->save()) {
            return $product;
        }

        return false;
    }

    public function delete($slug)
    {
        $product = Product::where("slug",$slug)->first();
        if ($product) {
            return $product->delete();
        }

        return false;
    }
}
