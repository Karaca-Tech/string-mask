<?php

namespace KaracaTech\StringMask\Contracts\Fluent;

interface WordMasker
{

    public function keepFirstWord(): WordMasker;

    public function keepNthWord(int $n): WordMasker;

    public function keepLastWord(): WordMasker;

    public function keepFirstCharacter(int $characterCount): WordMasker;

    public function keepLastCharacter(int $characterCount): WordMasker;

    public function keepFirstAndLast(int $characterCount): WordMasker;



}