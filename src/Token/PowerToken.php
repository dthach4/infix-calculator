<?php

namespace Omnicron\InfixCalculator\Token;

class PowerToken extends BinaryOperationToken
{

  public function __construct() {
    parent::__construct(
      '^',
      function ($a, $b) { return $a**$b; },
      400
    );
  }

}
