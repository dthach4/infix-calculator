<?php

namespace Omnicron\InfixCalculator\Token\Abstract;

use \Omnicron\InfixCalculator\Token\Abstract\Token;

abstract class EvaluableToken extends Token
{
  abstract public function evaluate(...$args);
}
