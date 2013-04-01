<?php

namespace Ddd\Slug\Infra\SlugGenerator\Strategy;

/**
 * Pattern strategy.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class PatternStrategy extends AbstractStrategy
{
    /**
     * {@inheritdoc}
     */
    public function slugify(array $fieldValues, array $options = array())
    {
        $replacements = array();
        foreach ($fieldValues as $name => $value) {
            $replacements['{'.$name.'}'] = $value;
        }

        return strtr($options['pattern'], $replacements);
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedOptions()
    {
        return array('pattern');
    }
}
