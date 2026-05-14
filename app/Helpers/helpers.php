<?php

use App\Models\Bio;
use App\Models\CompanyInformation;
use App\Models\DocumentDetail;
use App\Models\HNote;
use App\Models\Hospital;
use Illuminate\Support\Str;

if (! function_exists('create_slug')) {
    /**
     * description
     *
     * @param  string  $str
     * @return string lowercase
     */
    function create_slug($string)
    {
        $t = $string;
        $specChars = [
            ' ' => '-',    '!' => '',    '"' => '',
            '#' => '',    '$' => '',    '%' => '',
            '&' => 'and',    '\'' => '',   '(' => '',
            ')' => '',    '*' => '',    '+' => '',
            ',' => '',    '₹' => '',    '.' => '',
            '/-' => '',    ':' => '',    ';' => '',
            '<' => '',    '=' => '',    '>' => '',
            '?' => '',    '@' => '',    '[' => '',
            '\\' => '',   ']' => '',    '^' => '',
            '_' => '',    '`' => '',    '{' => '',
            '|' => '',    '}' => '',    '~' => '',
            '-----' => '-',    '----' => '-',    '---' => '-',
            '/' => '',    '--' => '-',   '/_' => '-',
        ];
        foreach ($specChars as $k => $v) {
            $t = str_replace($k, $v, $t);
        }

        return Str::lower($t);
    }
}

if (! function_exists('setting')) {
    function setting($key = false, $defaultValue = false)
    {
        static $settings = null;
        if ($settings === null) {
            $settings = CompanyInformation::first();
        }
        if ($key === false) {
            return $settings;
        }
        if (! $settings) {
            return $defaultValue;
        }
        $value = $settings->$key ?? null;

        return $value !== null ? $value : $defaultValue;
    }
}

if (! function_exists('checkExistBio')) {
    function checkExistBio($customer_id, $item_id)
    {
        $existItem = Bio::where('customer_id', $customer_id)
            ->where('item_id', $item_id)->first();

        return $existItem;
    }
}

if (! function_exists('checkExistService')) {
    function checkExistService($document_id, $service_name)
    {
        $existItem = DocumentDetail::where('document_id', $document_id)
            ->where('service_name', '=', $service_name)->first();

        return $existItem;
    }
}

if (! function_exists('get_hospital_id')) {
    function get_hospital_id($customer_id, $document_id)
    {
        $hospital = Hospital::where('customer_id', '=', $customer_id)
            ->where('document_id', '=', $document_id)
            ->first();
        if ($hospital) {
            return $hospital->id;
        }
    }
}

if (! function_exists('checkExistDate')) {
    function checkExistDate($hospital_id)
    {
        $existDate = HNote::where('hospital_id', $hospital_id)
            ->whereDate('date', '=', date('Y-m-d'))->first();
        if ($existDate) {
            return $existDate;
        } else {
            return 'Unknown';
        }
    }
}

if (! function_exists('assetUrl')) {
    function assetUrl()
    {
        return asset('assets/backend');
    }
}

if (! function_exists('uploadUrl')) {
    function uploadUrl()
    {
        return asset('uploads/');
    }
}

if (! function_exists('errorImageUrl')) {
    function errorImageUrl()
    {
        return asset('images/avatar3.png');
    }
}
