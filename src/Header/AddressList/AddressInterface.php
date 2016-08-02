<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Header\AddressList;

/**
 * Address Interface
 *
 * @package Slick\Mail\Header\AddressList
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface AddressInterface
{

    /**
     * Gets the e-mail address
     *
     * @return string
     */
    public function getAddress();

    /**
     * Gets the name
     *
     * @return null|string
     */
    public function getName();

    /**
     * Gets the string representation of this e-mail address
     *
     * @return string
     */
    public function toString();

    /**
     * An automated alias for toString() method
     *
     * @return string
     */
    public function __toString();
}