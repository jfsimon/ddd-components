<?php

namespace Ddd\Slug\Infra\Transliterator\Engine;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
interface EngineInterface
{
    /**
     * Transliterates given string to ascii.
     *
     * @param string $string
     *
     * @return string
     */
    public function transliterate($string);

    /**
     * Checks if engine is available for current platform & given encoding.
     *
     * @return boolean
     */
    public function isAvailable();

    /**
     * @return boolean
     */
    public function isPartial();
}
