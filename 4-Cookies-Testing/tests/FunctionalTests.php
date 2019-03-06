<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use Behat\Mink\Element\DocumentElement;
use Behat\Mink\Element\NodeElement;

require_once 'vendor/autoload.php';

/**
 * Class contains all functional tests for this web application.
 *
 */
class FunctionalTests extends TestCase {
  /* Change this to suite your server setup */
  protected $baseUrl = "http://localhost/imt2291/uke4_lab/index.php";
  protected $session;

  /**
   * Initiates the testing session, this is done before each test.
   * Starts a new session.
   */
  protected function setup() {
    $driver = new \Behat\Mink\Driver\GoutteDriver();
    $this->session = new \Behat\Mink\Session($driver);
    $this->session->start();
  }

  /**
   * Check that we get the right initial page (not logged in)
   */
  public function testInitialPage() {
    $this->session->visit($this->baseUrl);
    $page = $this->session->getPage();

    $this->assertInstanceOf(
                           NodeElement::Class,
                           $page->find('css', 'p'),
                           'Should have a p tag in this page'
                         );
    $this->assertEquals('Ikke logget inn', $page->find('css', 'p')->getText(),
                        'Wrong text in paragraph');
  }

  /**
   * Get default page, submit the login form, check that we get the
   * logged in page, then reload the page and check that we are still
   * logged in.
   */
  public function testCanLogIn() {
    $this->session->visit($this->baseUrl);
    $page = $this->session->getPage();

    // Logging in
    $form = $page->find('css', '#login');
    $this->assertInstanceOf(NodeElement::Class, $form, 'Unable to locate login form');
    $form->submit();

    $page = $this->session->getPage();

    // Check that we are logged in
    $this->assertInstanceOf(
                           NodeElement::Class,
                           $page->find('css', 'h1'),
                           'Should have a h1 tag in this page'
                         );
    $this->assertEquals('Hemmelig', $page->find('css', 'h1')->getText(),
                        'The secret message is wrong');

    // Reload the page
    $this->session->visit($this->baseUrl);
    $page = $this->session->getPage();

    // Check that we are still logged in
    $this->assertInstanceOf(
                           NodeElement::Class,
                           $page->find('css', 'h1'),
                           'Logged out after reload'
                         );
    $this->assertEquals('Hemmelig', $page->find('css', 'h1')->getText(),
                        'The secret message is wrong after page reload');
  }

  /**
   * Test that we can log out, also that we stay logged out when
   * page is reloaded.
   */
  public function testCanLogOut() {
    $this->session->visit($this->baseUrl);
    $page = $this->session->getPage();

    // Logg in
    $form = $page->find('css', '#login');
    $this->assertInstanceOf(NodeElement::Class, $form, 'Unable to locate login form');
    $form->submit();

    $page = $this->session->getPage();

    // Logg out
    $form = $page->find('css', '#logout');
    $this->assertInstanceOf(NodeElement::Class, $form, 'Unable to locate logout form');
    $form->submit();

    // Check that we are logged out
    $this->assertInstanceOf(
                           NodeElement::Class,
                           $page->find('css', 'p'),
                           'Should have a paragraph in this page'
                         );
    $this->assertEquals('Ikke logget inn', $page->find('css', 'p')->getText(),
                        'Wrong text in paragraph after logging out');

    // Relaod the page, should still be logged out
    $this->session->visit($this->baseUrl);
    $page = $this->session->getPage();

    $this->assertInstanceOf(
                           NodeElement::Class,
                           $page->find('css', 'p'),
                           'Logging out and reloading yields wrong result'
                         );
    $this->assertEquals('Ikke logget inn', $page->find('css', 'p')->getText(),
                        'Wrong text in paragraph after logging out and reloading page');
  }
}
