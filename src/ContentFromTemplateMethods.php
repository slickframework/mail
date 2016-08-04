<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Mail;

use Slick\Template\Template;
use Slick\Template\TemplateEngineInterface;

/**
 * Content From Template Methods
 *
 * @package Slick\Mail
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
trait ContentFromTemplateMethods
{

    /**
     * Gets the Template Engine
     *
     * @return TemplateEngineInterface
     */
    public function getTemplateEngine()
    {
        if (null == $this->templateEngine) {
            $engine = (new Template())->initialize();
            $this->setTemplateEngine($engine);
        }
        return $this->templateEngine;
    }

    /**
     * Sets the Template Engine
     *
     * @param TemplateEngineInterface $templateEngine
     *
     * @return MessageBody|$this|self
     */
    public function setTemplateEngine(TemplateEngineInterface $templateEngine)
    {
        $this->templateEngine = $templateEngine;
        return $this;
    }
}