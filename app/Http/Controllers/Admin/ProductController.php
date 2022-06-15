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

        try {
            DB::beginTransaction();
            $header = null;
            $data = [];
// dd(fopen($request->bulk_file, 'r'));
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
                    dd($row);
                        $product = new Product();
                        $product->subscription_id = $request->input('subscription_id');
                        $product->user_id = $request->input('user_id');
                        $product->outlet_id = $request->input('outlet_id');

                        $category_id = null;

                        /*if not category then store*/
                        if ($row['category']) {
                            $category = Category::where('name', $row['category'])->where('subscription_id', $request->input('subscription_id'))->first();
                            if (!$category) {
                                $category = new Category();
                                $category->user_id = $request->input('user_id');
                                $category->subscription_id = $request->input('subscription_id');
                                $category->name = $row['category'];
                                $category->save();
                            }

                            $category_id = $category->id;

                        }

                        $product->category_id = $category_id;

                        /*if not Brand then store*/
                        if ($row['brand']) {
                            $brand = Brand::where('name', $row['brand'])->where('subscription_id', $request->input('subscription_id'))->first();
                            if (!$brand) {
                                $brand = new Brand();
                                $brand->user_id = $request->input('user_id');
                                $brand->subscription_id = $request->input('subscription_id');
                                $brand->name = $row['brand'];
                                $brand->save();
                            }

                            $product->brand_id = $brand->id;
                        }

                        $product->product_code = $row['product_code'];
                        $product->name = $row['name'];
                        $product->description = null;

                        if (($row['vat_type'] && $row['vat_type'] === 'inclusive') || $row['vat_type'] === 'exclusive') {
                            $vat_category = VatCategory::where('vat', $row['vat'])->where('subscription_id', $request->input('subscription_id'))->first();
                            if (!$vat_category) {
                                $vat_category = new VatCategory();
                                $vat_category->user_id = $request->input('user_id');
                                $vat_category->subscription_id = $request->input('subscription_id');
                                $vat_category->vat = $row['vat'];
                                $vat_category->save();
                            }
                            $product->vat_type = strtolower($row['vat_type']);
                            $product->vat_category_id = $vat_category->id;
                        }

                        if ($row['supplier_phone']) {
                            //supplier
                            $supplier = Supplier::where('phone', $row['supplier_phone'])->where('subscription_id', $request->input('subscription_id'))->first();
                            if (!$supplier) {
                                $supplier = new Supplier();
                                $supplier->user_id = $request->input('user_id');
                                $supplier->subscription_id = $request->input('subscription_id');
                                $supplier->outlet_id = $request->input('outlet_id');
                                $supplier->name = $row['supplier_name'];
                                $supplier->phone = $row['supplier_phone'];
                                $supplier->save();
                            }

                            $product->supplier_id = $supplier->id;
                        }

                        $product->manufactured_by = $row['manufactured_by'];
                        $product->created_by = $request->input('user_id');

                        if ($product->save()) {
                            //check unit with name
                            $unit = Unit::where('name', $row['unit'])->orWhere('description', $row['unit'])->first();
                            if (!$unit) {
                                $unit = new Unit();
                                $unit->name = $row['unit'];
                                $unit->description = $row['unit'];
                                $unit->save();
                            }

                            $stock = new Stock();
                            $stock->product_id = $product->id;
                            $stock->unit_id = $unit->id;
                            $stock->quantity = $row['quantity'];
                            $stock->partial_quantity = 0;
                            $stock->created_by = $request->input('user_id');
                            $stock->save();

                            //pricing
                            $product_price = new ProductPrice();
                            $product_price->product_id = $product->id;
                            $product_price->purchase_price = $row['purchase_price'];
                            $product_price->retail_price = $row['sale_price'];
                            $product_price->wholesale_price = $row['wholesale_price'] ? $row['wholesale_price'] : 0;
                            $product_price->created_by = $request->input('user_id');
                            $product_price->save();

                        }

                }


                DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'Congrats! Bulk product uploaded successfully'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'No data found from the csv'
            ]);

        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while uploading bulk product, '. $e->getMessage().$e->getLine()
            ]);
        }
    }
    
}
