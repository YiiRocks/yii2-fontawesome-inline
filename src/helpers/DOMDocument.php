<?php
namespace thoulah\fontawesome\helpers;

use Yii;

/**
 * Represents an entire HTML or XML document; serves as the root of the document tree.
 */
class DOMDocument extends \DOMDocument
{
    /**
     * Creates a new DOMDocument object
     *
     * @param string $version The version number of the document as part of the XML declaration.
     * @param string $encoding The encoding of the document as part of the XML declaration.
     */
    public function __construct($version = null, $encoding = null)
    {
        libxml_use_internal_errors(true);
        parent::__construct($version, $encoding);
    }

    /**
     * Load XML from a file
     *
     * @param string $source The path to the XML document.
     * @param int $options [Bitwise OR](https://www.php.net/manual/en/language.operators.bitwise.php)
     * of the [libxml option constants](https://www.php.net/manual/en/libxml.constants.php).
     * @return mixed Returns `TRUE` on success or `FALSE` on failure. If called
     * statically, returns a [[DOMDocument]] or `FALSE` on failure.
     */
    public function load($source, $options = null)
    {
        $fileName = Yii::getAlias($source);
        return parent::load($fileName, $options);
    }
}
