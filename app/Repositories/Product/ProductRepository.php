<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductAttribute;
use App\Models\ProductVarient;
use App\Services\Utility;

class ProductRepository implements ProductRepositoryInterface
{

    public function products()
    {
        $products=Product::with('attribute','price','variant')->get();

        if ($products->isNotEmpty()) {
            return $products;
        }

        return false;
    }

    public function store($request)
    {
        // dd($request->all());
        $product = new Product();
        $product->category_id = $request->get('category_id');
        $product->sub_category_id = $request->get('sub_category_id');
        $product->sub_sub_category_id = $request->get('sub_sub_category_id');
        $product->brand_id = $request->get('brand_id');
        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->unit = $request->get('unit');
         if ($request->hasFile('image')) {
             $path = Utility::file_upload($request, 'image', 'products');

             $product->image = $path;
         }

        if ($product->save()) {
            $product_price = new ProductPrice();
            $product_price->product_id = $product->id;
            $product_price->unit_price = $request->get('unit_price');
            $product_price->purchase_price = $request->get('purchase_price');
            $product_price->tax = $request->get('tax');
            $product_price->discount = $request->get('discount');
            $product_price->discount_type = $request->get('discount_type');
            $product_price->quantity = $request->get('quantity');
            $product_price->shipping_cost = $request->get('shipping_cost');

            if($product_price->save()){
                if($request->get('attribute_id')){
                    foreach($request->get('attribute_id') as $key=>$attribute){
                        $product_attribute = new ProductAttribute();
                        $product_attribute->product_id = $product->id;
                        $product_attribute->attribute_id = $attribute;
                        $product_attribute->value = $request->get('attribute_tag')[$key];
                        $product_attribute->save();
                    }
                }
                if($request->get('variation_name')){
                    foreach($request->get('variation_name') as $key=>$variation){
                        $product_variation = new ProductVarient();
                        $product_variation->product_id = $product->id;
                        $product_variation->variant = $variation;
                        $product_variation->variant_price = $request->get('variation_price')[$key];
                        $product_variation->sku = $request->get('variation_sku')[$key];
                        $product_variation->quantity = $request->get('variation_quantity')[$key];
                        $product_variation->save();
                    }
                }
            }

            return $product;

        }

        return false;
    }

    public function getById($slug)
    {
        $product = Product::with('attribute','attribute.attribute','price','variant')->where("slug",$slug)->first();

        if ($product) {
            return $product;
        }

        return false;
    }

    public function update($request)
    {
        $product = Product::where("slug",$request->slug)->first();
        $product->category_id = $request->get('category_id');
        $product->sub_category_id = $request->get('sub_category_id');
        $product->sub_sub_category_id = $request->get('sub_sub_category_id');
        $product->brand_id = $request->get('brand_id');
        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->unit = $request->get('unit');
         if ($request->hasFile('image')) {
             $old_image = $product->image;
             $path = Utility::file_upload($request, 'image', 'products');

             if ($path) {
                 $product->image = $path;
                if ($old_image) {
                    unlink($old_image);
                }
             }
         }

         if ($product->save()) {
            $product_price = ProductPrice::where("product_id",$product->id)->first();
            $product_price->unit_price = $request->get('unit_price');
            $product_price->purchase_price = $request->get('purchase_price');
            $product_price->tax = $request->get('tax');
            $product_price->discount = $request->get('discount');
            $product_price->discount_type = $request->get('discount_type');
            $product_price->quantity = $request->get('quantity');
            $product_price->shipping_cost = $request->get('shipping_cost');

            if($product_price->save()){

                if($request->get('attribute_id')){
                    $attribute = ProductAttribute::where("product_id",$product->id)->get();
                    if($attribute){
                        foreach($attribute as $key=>$attribute){
                            $attribute->delete();
                        }
                    }
                    foreach($request->get('attribute_id') as $key=>$attribute){
                        $product_attribute = new ProductAttribute();
                        $product_attribute->product_id = $product->id;
                        $product_attribute->attribute_id = $attribute;
                        $product_attribute->value = $request->get('attribute_tag')[$key];
                        $product_attribute->save();
                    }
                }
                if($request->get('variation_name')){
                    $variation = ProductVarient::where("product_id",$product->id)->get();
                    if($variation){
                        foreach($variation as $key=>$attribute){
                            $attribute->delete();
                        }
                    }
                    foreach($request->get('variation_name') as $key=>$variation){
                        $product_variation = new ProductVarient();
                        $product_variation->product_id = $product->id;
                        $product_variation->variant = $variation;
                        $product_variation->variant_price = $request->get('variation_price')[$key];
                        $product_variation->sku = $request->get('variation_sku')[$key];
                        $product_variation->quantity = $request->get('variation_quantity')[$key];
                        $product_variation->save();
                    }
                }
            }
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
