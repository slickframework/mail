<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Transport\Vendor;

/**
 * PHP mail class wrapper
 *
 * @package Slick\Mail\Transport\Vendor
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 *
 * @codeCoverageIgnore
 */
class Php
{

    /**
     * Sends an email.
     *
     * @param string $to
     * @param string $subject
     * @param string $message
     * @param string $additionalHeaders
     *
     * @link http://php.net/manual/en/function.mail.php
     *
     * @return bool
     */
    public function mail($to, $subject, $message, $additionalHeaders = null)
    {
        return mail($to, $subject, $message);
    }
}