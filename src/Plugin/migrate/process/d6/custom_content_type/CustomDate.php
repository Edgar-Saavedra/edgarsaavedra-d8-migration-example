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
 *   id = "custom_process_date"
 * )
 */
class CustomDate extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    if (empty($value)) {
      // Skip this item if there's no URL.
      throw new MigrateSkipProcessException();
    }
//    print_r(['date process plugin']);
//    print_r($value);
    return $value;
  }
}
