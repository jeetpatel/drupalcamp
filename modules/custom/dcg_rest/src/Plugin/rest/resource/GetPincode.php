<?php

namespace Drupal\dcg_rest\Plugin\rest\resource;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Provides a resource to get Pincode data from entity.
 *
 * @RestResource(
 *   id = "dcg_rest_get_pincode",
 *   label = @Translation("Get Pincode"),
 *   uri_paths = {
 *     "canonical" = "/getpincode/{pincode}"
 *   }
 * )
 */
class GetPincode extends ResourceBase {
  const FAILURE = 'fail';
  const SUCCESS = 'success';
  const NOT_EXISTS = 'Data not exists.';
  /**
   * A current user instance.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructs a new DefaultGetResourse object.
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
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   A current user instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    array $serializer_formats,
    LoggerInterface $logger,
    AccountProxyInterface $current_user) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);

    $this->currentUser = $current_user;
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
      $container->get('logger.factory')->get('dcg_rest'),
      $container->get('current_user')
    );
  }

  /**
   * Responds to GET requests.
   *
   * @param string $pincode
   *   The pincode.
   *
   * @return \Drupal\rest\ResourceResponse
   *   The HTTP response object.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   *   Throws exception expected.
   */
  public function get($pincode) {
    // You must to implement the logic of your REST Resource here.
    // Use current user after pass authentication to validate access.
    if (!$this->currentUser->hasPermission('access content')) {
      throw new AccessDeniedHttpException();
    }
    $response = [];
    $isExist = \Drupal::entityTypeManager()
      ->getStorage('pincode_master')
      ->loadByProperties(['pincode' => $pincode]);
    if ($isExist) {
      $city = reset($isExist)->get('city')->value;
      $state = reset($isExist)->get('state')->value;
      $response['status'] = self::SUCCESS;
      $response['data'] = ['state' => $state, 'city' => $city];
    }
    else {
      $response['status'] = self::FAILURE;
      $response['data'] = self::NOT_EXISTS;
    }
    return new ResourceResponse($response, 200);
  }

}
