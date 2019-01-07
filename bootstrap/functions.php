<?php

use Illuminate\Support\Facades\DB;

/**
 * @param $string
 * @return string|string[]|null
 */
function seo_url($string)
{
    $string = trim($string); // Trim String

    $string = strtolower($string); //Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )

    $string = preg_replace("/[^a-z0-9_\s-]/", '', $string);  //Strip any unwanted characters

    $string = preg_replace("/[\s-]+/", ' ', $string); // Clean multiple dashes or whitespaces

    $string = preg_replace("/[\s_]/", '-', $string); //Convert whitespaces and underscore to dash

    return $string;
}

function statement(...$args)
{
    if (config('app.debug', false)) {
        try {
            return DB::statement(...$args);
        } catch (Exception $e) {
            return dd($e);
        }
    }
    return DB::statement(...$args);
}

/**
 * @param $current_offer
 * @return int
 */
function getMinimalTopUp($current_offer)
{
    if ($current_offer < 49.99) {
        return 0.50;
    } elseif ($current_offer < 499.99) {
        return 1;
    } elseif ($current_offer < 999.99) {
        return 5;
    } elseif ($current_offer < 4999.99) {
        return 10;
    }
    return 50;
}

/**
 * @param $price
 * @param int $decimals
 * @return string
 */
function priceFormat($price, int $decimals = 2)
{
    return number_format($price, $decimals, ',', '.');
}
