<?php

test('is it working?', function () {
    $stringToBeMasked = 'Curabitur consequat elit et ipsum.';

    $stringMask = new \KaracaTech\StringMask\StringMask($stringToBeMasked);

    $expectedString = 'C*******r c*******t e**t et i****.';

    $actualString = $stringMask->eachWord()
        ->start(1)
        ->length(-1)
        ->apply();

    expect($actualString)->toEqual($expectedString);
});
