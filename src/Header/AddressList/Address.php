<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Header\AddressList;

/**
 * Address
 *
 * @package Slick\Mail\Header\AddressList
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class Address implements AddressInterface
{

    /**
     * @var string
     */
    private $address;

    /**
     * @var string|null
     */
    private $name;

    /**
     * Address
     *
     * @param $address
     * @param null $name
     *
     */
    public function __construct($address, $name = null)
    {
        $this->address = $address;
        $this->name = $name;
    }

    /**
     * Gets the e-mail address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Gets the name
     *
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the string representation of this e-mail address
     *
     * @return string
     */
    public function toString()
    {
        $str = "{$this->getAddress()}";
        if ($this->name) {
            $str = "{$this->getName()} <{$str}>";
        }
        return $str;
    }

    /**
     * An automated alias for toString() method
     *
     * @see Address::toString()
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}