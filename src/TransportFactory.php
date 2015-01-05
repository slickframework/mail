<?php

/**
 * Mail transport factory
 *
 * @package   Slick\Mail
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Slick\Mail;

use ReflectionClass;
use Slick\Common\Base;
use InvalidArgumentException;
use Zend\Mail\Transport\TransportInterface;

/**
 * Mail transport factory
 *
 * @package   Slick\Mail
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 *
 * This is a simple factory class for Zend\Mail\Transport creation.
 * For documentation please see
 * @see http://framework.zend.com/manual/2.2/en/modules/zend.mail.smtp.options.html
 *
 * @property string $class The class name or alias
 */
class TransportFactory extends Base
{

    /**
     * @readwrite
     * @var string
     */
    protected $_class;

    /**
     * @readwrite
     * @var array
     */
    protected $_options;

    /**
     * @var array
     */
    protected static $_alias = [
        'SendMail' => '\Zend\Mail\Transport\Sendmail',
        'Smtp' => 'Zend\Mail\Transport\Smtp',
        'File' => 'Zend\Mail\Transport\File'
    ];

    /**
     * @var array
     */
    protected static $_optionsClass = [
        'Smtp' => 'Zend\Mail\Transport\SmtpOptions',
        'File' => 'Zend\Mail\Transport\FileOptions'
    ];

    /**
     * Initializes the transport object
     *
     * @return TransportInterface
     */
    public function getTransport()
    {
        $alias = array_keys(static::$_alias);
        $className = $this->class;
        if (in_array($this->class, $alias)) {
            $className = static::$_alias[$this->class];
        }

        $class = new ReflectionClass($className);
        $interface = '\Zend\Mail\Transport\TransportInterface';

        if (!$class->implementsInterface($interface)) {
            throw new InvalidArgumentException(
                "The class '{$this->class}' is not a valid alias or it " .
                "does not implement the '{$interface}'' interface."
            );
        }

        $optionsAlias = array_keys(static::$_optionsClass);
        if (in_array($this->class, $optionsAlias)) {
            $optionsClass = new ReflectionClass(
                static::$_optionsClass[$this->class]
            );
            $this->_options = $optionsClass->newInstanceArgs([$this->_options]);
        }

        return $class->newInstanceArgs([$this->_options]);
    }

}