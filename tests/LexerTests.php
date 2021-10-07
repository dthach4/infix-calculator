<?php

use \Omnicron\InfixCalculator\Classes\Lexer;
use \Omnicron\InfixCalculator\Token\AdditionToken;
use \Omnicron\InfixCalculator\Token\ClosedBracketToken;
use \Omnicron\InfixCalculator\Token\DivisionToken;
use \Omnicron\InfixCalculator\Token\MultiplicationToken;
use \Omnicron\InfixCalculator\Token\OpenBracketToken;
use \Omnicron\InfixCalculator\Token\SubtractionToken;
use \Omnicron\InfixCalculator\Token\LiteralToken;
use \PHPUnit\Framework\TestCase;

class LexerTests extends TestCase
{
  public function testLexerBasicAddition() {
    $lexer = new Lexer;
    $tokenizedExpression = $lexer->tokenizeExpression('5 + 4');
    $this->assertTrue(is_a($tokenizedExpression[0], LiteralToken::class));
    $this->assertTrue(is_a($tokenizedExpression[1], AdditionToken::class));
    $this->assertTrue(is_a($tokenizedExpression[2], LiteralToken::class));
  }
  public function testLexerBasicSubtraction() {
    $lexer = new Lexer;
    $tokenizedExpression = $lexer->tokenizeExpression('7 - 3');
    $this->assertTrue(is_a($tokenizedExpression[0], LiteralToken::class));
    $this->assertTrue(is_a($tokenizedExpression[1], SubtractionToken::class));
    $this->assertTrue(is_a($tokenizedExpression[2], LiteralToken::class));
  }
  public function testLexerBasicMultiplication() {
    $lexer = new Lexer;
    $tokenizedExpression = $lexer->tokenizeExpression('9 * 8');
    $this->assertTrue(is_a($tokenizedExpression[0], LiteralToken::class));
    $this->assertTrue(is_a($tokenizedExpression[1], MultiplicationToken::class));
    $this->assertTrue(is_a($tokenizedExpression[2], LiteralToken::class));
  }
  public function testLexerBasicDivision() {
    $lexer = new Lexer;
    $tokenizedExpression = $lexer->tokenizeExpression('6 / 2');
    $this->assertTrue(is_a($tokenizedExpression[0], LiteralToken::class));
    $this->assertTrue(is_a($tokenizedExpression[1], DivisionToken::class));
    $this->assertTrue(is_a($tokenizedExpression[2], LiteralToken::class));
  }
  public function testLexerBasicBrackets() {
    $lexer = new Lexer;
    $tokenizedExpression = $lexer->tokenizeExpression('(5 + 2) * 3');
    $this->assertTrue(is_a($tokenizedExpression[0], OpenBracketToken::class));
    $this->assertTrue(is_a($tokenizedExpression[1], LiteralToken::class));
    $this->assertTrue(is_a($tokenizedExpression[2], AdditionToken::class));
    $this->assertTrue(is_a($tokenizedExpression[3], LiteralToken::class));
    $this->assertTrue(is_a($tokenizedExpression[4], ClosedBracketToken::class));
    $this->assertTrue(is_a($tokenizedExpression[5], MultiplicationToken::class));
    $this->assertTrue(is_a($tokenizedExpression[6], LiteralToken::class));
  }
}
