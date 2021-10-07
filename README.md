# InfixCalculator

InfixCalculator is a basic solver for mathematical expressions written in
infix notation.

At the moment, it only supports:
* Numbers (integers and decimals)
* Brackets
* Arithmetic operators: + - * /

## Install via Composer

Install the latest version with

```
composer require omnicron/infix-calculator
```

## Usage

```php
<?php

use Omnicron\InfixCalculator\Calculator;

// create a Calculator object
$calculator = new Calculator;

// calculate the result of an expression
$result = $calculator->solve('3 + 5 * (2 + 1)');

// write the result
echo $result;
```

## Why?

Mostly because I wanted to try to write a parser on my own.

Also, I'm planning on making this library more complete and customizable. For
now, just enjoy this very basic expression solver!

## Author

Dany Thach - <d.thach4@gmail.com>

## License

InfixCalculator is licensed under the [MIT License](LICENSE).
