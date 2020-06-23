<?php
namespace Drupal\studentform\Formapi;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
class Form extends FormBase {
 
  public function getFormId() {
    return 'studentform';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['studentname'] = array(
      '#title' => 'studentname',
      '#description' => 'enter a studentname',
      '#type' => 'textfield',
       '#required' => TRUE,
    );
  
 
$form['Rollno'] = array(
  '#title' => 'Rollno',
  '#description' => 'enter a  Rollno',
  '#type' => 'textfield',
  '#required' => TRUE,
);
$form['submit'] = array
    (
      '#type' => 'submit',
      '#value' => $this->t ('Submit'),
    );
    return $form;
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {
    foreach ($form_state->getValues() as $key => $value) {
      drupal_set_message($key . ': ' . $value);
}
  }
}
