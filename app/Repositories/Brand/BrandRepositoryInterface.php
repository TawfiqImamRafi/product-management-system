<?php

namespace App\Repositories\Brand;

interface BrandRepositoryInterface
{
    public function brands();

    public function store($request);

    public function getById($id);

    public function update($request);

    public function delete($id);
}
