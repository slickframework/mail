<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Mime;

use Slick\Mail\Header\GenericHeader;
use Slick\Mail\Header\HeaderInterface;
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
     * Check if this message is a multi-part MIME message
     *
     * @return bool
     */
    public function isMultiPart()
    {
        return $this->parts->count() > 1;
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
     * Get message parts
     *
     * @return MimeParts|Part[]
     */
    public function parts()
    {
        return $this->parts;
    }

    /**
     * Access headers collection
     *
     * Lazy-loads if not already attached.
     *
     * @return HeaderInterface[]
     */
    public function getHeaders()
    {
        $this->generateHeaders();
        return $this->headers;
    }

    /**
     * Add the headers for MIME type message
     *
     * @return MimeMessage
     */
    protected function generateHeaders()
    {
        $this->headers['Mime-Version'] = New GenericHeader('MIME-Version', Mime::VERSION);
        $this->headers['Date'] = New GenericHeader('Date', date('r'));

        if ($this->isMultiPart()) {
            return $this->addMultiPartHeaders();
        }
        return $this->addMimeHeaders();
    }

    /**
     * Add headers for multipart MIME type message
     *
     * @return $this
     */
    protected function addMultiPartHeaders()
    {
        $boundary = $this->getMime()->boundary();
        $this->headers['Content-Type'] = new GenericHeader(
            'Content-Type',
            "multipart/mixed; boundary={$boundary}"
        );
        return $this;
    }

    /**
     * Add the headers for mime type message
     *
     * @return $this
     */
    protected function addMimeHeaders()
    {
        if (!$this->parts->isEmpty()) {
            $part = $this->parts[0];
            foreach ($part->getHeadersArray(HeaderInterface::EOL) as $header) {
                list($name, $value) = $header;
                $this->headers[$name] = new GenericHeader($name, $value);
            }
        }

        return $this;
    }

    /**
     * Get the string-serialized message body text
     *
     * @return string
     */
    public function getBodyText()
    {
        return ($this->isMultiPart())
            ? $this->generateMultiPartMime()
            : $this->generateMime();
    }

    /**
     * Generate single part MIME message
     * @return string
     */
    protected function generateMime()
    {
        if ($this->parts->isEmpty()) {
            return '';
        }

        /** @var Part $part */
        $part = $this->parts[0];
        return $part->getContent();
    }

    /**
     * Generate multi-part message content
     *
     * @return string
     */
    protected function generateMultiPartMime()
    {
        $eol = Mime::LINEEND;
        $boundaryLine = $this->getMime()->boundaryLine($eol);
        $body = 'This is a message in Mime Format.  If you see this, '
            . "your mail reader does not support this format." . $eol;

        foreach ($this->parts as $part) {
            $body .= $boundaryLine
                   . $part->getHeaders($eol)
                   . $eol
                   . $part->getContent($eol);
        }

        $body = $this->getMime()->mimeEnd($eol);
        return trim($body);
    }

}