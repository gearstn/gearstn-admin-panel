<?php

use AmrShawky\LaravelCurrency\Facade\Currency;
use Illuminate\Support\Facades\Route;

if (!function_exists("searchable_lang")) {

    function searchable_lang($inputs, $search_by)
    {
        if(isset($inputs['filter'][$search_by])){
            $value = $inputs['filter'][$search_by];
            preg_match('/\p{Arabic}/u', $value)? $inputs['filter'][$search_by.'_ar'] = $value : $inputs['filter']['title_en'] = $value;
            unset($inputs['filter'][$search_by]);
        }
        return $inputs;
    }
}
if (!function_exists("number_in_page")) {

    function number_in_page($num = null)
    {
        $num = $num == null ? $num = 10 : $num;
        return $num;
    }
}
//Machine Normal filters ex:[category,subCategory,.....]
if (!function_exists("items_filter")) {

    function items_filter($q,$input,$field)
    {
        return $q->when( $input != null, function ($q) use ($input,$field) {
            return $q->filter(function ($item) use ($input,$field) { if($item->$field == $input )return true;});
        });
    }
}
//Machine Range filters ex:[price, years, hours]
if (!function_exists("items_range_filter")) {

    function items_range_filter($q,$min,$max,$field)
    {
        return $q->when( ( isset($min ) || isset($max) ) && ($min != null || $max != null) , function ($q) use ($min,$max,$field) {
            return $q->filter(function ($item) use ($min,$max,$field) { return $item->$field >= $min && $max >= $item->$field; });
        });
    }
}


if (!function_exists("title")) {
    /**
     * @param string $title
     * @return string
     */
    function title($title = "")
    {
        if (isset($title) && $title != "") {
            return env("SITE_NAME", "GearsTN Admin") . " | " . $title;
        } else {
            $routeArray = app('request')->route()->getAction();
            $controllerAction = class_basename($routeArray['controller']);
            list($controller, $action) = explode('@', $controllerAction);
            $controller = str_replace("Controller", "", $controller);
            return env("SITE_NAME", "GearsTN Admin") . " | " . $controller;
        }
    }
}

if (!function_exists('areActiveRoutes')) {
    function areActiveRoutes(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
            if (str_contains($route, "*")) {
                $params = explode(".", $route);
                $currentRouteParams = explode(".", Route::currentRouteName());
                if ($params[0] == $currentRouteParams[0] && $params[1] == '*') return $output;
            }
        }
    }
}


if (!function_exists('currency_converter')) {
    function currency_converter($from, $amount)
    {
        $to = request()->header('currency') != null ? request()->header('currency') : 'EGP' ;
        // return ceil(Currency::convert()->from($from)->to($to)->amount($amount)->get());
        return $amount;
    }
}

if (!function_exists('array_flatten')) {
    function array_flatten($array)
    {
        if (!is_array($array)) {
            return FALSE;
        }
        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, array_flatten($value));
            } else {
                $result[] = $value;
            }
        }
        return $result;
    }
}

if (!function_exists('get_single_listing_plan_id')) {
    function get_single_listing_plan_id()
    {
        $subscription_id = app('rinvex.subscriptions.plan')->where('slug', 'listing-machine')->first();
        $subscription_id == null ? $result_id = 0 : $result_id = $subscription_id;
        return $result_id;
    }
}
