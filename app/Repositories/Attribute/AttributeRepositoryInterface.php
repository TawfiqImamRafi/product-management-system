<?php

namespace App\Repositories\Attribute;

interface AttributeRepositoryInterface
{
    public function attributes();

    public function store($request);

    public function getById($id);

    public function update($request);

    public function delete($id);
}
