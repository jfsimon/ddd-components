<?php

namespace Ddd\Slug\Service;

/**
 * Interface for slugifiers.
 *
 * @author Joseph Rouff <rouffj@gmail.com>
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
interface SlugGeneratorInterface
{
    /**
     * Slugifies an array of string values.
     *
     * Valid generator options are:
     * * `word_separator`: string used to separate words
     * * `lower_case`: boolean switching slug case lowering
     * * `transliterator`: name of transliterator used to replace non-ascii chars
     *
     * See strategies implementation for strategy-specific options.
     *
     * @param array $fieldValues Values to slugify
     * @param array $options     Generator + strategy options
     *
     * @return string The generated slug
     */
    public function slugify(array $fieldValues, array $options = array());
}
