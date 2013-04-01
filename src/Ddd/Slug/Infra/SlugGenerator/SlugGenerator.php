<?php

namespace Ddd\Slug\Infra\SlugGenerator;

use Ddd\Slug\Infra\SlugGenerator\Strategy\StrategyCollection;
use Ddd\Slug\Infra\Transliterator\TransliteratorCollection;
use Ddd\Slug\Service\SlugGeneratorInterface;

/**
 * Text slugifier.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
class SlugGenerator implements SlugGeneratorInterface
{
    const UNWANTED_CHARS = '~[^a-z0-9]~i';

    /**
     * @var TransliteratorCollection
     */
    private $transliterators;

    /**
     * @var StrategyCollection
     */
    private $strategies;

    /**
     * @var array
     */
    private $defaultOptions = array(
        'word_separator' => '-',
        'lower_case'     => true,
        'transliterator' => 'latin',
    );

    /**
     * Constructor.
     *
     * @param TransliteratorCollection $transliterators
     * @param StrategyCollection       $strategies
     * @param array                    $defaultOptions
     */
    public function __construct(TransliteratorCollection $transliterators, StrategyCollection $strategies, array $defaultOptions = array())
    {
        $this->transliterators = $transliterators;
        $this->strategies = $strategies;
        $this->defaultOptions = $this->mergeOptions($defaultOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function slugify(array $fieldValues, array $options = array('field_separator' => '-'))
    {
        $generatorOptions = $this->mergeOptions($options);
        $strategyOptions = array_diff_key($options, $generatorOptions);

        if (!$this->strategies->supportsOptions($strategyOptions)) {
            throw new \InvalidArgumentException('Unsupported options given "'.implode('", "', array_keys($strategyOptions)).'".');
        }

        foreach ($fieldValues as &$value) {
            $value = $this->transliterators->transliterate($generatorOptions['transliterator'], $value);
            $value = $this->replaceUnwantedChars($value, $generatorOptions['word_separator']);
        }

        $slug = $this->strategies->slugify($fieldValues, $strategyOptions);
        $slug = $this->removesUndueWordSeparators($slug, $generatorOptions['word_separator']);

        return $generatorOptions['lower_case'] ? strtolower($slug) : $slug;
    }

    /**
     * Merges given options with default ones and ignores unknown keys.
     *
     * @param array $options
     *
     * @return array
     */
    private function mergeOptions(array $options)
    {
        $mergedOptions = array();
        foreach ($this->defaultOptions as $key => $value) {
            $mergedOptions[$key] = isset($options[$key]) ? $options[$key] : $value;
        }

        return $mergedOptions;
    }

    /**
     * Transliterates field values.
     *
     * @param string $transliteratorName
     * @param array  $fieldValues
     *
     * @return array
     */
    private function transliterate($transliteratorName, array $fieldValues)
    {
        $transliteratedValues = array();
        foreach ($fieldValues as $name => $value) {
            $transliteratedValues[$name] = $this->transliterators->transliterate($transliteratorName, $value);
        }

        return $transliteratedValues;
    }

    /**
     * Replaces unwanted chars with word separator.
     *
     * @param string $value
     * @param string $wordSeparator
     *
     * @return array
     */
    private function replaceUnwantedChars($value, $wordSeparator)
    {
        return preg_replace(self::UNWANTED_CHARS, $wordSeparator, $value);
    }

    /**
     * Removed duplicates/heading/trailing word separators.
     *
     * @param string $slug
     * @param string $wordSeparator
     *
     * @return string
     */
    private function removesUndueWordSeparators($slug, $wordSeparator)
    {
        $slug = preg_replace('~['.preg_quote($wordSeparator).']+~', $wordSeparator, $slug);

        return trim($slug, $wordSeparator);
    }
}
