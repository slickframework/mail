<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Header;

/**
 * Common methods for HeaderInterface objects
 *
 * @package Slick\Mail\Header
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
trait HeaderCommonMethods
{

    /**
     * Gets header filed name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the header field name
     *
     * @param string $name
     *
     * @return AbstractHeader|$this|self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param $encoding
     *
     * @return HeaderInterface
     */
    public function setEncoding($encoding)
    {
        // TODO: Implement setEncoding() method.
    }

    /**
     * Gets header value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the header value
     *
     * @param string $value
     *
     * @return AbstractHeader|$this|self
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Returns the string version of this header
     *
     * @return string
     */
    abstract public function toString();

    /**
     * An automated version of toString() method
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}