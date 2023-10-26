<?php

namespace KaracaTech\StringMask\Powder;

use Closure;
use KaracaTech\StringMask\MaskTarget;

abstract class Processor
{
    abstract public function execute(MaskTarget $target): string;

    public function handle(MaskTarget $passable, Closure $next)
    {
        if($passable->shouldSkip()) {
            $passable->skipped($this);
            return $passable;
        }
        return $next($passable->update($this->execute($passable), get_class($this)));
    }
}
