<?php

namespace KaracaTech\StringMask\Contracts;

use KaracaTech\StringMask\Contracts\Fluent\Maskable;
use KaracaTech\StringMask\Contracts\Fluent\WordMasker;

interface Masker extends \Stringable
{

    public function of(string $target): Masker;

    public function silent(): Masker;

    public function using(string $processor, ...$args): Masker;

    public function except(string $processor): Masker;

    public function then(callable $callback): Masker;

    public function hide(): Masker;

    public function append(string $append): Masker;

    public function prepend(string $prepend): Masker;

    public function keepFirstCharacter(int $characterCount = 1): Masker;

    public function keepLastCharacter(int $characterCount = 1): Masker;

    public function keepFirstWord(): Masker;

    public function keepLastWord(): Masker;

    public function keepFirstAndLastCharacter(int $characterCount = 1): Masker;

    public function keepNthWord(int $n): Masker;

    public function apply(): string;

    public function eachWord(string $separator = ' '): Masker;

    /**
     * @param array<int,string>|string $chars
     */
    public function clear(array|string $chars): Masker;

    public function divide(string $separator = ' '): Masker;

    public function hiderCharacter(string $character): Masker;

    public function phone(string $phone): string;

    public function fullname(string $fullname): string;

    public function creditCard(string $creditCard): string;

    public function initials(string $fullname): string;


}