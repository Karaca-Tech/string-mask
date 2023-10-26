<?php

namespace KaracaTech\StringMask\Concerete\Processors;

use Illuminate\Support\Str;
use KaracaTech\StringMask\MaskTarget;
use KaracaTech\StringMask\Powder\Processor;

class Clear extends Processor
{
    public function __construct(protected array|string $characters)
    {
    }

    public function execute(MaskTarget $target): string
    {
        return Str::replace($this->characters, '', $target);
    }
}
