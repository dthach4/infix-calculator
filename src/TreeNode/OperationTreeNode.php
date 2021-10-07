<?php

namespace Omnicron\InfixCalculator\TreeNode;

use \Omnicron\InfixCalculator\Token\OperationToken;

class OperationTreeNode extends TreeNode
{

  protected OperationToken $operation;
  protected array $operands; // array of TreeNode

  public function __construct($operation, $operands) {
    $this->operation = $operation;
    $this->operands = $operands;
  }

  public function evaluate() {
    $operandsResults = array_map(
      function ($operand) {
        return $operand->evaluate();
      },
      $this->operands
    );
    return $this->operation->evaluate(...$operandsResults);
  }
}
