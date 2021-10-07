<?php

namespace Omnicron\InfixCalculator\Token;

class DivisionToken extends BinaryOperationToken
{

  public function __construct() {
    parent::__construct(function ($a, $b) { return $a/$b; });
  }

}
