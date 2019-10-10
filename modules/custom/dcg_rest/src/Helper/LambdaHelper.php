<?php

namespace Drupal\dcg_rest\Helper;

use Aws\Lambda\LambdaClient;

/**
 * Class LambdaHelper.
 *
 * @package Drupal\dcg_rest\Helper\LambdaHelper
 */
class LambdaHelper {

  /**
   * Hold class object.
   *
   * @var object
   */
  private static $instance;

  /**
   * Class instance.
   *
   * @staticvar object $inst
   *    Instance object.
   *
   * @return object
   *   Return instance.
   */
  public static function instance() {
    if (!isset(self::$instance)) {
      self::$instance = new LambdaHelper();
    }
    return self::$instance;
  }

  /**
   * Initiate account retry.
   *
   * @param string $message
   *   Message string.
   *
   * @return Symfony\Component\HttpFoundation\JsonResponse
   *   Return data as TRUE or FALSE.
   */
  public function pushMessage($message) {
    try {
      if ($message) {
        $client = LambdaClient::factory(
          [
            'version' => 'latest',
            'region' => 'ap-south-1',
          ]
        );
        // If success.
        if ($client && $client->invoke([
          'FunctionName' => 'function:' . getenv('LAMBDA_ACCOUNT_RETRY'),
          'Payload' => json_encode(['message' => $message]),
        ])) {
          return TRUE;
        }

      }
    }
    catch (\Exception $e) {
      drupal_set_message($e->getMessage(), 'status', TRUE);
    }
    return FALSE;
  }

}
