<?php

/**
 * Message template test case
 *
 * @package   Test\Slick\Mail
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Mail;

use UnitTester;
use Slick\Mail\Message;
use Slick\Template\Template;
use Codeception\TestCase\Test;

/**
 * Message template test case
 *
 * @package   Test\Slick\Mail
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class MessageTemplateTest extends Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * Add a template to a message
     * @test
     */
    public function addATemplateToAMessage()
    {
        $this->tester->am('Developer using Slick');
        $this->tester->amGoingTo(
            'create an e-mail message with Slick Template'
        );
        $this->tester->lookForwardTo(
            'can separate the sending e-mail logic from its presentation.'
        );

        $message = new Message();
        $return = $message->setTemplate('template.twig');
        $this->assertTrue($return instanceof Message);
        $this->assertEquals('twig', $message->getEngineType());
        $this->assertEquals('template.twig', $message->template);
        Template::addPath(dirname(__FILE__));
        $this->assertInstanceOf(
            '\Slick\Template\Engine\Twig',
            $message->getEngine()
        );
        $data = ['one' => 1, 'variable' => 'Hello world'];

        $return = $message->setData($data);
        $this->assertTrue($return instanceof Message);
        $this->assertEquals($data, $message->data);
        $this->tester->comment(
            "Verifying the template information (getters, setters and " .
            "default values)"
        );


        $body = (string) $message->getBody();
        $return = $message->processTemplate();
        $this->assertTrue($return instanceof Message);
        $this->assertEquals($data['variable'], $body);
        $this->tester->expectTo(
            'have a message body with the result of the template processing.'
        );
    }

}