<?php
/**
 * @file
 * Contains \Drupal\chatbot\Plugin\Block\ChatbotBotBlock.
 */
namespace Drupal\chatbot\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Provides a block to display interactable 'Chatbot Bot Block' elements.
 *
 * @Block(
 *   id = "chatbot_bot_block",
 *   admin_label = @Translation("Chatbot Bot Block")
 * )
 */
class ChatbotBotBlock extends BlockBase implements ContainerFactoryPluginInterface {
    /**
     * Stores the configuration factory.
     *
     * @var \Drupal\Core\Config\ConfigFactoryInterface
     */
    protected $configFactory;
    /**
     * Creates a ChatbotBlock instance.
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
            // Explain that the user does not have access to the Chatbot Bot Block Settings
            $site_logo_description = $this->t('You do not have the appropriate permissions to add a Chatbot Bot Block.');
        }
        $form['block_description'] = array(
            '#type' => 'fieldset',
            '#title' => $this->t('Choose title of block'),
            '#description' => $this->t('Choose what title you\'d like for this block instance.'),
        );
        $form['block_description']['title'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Title'),
            '#description' => $site_logo_description,
            '#default_value' => $this->configuration['title'],
        );
       $form['block_bot_name'] = array(
            '#type' => 'fieldset',
            '#title' => $this->t('Choose which bot you would like to enable'),
        );
         $form['block_bot_name']['name'] = array(
            '#type' => 'select',
            '#title' => t('Bot name'),
            '#description' => $this->t('Choose which bot you would like to enable for this block instance.'),
             '#options' => array(
                 'Harry' => 'Harry'
                 )
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
    $site_config = $this->configFactory->get('chatbot.botblock');
    $build.= "<h1>Chatbot</h1>";
    
    return array(
            '#theme' => 'chatbot',
            '#markup' => $build,
            '#attached' => array(
                'library' => array(
                    'chatbot/chatbot.block'),
            ),
        );
 
  }
    /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    return Cache::mergeTags(
      parent::getCacheTags(),
      $this->configFactory->get('chatbot.botblock')->getCacheTags()
    );
  }
}