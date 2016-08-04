<?php

/**
 * This file is part of slick/mail package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use GuzzleHttp\Client;

/**
 * MailCatcherClient
 *
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class MailCatcherClient
{

    /**
     * @var Client
     */
    protected $mailCatcher;

    /**
     * MailCatcherClient
     */
    public function __construct()
    {
        $this->mailCatcher = new Client(['base_uri' => 'http://mail']);
        // Clear messages between tests
        $this->clearMessages();
    }

    /**
     * Get all messages
     *
     * @return array
     */
    public function getAllMessages()
    {
        $data = $this->mailCatcher->get('/messages')->getBody()->getContents();
        return json_decode($data);
    }

    /**
     * Get last message
     *
     * @return null|object
     */
    public function getLastMessage()
    {
        $messages = $this->getAllMessages();
        return reset($messages);
    }

    /**
     * Clears all messages
     */
    public function clearMessages()
    {
        $this->mailCatcher->delete('/messages');
    }
}