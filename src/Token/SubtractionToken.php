<?php

namespace Omnicron\InfixCalculator\Token;

class SubtractionToken extends BinaryOperationToken
{

  public function __construct() {
    parent::__construct(function ($a, $b) { return $a-$b; });
  }

}
