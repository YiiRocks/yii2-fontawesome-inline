<?php
namespace thoulah\fontawesome\dom;

use Yii;

/**
 * {@inheritdoc}
 */
class DOMDocument extends \DOMDocument
{
    /**
     * {@inheritdoc}
     */
    public function __construct($version = null, $encoding = null)
    {
        libxml_use_internal_errors(true);
        parent::__construct($version, $encoding);
    }

    /**
     * {@inheritdoc}
     */
     public function load($source, $options = null)
     {
         $fileName = Yii::getAlias($source);
         return parent::load(realpath($fileName), $options);
     }
}
