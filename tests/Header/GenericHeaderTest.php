<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Tests\Header;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Mail\Header\GenericHeader;

/**
 * Generic Header Test Case
 *
 * @package Slick\Mail\Tests\Header
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class GenericHeaderTest extends TestCase
{

    /**
     * @var GenericHeader
     */
    protected $header;

    /**
     * @var string
     */
    protected $name = 'foo';

    /**
     * @var string
     */
    protected $value = 'bar';

    /**
     * Sets the SUT header object
     */
    protected function setUp()
    {
        parent::setUp();
        $this->header = new GenericHeader($this->name, $this->value);
    }

    /**
     * Should output a well formatted message header
     * @test
     */
    public function headerOutput()
    {
        $expected = "foo: bar";
        $this->assertEquals($expected, (string) $this->header);
    }
}
