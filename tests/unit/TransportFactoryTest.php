<?php

/**
 * Transport factory test case
 *
 * @package   Test\Slick\Mail\TransportFactory
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

use Codeception\TestCase\Test;
use Slick\Mail\TransportFactory;

/**
 * Transport factory test case
 *
 * @package   Test\Slick\Mail\TransportFactory
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class TransportFactoryTest extends Test
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * Create a mail transport
     * @test
     */
    public function createMailTransport()
    {
        $this->tester->am('Developer');
        $this->tester->amGoingTo('create a SMTP mail transport object using TransportFactory');
        $this->tester->lookForwardTo('can send e-mail messages through an SMTP server');


        $factory = new TransportFactory([
            'class' => 'Smtp',
            'options' => [
                'name' => 'localhost.localdomain',
                'host' => '127.0.0.1',
                'port' => 1025,
            ]
        ]);
        $transport = $factory->getTransport();
        $this->assertInstanceOf('\Zend\Mail\Transport\Smtp', $transport);
        $this->tester->expectTo('have a Zend\Mail SMTP object instance.');
    }

    /**
     * Create an invalid transport alias name.
     *
     * @expectedException InvalidArgumentException
     * @test
     */
    public function createAnInvalidTransportObject()
    {
        $this->tester->am('Developer');
        $this->tester->amGoingTo('try to create an MyFooTransport (invalid) transporter object');
        $this->tester->expect('that an exception is thrown');

        $factory = new TransportFactory([
            'class' => 'MyFooTransport'
        ]);
        $factory->getTransport();
        $this->tester->fail("The factory should throw an exception here.");
    }

}

/**
 * Test class
 * Class MyFooTransport
 */
class MyFooTransport
{

}