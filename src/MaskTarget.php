<?php

namespace KaracaTech\StringMask;

use KaracaTech\StringMask\Powder\Processor;

class MaskTarget
{
    protected bool $skip = false;

    protected readonly string $original;

    public array $utils = ['applied' => [], 'skipped' => []];


    public function __construct(protected string $target, protected string $hideCharacter = '*', protected string $encoding = 'UTF-8')
    {
        $this->original = $target;
    }

    public function update(string $string, $util)
    {
        if ($this->shouldSkip()) {
            $this->utils['skipped'][$util] = $string;
            return $this;
        }

        $this->utils['applied'][$util] = $string;
        $this->target = $string;
        return $this;
    }

    public function getHideCharacter(): string
    {
        return $this->hideCharacter;
    }

    public function setHideCharacter(string $hideCharacter): self
    {
        $this->hideCharacter = $hideCharacter;
        return $this;
    }

    public function getEncoding(): string
    {
        return $this->encoding;
    }

    public function skip()
    {
        $this->skip = true;
        return $this;
    }

    public function shouldSkip()
    {
        return $this->skip;
    }

    public function __toString(): string
    {
        return $this->target;
    }

    public function skipped(Processor|string $util)
    {
        $this->utils['skipped'][is_string($util) ? $util : get_class($util)] = $this->target;
    }

    public function applied(Processor|string $util)
    {
        $this->utils['applied'][is_string($util) ? $util : get_class($util)] = $this->target;
    }

    public function isApplied(Processor|string $util): bool
    {
        return isset($this->utils['applied'][is_string($util) ? $util : get_class($util)]);
    }

    public function isSkipped(Processor|string $util): bool
    {
        return isset($this->utils['skipped'][is_string($util) ? $util : get_class($util)]);
    }

    public function getOriginal(): string
    {
        return $this->original;
    }
}