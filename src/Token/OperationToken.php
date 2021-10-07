<?php

namespace Omnicron\InfixCalculator\Token;

class OperationToken extends EvaluableToken
{

  protected $operation;

  public function __construct(callable $operation) {
    $this->operation = $operation;
  }

  public function evaluate(...$args) {
    return ($this->operation)(...$args);
  }

}
