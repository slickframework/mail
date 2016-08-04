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
use Zend\Mail\Message as ZendMessage;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;

/**
 * SMTP Transport
 *
 * @package Slick\Mail\Transport
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class SmtpTransport extends Base implements MailTransportInterface
{

    /**
     * @var Smtp
     */
    protected $smtpServer;

    /**
     * @readwrite
     * @var array
     */
    protected $options;

    /**
     * Gets the Zend SMTP service
     *
     * @return Smtp
     */
    public function getSmtpServer()
    {
        if (null == $this->smtpServer) {
            $smtpServer = new Smtp();
            $settings = new SmtpOptions($this->options);
            $smtpServer->setOptions($settings);
            $this->setSmtpServer($smtpServer);
        }
        return $this->smtpServer;
    }

    /**
     * Sets the Zend SMTP service
     *
     * @param Smtp $smtpServer
     *
     * @return SmtpTransport|$this|self
     */
    public function setSmtpServer(Smtp $smtpServer)
    {
        $this->smtpServer = $smtpServer;
        return $this;
    }

    /**
     * Send a e-mail message
     *
     * @param MessageInterface $message
     *
     * @return MailTransportInterface
     */
    public function send(MessageInterface $message)
    {
        $message = $this->convert($message);
        $this->getSmtpServer()->send($message);
    }

    /**
     * @param MessageInterface $message
     *
     * @return ZendMessage
     */
    protected function convert(MessageInterface $message)
    {
        $text = '';
        foreach ($message->getHeaders() as $header) {
            $text .= "{$header}".HeaderInterface::EOL;
        }
        $text .= 'X-Mailer: Zend-SMPT-Transport; PHP/' .
            phpversion() .
            HeaderInterface::EOL;
        $text .= HeaderInterface::EOL.$message->getBodyText();
        return ZendMessage::fromString($text);
    }
}