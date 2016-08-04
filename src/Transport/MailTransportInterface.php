<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Transport;

use Slick\Mail\MessageInterface;

/**
 * E-Mail Message Transport Interface
 *
 * @package Slick\Mail\Transport
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface MailTransportInterface
{
    /**
     * Send a e-mail message
     *
     * @param MessageInterface $message
     *
     * @return MailTransportInterface
     */
    public function send(MessageInterface $message);
}