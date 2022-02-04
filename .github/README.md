# Convert XML into an array

[![Build Status](https://github.com/sammyjo20/xml-to-array/workflows/tests/badge.svg)](https://github.com/sammyjo20/xml-to-array/actions)

This package provides an easy way to convert an XML string into an array.

> Inspired by Spatie's [array-to-xml](https://github.com/spatie/array-to-xml).

## Install

You can install this package with Composer.

``` bash
composer require sammyjo20/xml-to-array
```

## Usage

```php
<?php

use Sammyjo20\XmlToArray\XmlToArray;

$xml = '<items>
    <good_guy>
        <name>Luke Skywalker</name>
        <weapon>Lightsaber</weapon>
    </good_guy>
    <bad_guy>
        <name>Sauron</name>
        <weapon>Evil Eye</weapon>
    </bad_guy>
</items>';

$result = XmlToArray::convert($xml);
```
After running this piece of code `$result` will contain:

```php
array:1 [
  "items" => array:2 [
    "good_guy" => array:2 [
      "name" => "Luke Skywalker"
      "weapon" => "Lightsaber"
    ]
    "bad_guy" => array:2 [
      "name" => "Sauron"
      "weapon" => "Evil Eye"
    ]
  ]
]
```

## Thank you to the original creator

This package was originally created by **vyuldashev**. This package is an up-to-date version with some bugs fixed. [Click here to view the original package.](https://github.com/vyuldashev/xml-to-array)
