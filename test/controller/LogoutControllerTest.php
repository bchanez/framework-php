<?php

use PHPUnit\Framework\TestCase;

session_start();
include_once 'src/tools.php';
include_once 'src/parameters.php';

class LogoutControllerTest extends TestCase
{
  /**
   * @test
   * @covers LogoutController
   */
  public function indexTest()
  {
    $logoutController = new LogoutController();

    $data = $logoutController->index();

    $this->assertSame('redirect', $data[0]);
    $this->assertSame('?r=login', $data[1]);
    $this->assertFalse(isset($data[2]));
    $this->assertTrue(isset($_SESSION));
  }
}
