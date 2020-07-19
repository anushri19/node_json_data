<?php

namespace Drupal\node_json\Form;


use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class NodeJsonForm extends ConfigFormBase {

  /** 
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'node_json.settings';

  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'node_json.settings';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $form['apiKey'] = [
      '#type' => 'textfield',
      '#title' => t('API KEY'),
    ];  

     

    return parent::buildForm($form, $form_state);
  }

//validating length of api key
function validateForm($form, FormStateInterface &$form_state) {
  if (strlen($form_state->getValue('apiKey')) <16) {
        $form_state->setErrorByName('apiKey', t('API Key limits should not exceed length 16'));
      }

       }



  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $this->configFactory->getEditable(static::SETTINGS)
      // Set the submitted configuration setting.
      ->set('apiKey', $form_state->getValue('apiKey'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
