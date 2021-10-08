<?php

namespace Omnicron\InfixCalculator\TreeNode;

abstract class TreeNode
{

  abstract public function evaluate();

  public function __toString() {
    return (string)$this->evaluate();
  }

}
