<?php

/**
 * @file
 * Contains Drupal\chatbot\Connection
 */

namespace Drupal\chatbot;

use Drupal\Component\Render\PlainTextOutput;
use Drupal\Component\Transliteration\TransliterationInterface;
use Drupal\Component\Utility\Unicode;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Language\LanguageManagerInterface;

/**
 * Manages client connection to Chatbot server
 */
class Connection {

    /**
     * The host IP address
     *
     * @var hostIP
     */
    var $hostIP;

    /**
     * The Port address
     *
     * @var port
     */
    var $port;

    /**
     * The names of the user
     *
     * @var user
     */
    var $user;

    /**
     * The name of the bot
     *
     * @var bot
     */
    var $bot;

    /**
     * Creates a new Connection.
     *
     * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
     *   The config factory.
     * @param \Drupal\chatbot\Connection $hostIP
     *   The config factory.
     * @param \Drupal\chatbot\Connection $port
     *   The alias storage helper.
     * @param \Drupal\chatbot\Connection $user
     *   The language manager.
     * @param \Drupal\chatbot\Connection $bot
     *   The cache backend.
     */
    public function __construct(ConfigFactoryInterface $config_factory = "chatbot",$hostIP, $port,$user,$bot ) {
        $this->configFactory = $config_factory;
        $this->hostIP = $hostIP;
        $this->port = $port;
        $this->user = $user;
        $this->bot = $bot;
    }

}
