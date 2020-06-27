<?php
namespace Drupal\migration_movies\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for the movies.
 *
 * @MigrateSource(
 *   id = "movies"
 * )
 */
class Movies extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('movies', 'd')
      ->fields('d', ['id', 'name', 'description']);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('movie ID'),
      'name' => $this->t('movie Name'),
      'description' => $this->t('movie Description'),
      'english_movies' => $this->t('english_movies'),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'id' => [
        'type' => 'integer',
        'alias' => 'd',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $genres = $this->select('english_movies', 'g')
      ->fields('g', ['id'])
      ->condition('movie_id', $row->getSourceProperty('id'))
      ->execute()
      ->fetchCol();
    $row->setSourceProperty('english_movies', $genres);
    return parent::prepareRow($row);
  }
}