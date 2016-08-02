<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Tests;

use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;
use Slick\Mail\Header\AddressListInterface;
use Slick\Mail\Header\HeaderInterface;
use Slick\Mail\Message;
use Slick\Mail\MessageBody;
use Slick\Mail\MessageInterface;

/**
 * E-Mail Message Test case
 *
 * @package Slick\Mail\Tests
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class MessageTest extends TestCase
{

    /**
     * A message created without sender is invalid
     * @test
     * @return Message
     */
    public function invalidMessage()
    {
        $message = new Message();
        $this->assertFalse($message->isValid());
        return $message;
    }

    /**
     * A message has always a header with date that was created
     *
     * @param Message $message
     *
     * @depends invalidMessage
     * @test
     */
    public function dateHeader(Message $message)
    {
        $headers = $message->getHeaders();
        $this->assertTrue(array_key_exists('Date', $headers));
    }

    /**
     * Sets correctly the sender address
     *
     * @test
     * @return Message
     */
    public function addFromAddress()
    {
        $message = new Message();
        $message->setFrom('john.doe@example.com', 'John Doe');
        $this->assertEquals(
            'John Doe <john.doe@example.com>',
            $message->getFromAddressList()
        );
        return $message;
    }

    /**
     * The From list is an address list
     *
     * @param Message $message
     *
     * @test
     * @depends addFromAddress
     */
    public function fromIsAnAddressList(Message $message)
    {
        $from = $message->getHeaders()['From'];
        $this->assertInstanceOf(AddressListInterface::class, $from);
    }

    /**
     * Use the addTo() method to add multiple addresses
     *
     * @param Message $message
     *
     * @test
     * @depends addFromAddress
     * @return Message
     */
    public function addToAddressList(Message $message)
    {
        $message->addTo('jane.doe@example.com', 'Jane Doe')
            ->addTo('joane.smith@test.com');
        $this->assertEquals(
            'Jane Doe <jane.doe@example.com>,joane.smith@test.com',
            $message->getToAddressList()
        );
        return $message;
    }

    /**
     * Should override the message To header
     *
     * @param Message $message
     *
     * @test
     * @depends addToAddressList
     *
     * @return Message
     */
    public function setToAddressList(Message $message)
    {
        $message->setTo('jane.doe@example.com', 'Jane Doe')
            ->addTo('elvin@example.com');
        $this->assertEquals(
            'Jane Doe <jane.doe@example.com>,elvin@example.com',
            $message->getToAddressList()
        );
        return $message;
    }

    /**
     * Set the subject header
     *
     * @param Message $message
     *
     * @test
     * @depends setToAddressList
     *
     * @return Message
     */
    public function setSubjectHeader(Message $message)
    {
        $message->setSubject('Hello Friends!');
        $this->assertEquals('Hello Friends!', $message->getSubject());
        return $message;
    }

    /**
     * The subject is an header
     *
     * @param Message $message
     *
     * @test
     * @depends setSubjectHeader
     */
    public function subjectIsAnHeader(Message $message)
    {
        $subject = $message->getHeaders()['Subject'];
        $this->assertInstanceOf(HeaderInterface::class, $subject);
    }

    /**
     * Set the body message
     *
     * @param Message $message
     *
     * @test
     * @depends setSubjectHeader
     */
    public function setBody(Message $message)
    {
        $body = new MessageBody('simple.mail.twig');
        $message->setBody($body);
        $this->assertEquals(
            'This is a simple e-mail message.',
            $message->getBodyText()
        );
    }

    /**
     * When adding a body the setMessage() method should be called
     * with the message as argument.
     *
     * @param Message $message
     *
     * @test
     * @depends setSubjectHeader
     */
    public function settingBodyNeedsToSetMessage(Message $message)
    {
        /** @var MessageBody|MockObject $body */
        $body = $this->getMockBuilder(MessageBody::class)
            ->setConstructorArgs(['simple.mail.twig'])
            ->setMethods(['setMailMessage'])
            ->getMock();
        $body->expects($this->once())
            ->method('setMailMessage')
            ->with($this->isInstanceOf(MessageInterface::class))
            ->willReturn($body);
        $message->setBody($body);
    }
}
