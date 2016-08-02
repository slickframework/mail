<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Header;

/**
 * E-Mail message header interface
 *
 * @package Slick\Mail\Header
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface HeaderInterface
{

    const EOL = "\r\n";

    /**
     * Gets header filed name
     *
     * @return string
     */
    public function getName();

    /**
     * Gets header value
     *
     * @return string
     */
    public function getValue();

    /**
     * Returns the string version of this header
     *
     * @return string
     */
    public function toString();

    /**
     * @param $encoding
     *
     * @return HeaderInterface
     */
    public function setEncoding($encoding);

    /**
     * An automated version of toString() method
     *
     * @return string
     */
    public function __toString();
}