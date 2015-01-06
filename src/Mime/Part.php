<?php

/**
 * E-Mail MIME part
 *
 * @package   Slick\Mail\Mime
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Slick\Mail\Mime;

use Zend\Mime\Mime;
use Slick\Mail\TemplateMethods;
use Zend\Mime\Part as ZendMailMimePart;

/**
 * E-Mail MIME part
 *
 * @package   Slick\Mail\Mime
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 *
 * For a complete reference please check the Zend\Mail reference site
 * @see http://framework.zend.com/manual/current/en/modules/zend.mail.message.html
 */
class Part extends ZendMailMimePart
{

    /**
     * Load template methods
     */
    use TemplateMethods;

    /**
     * create a new Mime Part.
     * The (unencoded) content of the Part as passed
     * as a string or stream
     *
     * @param mixed $content  String or Stream containing the content
     */
    public function __construct($content = null)
    {
        parent::__construct($content);
    }


    /**
     * Processes the template and assigns the result to the message body
     *
     * @return self
     */
    public function processTemplate()
    {
        $this->content = $this->getEngine()
            ->parse($this->template)
            ->process($this->data);
        return $this;
    }

    /**
     * Get the Content of the current Mime Part in the given encoding.
     *
     * @param string $EOL
     * @return string
     */
    public function getContent($EOL = Mime::LINEEND)
    {
        if (is_null($this->content) && is_null($this->template)) {
            throw new \InvalidArgumentException(
                "Trying to retrieve the part content but it is null. " .
                "Specify the content on constructor or add a template."
            );
        }

        if (is_null($this->content) && !is_null($this->template)) {
            $this->processTemplate();
        }

        return parent::getContent($EOL);
    }
}