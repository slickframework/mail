<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail;

use Slick\Mail\Header\AddressList;
use Slick\Mail\Header\AddressListInterface;
use Slick\Mail\Header\GenericHeader;
use Slick\Mail\Header\HeaderInterface;

/**
 * Wraps an e-mail message
 *
 * @package Slick\Mail
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class Message implements MessageInterface
{

    /**
     * @var HeaderInterface[]
     */
    protected $headers;

    /**
     * @var string
     */
    protected $encoding = 'ASCII';

    /**
     * @var MessageBodyInterface
     */
    protected $body;

    /**
     * Is the message valid?
     *
     * If we don't have any From addresses, we're invalid, according
     * to RFC2822.
     *
     * @return bool
     */
    public function isValid()
    {
        /** @var AddressList $from */
        $from = $this->getHeader('From', new AddressList('From'));
        return !$from->isEmpty();
    }

    /**
     * Set the message encoding
     *
     * @param  string $encoding
     *
     * @return MessageInterface
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
        foreach ($this->getHeaders() as $header) {
            $header->setEncoding($encoding);
        }
        return $this;
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
        if (null == $this->headers) {
            $this->headers['Date'] = New GenericHeader('Date', date('r'));
        }
        return $this->headers;
    }

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
    public function addHeader($name, HeaderInterface $header)
    {
        $headers = $this->getHeaders();
        $headers[$name] = $header;
        $this->headers = $headers;
        return $this;
    }

    /**
     * Set (overwrite) From addresses
     *
     * @param  string $emailAddress
     * @param  string|null $name
     *
     * @return MessageInterface
     */
    public function setFrom($emailAddress, $name = null)
    {
        $from = (new AddressList('From'))
            ->add(new AddressList\Address($emailAddress, $name));
        $this->addHeader('From', $from);
        return $this;
    }

    /**
     * Access the address list of the From header.
     *
     * @return string
     */
    public function getFromAddressList()
    {
        /** @var AddressList $from */
        $from = $this->getHeader('From', new AddressList('From'));
        return trim(str_replace('From:', '', $from->toString()));
    }

    /**
     * Overwrite the address list in the To recipients
     *
     * @param  string $email
     * @param  string|null $name
     *
     * @return MessageInterface
     */
    public function setTo($email, $name = null)
    {
        $toHeader = (new AddressList('To'))
            ->add(new AddressList\Address($email, $name));
        $this->addHeader('To', $toHeader);
        return $this;
    }

    /**
     * Access the address list of the To header.
     *
     * @return string
     */
    public function getToAddressList()
    {
        /** @var AddressList $from */
        $from = $this->getHeader('To', new AddressList('To'));
        return trim(str_replace('To:', '', $from->toString()));
    }

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
    public function addTo($email, $name = null)
    {
        $address = new AddressList\Address($email, $name);
        /** @var AddressListInterface $toHeader */
        $toHeader = $this->getHeader('To', new AddressList('To'));
        $toHeader->add($address);
        $this->addHeader('To', $toHeader);
        return $this;
    }

    /**
     * Add a "Cc" address
     *
     * @param  string|array|\Traversable $emailOrList
     * @param  string|null $name
     *
     * @return MessageInterface
     */
    public function addCc($emailOrList, $name = null)
    {
        // TODO: Implement addCc() method.
    }

    /**
     * Add a "Bcc" address
     *
     * @param  string|array|\Traversable $emailOrList
     * @param  string|null $name
     *
     * @return MessageInterface
     */
    public function addBcc($emailOrList, $name = null)
    {
        // TODO: Implement addBcc() method.
    }

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
    public function addReplyTo($emailOrList, $name = null)
    {
        // TODO: Implement addReplyTo() method.
    }

    /**
     * Set the message subject header value
     *
     * @param  string $subject
     *
     * @return MessageInterface
     */
    public function setSubject($subject)
    {
        $subject = new GenericHeader('Subject', $subject);
        $this->addHeader('Subject', $subject);
        return $this;
    }

    /**
     * Get the message subject header value
     *
     * @return null|string
     */
    public function getSubject()
    {
        $subject = $this->getHeader('Subject');
        return $subject->getValue();
    }

    /**
     * Set the message body
     *
     * @param  MessageBodyInterface $body
     *
     * @return MessageInterface
     */
    public function setBody(MessageBodyInterface $body)
    {
        $body->setMailMessage($this);
        $this->body = $body;
        return $this;
    }

    /**
     * Get the string-serialized message body text
     *
     * @return string
     */
    public function getBodyText()
    {
        $text = '';
        if (null != $this->body) {
            $text = $this->body->getBodyText();
        }
        return $text;
    }

    /**
     * Gets the header with provided name.
     *
     * If no header was set with that name, the default value will be
     * assign to a new header and returned.
     *
     * @param string $name
     * @param mixed $default
     *
     * @return HeaderInterface
     */
    protected function getHeader($name, $default = '')
    {
        if (array_key_exists($name, $this->getHeaders())) {
            return $this->headers[$name];
        }

        $this->headers[$name] = $default;
        return $default;
    }
}