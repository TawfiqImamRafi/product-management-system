<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Services\Utility;

class CategoryRepository implements CategoryRepositoryInterface
{

    public function categories()
    {
        $categories=Category::get();

        if ($categories->isNotEmpty()) {
            return $categories;
        }

        return false;
    }

    public function store($request)
    {
        $category = new Category();
        $category->name = $request->get('name');
        $category->priority = $request->get('priority');
         if ($request->hasFile('thumbnail')) {
             $path = Utility::file_upload($request, 'thumbnail', 'categories');

             $category->thumbnail = $path;
         }

        if ($category->save()) {
            return $category;
        }

        return false;
    }

    public function getById($slug)
    {
        $category = Category::where("slug",$slug)->first();

        if ($category) {
            return $category;
        }

        return false;
    }

    public function update($request)
    {
        $category = Category::where("slug",$request->slug)->first();
        $category->name = $request->get('name');
        $category->priority = $request->get('priority');
         if ($request->hasFile('thumbnail')) {
             $old_image = $category->thumbnail;
             $path = Utility::file_upload($request, 'thumbnail', 'categories');

             if ($path) {
                 $category->thumbnail = $path;
                if ($old_image) {
                    unlink($old_image);
                }
             }
         }

        if ($category->save()) {
            return $category;
        }

        return false;
    }

    public function delete($slug)
    {
        $category = Category::where("slug",$slug)->first();
        if ($category) {
            return $category->delete();
        }

        return false;
    }
}
