<?php

namespace Ddd\Slug\Infra\Transliterator;

/**
 * @author Joseph Rouff <rouffj@gmail.com>
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
class LatinTransliterator extends AbstractTransliterator
{
    /**
     * @param string $inputEncoding
     */
    public function __construct($inputEncoding = 'utf-8')
    {
        parent::__construct(array(
            new Engine\TransliteratorEngine('latin; NFKD; [^\u0000-\u007E] Remove; NFC'),
            new Engine\IconvEngine($inputEncoding),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'latin';
    }
}
