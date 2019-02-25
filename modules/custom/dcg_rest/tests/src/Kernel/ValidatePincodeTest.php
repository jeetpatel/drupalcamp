<?php

namespace Drupal\Tests\tatasky_pincode\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\tatasky_pincode\Plugin\rest\resource\ValidatePincode;

/**
 * Test ValidatePincode API logic.
 *
 * @group dcg_pincode
 * @coversDefaultClass \Drupal\tatasky_pincode\Plugin\rest\resource\ValidatePincode
 */
class ValidatePincodeTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['tatasky_pincode'];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $this->installConfig('tatasky_pincode');
    $this->installEntitySchema('pincode_master');
  }

  /**
   * @covers ::post
   */
  public function testValidatePincode() {

    $apiObject = new ValidatePincode([], [], [], $this->serialize, $this->rest_log);
    // Create PincodeMaster entity.
    $this->createPincodeMaster();
    // Correct Pincode.
    $request_options = ['pincode' => '121212'];
    $this->doTestAssert($apiObject, $request_options, 'SUCCESS');

    // Wrong Pincode (string).
    $request_options = ['pincode' => 'abcdefs'];
    $this->doTestAssert($apiObject, $request_options, 'FAIL');

    // Wrong Pincode (length).
    $request_options = ['pincode' => '201301234'];
    $this->doTestAssert($apiObject, $request_options, 'FAIL');

    // Wrong Pincode (not exist).
    $request_options = ['pincode' => '121111'];
    $this->doTestAssert($apiObject, $request_options, 'FAIL');

    // Wrong Pincode (empty).
    $request_options = ['pincode' => ''];
    $this->doTestAssert($apiObject, $request_options, 'FAIL');
  }

}
