<?php

namespace Ddd\Slug\Infra\SlugGenerator\Strategy;

/**
 * Base strategy class.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
abstract class AbstractStrategy implements StrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function supportsOptions(array $options)
    {
        $optionKeys = array_keys($options);
        $supportedOptions = $this->getSupportedOptions();

        return 0 === count(array_diff($optionKeys, $supportedOptions))
            && 0 === count(array_diff($supportedOptions, $optionKeys));
    }

    /**
     * @return array List of supported option keys
     */
    abstract protected function getSupportedOptions();
}
