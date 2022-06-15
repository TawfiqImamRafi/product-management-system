<?php

namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function products();

    public function store($request);

    public function getById($slug);

    public function update($request);

    public function delete($slug);
}
