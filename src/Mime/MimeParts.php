<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Mime;

use Slick\Common\Utils\Collection\AbstractCollection;
use Slick\Common\Utils\CollectionInterface;

/**
 * Mime Parts collection
 *
 * @package Slick\Mail\Mime
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class MimeParts extends AbstractCollection implements CollectionInterface
{

    /**
     * @param MimePartInterface $part
     *
     * @return $this|MimeParts
     */
    public function add(MimePartInterface $part)
    {
        $this->data[] = $part;
        return $this;
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function offsetSet($offset, $value)
    {
        $this->add($value);
    }
}