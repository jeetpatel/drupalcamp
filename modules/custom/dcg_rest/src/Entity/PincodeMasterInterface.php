<?php

namespace Drupal\dcg_rest\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Pincode master entities.
 *
 * @ingroup dcg_rest
 */
interface PincodeMasterInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Pincode master name.
   *
   * @return string
   *   Name of the Pincode master.
   */
  public function getName();

  /**
   * Sets the Pincode master name.
   *
   * @param string $name
   *   The Pincode master name.
   *
   * @return \Drupal\dcg_rest\Entity\PincodeMasterInterface
   *   The called Pincode master entity.
   */
  public function setName($name);

  /**
   * Gets the Pincode master creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Pincode master.
   */
  public function getCreatedTime();

  /**
   * Sets the Pincode master creation timestamp.
   *
   * @param int $timestamp
   *   The Pincode master creation timestamp.
   *
   * @return \Drupal\dcg_rest\Entity\PincodeMasterInterface
   *   The called Pincode master entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Pincode master published status indicator.
   *
   * Unpublished Pincode master are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Pincode master is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Pincode master.
   *
   * @param bool $published
   *   TRUE to set this Pincode master to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\dcg_rest\Entity\PincodeMasterInterface
   *   The called Pincode master entity.
   */
  public function setPublished($published);

}
