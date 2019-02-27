<?php

namespace Drupal\Tests\dcg_rest\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\dcg_rest\Plugin\rest\resource\DefaultPostResourse;
use Drupal\dcg_rest\Entity\PincodeMaster;

/**
 * Test ValidatePincode API logic.
 *
 * @group dcg_pincode
 * @coversDefaultClass \Drupal\dcg_rest\Plugin\rest\resource\DefaultPostResourse
 */
class ValidatePincodeTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['serialization', 'rest', 'dcg_rest'];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $container = \Drupal::getContainer();
    $this->serialize = $container->getParameter('serializer.formats');
    $this->rest_log = $container->get('logger.factory')->get('rest');
    $this->installConfig('dcg_rest');
    $this->installEntitySchema('pincode_master');
    // Create PincodeMaster entity.
    $this->createPincodeMaster();
  }

  /**
   * @covers ::post
   */
  public function testValidatePincode() {

    $apiObject = new DefaultPostResourse([], [], [], $this->serialize, $this->rest_log);

    // Only Pincode.
    $request_options = ['pincode' => '121212'];
    $response = $apiObject->post($request_options)->getResponseData();
    // Check if 'fail' exists in response array.
    $this->assertContains('fail', $response);
    // Opposite of assertContains.
    $this->assertNotContains('pass', $response);
    // Check if expected value is 'fail'.
    $this->assertEquals('fail', $response['status']);

    // Wrong pincode.
    $request_options = [
      'pincode' => '3020011',
      'city' => 'Jaipur',
      'state' => 'Rajasthan'
    ];
    $response = $apiObject->post($request_options)->getResponseData();
    // Check if expected value is 'fail'.
    $this->assertEquals('fail', $response['status']);
    // Check expected with actual, case matching.
    $this->assertSame('fail', $response['status']);

    // Correct data.
    $request_options = [
      'pincode' => '302001',
      'city' => 'Jaipur',
      'state' => 'Rajasthan'
    ];
    $response = $apiObject->post($request_options)->getResponseData();
    // Check if expected value is 'success'.
    $this->assertEquals('success', $response['status']);
    // Check expected with actual, case matching.
    $this->assertSame('success', $response['status']);
  }

  /**
   * Creates PincodeMaster entity entry.
   */
  protected function createPincodeMaster() {
    $pincode_master_entity = PincodeMaster::create([
      'pincode' => '121212',
      'city' => 'Gonda',
      'state' => 'Uttar Pradesh',
    ]);
    $pincode_master_entity->save();
  }

}
