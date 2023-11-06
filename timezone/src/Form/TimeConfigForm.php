<?php 

namespace Drupal\timezone\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class TimeConfigForm extends ConfigFormBase {
  protected function getEditableConfigNames() {
    return ['timezone.settings'];
  }

  public function getFormId() {
    return 'time_config_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('timezone.settings');

    $timezones = ['America/Chicago' => 'America/Chicago', 'America/New_York' => 'America/New_York', 'Asia/Tokyo' => 'Asia/Tokyo', 'Asia/Dubai' => 'Asia/Dubai', 'Asia/Kolkata' => 'Asia/Kolkata', 'Europe/Amsterdam' => 'Europe/Amsterdam', 'Europe/Oslo' => 'Europe/Oslo', 'Europe/London' => 'Europe/London'];

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#default_value' => $config->get('country'),
    ];
    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => $config->get('city'),
    ];
    $form['timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('Timezone'),
      '#options' => $timezones,
      '#default_value' => $config->get('timezone'),
    ];



    // Add more configuration fields as needed.

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->configFactory->getEditable('timezone.settings');
    $config->set('country', $form_state->getValue('country'))->save();
    $config->set('city', $form_state->getValue('city'))->save();
    $config->set('timezone', $form_state->getValue('timezone'))->save();
    // You can save other configuration settings here.

    parent::submitForm($form, $form_state);
  }
}