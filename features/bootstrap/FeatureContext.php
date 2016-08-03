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
     * @var MailCatcherClient
     */
    protected $mailCatcher;

    /**
     * @var string
     */
    protected $toRecipient;

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
        $this->mailCatcher = new MailCatcherClient();
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
        $this->toRecipient = $to;
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
        $found = false;
        foreach ($this->mailCatcher->getAllMessages() as $message) {
            if (in_array("<{$this->toRecipient}>", $message->recipients)) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            throw new RuntimeException(
                "Receptor does not receive the e-mail message."
            );
        }
    }

}
