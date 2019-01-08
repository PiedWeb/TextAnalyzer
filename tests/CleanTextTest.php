<?php
namespace PiedWeb\ExpressionHarvester\Test;

use PiedWeb\TextAnalyzer\CleanText;

class CleanTextTest extends \PHPUnit\Framework\TestCase
{
    public function testSimpleSentences()
    {
        $loremIpsum = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

        $this->assertSame(4, count(CleanText::getSentences($loremIpsum)));
    }

    public function testRemoveExtremityStopWords()
    {
        $this->assertSame('ferme', CleanText::removeStopWordsAtExtremity('la ferme'));
        $this->assertSame('ferme', CleanText::removeStopWordsAtExtremity('la ferme de'));
        $this->assertSame('ferme', CleanText::removeStopWordsAtExtremity('ferme de'));
    }

    public function testRemoveExtremityStopWords2()
    {
        $this->assertSame('savoir', CleanText::removeStopWordsAtExtremity('savoir plus '));
    }

    public function testremoveStopWords()
    {
        $this->assertSame('', CleanText::removeStopWords(' http//www '));
    }

    public function testStripTags()
    {
        $text = '<label class="u-block" for="js-toggler-menu"><svg aria-labelledby="title" role="img" class="u-icon u-icon-burger" viewbox="0 0 18 18" width="18" height="18"><title lang="fr">Icone menu burger</title><span class="u-visually-hidden" aria-hidden="true">Menu</span></label>';

        $this->assertSame('Icone menu burger Menu', CleanText::stripHtmlTags($text));
        $this->assertSame('Icone menu burger Menu', CleanText::stripHtmlTagsOldWay(str_replace('<', ' <', $text)));


        $text = '<label class="u-block" for="js-toggler-menu"><svg aria-labelledby="title" role="img" class="u-icon u-icon-burger" viewbox="0 0 18 18" width="18" height="18"><title lang="fr">Icone menu burger</title>'."\n".'<span class="u-visually-hidden" aria-hidden="true">Menu</span></label>';

        $this->assertSame('Icone menu burger Menu', CleanText::stripHtmlTags($text));
        $this->assertSame('Icone menu burger Menu', CleanText::stripHtmlTagsOldWay(str_replace('<', ' <', $text)));

    }
}
