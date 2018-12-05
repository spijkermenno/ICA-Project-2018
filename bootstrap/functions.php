<?php

function seo_url($string)
{
    $string = trim($string); // Trim String

    $string = strtolower($string); //Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )

    $string = preg_replace("/[^a-z0-9_\s-]/", '', $string);  //Strip any unwanted characters

    $string = preg_replace("/[\s-]+/", ' ', $string); // Clean multiple dashes or whitespaces

    $string = preg_replace("/[\s_]/", '-', $string); //Convert whitespaces and underscore to dash

    return $string;
}
