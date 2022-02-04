<?php

use Spatie\ArrayToXml\ArrayToXml;
use Sammyjo20\XmlToArray\XmlToArray;

$basicExample = [
    'Good-Guy' => [
        'name' => [
            '_cdata' => '<h1>Luke Skywalker</h1>',
        ],
        'weapon' => 'Lightsaber',
    ],
    'Bad-Guy' => [
        'name' => '<h1>Sauron</h1>',
        'weapon' => 'Evil Eye',
    ],
];


$repeatedNodeExample = [
    'Good-Guy' => [
        'name' => [
            '_cdata' => '<h1>Luke Skywalker</h1>',
        ],
        'weapon' => 'Lightsaber',
    ],
    'Bad-Guy' => [
        [
            'name' => '<h1>Sauron</h1>',
            'weapon' => 'Evil Eye',
        ],
        [
            'name' => '<h1>Darth Vader</h1>',
            'weapon' => 'Strangle',
        ],
    ],
];

$attributesExample = [
    'Good-Guy' => [
        'name' => [
            '_cdata' => '<h1>Luke Skywalker</h1>',
        ],
        '_attributes' => [
            'hasTheForce' => 'Yes',
            'hatesSand' => 'Yes',
        ],
        'weapon' => 'Lightsaber',
    ],
];

test('it can convert xml into an array', function () use ($basicExample) {
    $xml = ArrayToXml::convert($basicExample, '', true, 'UTF-8');
    $array = XmlToArray::convert($xml);

    expect($array)->toEqual(['root' => $basicExample]);
});

test('it can convert elements with the same name into an array of elements', function () use ($repeatedNodeExample) {
    $xml = ArrayToXml::convert($repeatedNodeExample, '', true, 'UTF-8');
    $array = XmlToArray::convert($xml);

    expect($array)->toEqual(['root' => $repeatedNodeExample]);
});

test('it can convert attributes', function () use ($attributesExample) {
    $xml = ArrayToXml::convert($attributesExample, '', true, 'UTF-8');
    $array = XmlToArray::convert($xml);

    expect($array)->toEqual(['root' => $attributesExample]);
});
