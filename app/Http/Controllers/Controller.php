<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Default data variable for views
     */
    protected $data = [];

    /**
     * Class Constructor
     * @author DataTrix Team
     */
    public function __construct()
    {
        // Default variables
        $this->data = [
            'page_title' => 'Dashboard',
            'page_header' => '6amtech',
        ];

    }
}
