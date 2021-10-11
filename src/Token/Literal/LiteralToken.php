<?php

namespace Omnicron\InfixCalculator\Token\Literal;

use \Omnicron\InfixCalculator\Token\Abstract\EvaluableToken;

class LiteralToken extends EvaluableToken
{

  protected $value;

  public function __construct($value) {
    $this->value = $value;
  }

  public function evaluate(...$args) {
    return $this->value;
  }

}
