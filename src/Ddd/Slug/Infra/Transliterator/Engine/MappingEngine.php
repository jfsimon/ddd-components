<?php

namespace Ddd\Slug\Infra\Transliterator\Engine;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class MappingEngine implements EngineInterface
{
    /**
     * @var array
     */
    private $mapping = array();

    /**
     * Constructor.
     *
     * @param array $mapping
     */
    public function __construct(array $mapping = array())
    {
        foreach ($mapping as $input => $output) {
            $this->map($input, $output);
        }
    }

    /**
     * @param string $input
     * @param string $output
     *
     * @return MappingEngine
     */
    public function map($input, $output)
    {
        $this->mapping[$input] = $output;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function transliterate($string)
    {
        return strtr($string, $this->mapping);
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailable()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isPartial()
    {
        return true;
    }
}
