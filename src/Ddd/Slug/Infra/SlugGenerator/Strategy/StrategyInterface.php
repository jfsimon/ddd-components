<?php

namespace Ddd\Slug\Infra\SlugGenerator\Strategy;

use Ddd\Slug\Service\SlugGeneratorInterface;

/**
 * Strategy interface.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
interface StrategyInterface extends SlugGeneratorInterface
{
    /**
     * @param array $options
     *
     * @return boolean
     */
    public function supportsOptions(array $options);
}
