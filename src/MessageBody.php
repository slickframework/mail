<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail;

use Slick\Template\TemplateEngineInterface;

/**
 * Simple text e-mail message body
 *
 * @package Slick\Mail
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class MessageBody implements MessageBodyInterface
{
    /**
     * @var MessageInterface
     */
    protected $message;

    /**
     * @var string
     */
    protected $template;

    /**
     * @var array
     */
    protected $data;

    /**
     * To load content from twig templates
     */
    use ContentFromTemplateMethods;

    /**
     * @var string
     */
    protected $bodyText;

    /**
     * @var int
     */
    protected $length;

    /**
     * @var TemplateEngineInterface
     */
    protected $templateEngine;

    /**
     * Creates an e-mail message body content
     *
     * @param string $template
     * @param array  $data
     */
    public function __construct($template, $data = [])
    {
        $this->template = $template;
        $this->data = $data;
    }

    /**
     * Attaches the E-Mail massage that will carry this body
     *
     * @param MessageInterface $message
     *
     * @return MessageBodyInterface
     */
    public function setMailMessage(MessageInterface $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Get the string-serialized message body text
     *
     * @return string
     */
    public function getBodyText()
    {
        if (null == $this->bodyText) {
            $text = $this->getTemplateEngine()
                ->parse($this->template)
                ->process($this->data);
            $this->bodyText = trim($text);
        }
        return $this->bodyText;
    }

    /**
     * Returns the string representation of this message body
     *
     * @return mixed
     */
    public function __toString()
    {
        return $this->getBodyText();
    }

    /**
     * Gets message length
     *
     * @return int
     */
    public function getLength()
    {
        if (null == $this->length) {
            $this->length = strlen($this);
        }
        return $this->length;
    }
}