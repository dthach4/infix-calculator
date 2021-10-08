<?php

namespace Omnicron\InfixCalculator\Token;

class OperationToken extends EvaluableToken
{

  protected $operator;
  protected $operation;
  protected $priority;

  public function __construct(string $operator, callable $operation, int $priority) {
    $this->operator  = $operator;
    $this->operation = $operation;
    $this->priority  = $priority;
  }

  public function getOperator() {
    return $this->operator;
  }

  public function getPriority() {
    return $this->priority;
  }

  public function evaluate(...$args) {
    return ($this->operation)(...$args);
  }

}
