<?php

namespace Omnicron\InfixCalculator\Token;

class NegationToken extends UnaryOperationToken
{

  public function __construct() {
    parent::__construct(
      '-',
      function ($a) { return -$a; },
      300
    );
  }

}
