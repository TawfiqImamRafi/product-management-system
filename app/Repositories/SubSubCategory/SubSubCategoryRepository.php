<?php

namespace App\Repositories\SubSubCategory;

use App\Models\SubSubCategory;

class SubSubCategoryRepository implements SubSubCategoryRepositoryInterface
{

    public function categories()
    {
        $categories=SubSubCategory::get();

        if ($categories->isNotEmpty()) {
            return $categories;
        }

        return false;
    }

    public function store($request)
    {
        $category = new SubSubCategory();
        $category->name = $request->get('name');
        $category->category_id = $request->get('category_id');
        $category->sub_category_id = $request->get('sub_category_id');
        $category->priority = $request->get('priority');

        if ($category->save()) {
            return $category;
        }

        return false;
    }

    public function getById($slug)
    {
        $category = SubSubCategory::where("slug",$slug)->first();

        if ($category) {
            return $category;
        }

        return false;
    }

    public function update($request)
    {
        $category = SubSubCategory::where("slug",$request->slug)->first();
        $category->name = $request->get('name');
        $category->category_id = $request->get('category_id');
        $category->sub_category_id = $request->get('sub_category_id');
        $category->priority = $request->get('priority');

        if ($category->save()) {
            return $category;
        }

        return false;
    }

    public function delete($slug)
    {
        $category = SubSubCategory::where("slug",$slug)->first();
        if ($category) {
            return $category->delete();
        }

        return false;
    }
}
