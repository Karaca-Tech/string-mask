<?php

namespace KaracaTech\StringMask\Concerete\Processors\Formatters;

use Illuminate\Support\Str;
use KaracaTech\StringMask\MaskTarget;
use KaracaTech\StringMask\Powder\Processor;

class CreditCardFormatter extends Processor
{

    public function execute(MaskTarget $target): string
    {
        //todo: consider different credit card patterns
        return preg_replace(
            '/(\d{4})(\d{4})(\d{4})(\d{4})/',
            '$1 $2 $3 $4',
            Str::replace(' ', '', $target->getOriginal())
        );
    }
}