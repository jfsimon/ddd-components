<?php

namespace Ddd\Slug\Infra\Transliterator\Engine;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class TransliteratorEngine implements EngineInterface
{
    /**
     * @var string
     */
    private $rules;

    /**
     * @param string $rules
     */
    public function __construct($rules)
    {
        $this->rules = $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function transliterate($string)
    {
        $transliterator = \Transliterator::create($this->rules);

        return $transliterator->transliterate($string);
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailable()
    {
        return class_exists('Transliterator');
    }

    /**
     * {@inheritdoc}
     */
    public function isPartial()
    {
        return false;
    }
}
