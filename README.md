![](https://banners.beyondco.de/StringMask.png?theme=light&packageManager=composer+require&packageName=karaca-tech%2Fstring-mask&pattern=hideout&style=style_1&description=A+simple+string+masker&md=1&showWatermark=1&fontSize=125px&images=eye-off)
# String Mask
[![Latest Version on Packagist](https://img.shields.io/packagist/v/karaca-tech/string-mask.svg?style=flat-square)](https://packagist.org/packages/karaca-tech/string-mask)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/karaca-tech/string-mask/run-tests.yml?label=tests&branch=main)](https://github.com/karaca-tech/string-mask/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/karaca-tech/string-mask/static-analysis.yml?label=static%20analysis&branch=main)](https://github.com/karaca-tech/string-mask/actions?query=workflow%3Astatic-analysis+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/karaca-tech/string-mask.svg?style=flat-square)](https://packagist.org/packages/karaca-tech/string-mask)

This package is a simple string masker for Laravel. 

## Installation

You can install the package via composer:

```bash
composer require karaca-tech/string-mask
```

## Usage

```php
use KaracaTech\StringMask\Facades\Mask;

mask('John Doe')->keepFirstAndLastCharacter()->apply(); // J******e

Mask::fullname('John Doe'); // J*** D**
Mask::initials('John Doe'); // J.D.

// Let's spice things up a little bit
Mask::of('John Doe')
    ->silent()
    ->eachWord()
    ->keepFirstWord()
    ->keepFirstCharacter()
    ->then(fn(Masker $masked) => $masked->append('.'))
    ->apply(); // John D.
```

### Using your own processors

All processors must be extended from `KaracaTech\StringMask\Powder\Processor` abstract class.

```php
use KaracaTech\StringMask\Powder\Processor;
use KaracaTech\StringMask\MaskTarget;

class MyProcessor extends Processor
{
    public function execute(MaskTarget $string): string
    {
        // Do your magic here
    }
}

// or

class ProcessorWithParams extends Processor
{
    public function __construct(private AnotherClass $anotherClass)
    {
    }

    public function execute(MaskTarget $string): string
    {
        // Do your magic here
    }
}
```

Then you can use your processor like this:

```php
Mask::of('John Doe')
    ->using(MyProcessor::class)
    ->using(MyOtherProcessor::class)
    ->using(ProcessorWithParams::class, new AnotherClass())
    ->apply();
```

For further examples, please check out the `KaracaTech\StringMask\Concerete\Processors` namespace.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing
Contributions are always welcome, [thanks to all of our contributors](https://github.com/Karaca-Tech/string-mask/graphs/contributors)!