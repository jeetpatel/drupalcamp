<?php

namespace Drupal\dcg_rest\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Pincode master edit forms.
 *
 * @ingroup dcg_rest
 */
class PincodeMasterForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\dcg_rest\Entity\PincodeMaster */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Pincode master.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Pincode master.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.pincode_master.canonical', ['pincode_master' => $entity->id()]);
  }

}
