<?php

namespace Omnicron\InfixCalculator;

use \Omnicron\InfixCalculator\Classes\Lexer;
use \Omnicron\InfixCalculator\Classes\Parser;
use \Omnicron\InfixCalculator\TreeNode\LiteralTreeNode;

class Calculator
{

  public function parse(string $expression) {
    $lexer = new Lexer;
    $expressionTokens = $lexer->tokenizeExpression($expression);
    $parser = new Parser;
    return $parser->parseTokenizedExpression($expressionTokens);
  }

  public function solve(string $expression) {
    return $this->parse($expression)->evaluate();
  }

  public function stringify(string $expression) {
    return $this->parse($expression)->__toString();
  }

  public function getSteps(string $expression) {
    $parsingTree = $this->parse($expression);
    $steps = [];
    while(!is_a($parsingTree, LiteralTreeNode::class)) {
      $steps[] = $parsingTree->__toString();
      $parsingTree = $parsingTree->reduceStep();
    }
    $steps[] = $parsingTree->__toString();
    return $steps;
  }

}
