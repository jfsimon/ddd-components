<?php

namespace Ddd\Slug\Infra\Transliterator;

use Ddd\Slug\Infra\Transliterator\Engine\EngineInterface;
use Ddd\Slug\Service\TransliteratorInterface;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
abstract class AbstractTransliterator implements TransliteratorInterface
{
    /**
     * @var EngineInterface[]
     */
    private $engines = array();

    /**
     * @param array $engines
     */
    public function __construct(array $engines = array())
    {
        foreach ($engines as $engine) {
            $this->add($engine);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function transliterate($string)
    {
        if (empty($this->engines)) {
            throw new \RuntimeException('No available engine found.');
        }

        foreach ($this->engines as $engine) {
            $string = $engine->transliterate($string);

            if (!$engine->isPartial()) {
                break;
            }
        }

        return $string;
    }

    /**
     * @param EngineInterface $engine
     *
     * @return TransliteratorInterface
     */
    protected function add(EngineInterface $engine)
    {
        if ($engine->isAvailable()) {
            $this->engines[] = $engine;
        }

        return $this;
    }
}
