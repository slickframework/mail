<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{

    /**
     * @var \Slick\Mail\Message
     */
    protected $message;

    /**
     * @var \Slick\Mail\Transport\PhpMailTransport
     */
    protected $transportAgent;

    /**
     * @var bool
     */
    protected $sendResult = false;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->message = new \Slick\Mail\Message();
        $path = dirname(__DIR__).'/templates';
        $paths = \Slick\Template\Template::getPaths();
        if (!in_array($path, $paths)) {
            \Slick\Template\Template::addPath($path);
        }
        $this->transportAgent = new \Slick\Mail\Transport\PhpMailTransport();
    }

    /**
     * @Given /^I create a message from "([^"]*)" to "([^"]*)"$/
     *
     * @param string $from
     * @param string $to
     *
     */
    public function iCreateAMessageFromTo($from, $to)
    {
        $this->message->setFrom($from)
            ->addTo($to);
    }

    /**
     * @Given /^I set the message subject "([^"]*)"$/
     *
     * @param string $subject
     */
    public function iSetTheMessageSubject($subject)
    {
        $this->message->setSubject($subject);
    }

    /**
     * @Given /^I set the message body:$/
     *
     * @param PyStringNode $body
     */
    public function iSetTheMessageBody(PyStringNode $body)
    {
        $data = ['message' => $body->getRaw()];
        $bodyMessage = new \Slick\Mail\MessageBody('greetings.twig', $data);
        $this->message->setBody($bodyMessage);
    }

    /**
     * @When /^I send the message$/
     */
    public function iSendTheMessage()
    {
        $this->transportAgent->send($this->message);
    }

    /**
     * @Then /^the receptor should receive the message$/
     */
    public function theReceptorShouldReceiveTheMessage()
    {
        throw new \Behat\Behat\Tester\Exception\PendingException();
    }
}
