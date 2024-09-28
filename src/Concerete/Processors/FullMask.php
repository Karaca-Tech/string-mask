<?php

namespace KaracaTech\StringMask\Concerete\Processors;

use KaracaTech\StringMask\MaskTarget;
use KaracaTech\StringMask\Powder\Processor;

class FullMask extends Processor
{
    public function execute(MaskTarget $target): string
    {
        return str_repeat($target->getHideCharacter(), mb_strlen($target));
    }
}
