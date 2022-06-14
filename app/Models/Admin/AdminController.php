<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminController extends Model
{
    use HasFactory;

    public function index()
    {
        return view('admin.dashboard');
    }
}
