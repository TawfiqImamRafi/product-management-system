<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class AjaxLoadController extends Controller
{
    public function getSubCategories(Request $request)
    {
        $categories = SubCategory::select('id', 'name')->orderBy('name', 'ASC')->where('category_id', $request->get('cat_id'))->get();

        if ($categories) {
            return response()->json([
                'status' => 'success',
                'data' => $categories,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'data' => null,
        ]);
    }
}
