<?php

namespace PiedWeb\TextAnalyzer;

class Analyzer
{
    protected $onlyInSentence;
    protected $expressionMaxWords;
    protected $keepTrail;

    protected $text;
    protected $expressions = [];
    protected $wordNumber = 0;
    protected $trail = [];

    public static function get(
        string $text,
        bool $onlySentence = false,
        int $expressionMaxWords = 5,
        int $keepTrail = 3
    ) {
        $self = new self($text);

        $self->onlyInSentence = $onlySentence;
        $self->expressionMaxWords = $expressionMaxWords;
        $self->keepTrail = $keepTrail;

        return $self->exec();
    }

    protected function __construct(string $text)
    {
        $text = CleanText::stripHtmlTags($text);
        $text = CleanText::fixEncoding($text);

        $text = CleanText::removeDate($text);

        if ($this->onlyInSentence) {
            $text = CleanText::keepOnlySentence($text);
        }

        $this->text = $text;
    }

    protected function incrementWordNumber(int $value)
    {
        $this->wordNumber = $this->wordNumber + $value;
    }

    protected function exec()
    {
        if ($this->onlyInSentence) {
            $sentences = [];
            foreach (explode(chr(10), $this->text) as $paragraph) {
                $sentences = array_merge($sentences, CleanText::getSentences($paragraph));
            }
        } else {
            $sentences = explode(chr(10), trim($this->text));
        }

        foreach ($sentences as $sentence) {
            $this->extract($sentence);
        }

        arsort($this->expressions);

        return new Analysis($this->expressions, $this->wordNumber, $this->trail);
    }

    protected function extract(string $sentence)
    {
        $sentence = CleanText::removePunctuation($sentence);

        $words = explode(' ', trim(strtolower($sentence)));

        foreach ($words as $key => $word) {
            for ($wordNumber = 1; $wordNumber <= $this->expressionMaxWords; ++$wordNumber) {
                $expression = '';
                for ($i = 0; $i < $wordNumber; ++$i) {
                    if (isset($words[$key + $i])) {
                        $expression .= ($i > 0 ? ' ' : '').$words[$key + $i];
                    }
                }

                $expression = $this->cleanExpr($expression, $wordNumber);

                if (
                    empty($expression)
                    || ((substr_count($expression, ' ') + 1) != $wordNumber) // We avoid sur-pondération
                    || !preg_match('/[a-z]/', $expression) // We avoid number or symbol only result
                ) {
                    if (1 === $wordNumber) {
                        $this->incrementWordNumber(-1);
                    }
                } else {
                    $plus = 1 + substr_count(CleanText::removeStopWords($expression), ' ');
                    $this->expressions[$expression] = isset($this->expressions[$expression]) ? $this->expressions[$expression] + $plus : $plus;
                    if ($this->keepTrail > 0 && $this->expressions[$expression] > $this->keepTrail) {
                        $this->trail[$expression][] = $sentence;
                    }
                }
            }
            $this->incrementWordNumber(1);
        }
    }

    protected function cleanExpr($expression, $wordNumber)
    {
        if ($wordNumber <= 2) {
            $expression = trim(CleanText::removeStopWords(' '.$expression.' '));
        } else {
            $expression = CleanText::removeStopWordsAtExtremity($expression);
            $expression = CleanText::removeStopWordsAtExtremity($expression);
            if (false === strpos($expression, ' ')) {
                $expression = trim(CleanText::removeStopWords(' '.$expression.' '));
            }
        }

        // Last Clean
        $expression = trim(preg_replace('/\s+/', ' ', $expression));
        if ('' == htmlentities($expression)) { //Avoid �
            $expression = '';
        }

        return $expression;
    }
}
