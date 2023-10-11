<?php

namespace KaracaTech\StringMask\Concerete\Processors;

use KaracaTech\StringMask\MaskTarget;
use KaracaTech\StringMask\Powder\Processor;

class Append extends Processor
{
    public function __construct(protected string $append)
    {
    }

    public function execute(MaskTarget $target): string
    {
        return $target.$this->append;
    }
}