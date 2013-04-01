<?php

namespace Ddd\Slug\Infra\SlugGenerator;

use Ddd\Slug\Service\SlugGeneratorInterface;

/**
 * Slug generator proxy, permit to store slugification default options.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class SlugGeneratorProxy implements SlugGeneratorInterface
{
    /**
     * @var SlugGeneratorInterface
     */
    private $generator;

    /**
     * @var array
     */
    private $defaultOptions;

    /**
     * Constructor.
     *
     * @param SlugGeneratorInterface $generator
     * @param array                  $defaultOptions
     */
    public function __construct(SlugGeneratorInterface $generator, array $defaultOptions)
    {
        $this->generator = $generator;
        $this->defaultOptions = $defaultOptions;
    }

    /**
     * {@inheritdoc}
     */
    public function slugify(array $fieldValues, array $options = array())
    {
        $options = empty($options) ? $this->defaultOptions : $this->mergeOptions($options);

        return $this->generator->slugify($fieldValues, $options);
    }

    /**
     * Merges non strategy related options.
     *
     * @param array $options
     *
     * @return array
     */
    private function mergeOptions(array $options)
    {
        foreach (array('word_separator', 'lower_case', 'transliterator') as $option) {
            if (isset($this->defaultOptions[$option]) && !isset($options[$option])) {
                $options[$option] = $this->defaultOptions[$option];
            }
        }

        return $options;
    }
}
