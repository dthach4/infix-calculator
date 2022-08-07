<?php

namespace Omnicron\InfixCalculator\Classes;

use \Omnicron\InfixCalculator\Exceptions\InvalidExpressionException;
use \Omnicron\InfixCalculator\Token\Abstract\BinaryOperationToken;
use \Omnicron\InfixCalculator\Token\Abstract\UnaryFunctionToken;
use \Omnicron\InfixCalculator\Token\Abstract\UnaryOperationToken;
use \Omnicron\InfixCalculator\Token\BinaryOperation\AdditionToken;
use \Omnicron\InfixCalculator\Token\BinaryOperation\DivisionToken;
use \Omnicron\InfixCalculator\Token\BinaryOperation\MultiplicationToken;
use \Omnicron\InfixCalculator\Token\BinaryOperation\PowerToken;
use \Omnicron\InfixCalculator\Token\BinaryOperation\SubtractionToken;
use \Omnicron\InfixCalculator\Token\Bracket\ClosedBracketToken;
use \Omnicron\InfixCalculator\Token\Bracket\OpenBracketToken;
use \Omnicron\InfixCalculator\Token\Literal\LiteralToken;
use \Omnicron\InfixCalculator\Token\UnaryFunction\SineToken;
use \Omnicron\InfixCalculator\Token\UnaryFunction\CosineToken;
use \Omnicron\InfixCalculator\Token\UnaryOperation\NegationToken;

class Lexer
{

  public array $operationTokens = [];

  public function __construct() {
    $this->operationTokens = [
      new AdditionToken,
      new DivisionToken,
      new MultiplicationToken,
      new NegationToken,
      new PowerToken,
      new SubtractionToken,
      new SineToken,
      new CosineToken,
    ];
  }

  public function tokenizeExpression($expression) {
    $unaryOperationOrFunctionTokens = [];
    $binaryOperationTokens = [];
    foreach($this->operationTokens as $operationToken) {
      if(
        is_a($operationToken, UnaryOperationToken::class) ||
        is_a($operationToken, UnaryFunctionToken::class)
      ) {
        $unaryOperationOrFunctionTokens[] = $operationToken;
      }
      if(is_a($operationToken, BinaryOperationToken::class)) {
        $binaryOperationTokens[] = $operationToken;
      }
    }
    usort(
      $unaryOperationOrFunctionTokens,
      function ($a, $b) {
        return strlen($b->getOperator()) <=> strlen($a->getOperator());
      }
    );
    usort(
      $binaryOperationTokens,
      function ($a, $b) {
        return strlen($b->getOperator()) <=> strlen($a->getOperator());
      }
    );
    $tokens = [];
    $remainingExpression = trim($expression);
    $expectBinaryOperator = false; // undignified fsa lmao
    while(strlen(trim($remainingExpression)) > 0) {
      if(false === $expectBinaryOperator) {
        if(preg_match('/^([0-9]+(?:\.[0-9]*)?)(.*)$/', $remainingExpression, $regexMatches)) {
          $tokens[] = new LiteralToken(floatval($regexMatches[1]));
          $remainingExpression = $regexMatches[2];
          $expectBinaryOperator = true;
        } elseif(preg_match('/^(\()(.*)$/', $remainingExpression, $regexMatches)) {
          $tokens[] = new OpenBracketToken;
          $remainingExpression = $regexMatches[2];
          $expectBinaryOperator = false;
        } else {
          $operationToken = null;
          $i = 0;
          while($i < count($unaryOperationOrFunctionTokens) && is_null($operationToken)) {
            if($unaryOperationOrFunctionTokens[$i]->getOperator() === substr($remainingExpression, 0, strlen($unaryOperationOrFunctionTokens[$i]->getOperator()))) {
              $operationToken = $unaryOperationOrFunctionTokens[$i];
            }
            ++$i;
          }
          if(is_null($operationToken)) {
            throw new InvalidExpressionException('Unexpected character "'.$remainingExpression[0].'" at index '.strlen(trim($expression))-strlen($remainingExpression));
          }
          $tokens[] = $operationToken;
          $remainingExpression = substr($remainingExpression, strlen($operationToken->getOperator()));
          $expectBinaryOperator = false;
        }
      } else {
        if(preg_match('/^(\))(.*)$/', $remainingExpression, $regexMatches)) {
          $tokens[] = new ClosedBracketToken;
          $remainingExpression = $regexMatches[2];
          $expectBinaryOperator = true;
        } else {
          $operationToken = null;
          $i = 0;
          while($i < count($binaryOperationTokens) && is_null($operationToken)) {
            if($binaryOperationTokens[$i]->getOperator() === substr($remainingExpression, 0, strlen($binaryOperationTokens[$i]->getOperator()))) {
              $operationToken = $binaryOperationTokens[$i];
            }
            ++$i;
          }
          if(is_null($operationToken)) {
            throw new InvalidExpressionException('Unexpected character "'.$remainingExpression[0].'" at index '.strlen(trim($expression))-strlen($remainingExpression));
          }
          $tokens[] = $operationToken;
          $expectBinaryOperator = false;
          $remainingExpression = substr($remainingExpression, strlen($operationToken->getOperator()));
        }
      }
      $remainingExpression = trim($remainingExpression);
    }
    return $tokens;
  }

}
