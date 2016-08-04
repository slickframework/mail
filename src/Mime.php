<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail;

/**
 * Mime
 *
 * @package Slick\Mail
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class Mime
{

    const TYPE_OCTETSTREAM         = 'application/octet-stream';
    const TYPE_TEXT                = 'text/plain';
    const TYPE_HTML                = 'text/html';
    const ENCODING_7BIT            = '7bit';
    const ENCODING_8BIT            = '8bit';
    const ENCODING_QUOTEDPRINTABLE = 'quoted-printable';
    const ENCODING_BASE64          = 'base64';
    const DISPOSITION_ATTACHMENT   = 'attachment';
    const DISPOSITION_INLINE       = 'inline';
    const LINELENGTH               = 72;
    const LINEEND                  = "\n";
    const MULTIPART_ALTERNATIVE    = 'multipart/alternative';
    const MULTIPART_MIXED          = 'multipart/mixed';
    const MULTIPART_RELATED        = 'multipart/related';
}