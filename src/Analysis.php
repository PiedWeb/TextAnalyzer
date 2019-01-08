<?php

namespace PiedWeb\TextAnalyzer;

class Analysis
{
    private $expressions = [];

    private $wordNumber = 0;

    private $trail = [];

    public function __construct(
        array $expressions,
        int $wordNumber,
        array $trail

    ) {
        $this->expressions     = $expressions;
        $this->wordNumber      = $wordNumber;
        $this->trail          = $trail;
    }

    public function getExpressionsByDensity()
    {
        $expressions = $this->expressions;
        foreach ($expressions as $k => $v) {
            $expressions[$k] = round(($v / $this->getWordNumber()) * 10000) / 100;
        }
        return $expressions;
    }

    public function getWordNumber()
    {
        return $this->wordNumber;
    }

    public function getExpressions(?int $number = null)
    {
        return !$number ? $this->expressions : array_slice($this->getExpressions(), 0, $number);
    }

    /**
     * @return array containing sentence where we can find expresion
     */
    public function getTrail(string $expression)
    {
        if (isset($this->trail[$expression])) {
            return $this->trail[$expression];
        }

        return [];
    }

    public function getTrails()
    {
        return $this->trail;
    }
}
