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
     * @var \Slick\Mail\Message|\Slick\Mail\Mime\MimeMessage
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
     * @var string
     */
    protected $ccRecipient;

    /**
     * @var string
     */
    protected $bccRecipient;

    /**
     * @var \Slick\Mail\Transport\SmtpTransport
     */
    protected $smtpTransport;

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
        $this->smtpTransport = new \Slick\Mail\Transport\SmtpTransport(
            [
                'options' => [
                    'name'              => 'mail',
                    'host'              => 'mail'
                ]
            ]
        );
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

    /**
     * @param string $address
     *
     * @Given /^I set the message CC "([^"]*)"$/
     */
    public function iSetTheMessageCC($address)
    {
        $this->message->addCc($address);
        $this->ccRecipient = $address;
    }

    /**
     * @param string $address
     *
     * @Given /^I set the message BCC "([^"]*)"$/
     */
    public function iSetTheMessageBCC($address)
    {
        $this->message->addBcc($address);
        $this->bccRecipient = $address;
    }

    /**
     * @Given /^the CC receptor should receive the message$/
     */
    public function theCCReceptorShouldReceiveTheMessage()
    {
        $found = false;
        foreach ($this->mailCatcher->getAllMessages() as $message) {
            if (in_array("<{$this->ccRecipient}>", $message->recipients)) {
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

    /**
     * @Given /^the BCC receptor should receive the message$/
     */
    public function theBCCReceptorShouldReceiveTheMessage()
    {
        $found = false;
        foreach ($this->mailCatcher->getAllMessages() as $message) {
            if (in_array("<{$this->bccRecipient}>", $message->recipients)) {
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

    /**
     * @param string $from
     * @param string $to
     *
     * @Given /^I set message from "([^"]*)" to "([^"]*)"$/
     */
    public function setMessageFromTo($from, $to)
    {
        $this->iCreateAMessageFromTo($from, $to);
    }

    /**
     * @Given /^I add a mime part with type "([^"]*)":$/
     */
    public function iAddAMimePartWithType($type, PyStringNode $string)
    {
        $part = new \Slick\Mail\Mime\Part('greetings.twig', ['message' => $string->getRaw()]);
        $part->setType($type);
        $this->message->parts()->add($part);
    }

    /**
     * @Given /^I create a MIME message$/
     */
    public function iCreateAMIMEMessage()
    {
        $this->message = new \Slick\Mail\Mime\MimeMessage();
    }

    /**
     * @param string $fileName
     * @Given /^I set file "([^"]*)" to be attached$/
     */
    public function iSetFileToBeAttached($fileName)
    {
        $path = dirname(__DIR__);
        $part = new \Slick\Mail\Mime\Part("{$path}/{$fileName}");
        $part->setEncoding(\Slick\Mail\Mime::ENCODING_BASE64);
        $part->setType('application/pdf');
        $part->setDisposition('attachment; filename=example.pdf');
        $this->message->parts()->add($part);
    }

    /**
     * @When /^I send the message with SMPT$/
     */
    public function iSendTheMessageWithSMPT()
    {
        $this->smtpTransport->send($this->message);
    }
}
