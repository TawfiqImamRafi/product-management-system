<?php

namespace App\Repositories\Brand;

interface BrandRepositoryInterface
{
    public function brands();

    public function store($request);

    public function getById($slug);

    public function update($request);

    public function delete($slug);
}
