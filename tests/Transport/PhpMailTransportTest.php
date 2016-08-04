<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Tests\Transport;

use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;
use Slick\Mail\Header\HeaderInterface;
use Slick\Mail\Message;
use Slick\Mail\MessageBody;
use Slick\Mail\Transport\PhpMailTransport;
use Slick\Mail\Transport\Vendor\Php;

/**
 * PHP Mail Transport Test Case
 *
 * @package Slick\Mail\Tests\Transport
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class PhpMailTransportTest extends TestCase
{

    /**
     * Should create a new PHP mail wrapper object if none is given
     * @test
     */
    public function getPhpMailWrapService()
    {
        $transport = new PhpMailTransport();
        $wrapper = $transport->getMailVendor();
        $this->assertInstanceOf(Php::class, $wrapper);
    }

    /**
     * Send out the message using the mail function
     * @test
     */
    public function senEmailMessage()
    {
        $message = $this->getMessage();
        $wrapper = $this->getMailWrapperMocked($message);
        $transport = new PhpMailTransport();
        $transport->setMailVendor($wrapper);
        $transport->send($message);
    }

    /**
     * @param Message $message
     *
     * @return MockObject|Php
     */
    protected function getMailWrapperMocked(Message $message)
    {
        /** @var Php|MockObject $wrapper */
        $wrapper = $this->getMockBuilder(Php::class)
            ->setMethods(['mail'])
            ->getMock();
        $wrapper->expects($this->once())
            ->method('mail')
            ->with(
                $message->getToAddressList(),
                $message->getSubject(),
                $message->getBodyText(),
                $this->headersSent($message)
            )
            ->willReturn(true);
        return $wrapper;
    }

    protected function getMessage()
    {
        $message = (new Message())
            ->setFrom('john.doe@example.com', 'John Doe')
            ->addTo('jane.doe@example.com', 'Jane Doe')
            ->setSubject('Greetings!')
            ->setBody(new MessageBody('simple.mail.twig'));
        return $message;
    }

    protected function headersSent(Message $message)
    {
        $headers = $message->getHeaders();
        $result = (string) $headers['Date'].HeaderInterface::EOL;
        $from = $message->getFromAddressList();
        $result .= "From: {$from}".HeaderInterface::EOL;
        $result .= "Sender: {$from}".HeaderInterface::EOL;
        $result .= 'X-Mailer: PHP/' . phpversion();
        return $result;
    }
}
