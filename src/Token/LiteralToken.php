<?php

namespace Omnicron\InfixCalculator\Token;

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
