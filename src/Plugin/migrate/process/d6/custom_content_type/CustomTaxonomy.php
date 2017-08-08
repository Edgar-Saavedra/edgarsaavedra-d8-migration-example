<?php

/**
 * @file
 * Contains \Drupal\link\Plugin\custom_d6_migration\process\CustomTaxonomy.
 */

namespace Drupal\edgarsaavedra_d8_d6Tod8Migration_example\Plugin\migrate\process\d6\CustomContentType;

use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\MigrateSkipProcessException;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * @MigrateProcessPlugin(
 *   id = "custom_process_taxonomy_term_2"
 * )
 */
class CustomTaxonomy extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    if (empty($value)) {
      // Skip this item if there's no URL.
      throw new MigrateSkipProcessException();
    }
    $term_array = [];

//    print_r(['taxonomy process plugin']);
    try
    {
      //http://www.eilyin.name/note/database-queries-drupal-8-7
      $db = \Drupal\Core\Database\Database::setActiveConnection('external');
      $connection = \Drupal\Core\Database\Database::getConnection('external');

      /**
       * Select table term node, set a token for it as "x"
       * get the tid field in the "x" table aka term_node
       * only get the fields where nid column is equal to the value given
       * and execute;
       */
      $sth = $connection->select('term_node', 'x')
        ->fields('x', array('tid'))
        ->condition('x.nid', $value, '=');
      // Execute the statement
      $data = $sth->execute();

      //https://api.drupal.org/api/drupal/core!lib!Drupal!Core!Database!Connection.php/function/Connection%3A%3Aselect/8.2.x
      $results = $data->fetchAll(\PDO::FETCH_OBJ);

      foreach ($results as $row) {
        //weed out similar tids
        if(!in_array($row->tid,$term_array))
          $term_array[] = $row->tid;
      }
      \Drupal\Core\Database\Database::setActiveConnection();
//      \Drupal\Core\Database\Database::setActiveConnection('default');
    }catch(Exceptiontion $e)
    {

    }
    return $term_array;
  }
}
