<?php

namespace App\Repositories\SubCategory;

use App\Models\SubCategory;

class SubCategoryRepository implements SubCategoryRepositoryInterface
{

    public function categories()
    {
        $categories=SubCategory::get();

        if ($categories->isNotEmpty()) {
            return $categories;
        }

        return false;
    }

    public function store($request)
    {
        $category = new SubCategory();
        $category->name = $request->get('name');
        $category->category_id = $request->get('category_id');
        $category->priority = $request->get('priority');

        if ($category->save()) {
            return $category;
        }

        return false;
    }

    public function getById($slug)
    {
        $category = SubCategory::where("slug",$slug)->first();

        if ($category) {
            return $category;
        }

        return false;
    }

    public function update($request)
    {
        $category = SubCategory::where("slug",$request->slug)->first();
        $category->name = $request->get('name');
        $category->category_id = $request->get('category_id');
        $category->priority = $request->get('priority');

        if ($category->save()) {
            return $category;
        }

        return false;
    }

    public function delete($slug)
    {
        $category = SubCategory::where("slug",$slug)->first();
        if ($category) {
            return $category->delete();
        }

        return false;
    }
}
