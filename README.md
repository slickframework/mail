# Slick Mail

[![Latest Version](https://img.shields.io/github/release/slickframework/mail.svg?style=flat-square)](https://github.com/slickframework/mail/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/slickframework/mail/master.svg?style=flat-square)](https://travis-ci.org/slickframework/mail)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/slickframework/mail/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/slickframework/mail/code-structure?branch=master)
[![Quality Score](https://img.shields.io/scrutinizer/g/slickframework/mail/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/slickframework/mail?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/slick/mail.svg?style=flat-square)](https://packagist.org/packages/slick/mail)

Email plugin provides generalized functionality to compose and send both text and
MIME-compliant multi-part e-mail messages.

This package is compliant with PSR-2 code standards and PSR-4 autoload standards.
It also applies the semantic version 2.0.0 specification.

**Features**

-   Easy mail transport creation (SMTP, PHP mail())
-   Uses [Twig][] for a robust template engine
-   Multi-Part e-mail messages


**Installation**

To use E-Mail plugin in your project just run the following command:

```
$ composer require slick/mail
```
    
**Quick Start**
    
Create a message:

``` php
use Slick\Mail\Message;
use Slick\Mail\MessageBody;

$message = new Message();
$message->setFrom('some@from.address', 'Slick Mail')
    ->addTo('you@example.com')
    ->setSubject('Log message');
   
$body = new MessageBody(
    'mail/template.twig',
    ['foo' => $foo, 'bar' => 'baz']
);    
$message->setBody($body);
```        

If you need to send a multi-part e-mail with text and HTML or embedding images in it
for example, you can do like this:

``` php
use Slick\Mail\Mime;
use Slick\Mail\Mime\MimeMessage;
use Slick\Mail\Mime\Part as MimePart;

$text = new MimePart('mail/template.twig', ['foo' => $foo, 'bar' => 'baz']);
$text->type = "text/plain";

$image = new MimePart('image.jpg');
$image->type = "image/jpeg";
$image->id = "image";
$image->encoding = Mime::ENCODING_BASE64;

$html = new MimePart('mail/template.html.twig', ['foo' => $foo, 'bar' => 'baz']);
$html->type = "text/html";

$message = new MimeMessage();
$message->parts()
    ->add($text)
    ->add($image)
    ->add($html)
;

```

As you can see it very easy to compose an e-mail message. Now you need to send it!
 Lets see:
 
``` php
use Slick\Mail\Transport\SmtpTransport;

$transport = new SmtpTransport([
    'options' => [
        'name' => 'localhost.localdomain',
        'host' => '127.0.0.1',
        'port' => 25,
    ]
]);

$transport->send($message);

```

> For a complete documentation on the SMTP transport object and options, as this is an extension to the
> Zend\Mail\Transport\Smtp class, you can go to the [Zend/Mail/transport manual][] website.



**Contribute**

-   Issue Tracker: <https://github.com/slickframework/mail/issues>
-   Source Code: <https://github.com/slickframework/mail>

**Support**

If you are having issues, please let us know.

**License**

The project is licensed under the MIT License (MIT)

  [Twig]: http://twig.sensiolabs.org/
  [Zend/Mail/transport manual]: http://framework.zend.com/manual/current/en/modules/zend.mail.transport.html