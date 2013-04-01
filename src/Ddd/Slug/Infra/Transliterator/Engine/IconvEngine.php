<?php

namespace Ddd\Slug\Infra\Transliterator\Engine;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class IconvEngine implements EngineInterface
{
    /**
     * @var string
     */
    private $inputEncoding;

    /**
     * @param string $inputEncoding
     */
    public function __construct($inputEncoding)
    {
        $this->inputEncoding = $inputEncoding;
    }

    /**
     * {@inheritdoc}
     */
    public function transliterate($string)
    {
        $transliteration = iconv($this->inputEncoding, 'us-ascii//TRANSLIT//IGNORE', $string);

        return preg_replace('/{\pM}/', '', $transliteration);
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailable()
    {
        return function_exists('iconv');
    }

    /**
     * {@inheritdoc}
     */
    public function isPartial()
    {
        return false;
    }
}
