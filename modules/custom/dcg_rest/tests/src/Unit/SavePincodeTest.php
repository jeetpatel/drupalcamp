<?php

namespace Drupal\Tests\dcg_rest\Unit;

use Drupal\Tests\UnitTestCase;
use GuzzleHttp\Client;

/**
 * Get PinCode test.
 *
 * @group dcg_rest_save_pincode
 */
class SavePincodeTest extends UnitTestCase {

  private $http;

  /**
   * PinCode variable.
   *
   * @var pincode
   */
  protected $pincode;

  /**
   * Before every test method is run, setUp() is invoked.
   *
   * Create new GuzzleHttp client object.
   */
  public function setUp() {
    $this->http = new Client(['base_uri' => 'http://localdrupalcamp.com']);
  }

  /**
   * Test Case to test /save-pincode-data API.
   */
  public function testSavePincode() {
    $params = [
      'pincode' => '302001',
      'city' => 'Jaipur',
      'state' => 'Rajasthan',
    ];
    $response = $this->http->request('POST', '/save-pincode-data', [
      'headers' => [
        'content-type' => 'application/json',
      ],
      'body' => json_encode($params),
    ]);
    // Test Header response status 200.
    $this->assertEquals(200, $response->getStatusCode());

    // Test Header response is in JSON format.
    $contentType = $response->getHeaders()["Content-Type"][0];
    $this->assertEquals("application/json", $contentType);

    // Test Header response status have 'success' value.
    $statusObj = json_decode($response->getBody())->{"status"};
    $this->assertRegexp('/success/', $statusObj);
  }

  /**
   * Clear created object on setUp().
   */
  public function tearDown() {
    $this->http = NULL;
  }

}
