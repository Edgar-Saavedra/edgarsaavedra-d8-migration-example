<?php
//https://www.calebthorne.com/blog/drupal/2016/07/16/drupal-8-migrate-pathauto
/**
 * @file
 * Contains \Drupal\custom_d6_migration\Plugin\migrate\source\Node\d6.
 */

namespace Drupal\edgarsaavedra_d8_d6Tod8Migration_example\Plugin\migrate\source\d6;

use Drupal\migrate\Row;
use Drupal\node\Plugin\migrate\source\d6\Node as D6Node;

/**
 * Custom node source including url aliases.
 *
 * @MigrateSource(
 *   id = "custom_d6_node"
 * )
 */
class Node extends D6Node {

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return ['alias' => $this->t('Path alias')] + parent::fields();
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    // Include path alias.
    $nid = $row->getSourceProperty('nid');
    $query = $this->select('url_alias', 'ua')
      ->fields('ua', ['dst']);
    $query->condition('ua.src', 'node/' . $nid);
    $alias = $query->execute()->fetchField();
    if (!empty($alias)) {
      $row->setSourceProperty('alias', '/' . $alias);
    }
    return parent::prepareRow($row);
  }

}