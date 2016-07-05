<?php

/**
 * @file
 * Contains \Drupal\chatbot\Form\SettingsForm.
 */

namespace Drupal\chatbot\Form;

use Drupal\Component\Utility\SafeMarkup;
use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Defines a form that configures devel settings.
 */
class SettingsForm extends ConfigFormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormID() {
        return 'chatbot_admin_settings_form';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return [
            'chatbot.settings',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {

        $chatbot_config = $this->config('chatbot.settings');

        $form['chatbot_server_address'] = array(
            '#type' => 'textfield',
            '#title' => t('Chatbot TCP/IP server address/ip address'),
            '#default_value' => $chatbot_config->get('chatbot_server_address', false),
            '#length' => 255,
            '#attributes' => array(
                'placeholder' => "127.0.0.1",
                )
        );
        $form['chatbot_port'] = array(
            '#type' => 'textfield',
            '#title' => t('Chatbot port'),
            '#default_value' => $chatbot_config->get('chatbot_port', false),
            '#attributes' => array(
                'placeholder' => "1024",
                ),
            '#length' => 11,
        );
        $botid = 0;
        $form['bot'][$botid] = array(
            '#type' => 'fieldset',
            '#title' => t('Podcast bot settings'),
            '#collapsible' => true,
        );
        // Required elements
        
            $form['bot'][$botid]["chatbot_{$botid}_botname_client"] = array(
            '#type' => 'textfield',
            '#title' => t('Bot Name:'),
            '#description' => t('The name to call the chatbot bot.'),
            '#default_value' => $chatbot_config->get("chatbot_{$botid}_botname_client", false),
            '#length' => 255,
            '#attributes' => array(
                'placeholder' => "Harry",
            ),
        );
            $form['bot'][$botid]["chatbot_{$botid}_botname_server"] = array(
            '#type' => 'textfield',
            '#title' => t('Bot Name (server)'),
            '#description' => t('The name of the chatbot bot as it is on the server'),
            '#default_value' => $chatbot_config->get("chatbot_{$botid}_botname_server", false),
            '#length' => 255,
            '#attributes' => array(
                'placeholder' => "Harry",
            ),
        );
            
        $form['bot'][$botid]["chatbot_{$botid}_description"] = array(
            '#type' => 'textarea',
            '#title' => t('Description'),
            '#description' => t('An optional description of the bot.'),
            '#default_value' => $chatbot_config->get("chatbot_{$botid}_description")
        );

        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $values = $form_state->getValues();
        foreach ($values as $key => $setting) {
            if (0 === strpos($key, "chatbot_")) {
                $this->config('chatbot.settings')
                        ->set($key, $setting)
                        ->save();
            }
        }
        // invalidate cache
        \Drupal::cache()->delete("chatbot");
    }

}
