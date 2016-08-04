<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Tests\Mime;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Mail\Mime\MimeMessage;
use Slick\Mail\Mime\Part;
use Zend\Mime\Mime;

/**
 * MIME Message Test Case
 *
 * @package Slick\Mail\Tests\Mime
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class MimeMessageTest extends TestCase
{
    /**
     * A simple mime message is one that have at most one part
     * @test
     */
    public function simpleMime()
    {
        $message = new MimeMessage();
        $part = new Part('simple.mail.twig');
        $part->setType('text/plain');
        $message->parts()->add($part);
        $this->assertFalse($message->isMultiPart());
        return $message;
    }

    /**
     * Should lazy load the Zend MIME is not set when requested
     * @test
     */
    public function lazyLoadsZendMime()
    {
        $message = new MimeMessage();
        $this->assertInstanceOf(Mime::class, $message->getMime());
    }

    /**
     * Should create the necessary headers for mime massage
     *
     * @param MimeMessage $message
     * @test
     * @depends simpleMime
     */
    public function checkMimeHeaders(MimeMessage $message)
    {
        $headers = $message->getHeaders();
        $this->assertTrue(array_key_exists('MIME-Version', $headers));
        $this->assertEquals(
            'Content-Type: text/plain',
            (string) $headers['Content-Type']
        );
    }

    /**
     * Should generate the template
     *
     * @param MimeMessage $message
     * @test
     * @depends simpleMime
     */
    public function getBodySimpleMime(MimeMessage $message)
    {
        $expected = "This is a simple e-mail message.";
        $this->assertEquals($expected, $message->getBodyText());
    }

    /**
     * Should generate the proper multipart headers
     * @param MimeMessage $message
     * @test
     * @depends simpleMime
     * @return MimeMessage
     */
    public function getMultiPartHeaders(MimeMessage $message)
    {
        $part = new Part('simple.mail.twig');
        $part->setType('text/html');
        $message->parts()->add($part);
        $headers = $message->getHeaders();
        $this->assertEquals(
            'Content-Type: multipart/mixed; boundary='.
                $message->getMime()->boundary(),
            (string) $headers['Content-Type']
        );
        return $message;
    }

    /**
     * @param MimeMessage $message
     * @test
     * @depends getMultiPartHeaders
     */
    public function getBodyMultiPart(MimeMessage $message)
    {
        $b = $message->getMime()->boundaryLine("\n");
        $t = 'This is a simple e-mail message.';
        $expected = "This is a message in Mime Format.  If you see this, your mail reader does\n"
                  . "not support this format.\n{$b}"
                  . "Content-Type: text/plain\n"
                  . "Content-Transfer-Encoding: 8bit\n"
                  . "\n{$t}{$b}"
                  . "Content-Type: text/html\n"
                  . "Content-Transfer-Encoding: 8bit\n\n{$t}\n--"
                  . $message->getMime()->boundary().'--';
        $this->assertEquals($expected, trim($message->getBodyText()));
    }

    public function testEmptyMessage()
    {
        $message = new MimeMessage();
        $this->assertEquals('', $message->getBodyText());
    }
}
