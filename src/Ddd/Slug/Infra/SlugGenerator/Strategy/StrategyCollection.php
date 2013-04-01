<?php

namespace Ddd\Slug\Infra\SlugGenerator\Strategy;

/**
 * Strategy collection.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class StrategyCollection implements StrategyInterface
{
    /**
     * @var StrategyInterface[]
     */
    private $strategies = array();

    /**
     * @var StrategyCollectionCache
     */
    private $cache;

    /**
     * Constructor.
     *
     * @param StrategyInterface[] $strategies
     */
    public function __construct(array $strategies = array())
    {
        $this->cache = new StrategyCollectionCache();

        foreach ($strategies as $strategy) {
            $this->add($strategy);
        }
    }

    /**
     * Adds a strategy to the collection.
     *
     * @param StrategyInterface $strategy
     *
     * @return StrategyCollection
     */
    public function add(StrategyInterface $strategy)
    {
        $this->strategies[] = $strategy;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function slugify(array $fieldValues, array $options = array())
    {
        return $this->findStrategy($options)->slugify($fieldValues, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsOptions(array $options)
    {
        return null !== $this->findStrategy($options);
    }

    /**
     * Finds strategy supporting given options.
     *
     * @param array $options
     *
     * @return StrategyInterface|null
     */
    private function findStrategy(array $options)
    {
        $optionKeys = array_keys($options);
        sort($optionKeys);

        if ($this->cache->has($optionKeys)) {
            return $this->cache->get($optionKeys);
        }

        foreach ($this->strategies as $strategy) {
            if ($strategy->supportsOptions($options)) {
                return $this->cache->set($optionKeys, $strategy);
            }
        }

        return $this->cache->set($optionKeys, null);
    }
}
