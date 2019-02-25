<?php

namespace Drupal\dcg_rest\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Pincode master entity.
 *
 * @ingroup dcg_rest
 *
 * @ContentEntityType(
 *   id = "pincode_master",
 *   label = @Translation("Pincode master"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\dcg_rest\PincodeMasterListBuilder",
 *     "views_data" = "Drupal\dcg_rest\Entity\PincodeMasterViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\dcg_rest\Form\PincodeMasterForm",
 *       "add" = "Drupal\dcg_rest\Form\PincodeMasterForm",
 *       "edit" = "Drupal\dcg_rest\Form\PincodeMasterForm",
 *       "delete" = "Drupal\dcg_rest\Form\PincodeMasterDeleteForm",
 *     },
 *     "access" = "Drupal\dcg_rest\PincodeMasterAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\dcg_rest\PincodeMasterHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "pincode_master",
 *   admin_permission = "administer pincode master entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "pincode",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/pincode_master/{pincode_master}",
 *     "add-form" = "/admin/structure/pincode_master/add",
 *     "edit-form" = "/admin/structure/pincode_master/{pincode_master}/edit",
 *     "delete-form" = "/admin/structure/pincode_master/{pincode_master}/delete",
 *     "collection" = "/admin/structure/pincode_master",
 *   },
 *   field_ui_base_route = "pincode_master.settings"
 * )
 */
class PincodeMaster extends ContentEntityBase implements PincodeMasterInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['pincode'] = BaseFieldDefinition::create('string')
      ->setLabel(t('PINCODE'))
      ->setSettings([
        'max_length' => 20,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['city'] = BaseFieldDefinition::create('string')
      ->setLabel(t('CITY'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['state'] = BaseFieldDefinition::create('string')
      ->setLabel(t('STATE'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));
    return $fields;
  }

}
