<?php

namespace KaracaTech\StringMask\Facades;

use Illuminate\Support\Facades\Facade;
use KaracaTech\StringMask\Masker;

/**
 * @see Masker
 *
 * @method static Masker of(string $string) Set the target string of the masker
 * @method static string creditCard(string $string) Set the target string of the masker and mask it as a credit card number
 * @method static string fullname(string $string) Set the target string of the masker and mask it as a full name
 * @method static string initials(string $string) Set the target string of the masker and mask it to its initials
 * @method static string email(string $string) Set the target string of the masker and mask it as an email address
 * @method static string phone(string $string) Set the target string of the masker and mask it as a phone number
 */
class Mask extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Masker::class;
    }
}
