<?php

namespace Drupal\migration_movies\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for the english_movies.
 *
 * @MigrateSource(
 *   id = "english_movies"
 * )
 */
class English_movies extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('english_movies', 'g')
      ->fields('g', ['id', 'movie_id', 'name']);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('english_movies ID'),
      'movie_id' => $this->t('movie ID'),
      'name' => $this->t('movie name'),
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
        'alias' => 'g',
      ],
    ];
  }
}