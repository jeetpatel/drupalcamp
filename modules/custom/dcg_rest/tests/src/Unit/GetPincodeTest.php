<?php

namespace Drupal\Tests\dcg_rest\Unit;

use Drupal\Tests\UnitTestCase;
use GuzzleHttp\Client;

/**
 * Get PinCode test.
 *
 * @group dcg_rest_get_pincode
 */
class GetPincodeTest extends UnitTestCase {

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
    $this->http = new Client(['base_uri' => 'http://dcg19.com']);
  }

  /**
   * Test Case to test /getpincode/{pincode} API.
   */
  public function testGetPincode() {
    $response = $this->http->request('GET', '/getpincode/201301');
    // Test Header response status 200.
    $this->assertEquals(200, $response->getStatusCode());

    // Test Header response is in JSON format.
    $contentType = $response->getHeaders()["Content-Type"][0];
    $this->assertEquals("application/json", $contentType);

    // Test city have Noida value.
    $cityObj = json_decode($response->getBody())->{"data"}->city;
    $this->assertRegexp('/Noida/', $cityObj);

    // Test Header response status have success value.
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
