<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Header;

use Slick\Common\Utils\Collection\AbstractCollection;
use Slick\Mail\Header\AddressList\AddressInterface;

/**
 * E-Mail Address List Header
 *
 * @package Slick\Mail\Header
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class AddressList extends AbstractCollection implements AddressListInterface
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * Methods implementing HeaderInterface
     */
    use HeaderCommonMethods;

    /**
     * Address List
     *
     * @param string $name
     *
     */
    public function __construct($name)
    {
        $this->name = $name;
        parent::__construct([]);
    }

    /**
     * Adds an address to the address list
     *
     * @param AddressInterface $address
     *
     * @return AddressListInterface
     */
    public function add(AddressInterface $address)
    {
        $this->data[] = $address;
        return $this;
    }


    /**
     * Returns the string version of this header
     *
     * @return string
     */
    public function toString()
    {
        $parts = [];
        /** @var AddressInterface $address */
        foreach ($this as $address) {
            $parts[] = (String) $address;
        }
        $addresses = implode(',', $parts);
        return "{$this->getName()}: {$addresses}";
    }

    /**
     * Offset to set
     *
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset The offset to assign the value to.
     * @param mixed $value  The value to set.
     */
    public function offsetSet($offset, $value)
    {
        $this->add($value);
    }
}