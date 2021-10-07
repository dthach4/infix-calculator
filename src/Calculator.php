<?php

namespace Omnicron\InfixCalculator;

use Onmicron\InfixCalculator\Classes\Lexer;

class Calculator
{

  public function solve(string $expression) {
    $lexer = new Lexer;
    $expressionTokens = $lexer->tokenizeExpression($expression);
    $parser = new Parser;
    $expressionTree = $lexer->parseTokenizedExpression($expressionTokens);
    return $expressionTree->evaluate();
  }

}
