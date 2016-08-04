<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Tests\Mime;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Mail\Mime;
use Slick\Mail\Mime\Part;

/**
 * MIME Part Test Case
 *
 * @package Slick\Mail\Tests\Mime
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class PartTest extends TestCase
{

    /**
     * Create the content based on provided template file name
     * @test
     */
    public function createFromTwigTemplate()
    {
        $part = new Part('simple.mail.twig');
        $expected = 'This is a simple e-mail message.';
        $this->assertEquals($expected, $part->getContent(''));
    }

    /**
     * Should call the source Zend Part object
     * @test
     */
    public function callSourcePartObject()
    {
        $part = new Part('simple.mail.twig');
        $part->setEncoding(Mime::ENCODING_7BIT);
        $this->assertEquals(Mime::ENCODING_7BIT, $part->getEncoding());
    }

    /**
     * Calling undefined methods raise an exception
     * @test
     */
    public function failToCallUndefinedExistingMethod()
    {
        $this->setExpectedException(\BadMethodCallException::class);
        $part = new Part('simple.mail.twig');
        $part->foo();
    }
}
