<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail\Mime;

use Slick\Mail\ContentFromTemplateMethods;
use Slick\Mail\Mime;
use Slick\Template\TemplateEngineInterface;

/**
 * Part
 *
 * @package Slick\Mail\Mime
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 *
 * @method string getType()
 * @method string getId()
 * @method string getDisposition()
 * @method string getDescription()
 * @method string getFileName()
 * @method string getCharset()
 * @method string getBoundary()
 * @method string getLocation()
 * @method string getLanguage()
 * @method string getHeadersArray($EOL = Mime::LINEEND)
 */
class Part implements MimePartInterface
{

    /**
     * @var \Zend\Mime\Part
     */
    protected $mimePart;

    /**
     * @var string
     */
    protected $template;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var TemplateEngineInterface
     */
    protected $templateEngine;

    /**
     * To load content from twig templates
     */
    use ContentFromTemplateMethods;

    /**
     * Part
     *
     * Loads a template or a file for this part
     *
     * @param string $template
     * @param array  $data
     *
     */
    public function __construct($template, $data = [])
    {
        $this->data = $data;
        $this->template = $template;
        $content = (is_file($template))
            ? fopen($template, 'r')
            : $this->processTemplate();
        $this->mimePart = new \Zend\Mime\Part($content);
    }

    /**
     * Magic method to handle Zend\Mime\Part method calls
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (!method_exists($this->mimePart, $name)) {
            throw new \BadMethodCallException("Undefined method call.");
        }

        $return = call_user_func_array([$this->mimePart, $name], $arguments);
        return ($return instanceOf \Zend\Mime\Part)
            ? $this
            : $return;
    }

    /**
     * Get content from template
     *
     * @return string
     */
    protected function processTemplate()
    {
        $text = $this->getTemplateEngine()
            ->parse($this->template)
            ->process($this->data);
        return trim($text);
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return MimePartInterface
     *
     * @codeCoverageIgnore
     */
    public function setType($type = Mime::TYPE_OCTETSTREAM)
    {
        $this->mimePart->setType($type);
        return $this;
    }

    /**
     * Set id
     *
     * @param string $id
     *
     * @return MimePartInterface
     *
     * @codeCoverageIgnore
     */
    public function setId($id)
    {
        $this->mimePart->setId($id);
        return $this;
    }

    /**
     * Set disposition
     *
     * @param string $disposition
     *
     * @return MimePartInterface
     *
     * @codeCoverageIgnore
     */
    public function setDisposition($disposition)
    {
        $this->mimePart->setDisposition($disposition);
        return $this;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return MimePartInterface
     *
     * @codeCoverageIgnore
     */
    public function setDescription($description)
    {
        $this->setDescription($description);
        return $this;
    }

    /**
     * Set filename
     *
     * @param string $fileName
     *
     * @return MimePartInterface
     *
     * @codeCoverageIgnore
     */
    public function setFileName($fileName)
    {
        $this->mimePart->setFileName($fileName);
        return $this;
    }

    /**
     * Set charset
     *
     * @param string $charset
     *
     * @return MimePartInterface
     *
     * @codeCoverageIgnore
     */
    public function setCharset($charset)
    {
        $this->mimePart->setCharset($charset);
        return $this;
    }

    /**
     * Set boundary
     *
     * @param string $boundary
     *
     * @return MimePartInterface
     *
     * @codeCoverageIgnore
     */
    public function setBoundary($boundary)
    {
        $this->mimePart->setBoundary($boundary);
        return $this;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return MimePartInterface
     *
     * @codeCoverageIgnore
     */
    public function setLocation($location)
    {
        $this->mimePart->setLocation($location);
        return $this;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return MimePartInterface
     *
     * @codeCoverageIgnore
     */
    public function setLanguage($language)
    {
        $this->mimePart->setLanguage($language);
        return $this;
    }

    /**
     * Return the headers for this part as a string
     *
     * @param string $eol
     *
     * @return String
     *
     * @codeCoverageIgnore
     */
    public function getHeaders($eol = Mime::LINEEND)
    {
        return $this->mimePart->getHeaders($eol);
    }

    /**
     * Get the Content of the current Mime Part in the given encoding.
     *
     * @param string $eol
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getContent($eol = Mime::LINEEND)
    {
        return $this->mimePart->getContent($eol);
    }
}