<?php

use \Omnicron\InfixCalculator\Classes\Lexer;
use \Omnicron\InfixCalculator\Classes\Parser;
use \PHPUnit\Framework\TestCase;

class ParserTests extends TestCase
{
  public function testParserBasicAddition() {
    $lexer = new Lexer;
    $parser = new Parser;
    $tokenizedExpression = $lexer->tokenizeExpression('9 + 3');
    $parsingTree = $parser->parseTokenizedExpression($tokenizedExpression);
    $this->assertEquals(12, $parsingTree->evaluate());
  }
  public function testParserBasicSubtraction() {
    $lexer = new Lexer;
    $parser = new Parser;
    $tokenizedExpression = $lexer->tokenizeExpression('9 - 3');
    $parsingTree = $parser->parseTokenizedExpression($tokenizedExpression);
    $this->assertEquals(6, $parsingTree->evaluate());
  }
  public function testParserBasicMultiplication() {
    $lexer = new Lexer;
    $parser = new Parser;
    $tokenizedExpression = $lexer->tokenizeExpression('9 * 3');
    $parsingTree = $parser->parseTokenizedExpression($tokenizedExpression);
    $this->assertEquals(27, $parsingTree->evaluate());
  }
  public function testParserBasicDivision() {
    $lexer = new Lexer;
    $parser = new Parser;
    $tokenizedExpression = $lexer->tokenizeExpression('9 / 3');
    $parsingTree = $parser->parseTokenizedExpression($tokenizedExpression);
    $this->assertEquals(3, $parsingTree->evaluate());
  }
  public function testParserNegationOne() {
    $lexer = new Lexer;
    $parser = new Parser;
    $tokenizedExpression = $lexer->tokenizeExpression('-(1 + 2)');
    $parsingTree = $parser->parseTokenizedExpression($tokenizedExpression);
    $this->assertEquals(-3, $parsingTree->evaluate());
  }
  public function testParserNegationTwo() {
    $lexer = new Lexer;
    $parser = new Parser;
    $tokenizedExpression = $lexer->tokenizeExpression('-(-3 * (1 + 2))');
    $parsingTree = $parser->parseTokenizedExpression($tokenizedExpression);
    $this->assertEquals(9, $parsingTree->evaluate());
  }
  public function testParserBracketsOne() {
    $lexer = new Lexer;
    $parser = new Parser;
    $tokenizedExpression = $lexer->tokenizeExpression('(9 + 3) / 2');
    $parsingTree = $parser->parseTokenizedExpression($tokenizedExpression);
    $this->assertEquals(6, $parsingTree->evaluate());
  }
  public function testParserBracketsTwo() {
    $lexer = new Lexer;
    $parser = new Parser;
    $tokenizedExpression = $lexer->tokenizeExpression('(7 + 3) / (-2 * -1)');
    $parsingTree = $parser->parseTokenizedExpression($tokenizedExpression);
    $this->assertEquals(5, $parsingTree->evaluate());
  }
  public function testParserBracketsThree() {
    $lexer = new Lexer;
    $parser = new Parser;
    $tokenizedExpression = $lexer->tokenizeExpression('1 + (3 * (5 - ((7 + 1) / 2)))');
    $parsingTree = $parser->parseTokenizedExpression($tokenizedExpression);
    $this->assertEquals(4, $parsingTree->evaluate());
  }
  public function testParserPemdasOne() {
    $lexer = new Lexer;
    $parser = new Parser;
    $tokenizedExpression = $lexer->tokenizeExpression('1 + 2 * 3');
    $parsingTree = $parser->parseTokenizedExpression($tokenizedExpression);
    $this->assertEquals(7, $parsingTree->evaluate());
  }
  public function testParserPemdasTwo() {
    $lexer = new Lexer;
    $parser = new Parser;
    $tokenizedExpression = $lexer->tokenizeExpression('4 / 2 + 4');
    $parsingTree = $parser->parseTokenizedExpression($tokenizedExpression);
    $this->assertEquals(6, $parsingTree->evaluate());
  }
  public function testParserPemdasThree() {
    $lexer = new Lexer;
    $parser = new Parser;
    $tokenizedExpression = $lexer->tokenizeExpression('4 / 2 * 5 + 4');
    $parsingTree = $parser->parseTokenizedExpression($tokenizedExpression);
    $this->assertEquals(14, $parsingTree->evaluate());
  }
  public function testParserPemdasFour() {
    $lexer = new Lexer;
    $parser = new Parser;
    $tokenizedExpression = $lexer->tokenizeExpression('2 * 3 + 5 * 9');
    $parsingTree = $parser->parseTokenizedExpression($tokenizedExpression);
    $this->assertEquals(51, $parsingTree->evaluate());
  }
  public function testParserPemdasFive() {
    $lexer = new Lexer;
    $parser = new Parser;
    $tokenizedExpression = $lexer->tokenizeExpression('30 + 4 * (2 - 5)');
    $parsingTree = $parser->parseTokenizedExpression($tokenizedExpression);
    $this->assertEquals(18, $parsingTree->evaluate());
  }
}
