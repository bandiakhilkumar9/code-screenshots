<?php
 
namespace Drupal\custom_block\Plugin\Block;
 
use Drupal\Core\Block\BlockBase;
/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "hello_block",
 *   admin_label = @Translation("Hello block"),
 *   category = @Translation("Custom example block"),
 * )
 */
 
class customblock extends BlockBase 
{
 
/**
   * {@inheritdoc}
   */
  public function build() {
 
    $form = \Drupal::formBuilder()->getForm('Drupal\custom_block\Form\drupalblock');
 
    return $form;
 
  }
    
  }
 

