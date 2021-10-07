<?php

namespace Omnicron\InfixCalculator\Token;

class NegationToken extends BinaryOperationToken
{

  public function __construct() {
    parent::__construct(function ($a) { return -$a; });
  }

}
