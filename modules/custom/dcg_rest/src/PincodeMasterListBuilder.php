<?php

namespace Drupal\dcg_rest;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Pincode master entities.
 *
 * @ingroup dcg_rest
 */
class PincodeMasterListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Pincode master ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\dcg_rest\Entity\PincodeMaster */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.pincode_master.edit_form',
      ['pincode_master' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
