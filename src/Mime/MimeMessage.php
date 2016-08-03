<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Mime;

use Zend\Mime\Mime;

/**
 * Message
 *
 * @package Slick\Mail\Mime
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class MimeMessage extends \Slick\Mail\Message
{

    /**
     * @var Mime
     */
    protected $mime;

    /**
     * @var MimeParts|Part[]
     */
    protected $parts;

    /**
     * Mime Message
     */
    public function __construct()
    {
        $this->parts = new MimeParts();
    }

    /**
     * Gets the Mime
     *
     * @return Mime
     */
    public function getMime()
    {
        if (null == $this->mime) {
            $this->setMime(New Mime());
        }
        return $this->mime;
    }

    /**
     * Sets the Mime
     *
     * @param Mime $mime
     *
     * @return MimeMessage|$this|self
     */
    public function setMime(Mime $mime)
    {
        $this->mime = $mime;
        return $this;
    }

    /**
     * Get the string-serialized message body text
     *
     * @return string
     */
    public function getBodyText()
    {

    }

}