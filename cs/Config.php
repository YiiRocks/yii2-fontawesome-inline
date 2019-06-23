<?php

/**
 * @link https://fontawesome.mr42.me/
 * @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome\cs;

/**
 * Basic rules.
 */
class Config extends \PhpCsFixer\Config
{
    /**
     * Construct.
     * @param mixed $name
     */
    public function __construct($name = 'mr42-cs-config')
    {
        parent::__construct($name);

        $header = <<<'header'
@link https://fontawesome.mr42.me/
@license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
header;

        $this->setRiskyAllowed(true);

        $this->setRules([
            '@PSR2' => true,
            'header_comment' => [
                'header' => $header,
                'commentType' => 'PHPDoc',
            ],
        ]);
    }
}
