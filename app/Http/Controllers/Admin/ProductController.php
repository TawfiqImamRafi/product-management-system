<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $product;

    public function __construct(ProductRepositoryInterface $product)
    {
        $this->product = $product;
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
        ];

        return view('admin.product.create')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];
        //validation

        $validator = Validator::make ( $request->all(), $rules );
        if ($validator->fails())
            return response()->json ( array (

                'errors' => $validator->getMessageBag()->toArray()
            ) );
        else {

            return response()->json ( $this->product->store($request));
        }

//        if ($this->category->store($request)) {
//            return response()->json([
//                'type' => 'success',
//                'title' => 'Success',
//                'message' => 'Category saved successfully',
//            ]);
//        }
//
//        return response()->json([
//            'type' => 'warning',
//            'title' => 'Failed',
//            'message' => 'Category failed to save'
//        ]);
    }

    public function edit(Request $request)
    {
        return response()->json ( $this->product->getById($request->slug));
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];

        //validation

        $validator = Validator::make ( $request->all(), $rules );
        if ($validator->fails())
            return response()->json ( array (

                'errors' => $validator->getMessageBag()->toArray()
            ) );
        else {

            return response()->json ( $this->product->update($request));
        }
        // $this->validate($request, $rules);

        // if ($this->category->update($request)) {
        //     return response()->json([
        //         'type' => 'success',
        //         'title' => 'Success',
        //         'message' => 'Category updated successfully',
        //         'redirect' => route('category.list')
        //     ]);
        // }

        // return response()->json([
        //     'type' => 'warning',
        //     'title' => 'Failed',
        //     'message' => 'Category failed to update'
        // ]);
    }

    public function destroy(Request $request)
    {
        return response()->json ( $this->product->delete($request->slug));
    }
}
