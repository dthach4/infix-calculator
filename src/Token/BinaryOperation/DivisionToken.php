<?php

namespace Omnicron\InfixCalculator\Token\BinaryOperation;

use \Omnicron\InfixCalculator\Token\Abstract\BinaryOperationToken;

class DivisionToken extends BinaryOperationToken
{

  public function __construct() {
    parent::__construct(
      '/',
      function ($a, $b) { return $a/$b; },
      200
    );
  }

}
