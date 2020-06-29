<?php

namespace Drupal\Ajaxapidb_form\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Ajaxapidb_form\AjaxapidbFormRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;
use Drupal\Core\Render\Markup;
use Drupal\user\Entity\User;
/**
 * Controller for DBTNG Example.
 *
 * @ingroup database_student
 */
class AjaxapidbFormController extends ControllerBase {

  /**
   * The repository for our specialized queries.
   *
   * @var \Drupal\database_student\DatabaseStudentRepository
   */
  protected $repository;
  public $user;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $controller = new static($container->get('Ajaxapidb_form.repository'));
    $controller->setStringTranslation($container->get('string_translation'));
    return $controller;
  }

  /**
   * Construct a new controller.
   *
   * @param \Drupal\database_student\DatabaseStudentRepository $repository
   *   The repository service.
   */
  public function __construct(AjaxapidbFormRepository $repository) {
  $this->repository = $repository;
  }
 public function entryList() {
    $content = [];
    $content['message'] = [
      '#markup' => $this->t('Generate a list of all entries in the database. There is no filter in the query.'),
    ];

    $rows = [];
    $headers = [
      $this->t('pid'),
    
      $this->t('firstname'),
      $this->t('lastname'),
      $this->t('bio'),
	  $this->t('interest'), 
	    $this->t('gender'),
		$this->t('link'),
    ];
  $results = $this->repository->load();
	$k1=array();
   $output=array();

    foreach($results as $k=>$data){

      $term_name = \Drupal\taxonomy\Entity\Term::load($results[$k]->interest)->get('name')->value;

      if($results[$k]->gender ==1)
      {
		  
		  $edit   = Url::fromUserInput('/update');
          $output[] = [
		  'pid' => $results[$k]->pid,
		  'lastname' => $results[$k]->lastname,
          'firstname' => $results[$k]->firstname,    
          'bio' => $results[$k]->bio, 
          'gender' => 'Female',
		 
          'interest' => $term_name,
          \Drupal::l('Edit', $edit),
         ];
      }
      if($results[$k]->gender ==2)
      {
		  
		 $edit   = Url::fromUserInput('/update');
          $output[] = [
		  'pid' => $results[$k]->pid,
		  'lastname' => $results[$k]->lastname,
          'firstname' => $results[$k]->firstname,     
          'bio' => $results[$k]->bio, 
          'gender' => 'Male',
		  
          'interest' => $term_name,
          \Drupal::l('Edit', $edit),
         ];
      }
      if($results[$k]->gender ==3)
      {
		  
		 $edit   = Url::fromUserInput('/update');
          $output[] = [
		  'pid' => $results[$k]->pid,
		  'lastname' => $results[$k]->lastname,
          'firstname' => $results[$k]->firstname,     
          'bio' => $results[$k]->bio, 
          'gender' => 'Others',
		  
          'interest' => $term_name,
          \Drupal::l('Edit', $edit),
         ];
      }
   array_push($k1,$output);
    }
   $content['table'] = [
              '#type' => 'table',
              '#header' => $headers,
              '#rows' => $output,
              '#empty' => t('No users found'),
          ];
          return $content;
  }
}
