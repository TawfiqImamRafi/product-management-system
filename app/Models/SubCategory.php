<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
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
}
