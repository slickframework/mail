<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Tests\Transport;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Mail\Message;
use Slick\Mail\MessageBody;
use Slick\Mail\Transport\SmtpTransport;
use Zend\Mail\Transport\Smtp;

/**
 * SMTP Transport Test Case
 *
 * @package Slick\Mail\Tests\Transport
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class SmtpTransportTest extends TestCase
{

    /**
     * Should create an instance of Zend SmtpTransport if none is given
     * @test
     */
    public function getSmtpServer()
    {
        $smtpService = new SmtpTransport(['options' => ['host' => 'mail']]);
        $service = $smtpService->getSmtpServer();
        $this->assertInstanceOf(Smtp::class, $service);
    }

    /**
     * Should convert the message to a Zend-Mail message and send it
     * @test
     */
    public function sendMessage()
    {
        $message = $this->getMessage();
        $service = $this->getMockBuilder(Smtp::class)
            ->disableOriginalConstructor()
            ->setMethods(['send'])
            ->getMock();
        $service->expects($this->once())
            ->method('send')
            ->with($this->isInstanceOf(\Zend\Mail\Message::class))
            ->willReturn(true);
        $smtpService = new SmtpTransport(['options' => ['host' => 'mail']]);
        $smtpService->setSmtpServer($service);
        $smtpService->send($message);
    }

    /**
     * Creates a message to use
     *
     * @return \Slick\Mail\MessageInterface
     */
    protected function getMessage()
    {
        $message = (new Message())
            ->setFrom('john.doe@example.com', 'John Doe')
            ->addTo('jane.doe@example.com', 'Jane Doe')
            ->setSubject('Greetings!')
            ->setBody(new MessageBody('simple.mail.twig'));
        return $message;
    }
}
