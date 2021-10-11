<?php

namespace Omnicron\InfixCalculator\Token\UnaryOperation;

use \Omnicron\InfixCalculator\Token\Abstract\UnaryOperationToken;

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
