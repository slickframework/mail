<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Mime;

use Slick\Mail\Mime;

/**
 * MimePartInterface
 *
 * @package Slick\Mail\Mime
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface MimePartInterface
{

    /**
     * Set type
     *
     * @param string $type
     *
     * @return MimePartInterface
     */
    public function setType($type = Mime::TYPE_OCTETSTREAM);

    /**
     * Set id
     *
     * @param string $id
     *
     * @return MimePartInterface
     */
    public function setId($id);

    /**
     * Set disposition
     *
     * @param string $disposition
     *
     * @return MimePartInterface
     */
    public function setDisposition($disposition);

    /**
     * Set description
     *
     * @param string $description
     *
     * @return MimePartInterface
     */
    public function setDescription($description);

    /**
     * Set filename
     *
     * @param string $fileName
     *
     * @return MimePartInterface
     */
    public function setFileName($fileName);

    /**
     * Set charset
     *
     * @param string $charset
     *
     * @return MimePartInterface
     */
    public function setCharset($charset);

    /**
     * Set boundary
     *
     * @param string $boundary
     *
     * @return MimePartInterface
     */
    public function setBoundary($boundary);

    /**
     * Set location
     * @param string $location
     * @return self
     */
    public function setLocation($location);

    /**
     * Set language
     *
     * @param string $language
     *
     * @return self
     */
    public function setLanguage($language);

    /**
     * Return the headers for this part as a string
     *
     * @param string $eol
     * @return String
     */
    public function getHeaders($eol = Mime::LINEEND);

    /**
     * Get the Content of the current Mime Part in the given encoding.
     *
     * @param string $eol
     * @return string
     */
    public function getContent($eol = Mime::LINEEND);
}