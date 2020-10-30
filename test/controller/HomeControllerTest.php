<?php

use PHPUnit\Framework\TestCase;

include_once 'src/tools.php';
include_once 'src/parameters.php';

class HomeControllerTest extends TestCase
{
  /**
   * @test
   * @covers HomeController
   */
  public function indexTest()
  {
    $homeController = new HomeController();

    $data = $homeController->index();

    $this->assertSame('render', $data[0]);
    $this->assertSame('index', $data[1]);
    $this->assertFalse(isset($data[2]));
  }
}
