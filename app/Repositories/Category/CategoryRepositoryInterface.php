<?php

namespace App\Repositories\Category;

interface CategoryRepositoryInterface
{
    public function categories();

    public function store($request);

    public function getById($id);

    public function update($request);

    public function delete($id);
}
