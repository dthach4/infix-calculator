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
use \Omnicron\InfixCalculator\TreeNode\LiteralTreeNode;
use \Omnicron\InfixCalculator\TreeNode\OperationTreeNode;

class Parser
{

  public function parseTokenizedExpression(array $tokens) {
    $tree = $this->makeParsingTree($tokens);
    return $tree;
  }

  protected function makeParsingTree($tokens) {
    $i = 0;
    $tree = $this->convertExpressionToTree($tokens, $i);
    return $tree;
  }

  protected function convertExpressionToTree($tokens, &$i) {
    $buffer = [];
    $done = false;
    while(!$done && $i < count($tokens)) {
      $nextToken = $tokens[$i];
      ++$i;
      if(is_a($nextToken, ClosedBracketToken::class)) {
        $done = true;
      } elseif(is_a($nextToken, OpenBracketToken::class)) {
        $buffer[] = $this->convertExpressionToTree($tokens, $i);
      } elseif(is_a($nextToken, LiteralToken::class)) {
        $buffer[] = new LiteralTreeNode($nextToken);
      } else { // any operation token stays
        $buffer[] = $nextToken;
      }
    }
    // processing power
    for($j = 0; $j < count($buffer); ++$j) {
      if(is_a($buffer[$j], PowerToken::class)) {
        array_splice(
          $buffer,
          $j-1,
          3,
          [new OperationTreeNode(
            $buffer[$j],
            [$buffer[$j-1], $buffer[$j+1]]
          )]
        );
        --$j;
      }
    }
    // processing negation
    for($j = 0; $j < count($buffer); ++$j) {
      if(is_a($buffer[$j], NegationToken::class)) {
        array_splice(
          $buffer,
          $j,
          2,
          [new OperationTreeNode(
            $buffer[$j],
            [$buffer[$j+1]]
          )]
        );
      }
    }
    // processing multiplications and divisions
    for($j = 0; $j < count($buffer); ++$j) {
      if(
        is_a($buffer[$j], MultiplicationToken::class) ||
        is_a($buffer[$j], DivisionToken::class)
      ) {
        array_splice(
          $buffer,
          $j-1,
          3,
          [new OperationTreeNode(
            $buffer[$j],
            [$buffer[$j-1], $buffer[$j+1]]
          )]
        );
        --$j;
      }
    }
    // processing additions and subtractions
    for($j = 0; $j < count($buffer); ++$j) {
      if(
        is_a($buffer[$j], AdditionToken::class) ||
        is_a($buffer[$j], SubtractionToken::class)
      ) {
        array_splice(
          $buffer,
          $j-1,
          3,
          [new OperationTreeNode(
            $buffer[$j],
            [$buffer[$j-1], $buffer[$j+1]]
          )]
        );
        --$j;
      }
    }
    if(count($buffer) !== 1) {
      var_dump($buffer);
      throw new \Exception('Buffer size is '.count($buffer).' after reduction');
    }
    return $buffer[0];
  }

}
