<?php

namespace Omnicron\InfixCalculator\Token\UnaryFunction;

use \Omnicron\InfixCalculator\Token\Abstract\UnaryFunctionToken;

class CosineToken extends UnaryFunctionToken
{

  public function __construct() {
    parent::__construct(
      'cos',
      function ($a) { return cos($a); },
      300
    );
  }

}
