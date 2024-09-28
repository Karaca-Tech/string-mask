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

    $mask = Mask::initials('Şahin Örnek');
    expect($mask)->toEqual('Ş.Ö.');
});

it('can mask fullname', function () {
    $mask = Mask::fullname('John Doe');
    expect($mask)->toEqual('J*** D**');

    $mask = Mask::fullname('Onur Şimşek');
    expect($mask)->toEqual('O*** Ş*****');
});

it('can mask a string', function () {
    $mask = Mask::of('ABCÇDEFGĞHIİJKLMNOÖPQRSŞTUÜVWXYZ');

    expect((string)$mask->hide())->toBeString()
        ->toBe('********************************');
});

it('can mask each word a string', function () {
    $mask = Mask::of('abcç defg ğhıi jklm noöp rsşt uüvy z');

    expect((string)$mask->eachWord())->toBeString()
        ->toBe('**** **** **** **** **** **** **** *');
});

it('can clear letter(s) in a string', function () {
    $mask = Mask::of('Hello world!');

    expect((string)$mask->clear(['o', 'l']))->toBeString()
        ->toBe('He wrd!');
});
