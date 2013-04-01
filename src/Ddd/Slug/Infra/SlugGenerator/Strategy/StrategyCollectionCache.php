<?php

namespace Ddd\Slug\Infra\SlugGenerator\Strategy;

/**
 * Supported strategy cache.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class StrategyCollectionCache
{
    /**
     * @var StrategyInterface[]
     */
    private $validStrategies = array();

    /**
     * @var array
     */
    private $invalidStrategies = array();

    /**
     * @param array $options
     *
     * @return bool
     */
    public function has(array $options)
    {
        $key = $this->key($options);

        return isset($this->validStrategies[$key]) || in_array($key, $this->invalidStrategies);
    }

    /**
     * @param array $options
     *
     * @return StrategyInterface|null
     */
    public function get(array $options)
    {
        $key = $this->key($options);

        return isset($this->validStrategies[$key]) ? $this->validStrategies[$key] : null;
    }

    /**
     * @param array             $options
     * @param StrategyInterface $strategy
     *
     * @return StrategyInterface|null
     */
    public function set(array $options, StrategyInterface $strategy = null)
    {
        if (null === $strategy) {
            $this->invalidStrategies[] = $this->key($options);
        } else {
            $this->validStrategies[$this->key($options)] = $strategy;
        }

        return $strategy;
    }

    /**
     * @param array $options
     *
     * @return string
     */
    private function key(array $options)
    {
        return implode('+', $options);
    }
}
