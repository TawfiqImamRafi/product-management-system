<?php

namespace App\Repositories\SubSubCategory;

interface SubSubCategoryRepositoryInterface
{
    public function categories();

    public function store($request);

    public function getById($id);

    public function update($request);

    public function delete($id);
}
