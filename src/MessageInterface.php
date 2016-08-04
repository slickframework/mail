<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail;

use Slick\Mail\Header\HeaderInterface;

/**
 * E-Mail Message Interface
 *
 * @package Slick\Mail
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface MessageInterface
{

    /**
     * Is the message valid?
     *
     * If we don't have any From addresses, we're invalid, according
     * to RFC2822.
     *
     * @return bool
     */
    public function isValid();

    /**
     * Access headers collection
     *
     * Lazy-loads if not already attached.
     *
     * @return HeaderInterface[]
     */
    public function getHeaders();

    /**
     * Adds an header with provided value
     *
     * If key already exists it will be overridden
     *
     * @param string $name
     * @param HeaderInterface $header
     *
     * @return MessageInterface
     */
    public function addHeader($name, HeaderInterface $header);

    /**
     * Set (overwrite) From addresses
     *
     * @param  string $emailAddress
     * @param  string|null $name
     *
     * @return MessageInterface
     */
    public function setFrom($emailAddress, $name = null);

    /**
     * Access the address list of the From header.
     *
     * @return string
     */
    public function getFromAddressList();

    /**
     * Overwrite the address list in the To recipients
     *
     * @param  string $email
     * @param  string|null $name
     *
     * @return MessageInterface
     */
    public function setTo($email, $name = null);

    /**
     * Access the address list of the To header.
     *
     * @return string
     */
    public function getToAddressList();

    /**
     * Add one or more addresses to the To recipients
     *
     * Appends to the list.
     *
     * @param  string $email
     * @param  null|string $name
     *
     * @return MessageInterface
     */
    public function addTo($email, $name = null);

    /**
     * Add a "Cc" address
     *
     * @param  string $email
     * @param  null|string $name
     *
     * @return MessageInterface
     */
    public function addCc($email, $name = null);

    /**
     * Add a "Bcc" address
     *
     * @param  string $email
     * @param  null|string $name
     *
     * @return MessageInterface
     */
    public function addBcc($email, $name = null);

    /**
     * Add one or more addresses to the Reply-To recipients
     *
     * Appends to the list.
     *
     * @param  string|array|\Traversable $emailOrList
     * @param  null|string $name
     *
     * @return MessageInterface
     */
    public function addReplyTo($emailOrList, $name = null);

    /**
     * Set the message subject header value
     *
     * @param  string $subject
     *
     * @return MessageInterface
     */
    public function setSubject($subject);

    /**
     * Get the message subject header value
     *
     * @return null|string
     */
    public function getSubject();

    /**
     * Set the message body
     *
     * @param  MessageBodyInterface $body
     *
     * @return MessageInterface
     */
    public function setBody(MessageBodyInterface $body);

    /**
     * Get the string-serialized message body text
     *
     * @return string
     */
    public function getBodyText();
}