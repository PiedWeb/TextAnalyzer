<?php
namespace PiedWeb\TextAnalyzer\Test;

use PiedWeb\TextAnalyzer\Analysis;
use PiedWeb\TextAnalyzer\Analyzer;
use PiedWeb\TextAnalyzer\MultiAnalyzer;

class CleanTextTest extends \PHPUnit\Framework\TestCase
{
    public function testMultiAnalyzer()
    {
        $test = new MultiAnalyzer();

        $result = $test->addContent("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed...");

        $this->assertTrue($result instanceof Analysis);
        $this->assertTrue(is_array($result->getExpressions()));
        $this->assertTrue(is_array($result->getTrails()));
        $this->assertTrue(is_int($result->getWordNumber()));

        $result = $test->addContent("Text Analyser : Expression in a text per Usage.");
        $result = $test->addContent("Please check if test are still running without error (phpunit)");
        $results = $test->exec();

        $this->assertTrue($results instanceof Analysis);
        $this->assertTrue(is_array($results->getExpressions()));
        $this->assertTrue(is_array($results->getTrails()));
        $this->assertTrue(is_int($results->getWordNumber()));
    }
}
