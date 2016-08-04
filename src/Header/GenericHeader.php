<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Header;

/**
 * GenericHeader
 *
 * @package Slick\Mail\Header
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class GenericHeader extends AbstractHeader implements HeaderInterface
{

    /**
     * Creates a generic header with its name and value
     *
     * @param string $name
     * @param string $value
     *
     */
    public function __construct($name, $value)
    {
        $this->setName($name)
            ->setValue($value);
    }
}