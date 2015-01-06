<?php

/**
 * Mime Part test case
 *
 * @package   Test\Slick\Mail\Mime
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Mail\Mime;

use Codeception\TestCase\Test;
use Slick\Mail\Mime\Part;
use Slick\Template\Template;

/**
 * Mime Part test case
 *
 * @package   Test\Slick\Mail\Mime
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @package Mail\Mime
 */
class PartTest extends Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * Create a mime part with no content
     * @test
     */
    public function createAPartWithNoContent()
    {
        $this->tester->am('Developer');
        $this->tester->amGoingTo('create a mime part with no content');
        $part = new Part();
        try {
            $part->getContent();
            $this->fail('This should throw an InvalidArgumentException here.');
        } catch (\Exception $e) {
            $this->assertInstanceOf('\InvalidArgumentException', $e);
            $this->tester->expectTo(
                'Have an exception thrown: parts cannot be created without ' .
                'a content.'
            );
        }
    }

    /**
     * Retrieve the template processed content from a mime part
     * @test
     */
    public function retrieveTemplateProcessedFromPart()
    {
        $this->tester->am('Developer');
        $this->tester->amGoingTo('create a mime part with a Slick template');
        $this->tester->lookForwardTo(
            'separate the presentation logic from e-mail sending process.'
        );

        $part = new Part();
        $return = $part->setTemplate('template.twig');
        $this->assertTrue($return instanceof Part);
        $this->assertEquals('twig', $part->getEngineType());
        $this->assertEquals('template.twig', $part->template);
        Template::addPath(dirname(__FILE__));
        $this->assertInstanceOf(
            '\Slick\Template\Engine\Twig',
            $part->getEngine()
        );
        $data = ['one' => 1, 'variable' => 'Hello world'];

        $return = $part->setData($data);
        $this->assertTrue($return instanceof Part);

        /** @var Part $body */
        $body = $part->getContent();
        $return = $part->processTemplate();
        $this->assertTrue($return instanceof Part);
        $this->assertEquals($data['variable'], $body);

        $this->tester->expectTo(
            'have a content raw as the result of the template processing.'
        );
    }
}