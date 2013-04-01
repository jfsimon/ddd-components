<?php

namespace Ddd\Slug\Tests\Transliterator;

use Ddd\Slug\Infra\Transliterator\Engine;
use Ddd\Slug\Infra\Transliterator\LatinTransliterator;

class LatinTransliteratorTest extends \PhpUnit_Framework_TestCase
{
    /** @dataProvider getTransliteratorTestData */
    public function testTransliterator($input, $expectedOutput)
    {
        $transliterator = new LatinTransliterator();
        $this->assertEquals($expectedOutput, $transliterator->transliterate($input));
    }

    public function getTransliteratorTestData()
    {
        return array(
            array('aiune', 'aiune'), // Normal letters
            // accents
            array('âïùñé', 'aiune'), // Classic accents
            array('ŭąłå', 'uala'),   // Specific accents
            // compound
            array('æ', 'ae'),        // Ash, Aesc, Near-open front unrounded vowel
            array('ǽ', 'ae'),        // With acute
            array('€', 'EUR'),       // Euro symbol
            array('ß', 'ss'),        // German eszett
            array('ﬀ', 'ff'),        // Ligature FF
        );
    }
}
