<?php

namespace KaracaTech\StringMask;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Str;
use KaracaTech\StringMask\Concerete\Processors\Append;
use KaracaTech\StringMask\Concerete\Processors\Clear;
use KaracaTech\StringMask\Concerete\Processors\FullMask;
use KaracaTech\StringMask\Concerete\Processors\KeepFirst;
use KaracaTech\StringMask\Concerete\Processors\KeepLast;
use KaracaTech\StringMask\Concerete\Processors\Prepend;
use KaracaTech\StringMask\Contracts\Fluent\Maskable;
use KaracaTech\StringMask\Contracts\Fluent\WordMasker;
use KaracaTech\StringMask\Contracts\Masker as MasksStrings;
use KaracaTech\StringMask\Powder\Processor;

class Masker implements MasksStrings
{
    /**
     * The target string to be masked
     *
     * @var string|array $target
     */
    protected string|array $target;

    /**
     * Processors to be applied to the target string
     * @var Collection $processors
     */
    protected Collection $processors;
    protected string $hideCharacter = '*';
    /**
     * @var array
     */
    protected array $willSkipProcess = [];
    private string $wordSeparator = ' ';

    public function __construct()
    {
        $this->processors = collect();
    }

    public function then(callable $callback): self
    {
        $masked = $this->apply();
        return $callback($this->of($masked));
    }

    public function of(string $string): Maskable
    {
        $this->target = $string;
        return $this;
    }

    public function using(string $util, mixed $value = null): self
    {
        $this->processors->put($util, $value);
        return $this;
    }

    public function except($rule): self
    {
        $this->processors->put($rule, false);
        return $this;
    }

    public function hide(): self
    {
        $this->using(FullMask::class);
        return $this;
    }

    public function append(string $string): self
    {
        $this->using(Append::class, $string);
        return $this;
    }

    public function prepend(string $string): self
    {
        $this->using(Prepend::class, $string);
        return $this;
    }

    public function keepFirstCharacter(int $characterCount = 1): self
    {
        $this->using(KeepFirst::class, $characterCount);
        return $this;
    }

    public function keepLastCharacter(int $characterCount = 1): self
    {
        $this->using(KeepLast::class, $characterCount);
        return $this;
    }

    public function clear(array|string $chars): self
    {
        $this->using(Clear::class, $chars);
        return $this;
    }

    protected function getApplicableProcessors(): array
    {
        return $this->processors
            ->reject(fn($availability) => is_bool($availability) && !$availability)
            ->keys()
            ->map(fn($processor) => new $processor($this->processors->get($processor)))
            ->filter(fn($processor) => $processor instanceof Processor)
            ->toArray();
    }

    public function divide(string $separator = ' '): self
    {
        $this->wordSeparator = $separator;
        $this->target = explode($this->wordSeparator, $this->target);
        return $this;
    }

    public function eachWord($separator = ' '): self
    {
        $this->divide($separator);
        return $this;
    }

    public function email(string $string): string
    {
        return $this->of($string)->divide('@')->keepFirstAndLast()->keepLastWord()->apply();
    }

    /**
     * todo: improve prepended format
     */
    public function phone(string $string): string
    {
        $this->of($string)->eachWord()->silent();

        if (is_array($this->target) && count($this->target) > 1) {
            return $this->keepLastWord()->prepend('(***) *** ')->apply();
        }

        return $this->keepLastCharacter(4)->prepend('(***) *** ')->apply();
    }

    public function fullname(string $string): string
    {
        return $this->of($string)->eachWord()->keepFirstCharacter()->apply();
    }

    public function creditCard(string $string): string
    {
        return $this->of($string)
            ->eachWord()
            ->keepFirstWord()
            ->keepLastWord()
            ->apply();
    }

    public function initials(string $string): string
    {
        return Str::replace(
            ' ',
            '',
            $this->of($string)
                ->keepFirstCharacter()
                ->eachWord()
                ->append('.')
                ->silent()
                ->apply()
        );
    }

    public function silent(): self
    {
        $this->hideCharacter('');
        return $this;
    }

    public function hideCharacter(string $character): self
    {
        $this->hideCharacter = $character;
        return $this;
    }

    public function keepLastWord(): WordMasker
    {
        return $this->keepNthWord(count($this->target));
    }

    public function keepNthWord(int $n): WordMasker
    {
        $this->willSkipProcess[$n - 1] = true;
        return $this;
    }

    public function keepFirstWord(): WordMasker
    {
        return $this->keepNthWord(1);
    }

    public function keepFirstAndLast(int $characterCount = 1): self
    {
        return $this->keepFirstCharacter($characterCount)->keepLastCharacter($characterCount);
    }

    private function process(string $word): string
    {
        return Pipeline::send(new MaskTarget($word, $this->hideCharacter))
            ->through($this->getApplicableProcessors())
//            ->then(fn(MaskTarget $target) => dd($target))
            ->thenReturn();
    }

    /**
     * @param  array  $manipulated
     * @return string
     */
    public function processMultipleWords(array $manipulated): string
    {
        foreach ($this->target as $index => $word) {
            if (isset($this->willSkipProcess[$index])) {
                $manipulated[] = $word;
                continue;
            }
            $manipulated[] = $this->process($word);
        }
        $manipulated = join($this->wordSeparator, $manipulated);
        $this->reset();
        return $manipulated;
    }

    private function reset()
    {
        $this->processors = collect();
        $this->willSkipProcess = [];
        $this->wordSeparator = ' ';
        $this->hideCharacter = '*';
    }

    public function apply(): string
    {
        if (is_array($this->target)) {
            $manipulated = [];
            if ($this->processors->isEmpty()) {
                $this->using(FullMask::class);
            }
            return $this->processMultipleWords($manipulated);
        }

        $manipulated = $this->process($this->target);
        $this->reset();

        return $manipulated;
    }

    public function __toString(): string
    {
        return $this->apply();
    }
}