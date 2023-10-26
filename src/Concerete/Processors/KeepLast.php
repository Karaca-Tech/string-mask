<?php

namespace KaracaTech\StringMask\Concerete\Processors;

use Illuminate\Support\Str;
use KaracaTech\StringMask\MaskTarget;
use KaracaTech\StringMask\Powder\Processor;

class KeepLast extends Processor
{
    /**
     * @param  int  $characterCount
     */
    public function __construct(protected int $characterCount)
    {
    }

    public function execute(MaskTarget $target): string
    {
        $kept = $target->isApplied(KeepFirst::class) ? Str::before($target, $target->getHideCharacter()) : '';
        $keptLength = strlen($kept);
        $repeat = mb_strlen($target->getOriginal()) - $keptLength - $this->characterCount;

        if ($repeat <= 0) {
            return $target;
        }

        return $kept
            .str_repeat($target->getHideCharacter(), $repeat - 1)
            .mb_substr($target->getOriginal(), -$this->characterCount, encoding: $target->getEncoding());
    }
}
