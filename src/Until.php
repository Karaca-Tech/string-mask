<?php

namespace KaracaTech\StringMask;
final readonly class Until
{
    public function __construct(public string $needle, public int $encounter = 1)
    {
    }
}
