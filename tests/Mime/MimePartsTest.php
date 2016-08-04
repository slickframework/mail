<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Tests\Mime;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Mail\Mime\MimeParts;
use Slick\Mail\Mime\Part;

/**
 * MIME Parts Test Case
 *
 * @package Slick\Mail\Tests\Mime
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class MimePartsTest extends TestCase
{

    /**
     * Add a part should add it to data and return a self instance
     * @test
     */
    public function addPart()
    {
        $part = new Part('simple.mail.twig');
        $parts = new MimeParts();
        $result = $parts->add($part);
        $this->assertFalse($parts->isEmpty());
        $this->assertSame($parts, $result);
    }

}
