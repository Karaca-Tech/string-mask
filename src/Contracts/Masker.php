<?php

namespace KaracaTech\StringMask\Contracts;

use KaracaTech\StringMask\Contracts\Fluent\Maskable;
use KaracaTech\StringMask\Contracts\Fluent\WordMasker;

interface Masker extends \Stringable, Maskable, WordMasker
{

    public function apply(): string;

}