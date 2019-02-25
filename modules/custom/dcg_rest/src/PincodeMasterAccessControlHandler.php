<?php

namespace Drupal\dcg_rest;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Pincode master entity.
 *
 * @see \Drupal\dcg_rest\Entity\PincodeMaster.
 */
class PincodeMasterAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\dcg_rest\Entity\PincodeMasterInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished pincode master entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published pincode master entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit pincode master entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete pincode master entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add pincode master entities');
  }

}
