<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail;

/**
 * E-Mail Message Body Interface
 *
 * @package Slick\Mail
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface MessageBodyInterface
{

    /**
     * Attaches the E-Mail massage that will carry this body
     *
     * @param MessageInterface $message
     *
     * @return MessageBodyInterface
     */
    public function setMailMessage(MessageInterface $message);

    /**
     * Get the string-serialized message body text
     *
     * @return string
     */
    public function getBodyText();

    /**
     * Gets message length
     *
     * @return int
     */
    public function getLength();

    /**
     * Returns the string representation of this message body
     *
     * @return mixed
     */
    public function __toString();
}