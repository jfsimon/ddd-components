<?php

namespace Ddd\Slug\Infra\SlugGenerator\Strategy;

/**
 * Field separator strategy.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class FieldSeparatorStrategy extends AbstractStrategy
{
    /**
     * {@inheritdoc}
     */
    public function slugify(array $fieldValues, array $options = array())
    {
        return implode($options['field_separator'], $fieldValues);
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedOptions()
    {
        return array('field_separator');
    }
}
