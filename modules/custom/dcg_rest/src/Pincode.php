<?php

namespace Drupal\dcg_rest;

/**
 * Defines a Pincode class.
 */
class Pincode {

  /**
   * Pincode length constant.
   */
  const PINCODE_LENGTH = 6;

  /**
   * Pincode variable.
   *
   * @var int
   */
  private $pincode = 0;

  /**
   * Function to set Pincode.
   *
   * @param int $pincode
   *   Pincode to set..
   */
  public function setPincode(int $pincode) {
    $this->pincode = $pincode;
  }

  /**
   * Function to get Pincode.
   *
   * @return int
   *   The pincode.
   */
  public function getPincode() {
    return $this->pincode;
  }

  /**
   * Function to check if Pincode is valid or not.
   *
   * @return bool
   *   Return bool value.
   */
  public function validatePincode() {
    if (strlen($this->pincode) != self::PINCODE_LENGTH || !is_numeric($this->pincode)) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Function to return sample array.
   *
   * @return array
   *   Return sample array.
   */
  public function getSampleArray() {
    return [
      'pincode' => '302012',
      'state' => 'Rajasthan',
      'city' => 'Jaipur',
    ];
  }

}
