<?php

namespace Drupal\Tests\dcg_rest\Functional;

use Drupal\Core\Url;
use Drupal\Tests\BrowserTestBase;
use Drupal\FunctionalJavascriptTests\DrupalSelenium2Driver;
use Drupal\FunctionalJavascriptTests\WebDriverTestBase;

/**
 * Simple test to ensure that main page loads with module enabled.
 *
 * @group dcg_rest_functional
 */
class LoadTest extends BrowserTestBase {
  protected $minkDefaultDriverClass = DrupalSelenium2Driver::class;
  protected $minkDefaultDriverArgs = [
    'chrome',
    NULL,
    "http://localhost:4445/wd/hub",
  ];

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['dcg_rest', 'user'];

  /**
   * A user with permission to administer site configuration.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $user;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->drupalLogin($this->createUser(['administer site configuration']));
  }

  /**
   * Tests that the home page loads with a 200 response.
   */
  public function testLoad() {
    $this->getSession()->wait(1000);
    $assert_session = $this->assertSession();
    $this->getSession()->wait(1000);
    $this->drupalGet('admin/reports/status');
    $this->getSession()->wait(1000);
    $assert_session->pageTextNotContains('/GENERAL SYSTEM INFORMATION/');
    $this->getSession()->wait(1000);
  }

  /**
   * Tests that the home page loads with a 200 response.
   */
//  public function testLogout() {
//    $this->getSession()->wait(1000);
//    $this->drupalLogout($this->user);
//    $this->getSession()->wait(1000);
//    $this->drupalGet(Url::fromRoute('user.admin_index'));
//    $this->getSession()->wait(1000);
//    $this->assertSession()->statusCodeEquals(403);
//    $this->getSession()->wait(1000);
//  }
}
