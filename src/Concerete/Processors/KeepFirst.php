<?php

namespace KaracaTech\StringMask\Concerete\Processors;

use Illuminate\Support\Str;
use KaracaTech\StringMask\MaskTarget;
use KaracaTech\StringMask\Powder\Processor;

class KeepFirst extends Processor
{
    public function __construct(protected int $characterCount)
    {
    }

    public function execute(MaskTarget $target): string
    {
        $kept = $target->isApplied(KeepLast::class) ? Str::afterLast($target, $target->getHideCharacter()) : '';
        $keptLength = mb_strlen($kept);
        $repeat = mb_strlen((string) $target) - $keptLength - $this->characterCount;
        if ($repeat < 0) {
            return $target;
        }

        return mb_substr($target->getOriginal(), 0, $this->characterCount, encoding: $target->getEncoding())
            .str_repeat($target->getHideCharacter(), $repeat)
            .$kept;
    }
}
