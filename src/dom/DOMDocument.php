<?php
namespace thoulah\fontawesome\dom;

use Yii;

class DOMDocument extends \DOMDocument
{
    /**
     * {@inheritdoc}
     */
    public function __construct($version = null, $encoding = null)
    {
        libxml_use_internal_errors(true);
        parent::__construct($version, $encoding);

        $this->registerNodeClass('DOMDocument', __CLASS__);
    }

    /**
     * {@inheritdoc}
     */
     public function load($source, $options = null)
     {
         $fileName = Yii::getAlias($source);
         $fileName = realpath($fileName);
         
         return parent::load($fileName, $options);
     }
}
