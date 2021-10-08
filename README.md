# InfixCalculator

InfixCalculator is a basic solver for mathematical expressions written in
infix notation.

At the moment, it only supports:
* Numbers (integers and decimals)
* Brackets
* Arithmetic operators: + - * / ^

## Install via Composer

Install the latest version with

```
composer require omnicron/infix-calculator
```

## Usage

### Obtain the final result

```php
<?php

use \Omnicron\InfixCalculator\Calculator;

// create a Calculator object
$calculator = new Calculator;

// calculate the result of an expression
$result = $calculator->solve('3 + 5 * (2^2 + 1)');

// write the result (28)
echo $result.PHP_EOL;
```

### Obtain all the steps to solve an expression

```php
<?php

use \Omnicron\InfixCalculator\Calculator;

// create a Calculator object
$calculator = new Calculator;

// get steps to solve an expression
$steps = $calculator->getSteps('3 + 5 * (2^3 + 1) / (2^2 - 1)');

// show the steps
echo implode(PHP_EOL, $steps).PHP_EOL;

/*
the steps will be shown like this:
  (3 + ((5 * ((2 ^ 3) + 1)) / ((2 ^ 2) - 1)))
  (3 + ((5 * (8 + 1)) / (4 - 1)))
  (3 + ((5 * 9) / 3))
  (3 + (45 / 3))
  (3 + 15)
  18
*/
```

## Why?

Mostly because I wanted to try to write a parser on my own.

Also, I'm planning on making this library more complete and customizable. For
now, just enjoy this very basic expression solver!

## Author

Dany Thach - <d.thach4@gmail.com>

## License

InfixCalculator is licensed under the [MIT License](LICENSE).
