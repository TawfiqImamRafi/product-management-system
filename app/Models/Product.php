<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = $this->slugify($value);
    }

    protected function slugify($name)
    {
        $slug = str_replace(array(' ', '.'), array('-', ''), strtolower($name));

        if (isset($this->attributes['id'])) {
            $spot = Category::where('slug', $slug)->where('id', '!=', $this->attributes['id'])->get();
        } else {
            $spot = Category::where('slug', $slug)->get();
        }

        if (count($spot) > 0) {
            $slug = $slug.'-'.$spot->count();
        }

        return $slug;
    }

    public function attribute()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id', 'id');
    }
    public function price()
    {
        return $this->hasOne(ProductPrice::class, 'product_id', 'id');
    }
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
    public function variant()
    {
        return $this->hasMany(ProductVarient::class, 'product_id', 'id');
    }
}
