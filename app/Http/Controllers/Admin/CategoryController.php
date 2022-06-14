<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(CategoryRepositoryInterface $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $data = [
            'page_title' => 'Category list',
            'categories' => $this->category->categories(),
        ];

        return view('admin.category.index')->with(array_merge($this->data, $data));
    }

    public function create()
    {
        $data = [
            'page_title' => 'Create new Category',
            'categories' => $this->category->categories()
        ];

        return view('admin.category.create')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];
        //validation
        $this->validate($request, $rules);

        if ($this->category->store($request)) {
            return response()->json([
                'type' => 'success',
                'title' => 'Success',
                'message' => 'Category saved successfully',
            ]);
        }

        return response()->json([
            'type' => 'warning',
            'title' => 'Failed',
            'message' => 'Category failed to save'
        ]);
    }

    public function edit($id)
    {
        $data = [
            'page_title' => 'Update Category',
            'category' => $this->category->getById($id),
            'categories' => $this->category->categories()
        ];

        return view('admin.category.edit')->with(array_merge($this->data, $data));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
        ];
        //validation
        $this->validate($request, $rules);

        if ($this->category->update($request, $id)) {
            return response()->json([
                'type' => 'success',
                'title' => 'Success',
                'message' => 'Category updated successfully',
                'redirect' => route('category.list')
            ]);
        }

        return response()->json([
            'type' => 'warning',
            'title' => 'Failed',
            'message' => 'Category failed to update'
        ]);
    }

    public function destroy($id)
    {
        if($this->category->delete($id)){
            return response()->json([
                'type' => 'success',
                'title' => 'Deleted',
                'message' => 'Category has been deleted',
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Failed to delete Category',
        ]);

    }
}
