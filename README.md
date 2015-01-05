Slick E-Mail plugin
===================

Email plugin provides generalized functionality to compose and send both text and
MIME-compliant multi-part email messages. It uses the Zen\Mail library to create
and send the e-mail messages. It also adds the possibility to use the Slick\Template
library to create the content for the message or the mime parts.

**Features**

-   Easy mail transport creation (SMTP, SendMail)
-   Uses [Twig][] for a robust template engine
-   Multi-Part e-mail messages
-   Created on top of [Zend/Mail][] library


**Installation**

To use E-Mail plugin in your project just add the following line to your project’s
`composer.json` file:

    {
        "require": {
            "slick/slick": "1.0.*@dev",
            ...
        }
    }

Then you need to run:

    $ composer update
    
**Quick Start**
    
Create a message:

``` php
use Slick\Mail\Message;

$message = new Message();
        $message->addFrom('some@from.address', 'Slick Mail')
            ->addTo('you@example.com')
            ->setSubject('Log message');

$message->setTemplate('mail/template.twig')
    ->setData(['foo' => $foo, 'bar' => 'baz']);
```        
            
Once you create a ``Message`` you can set the content and headers. In this case the content
will be processed using the Slick\Template Twig engine by using the ``Message::setTemplate()``
and ``Message::setData()`` methods.

> For a more complete help on the message object, as this is an extension to the
> Zend\Mail library, you can jump to the [Zend/Mail manual][] page.

If you need to send a multi-part e-mail with text and HTML, embedding  images in it,
for example, you can do like this:

``` php
use Slick\Mail\Message;
use Slick\Mail\Mime\Part as MimePart;
use Slick\Mail\Mime\Message as MimeMessage;
use Zend\Mime\Mime;

$text = new MimePart();
$text->type = "text/plain";
$text->setTemplate('mail/template.twig')
    ->setData(['foo' => $foo, 'bar' => 'baz']);

$image = new MimePart(fopen('image.jpg', 'r'));
$image->type = "image/jpeg";
$image->id = 'image';
$image->encoding = Mime::ENCODING_BASE64;

$html = new MimePart('<p>HTML e-mail message.</p><img src="cid:image"> ');
$html->type = "text/html";

$body = new MimeMessage();
$body->setParts(array($text, $html, $image));

$message = new Message();
$message->setBody($body);

```

As you can see it very easy to compose an e-mail message. Now you need to send it!
 Lets see:
 
``` php
use Slick\Mail\TransportFactory;

$factory = new TransportFactory([
    'class' => 'Smtp',
    'options' => [
        'name' => 'localhost.localdomain',
        'host' => '127.0.0.1',
        'port' => 25,
    ]
]);
$transport = $factory->getTransport();

$transport->send($message);

```

> For a more complete help on the transport object and options, as this is an extension to the
> Zend\Mail library, you can jump to the [Zend/Mail/transport manual][] page.

**Contribute**

-   Issue Tracker: <https://github.com/slickframework/mail/issues>
-   Source Code: <https://github.com/slickframework/mail>

**Support**

If you are having issues, please let us know.

**License**

The project is licensed under the MIT License (MIT)

  [Twig]: http://twig.sensiolabs.org/
  [Zend/Mail]: http://framework.zend.com/manual/current/en/modules/zend.mail.introduction.html
  [zend/Mail Manual]: http://framework.zend.com/manual/current/en/modules/zend.mail.message.html
  [Zend/Mail/transport manual]: http://framework.zend.com/manual/current/en/modules/zend.mail.transport.html