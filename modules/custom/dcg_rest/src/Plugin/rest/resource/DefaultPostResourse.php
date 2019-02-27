<?php

namespace Drupal\dcg_rest\Plugin\rest\resource;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\dcg_rest\Entity\PincodeMaster;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "default_post_resourse",
 *   label = @Translation("Default post resourse"),
 *   uri_paths = {
 *     "https://www.drupal.org/link-relations/create" = "/save-pincode-data"
 *   }
 * )
 */

class DefaultPostResourse extends ResourceBase {
  CONST FAILURE = 'fail';
  CONST MISSING_PARAMS = 'Some of the required fields are missing in request.';
  CONST SUCCESS = 'success';
  CONST ALREADY_EXISTS = 'Data already exists.';
  CONST ENTITY_SAVE_ERROR = 'Error in saving entity.';
  CONST PINCODE_LENGTH = 6;
  CONST INVALID_PINCODE = 'Pincode is not valid.';

  /**
   * Constructs a new DefaultPostResourse object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param array $serializer_formats
   *   The available serialization formats.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    array $serializer_formats,
    LoggerInterface $logger) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('dcg_rest')
    );
  }

  /**
   * Responds to POST requests.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity object.
   *
   * @return \Drupal\rest\ModifiedResourceResponse
   *   The HTTP response object.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   *   Throws exception expected.
   */
  public function post($data) {

    $response = [];
    $response['status'] = self::FAILURE;
    // Check for empty request.
    if (empty($data['pincode']) || empty($data['city']) || empty($data['state'])) {
      $response['data'] = self::MISSING_PARAMS;
    }
    elseif (strlen($data['pincode']) != self::PINCODE_LENGTH || !is_numeric($data['pincode'])) {
      $response['data'] = self::INVALID_PINCODE;
    }
    else {
      // Check for already exist.
      $isExist = \Drupal::entityTypeManager()
        ->getStorage('pincode_master')
        ->loadByProperties(['pincode' => $data['pincode']]);
      if ($isExist) {
        $response['data'] = self::ALREADY_EXISTS;
      }else{
        $isSaved = $this->savePincode($data);
        if ($isSaved) {
          $response['status'] = self::SUCCESS;
        }else{
          $response['status'] = self::FAILURE;  
          $response['data'] = self::ENTITY_SAVE_ERROR;
        }
      }        
    }
    return new ModifiedResourceResponse(($response), 200);
  }

  /*
   * Function to save Pincode Entity.
   */
  private function savePincode($data){
      try {
        $pincode = PincodeMaster::create([
        // The pincode_master entity bundle.
          'pincode' => $data['pincode'],
          'created' => REQUEST_TIME,
          'changed' => REQUEST_TIME,
          'city' => $data['city'],
          'state' => $data['state'],
        ]);
        $pincode->save();
        return TRUE;
        }
        catch (\Exception $e) {
          return FALSE;
        } 
  }
}
