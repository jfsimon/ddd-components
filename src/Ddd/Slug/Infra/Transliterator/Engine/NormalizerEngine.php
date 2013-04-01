<?php

namespace Ddd\Slug\Infra\Transliterator\Engine;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class NormalizerEngine implements EngineInterface
{
    /**
     * {@inheritdoc}
     */
    public function transliterate($string)
    {
        $normalization = \Normalizer::normalize($string, \Normalizer::FORM_KD);

        return preg_replace('/{\pMn}/', '', $normalization);
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailable()
    {
        return class_exists('Normalizer');
    }

    /**
     * {@inheritdoc}
     */
    public function isPartial()
    {
        return false;
    }
}
