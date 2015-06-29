<?php

/**
 * @file
 * Contains \Drupal\system\Plugin\Block\ChatscriptBlock.
 */

namespace Drupal\system\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a block to display interactable 'Chatscript Bot Block' elements.
 *
 * @Block(
 *   id = "chatscript_bot_block",
 *   admin_label = @Translation("Chatscript Bot Block")
 * )
 */
class ChatscriptBotBlock extends BlockBase implements ContainerFactoryPluginInterface {

    /**
     * Stores the configuration factory.
     *
     * @var \Drupal\Core\Config\ConfigFactoryInterface
     */
    protected $configFactory;

    /**
     * Creates a ChatscriptBlock instance.
     *
     * @param array $configuration
     *   A configuration array containing information about the plugin instance.
     * @param string $plugin_id
     *   The plugin_id for the plugin instance.
     * @param mixed $plugin_definition
     *   The plugin implementation definition.
     * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
     *   The factory for configuration objects.
     */
    public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->configFactory = $config_factory;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
                $configuration, $plugin_id, $plugin_definition, $container->get('config.factory')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration() {
        return array(
                #
        );
    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
        // Get the theme.
        $theme = $form_state->get('block_theme');

        // Get permissions.
        $url_system_theme_settings = new Url('system.theme_settings');
        $url_system_theme_settings_theme = new Url('system.theme_settings_theme', array('theme' => $theme));

        if ($url_system_theme_settings->access() && $url_system_theme_settings_theme->access()) {
            
        } else {
            // Explain that the user does not have access to the Chatscript Bot Block Settings
            $site_logo_description = $this->t('You do not have the appropriate permissions to add a Chatscript Bot Block.');
        }

        $form['block_description'] = array(
            '#type' => 'fieldset',
            '#title' => $this->t('Choose title of block'),
            '#description' => $this->t('Choose what title you\'d like fot this block instance.'),
        );
        $form['block_description']['title'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Title'),
            '#description' => $site_logo_description,
            '#default_value' => $this->configuration['title'],
        );
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
        $block_description = $form_state->getValue('block_description');
        $this->configuration['title'] = $block_description['title'];
    }
     /**
   * {@inheritdoc}
   */
  public function build() {
    $build = array();
    $site_config = $this->configFactory->get('chatscript.botblock');
    return $build;
  }
    /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    return Cache::mergeTags(
      parent::getCacheTags(),
      $this->configFactory->get('chatscript.botblock')->getCacheTags()
    );
  }
}
