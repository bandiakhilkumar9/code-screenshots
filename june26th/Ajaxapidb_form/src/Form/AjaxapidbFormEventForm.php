<?php

namespace Drupal\Ajaxapidb_form\Form;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerTrait;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Ajaxapidb_form\AjaxapidbFormRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

class AjaxapidbFormEventForm implements FormInterface, ContainerInjectionInterface {

use StringTranslationTrait;
  use MessengerTrait;

  /**
   * Our database repository service.
   *
   * @var \Drupal\applicationform_student\DatabaseStudentRepository
   */
  protected $repository;

  /**
   * The current user.
   *
   * We'll need this service in order to check if the user is logged in.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * {@inheritdoc}
   *
   * We'll use the ContainerInjectionInterface pattern here to inject the
   * current user and also get the string_translation service.
   */
  public static function create(ContainerInterface $container) {
    $form = new static(
      $container->get('Ajaxapidb_form.repository'),
      $container->get('current_user')
    );
    // The StringTranslationTrait trait manages the string translation service
    // for us. We can inject the service here.
    $form->setStringTranslation($container->get('string_translation'));
    $form->setMessenger($container->get('messenger'));
    return $form;
  }

  /**
   * Construct the new form object.
   */
  public function __construct(AjaxapidbFormRepository $repository, AccountProxyInterface $current_user) {
    $this->repository = $repository;
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'Ajaxapidb_form_Event_form';
  }
  public function validateForm(array &$form, FormStateInterface $form_state) {

      if (empty($form_state->getValue('Firstname'))) {
        $form_state->setErrorByName('Firstname', $this->t('enter Firstname.'));
      }
	  if (empty($form_state->getValue('Lastname'))) {
        $form_state->setErrorByName('Lastname', $this->t('enter Lastname.'));
      }
	   if (empty($form_state->getValue('Bio'))) {
        $form_state->setErrorByName('Bio', $this->t('enter Bio.'));
      }
	  

    }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = [];

    $form['message'] = [
      '#markup' => $this->t('Registration of user form table.'),
    ];
    //$keys = \Drupal::service('config.factory')->listAll($prefix = "system");
	//print_r ($keys);exit;
    $form['add'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('user registration'),
    ];
    $form['Firstname'] = array(
      '#type' => 'textfield',
      '#required' => TRUE,
      '#attributes' => array(
      'placeholder' => t('Firstname *'),
       )
      );
    $form['Lastname'] = array(
      '#type' => 'textfield',
      '#required' => TRUE,
      '#attributes' => array(
      'placeholder' => t('Lastname *'),
      )
      );
      $form['add']['Bio'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Bio'),
      '#size' => 15,
    ];
    $form['gender'] = array(
      '#type' => 'radios',
      '#title' => t('Gender'),
      '#options' => [1 => 'Female', 2 => 'Male', 3 => 'Others',],
      '#required' => TRUE,
      );
     $database = \Drupal::database();
		$query = $database->query("SELECT tid,name FROM taxonomy_term_field_data WHERE vid = 'interest' ");
		$results = $query->fetchAll();

			//$results = db_query("SELECT tid, name FROM taxonomy_term_field_data WHERE vid = 'interest' ")->fetchAll();

			$options1 = array();$v=0;
			$a=array();$b=array();$c=array();
			foreach($results  as $key=>$value){
			
			
				array_push($a,$results[$v]->tid);
				array_push($b,$results[$v]->name);
				
				$v++;
			}
			$c=array_combine($a,$b);
			//print_r($c);exit;
			//print_r($options1);exit;
			$form['add']['interest'] = array(
			'#type' => 'select',
			'#title' => t('Click on your interset'),
			
			'#options' =>$c,
			'#description' => t(''),
			);
	
      $form['submit'] = array(
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
      
		  
		   '#ajax' => [
        'callback' => '::addCallback',
        'wrapper' => 'names-fieldset-wrapper',
      ]
       );
	

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
  }
  public function addCallback(array &$form, FormStateInterface $form_state) {
  $entry = [
      'Firstname' => $form_state->getValue('Firstname'),
      'Lastname' => $form_state->getValue('Lastname'),
      'gender' => $form_state->getValue('gender'),
	  'Bio' => $form_state->getValue('Bio'),
      'interest' => $form_state->getValue('interest'),
    ];
	 $return = $this->repository->insert($entry);
   $response = new AjaxResponse();
    if ($return) {
      $this->messenger()->addMessage($this->t('Created entry @entry', ['@entry' => print_r($entry, TRUE)]));
    }
	return $response;
  }

}
