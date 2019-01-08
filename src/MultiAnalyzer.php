<?php

namespace PiedWeb\TextAnalyzer;

class MultiAnalyzer
{
    protected $onlyInSentence;
    protected $expressionMaxWords;
    protected $keepTrail;

    protected $words;

    /**
     * @var array contain the source texts
     */
    protected $text = [];

    public function __construct(
        bool $onlySentence      = false,
        int $expressionMaxWords = 5,
        int $keepTrail          = 3
    ) {
        $this->onlyInSentence     = $onlySentence;
        $this->expressionMaxWords = $expressionMaxWords;
        $this->keepTrail          = $keepTrail;
    }

    /**
     * @return Analysis
     */
    public function addContent(string $text)
    {
        $text = Analyzer::get(
            $text,
            $this->onlyInSentence,
            $this->expressionMaxWords,
            $this->keepTrail
        );

        $this->text[] = $text;

        return $text;
    }

    public function exec()
    {
        $mergedExpressions = [];

        foreach ($this->text as $text) {
            $expressions = $text->getExpressionsByDensity();
            foreach ($expressions as $expression => $density) {
                $mergedExpressions[$expression] =
                    (isset($mergedExpressions[$expression]) ? $mergedExpressions[$expression] : 0)
                    + $density
                ;
            }
        }

        arsort($mergedExpressions);

        return new Analysis($mergedExpressions, $this->getWordNumber(), $this->getTrails());
    }

    protected function getWordNumber()
    {
        $wn = 0;
        foreach ($this->text as $text) {
            $wn = $wn + $text->getWordNumber();
        }

        return $wn;
    }

    protected function getTrails()
    {
        $trails = [];

        foreach ($this->text as $text) {
            $traisl = array_merge($trails, $text->getTrails());
        }

        return $trails;
    }
}
