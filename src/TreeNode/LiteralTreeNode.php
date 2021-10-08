<?php

namespace Omnicron\InfixCalculator\TreeNode;

use \Omnicron\InfixCalculator\Token\LiteralToken;

class LiteralTreeNode extends TreeNode
{

  protected LiteralToken $value;

  public function __construct($value) {
    $this->value = $value;
  }

  public function reduceStep() {
    return $this;
  }

  public function evaluate() {
    return $this->value->evaluate();
  }

  public function __toString() {
    return strval($this->value->evaluate());
  }

}
