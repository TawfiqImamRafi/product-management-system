<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Attribute\AttributeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    protected $attribute;

    public function __construct(AttributeRepositoryInterface $attribute)
    {
        $this->attribute = $attribute;
    }

    public function index()
    {
        $data = [
            'page_title' => 'Attribute list',
            'attributes' => $this->attribute->attributes(),
        ];

        return view('admin.attribute.index')->with(array_merge($this->data, $data));
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

            return response()->json ( $this->attribute->store($request));
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
        return response()->json ( $this->attribute->getById($request->id));
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

            return response()->json ( $this->attribute->update($request));
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
        return response()->json ( $this->attribute->delete($request->id));
    }
}
