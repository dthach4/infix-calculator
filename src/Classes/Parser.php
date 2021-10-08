<?php

namespace Omnicron\InfixCalculator\Classes;

use \Omnicron\InfixCalculator\Token\BinaryOperationToken;
use \Omnicron\InfixCalculator\Token\ClosedBracketToken;
use \Omnicron\InfixCalculator\Token\LiteralToken;
use \Omnicron\InfixCalculator\Token\OpenBracketToken;
use \Omnicron\InfixCalculator\Token\OperationToken;
use \Omnicron\InfixCalculator\Token\UnaryOperationToken;
use \Omnicron\InfixCalculator\TreeNode\LiteralTreeNode;
use \Omnicron\InfixCalculator\TreeNode\OperationTreeNode;
use \Omnicron\InfixCalculator\TreeNode\TreeNode;

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
    // getting all priorities
    $priorities = [];
    for($j = 0; $j < count($buffer); ++$j) {
      if(is_a($buffer[$j], OperationToken::class) && !in_array($buffer[$j]->getPriority(), $priorities)) {
        array_push($priorities, $buffer[$j]->getPriority());
      }
    }
    usort($priorities, function ($a, $b) { return $b <=> $a; });
    // processing tokens by priority
    foreach($priorities as $priority) {
      for($j = 0; $j < count($buffer); ++$j) {
        if(is_a($buffer[$j], OperationToken::class) && $buffer[$j]->getPriority() === $priority) {
          if(is_a($buffer[$j], UnaryOperationToken::class)) {
            $k = $j;
            while(is_a($buffer[$k+1], UnaryOperationToken::class)) {
              ++$k;
            }
            while($k >= $j) {
              array_splice(
                $buffer,
                $k,
                2,
                [new OperationTreeNode(
                  $buffer[$k],
                  [$buffer[$k+1]]
                )]
              );
              --$k;
            }
          } elseif(is_a($buffer[$j], BinaryOperationToken::class)) {
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
          } else {
            throw new \Exception('Unable to handle an OperationToken which isn\'t either a UnaryOperationToken or a BinaryOperationToken');
          }
        }
      }
    }
    if(count($buffer) !== 1) {
      var_dump($buffer);
      throw new \Exception('Buffer size is '.count($buffer).' after reduction');
    }
    return $buffer[0];
  }

}
