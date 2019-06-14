<?php

namespace Drupal\dcg_rest\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Pincode master entities.
 */
class PincodeMasterViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
