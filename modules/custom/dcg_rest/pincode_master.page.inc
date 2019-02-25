<?php

/**
 * @file
 * Contains pincode_master.page.inc.
 *
 * Page callback for Pincode master entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Pincode master templates.
 *
 * Default template: pincode_master.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_pincode_master(array &$variables) {
  // Fetch PincodeMaster Entity Object.
  $pincode_master = $variables['elements']['#pincode_master'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
