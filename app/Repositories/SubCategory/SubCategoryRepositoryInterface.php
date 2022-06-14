<?php

namespace App\Repositories\SubCategory;

interface SubCategoryRepositoryInterface
{
    public function categories();

    public function store($request);

    public function getById($id);

    public function update($request);

    public function delete($id);
}
