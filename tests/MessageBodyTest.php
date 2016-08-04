<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Tests;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Mail\MessageBody;
use Slick\Template\Template;

/**
 * Message Body Test Case
 *
 * @package Slick\Mail\Tests
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class MessageBodyTest extends TestCase
{

    /**
     * @var MessageBody
     */
    protected $message;

    /**
     * Set the SUT body message object
     */
    protected function setUp()
    {
        parent::setUp();
        $this->message = new MessageBody('simple.mail.twig');
    }

    /**
     * Should count the content length
     * @test
     */
    public function getContentLength()
    {
        $this->assertEquals(32, $this->message->getLength());
    }
}
