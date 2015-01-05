<?php

/**
 * Email test case test
 *
 * @package   Test\Slick\Mail\Test
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Mail\Test;

use Slick\Mail\Test\EmailTestCase;

/**
 * Email test case test
 *
 * @package   Test\Slick\Mail\Test
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class EmailTest extends EmailTestCase
{
    /**
     * @var \FunctionalTester
     */
    protected $tester;

    /**
     * @var EmailTestCase
     */
    protected $testCase;

    /**
     * Create a badly configured test case
     * @test
     */
    public function skipInvalidEmailTestCase()
    {
        $this->tester->am('Developer');
        $this->tester->amGoingTo('create an e-mail test case with no MailCatcher daemon running');
        $this->tester->expectTo('receive a skipped test message.');
        $this->setServerAddress('http://192.168.1.12:1088');
        try {
            $this->checkMailCatcher();
            $this->fail("This should raise an exception here.");
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof \PHPUnit_Framework_SkippedTestError);
            $this->tester->comment('The test was correctly skipped');
        }
    }

    /**
     * Retrieve e-mail message on empty mail box fail test.
     *
     * @test
     */
    public function retrieveMessagesOnEmptyMailBox()
    {
        $this->tester->am('Developer');
        $this->tester->amGoingTo('create a test with email test case');
        $this->tester->lookForwardTo('verify my class is sending emails.');
        $this->tester->comment("The test fail and no e-mail is sent.");
        $this->tester->expectTo("get a fail test.");

        $this->setServerAddress('http://127.0.0.1:1080');
        try {
            $this->getLastMessage();
            $this->fail("This should raise an exception here.");
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof \PHPUnit_Framework_AssertionFailedError);
            $this->tester->comment('The test fails as expected.');
        }
    }
}