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
    $this->http = new Client(['base_uri' => 'http://localdrupalcamp.com']);
  }

  /**
   * Test Case to test /getpincode/{pincode} API.
   */
  public function testGetPincode() {
    $response = $this->http->request('GET', '/getpincode/302001');
    // Test Header response status 200.
    $this->assertEquals(200, $response->getStatusCode());

    // Test Header response is in JSON format.
    $contentType = $response->getHeaders()["Content-Type"][0];
    $this->assertEquals("application/json", $contentType);

    // Test city have Jaipur value.
    $city = 'test';
    $responseBody = json_decode($response->getBody());
    if ($responseBody && (isset($responseBody->data->city))) {
      $city = $responseBody->data->city;
    }
    $this->assertRegexp('/Jaipur/', $city);

    // Test Header response status have success value.
    $this->assertRegexp('/success/', $responseBody->status);
  }

  /**
   * Clear created object on setUp().
   */
  public function tearDown() {
    $this->http = NULL;
  }

}
