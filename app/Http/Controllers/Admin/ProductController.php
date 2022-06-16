<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\SubSubCategory\SubSubCategoryRepositoryInterface;
use App\Repositories\SubCategory\SubCategoryRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Attribute\AttributeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $product;
    protected $category;
    protected $subcategory;
    protected $parent_category;
    protected $brand;
    protected $attribute;

    public function __construct(ProductRepositoryInterface $product,SubSubCategoryRepositoryInterface $category, CategoryRepositoryInterface $parent_category, SubCategoryRepositoryInterface $subcategory,BrandRepositoryInterface $brand,AttributeRepositoryInterface $attribute)
    {
        $this->product = $product;
        $this->category = $category;
        $this->parent_category = $parent_category;
        $this->subcategory = $subcategory;
        $this->brand = $brand;
        $this->attribute = $attribute;
    }

    public function index()
    {
        $data = [
            'page_title' => 'Product list',
            'products' => $this->product->products(),
        ];

        return view('admin.product.index')->with(array_merge($this->data, $data));
    }

    public function create()
    {
        $data = [
            'page_title' => 'Product Create',
            'sub_categories' => $this->category->categories(),
            'parent_categories' => $this->parent_category->categories(),
            'sub_sub_Categories' => $this->subcategory->categories(),
            'brands' => $this->brand->brands(),
            'attributes' => $this->attribute->attributes(),
        ];

        return view('admin.product.create')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'unit_price' => 'required',
            'purchase_price' => 'required',
            'discount' => 'required',
            'image' => 'required',
        ]);

       if ($this->product->store($request)) {
           return response()->json([
               'type' => 'success',
               'title' => 'Success',
               'message' => 'Product saved successfully',
           ]);
       }

       return response()->json([
           'type' => 'warning',
           'title' => 'Failed',
           'message' => 'Product failed to save'
       ]);
    }

    public function edit($slug)
    {
        $data = [
            'page_title' => 'Update Category',
            'product' => $this->product->getById($slug),
            'sub_categories' => $this->category->categories(),
            'parent_categories' => $this->parent_category->categories(),
            'sub_sub_Categories' => $this->subcategory->categories(),
            'brands' => $this->brand->brands(),
            'attributes' => $this->attribute->attributes(),
        ];

        return view('admin.product.edit')->with(array_merge($this->data, $data));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'unit_price' => 'required',
            'purchase_price' => 'required',
            'discount' => 'required',
            'image' => 'required',
        ]);

        if ($this->product->update($request)) {
            return response()->json([
                'type' => 'success',
                'title' => 'Success',
                'message' => 'Product updated successfully',
                'redirect' => route('product.list')
            ]);
        }

        return response()->json([
            'type' => 'warning',
            'title' => 'Failed',
            'message' => 'Product failed to update'
        ]);
    }

    public function destroy($slug)
    {
        if($this->product->delete($slug)){
            return response()->json([
                'type' => 'success',
                'title' => 'Deleted',
                'message' => 'Product has been deleted',
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Failed to delete product',
        ]);
    }

    public function bulkCreate(){
        return view('admin.product.bulk');
    }

    public function bulkUpload(Request $request)
    {
        $this->validate($request, [
            'bulk_file' => 'required',
        ]);

        $header = null;
        $data = [];
        if ($handle = fopen($request->bulk_file, 'r')) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false)
            {
                if(!$header) {
                    $header = ['name', 'category_id', 'sub_category_id', 'sub_sub_category_id', 'brand_id', 'unit', 'quantity', 'unit_price', 'purchase_price', 'tax', 'discount', 'discount_type', 'details'];
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        //store product
        if ($data) {
            foreach ($data as $row) {
                    $product = new Product();
                    $product->name = $row['name'];
                    $product->category_id = $row['category_id'];
                    $product->sub_category_id = $row['sub_category_id'];
                    $product->sub_sub_category_id = $row['sub_sub_category_id'];
                    $product->brand_id = $row['brand_id'];
                    $product->unit = $row['unit'];
                    $product->description = $row['details'];

                    if ($product->save()) {
                        $product_price = new ProductPrice();
                        $product_price->product_id = $product->id;
                        $product_price->unit_price = $row['unit_price'];
                        $product_price->purchase_price = $row['purchase_price'];
                        $product_price->tax = $row['tax'];
                        $product_price->discount = $row['discount'];
                        $product_price->discount_type = $row['discount_type'];
                        $product_price->quantity = $row['quantity'];
                        $product_price->save();
                    }
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Congrats! Bulk product uploaded successfully'
            ]);

    }
    
}
