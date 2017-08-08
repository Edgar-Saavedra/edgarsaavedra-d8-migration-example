<?php

/**
 * @file
 * Contains \Drupal\link\Plugin\custom_d6_migration\process\CustomTaxonomy.
 */
namespace Drupal\edgarsaavedra_d8_d6Tod8Migration_example\Plugin\migrate\process\d6\CustomContentType;

use Drupal\Core\File\FileSystem;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\MigrateSkipProcessException;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * @MigrateProcessPlugin(
 *   id = "custom_process_files"
 * )
 */
class CustomFiles extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    if (empty($value)) {
      // Skip this item if there's no URL.
      throw new MigrateSkipProcessException();
    }
//    print_r($row);
    $file_arr = [];
    if (isset($value['fid'])) {
      $options = unserialize($value['data']);
      $description = \Drupal\file\Entity\File::load($value['fid'])->getFilename();
      if(isset($options['description']))
      {
        if(trim($options['description']) != '')
          $description = $options['description'];
      }
      $file_arr = [
        'target_id' => $value['fid'],
        'display' => $value['list'],
        'description' => $description,
        'alt' => isset($options['alt']) ? $options['alt'] : \Drupal\file\Entity\File::load($value['fid'])->getFilename(),
        'title' => isset($options['title']) ? $options['title'] : \Drupal\file\Entity\File::load($value['fid'])->getFilename(),
      ];
    }
    return $file_arr;
  }
}
