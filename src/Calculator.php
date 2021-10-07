<?php

namespace Omnicron\InfixCalculator;

use Omnicron\InfixCalculator\Classes\Lexer;
use Omnicron\InfixCalculator\Classes\Parser;

class Calculator
{

  public function solve(string $expression) {
    $lexer = new Lexer;
    $expressionTokens = $lexer->tokenizeExpression($expression);
    $parser = new Parser;
    $expressionTree = $parser->parseTokenizedExpression($expressionTokens);
    return $expressionTree->evaluate();
  }

}
