<?php

namespace Omnicron\InfixCalculator\Classes;

use \Omnicron\InfixCalculator\Exceptions\InvalidExpressionException;
use \Omnicron\InfixCalculator\Token\AdditionToken;
use \Omnicron\InfixCalculator\Token\ClosedBracketToken;
use \Omnicron\InfixCalculator\Token\DivisionToken;
use \Omnicron\InfixCalculator\Token\LiteralToken;
use \Omnicron\InfixCalculator\Token\MultiplicationToken;
use \Omnicron\InfixCalculator\Token\NegationToken;
use \Omnicron\InfixCalculator\Token\OpenBracketToken;
use \Omnicron\InfixCalculator\Token\PowerToken;
use \Omnicron\InfixCalculator\Token\SubtractionToken;

class Lexer
{

  public function tokenizeExpression($expression) {
    $tokens = [];
    $remainingExpression = $expression;
    $expectOperator = false; // undignified fsa lmao
    while(strlen(trim($remainingExpression)) > 0) {
      if(false === $expectOperator) {
        if(preg_match('/^\s*([0-9]+(?:\.[0-9]*)?)(.*)$/', $remainingExpression, $regexMatches)) {
          $tokens[] = new LiteralToken(floatval($regexMatches[1]));
          $remainingExpression = $regexMatches[2];
          $expectOperator = true;
        } elseif(preg_match('/^\s*(-)(.*)$/', $remainingExpression, $regexMatches)) {
          $tokens[] = new NegationToken;
          $remainingExpression = $regexMatches[2];
          $expectOperator = false;
        } elseif(preg_match('/^\s*(\()(.*)$/', $remainingExpression, $regexMatches)) {
          $tokens[] = new OpenBracketToken;
          $remainingExpression = $regexMatches[2];
          $expectOperator = false;
        } else {
          throw new InvalidExpressionException;
        }
      } else {
        if(preg_match('/^\s*(\+)(.*)$/', $remainingExpression, $regexMatches)) {
          $tokens[] = new AdditionToken;
          $remainingExpression = $regexMatches[2];
          $expectOperator = false;
        } elseif(preg_match('/^\s*(-)(.*)$/', $remainingExpression, $regexMatches)) {
          $tokens[] = new SubtractionToken;
          $remainingExpression = $regexMatches[2];
          $expectOperator = false;
        } elseif(preg_match('/^\s*(\*)(.*)$/', $remainingExpression, $regexMatches)) {
          $tokens[] = new MultiplicationToken;
          $remainingExpression = $regexMatches[2];
          $expectOperator = false;
        } elseif(preg_match('/^\s*(\/)(.*)$/', $remainingExpression, $regexMatches)) {
          $tokens[] = new DivisionToken;
          $remainingExpression = $regexMatches[2];
          $expectOperator = false;
        } elseif(preg_match('/^\s*(\^)(.*)$/', $remainingExpression, $regexMatches)) {
          $tokens[] = new PowerToken;
          $remainingExpression = $regexMatches[2];
          $expectOperator = false;
        } elseif(preg_match('/^\s*(\))(.*)$/', $remainingExpression, $regexMatches)) {
          $tokens[] = new ClosedBracketToken;
          $remainingExpression = $regexMatches[2];
          $expectOperator = true;
        } else {
          throw new InvalidExpressionException;
        }
      }
    }
    return $tokens;
  }

}
