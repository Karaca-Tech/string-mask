<?php

namespace Tests;
use KaracaTech\StringMask\StringMaskServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            StringMaskServiceProvider::class
        ];
    }

}