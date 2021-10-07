<?php

namespace Omnicron\InfixCalculator\Token;

abstract class EvaluableToken
{
  abstract public function evaluate(...$args);
}
