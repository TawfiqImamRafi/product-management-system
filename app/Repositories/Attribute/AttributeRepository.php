<?php

namespace App\Repositories\Attribute;

use App\Models\Attribute;

class AttributeRepository implements AttributeRepositoryInterface
{

    public function attributes()
    {
        $attributes=Attribute::get();

        if ($attributes->isNotEmpty()) {
            return $attributes;
        }

        return false;
    }

    public function store($request)
    {
        $attribute = new Attribute();
        $attribute->name = $request->get('name');

        if ($attribute->save()) {
            return $attribute;
        }

        return false;
    }

    public function getById($id)
    {
        $attribute = Attribute::find($id);

        if ($attribute) {
            return $attribute;
        }

        return false;
    }

    public function update($request)
    {
        $attribute = Attribute::find($request->attribute_id);
        $attribute->name = $request->get('name');

        if ($attribute->save()) {
            return $attribute;
        }

        return false;
    }

    public function delete($id)
    {
        $attribute = Attribute::find($id);
        if ($attribute) {
            return $attribute->delete();
        }

        return false;
    }
}
