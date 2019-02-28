<?php

namespace Drupal\Tests\dcg_rest\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\dcg_rest\Plugin\rest\resource\SavePincode;
use Drupal\dcg_rest\Entity\PincodeMaster;

/**
 * Test SavePincode API logic.
 *
 * @group dcg_pincode
 * @coversDefaultClass \Drupal\dcg_rest\Plugin\rest\resource\SavePincode
 */
class SavePincodeTest extends KernelTestBase {

  /**
   * Modules required to run this test.
   *
   * {@inheritdoc}
   */
  public static $modules = ['serialization', 'rest', 'dcg_rest'];

  /**
   * Initialization of required items.
   *
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $container = \Drupal::getContainer();
    $this->serialize = $container->getParameter('serializer.formats');
    $this->rest_log = $container->get('logger.factory')->get('rest');
    // Install pincode_master entity.
    $this->installEntitySchema('pincode_master');
    // Create PincodeMaster entity.
    $this->createPincodeMaster();
  }

  /**
   * Function to test SavePincode api.
   *
   * @covers ::post
   */
  public function testSavePincode() {

    $apiObject = new SavePincode([], [], [], $this->serialize, $this->rest_log);

    // Try to Save only Pincode.
    $request_options = ['pincode' => '121212'];
    $response = $apiObject->post($request_options)->getResponseData();
    // This checks value 'fail' in $response array.
    $this->assertContains('fail', $response);
    // Opposite of assertContains.
    $this->assertNotContains('success', $response);
    // Check if expected value is 'fail' in string.
    $this->assertEquals('fail', $response['status']);

    // Try to save Wrong pincode.
    $request_options = [
      'pincode' => '3020011',
      'city' => 'Jaipur',
      'state' => 'Rajasthan'
    ];
    $response = $apiObject->post($request_options)->getResponseData();
    // Check if expected value is 'fail'.
    $this->assertEquals('fail', $response['status']);
    // Check expected with actual, same type and value.
    $this->assertSame('fail', $response['status']);

    // Try to save Duplicate data.
    $request_options = [
      'pincode' => '121212',
      'city' => 'Gonda',
      'state' => 'Uttar Pradesh',
    ];
    $response = $apiObject->post($request_options)->getResponseData();
    // Check if expected value is 'fail'.
    $this->assertEquals('fail', $response['status']);
    // Check expected with actual, same type and value.
    $this->assertSame('fail', $response['status']);

    // Try to save Correct data.
    $request_options = [
      'pincode' => '302001',
      'city' => 'Jaipur',
      'state' => 'Rajasthan'
    ];
    $response = $apiObject->post($request_options)->getResponseData();
    // Check if expected value is 'success'.
    $this->assertEquals('success', $response['status']);
    // Check expected with actual, same type and value.
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
