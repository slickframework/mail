<?php

/**
 * E-Mail test case class
 *
 * @package   Slick\Mail\Test
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Slick\Mail\Test;

use Guzzle\Http\Client;
use Codeception\TestCase\Test;
use Guzzle\Http\Exception\RequestException;

/**
 * E-Mail test case class
 *
 * @package   Slick\Mail\Test
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 *
 * This test case was based on the  Michael Bodnarchuk's example code for
 * tests with PHP e-mail sending.
 * @see http://codeception.com/12-15-2013/testing-emails-in-php.html
 * @see https://gist.github.com/DavertMik/7969053
 *
 * YPlease make sure that MailCatcher is installed and running.
 * @see http://mailcatcher.me/
 */
class EmailTestCase extends Test
{

    /**
     * @var \Guzzle\Http\Client
     */
    private $_mailCatcher;

    /**
     * @var string
     */
    protected $serverAddress = 'http://127.0.0.1:1080';

    /**
     * Open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        parent::setUp();
        $this->_mailCatcher = new Client($this->serverAddress);
        $this->checkMailCatcher();
    }

    /**
     * Check if MailCatcher is installed and responding on server address provided
     * Mark this test as skipped if it not correctly configured
     */
    public function checkMailCatcher()
    {
        try {
            $this->cleanMessages();
        } catch (RequestException $exp) {
            $this->markTestSkipped(
                'Cannot connect to the CatchMail server. Please check ' .
                'your configuration or installation. Current configuration ' .
                'is: '.$this->serverAddress
            );
        }
    }

    /**
     * Sets MailCatcher server address
     *
     * @param string $address
     * @return self
     */
    public function setServerAddress($address)
    {
        $this->serverAddress = $address;
        $this->_mailCatcher = new Client($address);
        return $this;
    }

    // api calls

    /**
     * Clears all messages int the server inbox
     */
    public function cleanMessages()
    {
        $this->_mailCatcher->delete('/messages')->send();
    }

    /**
     * Returns the last message sent
     *
     * @return object
     */
    public function getLastMessage()
    {
        $messages = $this->getMessages();
        if (empty($messages))
            $this->fail("No messages received");
        // messages are in descending order
        return reset($messages);
    }

    /**
     * Returns all messages in the inbox
     *
     * @return object[]
     */
    public function getMessages()
    {
        $jsonResponse = $this->_mailCatcher->get('/messages')->send();
        return json_decode($jsonResponse->getBody());
    }

    // assertions
    /**
     * Check if an e-mail was sent
     *
     * @param string $description
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function assertEmailIsSent($description = '')
    {
        $this->assertNotEmpty($this->getMessages(), $description);
    }

    /**
     * Check if email subject contains the provided needle
     *
     * @param string $needle
     * @param object $email
     * @param string $description
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function assertEmailSubjectContains($needle, $email, $description = '')
    {
        $this->assertContains($needle, $email->subject, $description);
    }

    /**
     * Check if email subject is equal to the provided expectation
     *
     * @param string $expected
     * @param object $email
     * @param string $description
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function assertEmailSubjectEquals($expected, $email, $description = '')
    {
        $this->assertEquals($expected, $email->subject, $description);
    }

    /**
     * Asserts that the HTML body part of the e-mail contains the provided needle
     *
     * @param string $needle
     * @param object $email
     * @param string $description
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function assertEmailHtmlContains($needle, $email, $description = '')
    {
        $response = $this->_mailCatcher->get("/messages/{$email->id}.html")->send();
        $this->assertContains($needle, (string)$response->getBody(), $description);
    }

    /**
     * Asserts that the text body part of the e-mail contains the provided needle
     *
     * @param string $needle
     * @param object $email
     * @param string $description
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function assertEmailTextContains($needle, $email, $description = '')
    {
        $response = $this->_mailCatcher->get("/messages/{$email->id}.plain")->send();
        $this->assertContains($needle, (string)$response->getBody(), $description);
    }

    /**
     * Asserts that e-mail sender is equal to the expectation
     *
     * @param string $expected
     * @param object $email
     * @param string $description
     */
    public function assertEmailSenderEquals($expected, $email, $description = '')
    {
        $response = $this->_mailCatcher->get("/messages/{$email->id}.json")->send();
        $email = json_decode($response->getBody());
        $this->assertEquals($expected, $email->sender, $description);
    }

    /**
     * Check that e-mail recipients contains the provided needle
     *
     * @param string $needle
     * @param object $email
     * @param string $description
     */
    public function assertEmailRecipientsContain($needle, $email, $description = '')
    {
        $response = $this->_mailCatcher->get("/messages/{$email->id}.json")->send();
        $email = json_decode($response->getBody());
        $this->assertContains($needle, $email->recipients, $description);
    }
}