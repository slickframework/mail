<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Header;

use Slick\Common\Utils\CollectionInterface;
use Slick\Mail\Header\AddressList\AddressInterface;

/**
 * Address List Interface
 *
 * @package Slick\Mail\Header
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface AddressListInterface extends CollectionInterface, HeaderInterface
{

    /**
     * Adds an address to the address list
     *
     * @param AddressInterface $address
     *
     * @return AddressListInterface
     */
    public function add(AddressInterface $address);
}