<?php

namespace Drupal\dcg_rest\Controller;

use Drupal\Core\Controller\ControllerBase;
use Aws\DynamoDb\DynamoDbClient;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   */
  public function hello($name) {
    var_dump(drupal_get_path('vendor', 'asm89'));
    die();
    phpinfo();die;
$sdk = new \Aws\Sdk([
    'profile' => 'default',
    'region'   => 'us-west-2',
    'version'  => 'latest',
    'endpoint' => 'http://localhost:8000'
]);    
$dynamodb = $sdk->createDynamoDb();   
$result = $dynamodb->describeTable(array(
    'TableName' => 'Dynamotable'
));
print_r($result);die;
//$client = new DynamoDbClient([
//    'profile' => 'default',
//    'region'  => 'us-east-1',
//    'version' => 'latest'
//]);
//
//$result = $client->describeTable(array(
//    'TableName' => 'Dynamotable'
//));

echo $result;
    die;
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: hello with parameter(s): $name'),
    ];
  }

}
