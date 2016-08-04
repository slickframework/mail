<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Header;

/**
 * Abstract Header
 *
 * @package Slick\Mail\Header
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
abstract class AbstractHeader implements HeaderInterface
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
     *  HeaderInterface methods
     */
    use HeaderCommonMethods;

    /**
     * Returns the string version of this header
     *
     * @return string
     */
    public function toString()
    {
        return "{$this->getName()}: {$this->getValue()}";
    }

}