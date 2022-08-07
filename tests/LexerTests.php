<?php

use \Omnicron\InfixCalculator\Classes\Lexer;
use \Omnicron\InfixCalculator\Token\BinaryOperation\AdditionToken;
use \Omnicron\InfixCalculator\Token\BinaryOperation\DivisionToken;
use \Omnicron\InfixCalculator\Token\BinaryOperation\MultiplicationToken;
use \Omnicron\InfixCalculator\Token\BinaryOperation\SubtractionToken;
use \Omnicron\InfixCalculator\Token\BinaryOperation\PowerToken;
use \Omnicron\InfixCalculator\Token\Bracket\ClosedBracketToken;
use \Omnicron\InfixCalculator\Token\Bracket\OpenBracketToken;
use \Omnicron\InfixCalculator\Token\Literal\LiteralToken;
use \Omnicron\InfixCalculator\Token\UnaryFunction\CosineToken;
use \Omnicron\InfixCalculator\Token\UnaryFunction\SineToken;
use \Omnicron\InfixCalculator\Token\UnaryOperation\NegationToken;
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
  public function testLexerBasicPower() {
    $lexer = new Lexer;
    $tokenizedExpression = $lexer->tokenizeExpression('3 ^ 2');
    $this->assertTrue(is_a($tokenizedExpression[0], LiteralToken::class));
    $this->assertTrue(is_a($tokenizedExpression[1], PowerToken::class));
    $this->assertTrue(is_a($tokenizedExpression[2], LiteralToken::class));
  }
  public function testLexerBasicNegation() {
    $lexer = new Lexer;
    $tokenizedExpression = $lexer->tokenizeExpression('- 7');
    $this->assertTrue(is_a($tokenizedExpression[0], NegationToken::class));
    $this->assertTrue(is_a($tokenizedExpression[1], LiteralToken::class));
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
  public function testLexerSineFunction() {
    $lexer = new Lexer;
    $tokenizedExpression = $lexer->tokenizeExpression('sin(3.1415926535)');
    $this->assertTrue(is_a($tokenizedExpression[0], SineToken::class));
    $this->assertTrue(is_a($tokenizedExpression[1], OpenBracketToken::class));
    $this->assertTrue(is_a($tokenizedExpression[2], LiteralToken::class));
    $this->assertTrue(is_a($tokenizedExpression[3], ClosedBracketToken::class));
  }
  public function testLexerCosineFunction() {
    $lexer = new Lexer;
    $tokenizedExpression = $lexer->tokenizeExpression('cos(3.1415926535)');
    $this->assertTrue(is_a($tokenizedExpression[0], CosineToken::class));
    $this->assertTrue(is_a($tokenizedExpression[1], OpenBracketToken::class));
    $this->assertTrue(is_a($tokenizedExpression[2], LiteralToken::class));
    $this->assertTrue(is_a($tokenizedExpression[3], ClosedBracketToken::class));
  }
}
