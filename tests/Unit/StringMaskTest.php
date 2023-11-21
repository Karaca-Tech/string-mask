<?php

use KaracaTech\StringMask\Facades\Mask;

it('can mask phone numbers', function () {
    $mask = Mask::phone('5321234567');
    expect($mask)->toEqual('(***) *** 4567');
});

it('can mask emails', function () {
    $mask = Mask::email('john_doe_personal_email_address@example.com');
    expect($mask)->toEqual('j****************************s@example.com');
});

it('can mask formatted credit cards', function () {
    $mask = Mask::creditCard('1111 2222 3333 4444');
    expect($mask)->toEqual('1111 **** **** 4444');
});

it('can mask unformatted credit cards', function () {
   $mask = Mask::creditCard('1111222233334444');

   expect($mask)->toBeString()
       ->toBe('1111 **** **** 4444');
});

it('can mask initials', function () {
    $mask = Mask::initials('John Doe');
    expect($mask)->toEqual('J.D.');
});

it('can mask fullname', function () {
    $mask = Mask::fullname('John Doe');
    expect($mask)->toEqual('J*** D**');
});
