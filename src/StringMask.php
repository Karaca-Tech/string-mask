<?php

namespace KaracaTech\StringMask;

class StringMask
{
    private string $manipulated;
    private string $wordSeparator = ' ';
    private bool $eachWord = false;
    private int $startIndex = 0;
    private int $length = 0;
    private Until $until;
    private string $via = '*';

    public function __construct(private string $string = '')
    {
        $this->text($string);
    }

    public function text(string $string): self
    {
        $this->string = $this->manipulated = $string;

        return $this;
    }

    public function __toString()
    {
        return $this->manipulated;
    }

    public function eachWord(): self
    {
        $this->eachWord = true;
        return $this;
    }

    public function wordSeparator(string $separator): self
    {
        $this->wordSeparator = $separator;
        return $this;
    }

    public function until(string $needle, int $encounter = 1): self
    {
        $this->until = new Until($needle, $encounter);
        return $this;
    }

    public function start(int $startIndex): self
    {
        $this->startIndex = $startIndex;
        return $this;
    }

    public function length(int $length): self
    {
        $this->length = $length;
        return $this;
    }

    public function via(string $via): self
    {
        $this->via = $via;
        return $this;
    }

    public function apply(): string
    {
        $strings = $this->eachWord ? explode($this->wordSeparator, $this->string) : [$this->string];
        $manipulatedStrings = array_map(
            fn($str) => self::mask($str, $this->via, $this->startIndex, $this->getLength($str)),
            $strings
        );
        $this->manipulated = implode($this->wordSeparator, $manipulatedStrings);
        return $this->manipulated;
    }

    private function getLength(string $string): int
    {
        if ($length = $this->getUntilLength($string)) {
            return $length;
        }
        return $this->length ?: mb_strlen($this->string);
    }

    private function getUntilLength(string $string): bool|int
    {
        if (!isset($this->until)) {
            return false;
        }
        $offset = 0;
        for ($i = 0; $i < $this->until->encounter; $i++) {
            $offset = strpos($string, $this->until->needle, $offset);
            if ($offset === false) {
                return false;
            }
        }
        return $offset;
    }

    private static function mask($string, $character, $index, $length = null, $encoding = 'UTF-8')
    {
        if ($character === '') {
            return $string;
        }

        $segment = mb_substr($string, $index, $length, $encoding);

        if ($segment === '') {
            return $string;
        }

        $strlen = mb_strlen($string, $encoding);
        $startIndex = $index;

        if ($index < 0) {
            $startIndex = $index < -$strlen ? 0 : $strlen + $index;
        }

        $start = mb_substr($string, 0, $startIndex, $encoding);
        $segmentLen = mb_strlen($segment, $encoding);
        $end = mb_substr($string, $startIndex + $segmentLen);

        return $start . str_repeat(mb_substr($character, 0, 1, $encoding), $segmentLen) . $end;
    }
}
