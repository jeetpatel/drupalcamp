<?php
namespace Drupal\dcg_rest;

/**
 * Defines a Pincode class.
 */
class Pincode {
  private $pincode = 0;
  /**
   * @param int $pincode
   */
  public function setPincode(int $pincode) {
    $this->pincode = $pincode;
  }
  /**
   * @return int
   *   The pincode.
   */
  public function getPincode() {
    return $this->pincode;
  }
  
  public function getSampleArray() {
    return [
      'pincode' =>'302012',
      'state' => 'Rajasthan',
      'city' => 'Jaipur'
    ];
  }
}
