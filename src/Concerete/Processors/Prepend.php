<?php

namespace KaracaTech\StringMask\Concerete\Processors;

use KaracaTech\StringMask\MaskTarget;
use KaracaTech\StringMask\Powder\Processor;

class Prepend extends Processor
{
    public function __construct(protected string $prepend)
    {
    }

    public function execute(MaskTarget $target): string
    {
        return $this->prepend.$target;
    }
}