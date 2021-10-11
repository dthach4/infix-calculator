<?php

namespace Omnicron\InfixCalculator\TreeNode;

use \Omnicron\InfixCalculator\Token\Abstract\OperationToken;
use \Omnicron\InfixCalculator\Token\Abstract\BinaryOperationToken;
use \Omnicron\InfixCalculator\Token\Abstract\UnaryOperationToken;
use \Omnicron\InfixCalculator\Token\Literal\LiteralToken;
use \Omnicron\InfixCalculator\TreeNode\TreeNode;

class OperationTreeNode extends TreeNode
{

  protected OperationToken $operation;
  protected array $operands; // array of TreeNode

  public function __construct($operation, $operands) {
    $this->operation = $operation;
    $this->operands = $operands;
  }

  public function reduceStep() {
    $isFinal = true;
    foreach($this->operands as $operand) {
      if(!is_a($operand, LiteralTreeNode::class)) {
        $isFinal = false;
      }
    }
    if($isFinal) {
      return new LiteralTreeNode(
        new LiteralToken(
          $this->evaluate()
        )
      );
    }
    return new self(
      $this->operation,
      array_map(
        function ($operand) {
          return $operand->reduceStep();
        },
        $this->operands
      )
    );
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

  public function __toString() {
    if(is_a($this->operation, UnaryOperationToken::class)) {
      return '('.$this->operation->getOperator().' '.$this->operands[0]->__toString().')';
    }
    if(is_a($this->operation, BinaryOperationToken::class)) {
      return '('.$this->operands[0]->__toString().' '.$this->operation->getOperator().' '.$this->operands[1]->__toString().')';
    }
    return $this->operation->getOperator().'('.implode(', ', array_map(function ($operand) { return $operand->__toString(); }, $this->operands)).')';
  }

}
