<?php

namespace Ddd\Slug\Infra\SlugGenerator;

use Ddd\Slug\Infra\SlugGenerator\Strategy\FieldSeparatorStrategy;
use Ddd\Slug\Infra\SlugGenerator\Strategy\PatternStrategy;
use Ddd\Slug\Infra\SlugGenerator\Strategy\StrategyCollection;
use Ddd\Slug\Infra\Transliterator\LatinTransliterator;
use Ddd\Slug\Infra\Transliterator\TransliteratorCollection;

/**
 * Default text slugifier.
 *
 * @author Joseph Rouff <rouffj@gmail.com>
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
class DefaultSlugGenerator extends SlugGeneratorProxy
{
    /**
     * @param array $defaultOptions
     */
    public function __construct(array $defaultOptions = array('field_separator' => '-'))
    {
        $generator = new SlugGenerator(
            new TransliteratorCollection(array(new LatinTransliterator())),
            new StrategyCollection(array(new FieldSeparatorStrategy(), new PatternStrategy()))
        );

        parent::__construct($generator, $defaultOptions);
    }
}
