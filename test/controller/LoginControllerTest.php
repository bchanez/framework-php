<?php

use PHPUnit\Framework\TestCase;

include_once 'src/tools.php';
include_once 'src/parameters.php';

class LoginControllerTest extends TestCase
{
  /**
   * @test
   * @covers LoginController
   */
  public function indexTest()
  {
    $loginController = new LoginController();
    $data = $loginController->index();

    $this->assertSame('render', $data[0]);
    $this->assertSame('index', $data[1]);
    $this->assertFalse(isset($data[2]));
  }

  /**
   * @test
   * @covers LoginController
   */
  public function loginTestAuthentificationWorks()
  {
    $loginController = new LoginController();
    setParameters(['email' => 'LoginController001@a.fr', 'password' => 'LoginController001']);
    $expectedId = 42;
    $expectedIsAdmin = true;

    $userTest = new UserModel();
    $userTest
      ->setId($expectedId)
      ->setIsAdmin($expectedIsAdmin);

    $userBoMock = $this->createPartialMock(UserBoImpl::class, ['selectUserByEmailAndPassword']);
    $userBoMock->method('selectUserByEmailAndPassword')->willReturn($userTest);

    $app_BoFactoryMock = $this->createPartialMock(App_BoFactory::class, ['getUserBo']);
    $app_BoFactoryMock->method('getUserBo')->willReturn($userBoMock);
    App_BoFactory::setFactory($app_BoFactoryMock);

    $data = $loginController->login();

    $this->assertSame('redirect', $data[0]);
    $this->assertSame('?r=home', $data[1]);
    $this->assertFalse(isset($data[2]));
    $this->assertSame($expectedId, $_SESSION['userId']);
    $this->assertSame($expectedIsAdmin, $_SESSION['isAdmin']);

    unset($_SESSION['userId'], $_SESSION['isAdmin']);
  }

  /**
   * @test
   * @covers LoginController
   */
  public function loginTestAuthentificationNotWorks()
  {
    $loginController = new LoginController();
    setParameters(['email' => 'LoginController001@a.fr', 'password' => 'LoginController001']);

    $userTest = null;

    $userBoMock = $this->createPartialMock(UserBoImpl::class, ['selectUserByEmailAndPassword']);
    $userBoMock->method('selectUserByEmailAndPassword')->willReturn($userTest);

    $app_BoFactoryMock = $this->createPartialMock(App_BoFactory::class, ['getUserBo']);
    $app_BoFactoryMock->method('getUserBo')->willReturn($userBoMock);
    App_BoFactory::setFactory($app_BoFactoryMock);

    $data = $loginController->login();

    $this->assertSame('render', $data[0]);
    $this->assertSame('index', $data[1]);
    $this->assertSame(['errors' => ['wrongIdentifiers' => 'Identifiants incorrects']], $data[2]);
  }
}
