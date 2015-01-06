<?php

/**
 * Version test case
 *
 * @package   Test\Slick\Mail
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Mail;

use Slick\Mail\Version;
use Codeception\TestCase\Test;

/**
 * Version test case
 *
 * @package   Test\Slick\Mail
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class VersionTest extends Test
{
    /**
     * Verify version information
     * @test
     */
    public function checkVersion()
    {
        $this->assertTrue(Version::isLatest());
        $this->assertEquals('-1', Version::compare("0.2.2"));
        $this->assertEquals('0', Version::compare("1.0.1"));
        $this->assertEquals('1', Version::compare("100.2.2"));
    }
}