<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Transport;

use Slick\Common\Base;
use Slick\Mail\Header\HeaderInterface;
use Slick\Mail\MessageInterface;
use Slick\Mail\Transport\Vendor\Php;

/**
 * PHP mail() transport
 *
 * @package Slick\Mail\Transport
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class PhpMailTransport extends Base implements MailTransportInterface
{

    /**
     * @var MessageInterface
     */
    protected $message;

    /**
     * @var Php
     */
    protected $mailVendor;

    /**
     * Send a e-mail message
     *
     * @param MessageInterface $message
     *
     * @return MailTransportInterface
     */
    public function send(MessageInterface $message)
    {
        $this->message = $message;
        $this->getMailVendor()
            ->mail(
                $message->getToAddressList(),
                $message->getSubject(),
                $message->getBodyText(),
                $this->getHeadersAsString()
            );
        return $this;
    }

    /**
     * Gets the Mail Vendor object
     *
     * @return Php
     */
    public function getMailVendor()
    {
        if (null == $this->mailVendor) {
            $this->setMailVendor(new Php());
        }
        return $this->mailVendor;
    }

    /**
     * Sets the Mail Vendor object
     *
     * @param Php $mailVendor
     *
     * @return PhpMailTransport|$this|self
     */
    public function setMailVendor(Php $mailVendor)
    {
        $this->mailVendor = $mailVendor;
        return $this;
    }

    /**
     * Get the headers for all
     *
     * @return string
     */
    public function getHeadersAsString()
    {
        $eol = HeaderInterface::EOL;
        $headers = '';
        $skipHeaders = ['To', 'Subject'];
        foreach ($this->message->getHeaders() as $header) {
            if (in_array($header->getName(), $skipHeaders)) {
                continue;
            }
            $headers .= "{$header}{$eol}";
        }
        $headers = trim($headers).$eol.'X-Mailer: PHP/' . phpversion();
        return $headers;
    }
}