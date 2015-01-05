<?php

/**
 * Template message methods
 *
 * @package   Slick\Mail
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Slick\Mail;

use Slick\Template\Template;
use Slick\Template\EngineInterface;

/**
 * Template message methods
 *
 * @package   Slick\Mail
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
trait TemplateMethods
{

    /**
     * @var string Template engine class name or alias
     */
    public $engineType = 'twig';

    /**
     * @var string Template file
     */
    public $template;

    /**
     * @var EngineInterface
     */
    public $engine;

    /**
     * @var array
     */
    public $data = [];

    /**
     * Content of the message
     *
     * @var string|object
     */
    protected $body;

    /**
     * Set template file
     *
     * @param string $template
     * @return self
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * Returns the engine type in use
     *
     * @return string
     */
    public function getEngineType()
    {
        return $this->engineType;
    }

    /**
     * Returns the initialized template engine
     *
     * @return EngineInterface
     */
    public function getEngine()
    {
        if (is_null($this->engine)) {
            $engineFactory = new Template(
                [
                    'engine' => $this->getEngineType()
                ]
            );
            $this->engine = $engineFactory->initialize();
        }
        return $this->engine;
    }

    /**
     * Sets data for template
     *
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Return the currently set message body
     *
     * @return object
     */
    public function getBody()
    {
        // Body is not set yet and we have a template
        if (is_null($this->body) && !is_null($this->template)) {
            $this->processTemplate();
        }
        return $this->body;
    }

    /**
     * Processes the template and assigns the result to the message body
     *
     * @return self
     */
    public function processTemplate()
    {
        $this->body = $this->getEngine()
            ->parse($this->template)
            ->process($this->data);
        return $this;
    }
}