<?php

use Carbon\Carbon;

if (!function_exists('database_formatted_date')) {
    function database_formatted_date($value = null) {

        return date('Y-m-d', strtotime($value));
    }
}

if (!function_exists('database_formatted_datetime')) {
    function database_formatted_datetime($date = null)
    {
        return $date ? date('Y-m-d H:i:s', strtotime($date)) : date('Y-m-d H:i:s');
    }
}

if (!function_exists('database_formatted_time')) {
    function database_formatted_time($date = null)
    {
        return $date ? date('H:i:s', strtotime($date)) : date('H:i:s');
    }
}


if (!function_exists('user_formatted_datetime')) {
    function user_formatted_datetime($date = null)
    {
        return $date ? date('d M, y  h:i A', strtotime($date)) : date('d M, y  h:i A');
    }
}


if (!function_exists('user_formatted_time')) {
    function user_formatted_time($date = null)
    {
        return $date ? date('h:i A', strtotime($date)) : date('h:i A');
    }
}

if (!function_exists('database_formatted_date')) {
    function database_formatted_date($value = null) {

        return date('Y-m-d', strtotime($value));
    }
}

if (!function_exists('user_formatted_date')) {
    function user_formatted_date($value = null) {

        return date('d-M, Y', strtotime($value));
    }
}

if (!function_exists('datepicker_formatted_date')) {
    function datepicker_formatted_date($value = null) {
        if (!$value) {
            return '';
        }

        return date('d-m-Y', strtotime($value));
    }
}

if (!function_exists('pagination_links')) {
    function pagination_links($route, $pagination)
    {
        if(count($pagination['links']) < 4) {
            return '';
        }

        $code = '<div class="pagination">';
        $code .= '<ul>';

        $code .= '<li class="page-first"><a href="'.route($route, 1).'"><i class="fas fa-angle-double-left"></i></a></li>';


        foreach ($pagination['links'] as $link)
        {
            if ($link->label === 'pagination.previous') {
                if ($pagination['current_page'] > 1) {
                    $code .= '<li><a href="'.route($route, $pagination['current_page']-1).'"><i class="fas fa-angle-left"></i></a></li>';
                } else {
                    $code .= '<li class="disable-link"><a href="javascript:void(0)"><i class="fas fa-angle-left"></i></a></li>';
                }
            } elseif ($link->label === 'pagination.next') {
                if ($pagination['last_page'] > $pagination['current_page']) {
                    $code .= '<li><a href="'.route($route, $pagination['current_page']+1).'"><i class="fas fa-angle-right"></i></a></li>';
                } else {
                    $code .= '<li class="disable-link"><a href="javascript:void(0)"><i class="fas fa-angle-right"></i></a></li>';
                }
            } elseif ($link->label === '...') {
                $code .= '<li class="disable-link"><a href="javascript:void(0)">'.$link->label.'</a></li>';
            } else {
                if(!$link->active) {
                    $code .= '<li><a href="'.route($route, $link->label).'">'.$link->label.'</a></li>';
                } else {
                    $code .= '<li class="active"><a href="'.route($route, $link->label).'">'.$link->label.'</a></li>';
                }
            }
        }

        $code .= '<li class="page-last"><a href="'.route($route, $pagination['last_page']).'"><i class="fas fa-angle-double-right"></i></a></li>';


        $code .= '</ul>';
        $code .= '</div>';

        return $code;
    }
}

if (!function_exists('getPriority')) {
    function getPriority()
    {
        $priority = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10',
        ];

        return $priority;
    }
}

if (!function_exists('selectOptions')) {
    function selectOptions($objects, $key='id', $value='name')
    {
        $dropdown_lists = [];

        if ($objects) {
            foreach ($objects as $object) {
                $dropdown_lists[$object->$key] = $object->$value;
            }
        }

        return $dropdown_lists;
    }
}


if (!function_exists('getStatus')) {
    function getStatus()
    {

        $status = [
            'pending' => 'Pending',
            'confirmed' => 'Confirm',
            'completed' => 'Complete',
        ];

        return $status;
    }
}

if (!function_exists('styleStatus')) {
    function styleStatus($value)
    {
        $output = '';

        if ($value == 'pending') {
            $output .= '<span class="btn btn-warning btn-sm">Pending</span>';
        } else if ($value == 'declined') {
            $output .= '<span class="btn btn-danger btn-sm">Declined</span>';
        } else if ($value == 'complete') {
            $output .= '<span class="btn btn-success btn-sm">Completed</span>';
        } else if ($value == 'confirmed') {
            $output .= '<span class="btn btn-primary btn-sm">Confirmed</span>';
        }

        return $output;
    }
}

if (!function_exists('generateUniqueId')) {
    function generateUniqueId($model, $model_id, $pre_text) {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;

        if (strlen($month) < 2) {
            $month = '0'.$month;
        }

        $prefix = $pre_text.$year.$month;

        $data = \App::make('\App\Models\\'.$model)::select('id', $model_id)->where($model_id, 'LIKE', $prefix.'%')->latest()->first();

        if($data) {
            $exp = explode($prefix, $data->{$model_id});
            $last_num = (int)$exp[1]+1;

            switch (strlen($last_num)) {
                case 4:
                    $gen_id = $last_num;
                    break;
                case 3:
                    $gen_id = '0'.$last_num;
                    break;
                case 2:
                    $gen_id = '00'.$last_num;
                    break;
                default:
                    $gen_id = '000'.$last_num;;
            }
            $unique_id = $prefix.$gen_id;
        } else {
            $unique_id = $prefix.'0001';
        }

        return $unique_id;
    }
}
