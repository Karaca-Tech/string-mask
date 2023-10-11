<?php

use KaracaTech\StringMask\Facades\Mask;
use KaracaTech\StringMask\Masker;

if (!function_exists('mask')) {
    function mask(string $string): Masker
    {
        return Mask::of($string);
    }
}