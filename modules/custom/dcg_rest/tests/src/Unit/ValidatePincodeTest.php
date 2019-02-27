<?php

namespace Drupal\Tests\dcg_rest\Unit;

use Drupal\dcg_rest\Pincode;
use Drupal\Tests\UnitTestCase;

/**
 * Simple test to ensure that asserts pass.
 *
 * @group dcg_rest
 */
class UnitTest extends UnitTestCase {

  protected $pincode;

  /**
   * Before a test method is run, setUp() is invoked.
   *
   * Create new Pincode object.
   */
  public function setUp() {
    $this->pincode = new Pincode();
  }

  /**
   * @covers Drupal\dcg_rest\Pincode::setPincode
   */
  public function testSetPincode() {
    $this->assertEquals(0, $this->pincode->getPincode());
    $this->pincode->setPincode(302012);
    $this->assertEquals(302012, $this->pincode->getPincode());
  }

  /**
   * @covers Drupal\dcg_rest\Pincode::getPincode
   */
  public function testGetPincode() {
    $this->assertEmpty($this->pincode->getPincode());
    $this->pincode->setPincode(302021);
    $this->assertNotEmpty($this->pincode->getPincode());
    $this->assertNotEquals(302012, $this->pincode->getPincode());
  }

  /**
   * @covers Drupal\dcg_rest\Pincode::getSampleArray
   */
  public function testGetSampleArray() {
    $sampleArray = $this->pincode->getSampleArray();
    $this->assertArrayHasKey('pincode', $sampleArray);
  }

  /**
   * Function to test class attributes.
   */
  public function testClassAttributes() {
    $this->assertClassHasAttribute('pincode', Pincode::class);
  }

  /**
   * Once test method has finished running, whether it succeeded or failed, tearDown() will be invoked.
   *
   * Unset the $pincode object.
   */
  public function tearDown() {
    unset($this->pincode);
  }

}
