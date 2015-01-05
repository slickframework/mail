<?php

/**
 * Send email functional test
 *
 * @package   Test\Slick\Mail\SendMail
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Mail;

use Slick\Mail\Message;
use Zend\Mail\Transport\Smtp;
use Zend\Mime\Mime;
use Zend\Mime\Part as MimePart;
use Slick\Mail\TransportFactory;
use Slick\Mail\Test\EmailTestCase;
use Zend\Mime\Message as MimeMessage;

/**
 * Send email functional test
 *
 * @package   Test\Slick\Mail\SendMail
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class SendEmailTest extends EmailTestCase
{
    /**
     * @var \FunctionalTester
     */
    protected $tester;

    /**
     * @var Smtp
     */
    protected $transporter;

    /**
     * Create the transport object
     */
    protected function _before()
    {
        parent::_before();
        $factory = new TransportFactory([
            'class' => 'Smtp',
            'options' => [
                'host' => '127.0.0.1',
                'port' => 1025,
            ]

        ]);
        $this->transporter = $factory->getTransport();
    }

    /**
     * Unset the transporter object
     */
    protected function _after()
    {
        $this->transporter = null;
        parent::_after();
    }

    // tests
    /**
     * Send simple message
     * @test
     */
    public function sendSimpleMessage()
    {
        $this->tester->am('Developer');
        $this->tester->amGoingTo('send a simple e-mail message to an SMTP server');
        $this->tester->lookForwardTo('use the email to send log messages by e-mail.');
        $message = new Message();
        $message->addFrom('some@from.address', 'Slick Framework')
            ->addTo('silvam.filipe@gmail.com', 'Filipe Silva')
            ->setBody('Log message test')
            ->setSubject('Log message');

        $this->transporter->send($message);
        $this->tester->expectTo("Message would be sent to SMTP server.");

        $email = $this->getLastMessage();
        $this->assertEmailIsSent();
        $this->assertEmailSenderEquals('<some@from.address>', $email);
        $this->assertEmailRecipientsContain('<silvam.filipe@gmail.com>', $email);
        $this->assertEmailTextContains('message test', $email);
        $this->assertEmailSubjectEquals('Log message', $email);
        $this->assertEmailSubjectContains('Log', $email);
        $this->tester->comment('The message was sent successfully to server.');
    }

    /**
     * Send an HTML message
     * @test
     */
    public function sendAnHtmlMessage()
    {
        $this->tester->am('Developer');
        $this->tester->amGoingTo('send an HTML MIME e-mail message to an SMTP server');
        $this->tester->lookForwardTo('send HTML e-mail messages to users.');

        $text = new MimePart('HTML e-mail message.');
        $text->type = "text/plain";


        $path = dirname(dirname(__DIR__)).'/_data/image.jpg';

        $image = new MimePart(fopen($path, 'r'));
        $image->type = "image/jpeg";
        $image->id = 'women';
        $image->disposition = Mime::DISPOSITION_INLINE;
        $image->encoding = Mime::ENCODING_BASE64;


        $html = new MimePart('<p>HTML e-mail message.</p><img src="cid:women"> ');
        $html->type = "text/html";

        $body = new MimeMessage();
        $body->setParts(array($text, $html, $image));

        $message = new Message();
        $message->setBody($body);

        $message->addFrom('some@from.address', 'Slick Framework')
            ->addTo('silvam.filipe@gmail.com', 'Filipe Silva')
            ->setSubject('HTML message');

        $this->transporter->send($message);
        $email = $this->getLastMessage();
        $this->assertEmailIsSent();
        $this->assertEmailHtmlContains('<img src="1/parts/women">', $email);
        $this->assertEmailSubjectEquals('HTML message', $email);
    }
}