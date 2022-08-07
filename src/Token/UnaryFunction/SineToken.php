<?php

namespace Omnicron\InfixCalculator\Token\UnaryFunction;

use \Omnicron\InfixCalculator\Token\Abstract\UnaryFunctionToken;

class SineToken extends UnaryFunctionToken
{

  public function __construct() {
    parent::__construct(
      'sin',
      function ($a) { return sin($a); },
      300
    );
  }

}
