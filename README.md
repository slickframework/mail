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
-   Created on top of [Zend\Mail][] library


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
<?php
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

**Contribute**

-   Issue Tracker: <https://github.com/slickframework/mail/issues>
-   Source Code: <https://github.com/slickframework/mail>

**Support**

If you are having issues, please let us know.

**License**

The project is licensed under the MIT License (MIT)

  [Twig]: http://twig.sensiolabs.org/
  [Zend\Mail]: http://framework.zend.com/manual/current/en/modules/zend.mail.introduction.html