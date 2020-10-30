<?php

use PHPUnit\Framework\TestCase;

include_once 'src/tools.php';
include_once 'src/parameters.php';

class AccountControllerTest extends TestCase
{
  /**
   * @test
   * @covers AccountController
   */
  public function indexTestUserExist()
  {
    $accountController = new AccountController();
    setParameters(['userId' => 1]);

    $userTest = new UserModel();
    $userTest->setId(parameters()['userId']);

    $userBoMock = $this->createPartialMock(UserBoImpl::class, ['selectUserByUserId']);
    $userBoMock->method('selectUserByUserId')->willReturn($userTest);

    $app_BoFactoryMock = $this->createPartialMock(App_BoFactory::class, ['getUserBo']);
    $app_BoFactoryMock->method('getUserBo')->willReturn($userBoMock);
    App_BoFactory::setFactory($app_BoFactoryMock);

    $data = $accountController->index();

    $this->assertSame('render', $data[0]);
    $this->assertSame('index', $data[1]);
    $this->assertSame(parameters()['userId'], $data[2]['user']->getId());
  }

  /**
   * @test
   * @covers AccountController
   */
  public function indexTestUserNotExist()
  {
    $accountController = new AccountController();
    setParameters(['userId' => 2]);

    $userTest = null;

    $userBoMock = $this->createPartialMock(UserBoImpl::class, ['selectUserByUserId']);
    $userBoMock->method('selectUserByUserId')->willReturn($userTest);

    $app_BoFactoryMock = $this->createPartialMock(App_BoFactory::class, ['getUserBo']);
    $app_BoFactoryMock->method('getUserBo')->willReturn($userBoMock);
    App_BoFactory::setFactory($app_BoFactoryMock);

    $data = $accountController->index();

    $this->assertSame('redirect', $data[0]);
    $this->assertSame('?r=home', $data[1]);
    $this->assertFalse(isset($data[2]));
  }

  /**
   * @test
   * @covers AccountController
   */
  public function editTestUserExist()
  {
    $accountController = new AccountController();
    setParameters(['userId' => 3]);

    $userTest = new UserModel();
    $userTest->setId(parameters()['userId']);

    $userBoMock = $this->createPartialMock(UserBoImpl::class, ['selectUserByUserId']);
    $userBoMock->method('selectUserByUserId')->willReturn($userTest);

    $app_BoFactoryMock = $this->createPartialMock(App_BoFactory::class, ['getUserBo']);
    $app_BoFactoryMock->method('getUserBo')->willReturn($userBoMock);
    App_BoFactory::setFactory($app_BoFactoryMock);

    $data = $accountController->edit();

    $this->assertSame('render', $data[0]);
    $this->assertSame('edit', $data[1]);
    $this->assertSame(parameters()['userId'], $data[2]['user']->getId());
  }

  /**
   * @test
   * @covers AccountController
   */
  public function editTestUserNotExist()
  {
    $accountController = new AccountController();
    setParameters(['userId' => '4']);

    $userTest = null;

    $userBoMock = $this->createPartialMock(UserBoImpl::class, ['selectUserByUserId']);
    $userBoMock->method('selectUserByUserId')->willReturn($userTest);

    $app_BoFactoryMock = $this->createPartialMock(App_BoFactory::class, ['getUserBo']);
    $app_BoFactoryMock->method('getUserBo')->willReturn($userBoMock);
    App_BoFactory::setFactory($app_BoFactoryMock);

    $data = $accountController->edit();

    $this->assertSame('redirect', $data[0]);
    $this->assertSame('?r=home', $data[1]);
    $this->assertFalse(isset($data[2]));
  }

  /**
   * @test
   * @covers AccountController
   */
  public function updateTestUserNotExist()
  {
    $accountController = new AccountController();
    setParameters(['userId' => '5', 'firstName' => 'indexTest005', 'lastName' => 'indexTest005', 'email' => 'indexTest005']);

    $userTest = null;

    $userBoMock = $this->createPartialMock(UserBoImpl::class, ['selectUserByUserId']);
    $userBoMock->method('selectUserByUserId')->willReturn($userTest);

    $app_BoFactoryMock = $this->createPartialMock(App_BoFactory::class, ['getUserBo']);
    $app_BoFactoryMock->method('getUserBo')->willReturn($userBoMock);
    App_BoFactory::setFactory($app_BoFactoryMock);

    $data = $accountController->update();

    $this->assertSame('redirect', $data[0]);
    $this->assertSame('?r=home', $data[1]);
    $this->assertFalse(isset($data[2]));
  }

  /**
   * @test
   * @covers AccountController
   */
  public function updateTestUserExistNotAnEmailValide()
  {
    $accountController = new AccountController();
    setParameters(['userId' => '6', 'firstName' => 'indexTest006', 'lastName' => 'indexTest006', 'email' => 'indexTest006']);

    $userTest = new UserModel();
    $userTest->setId(parameters()['userId']);

    $userBoMock = $this->createPartialMock(UserBoImpl::class, ['selectUserByUserId']);
    $userBoMock->method('selectUserByUserId')->willReturn($userTest);

    $app_BoFactoryMock = $this->createPartialMock(App_BoFactory::class, ['getUserBo']);
    $app_BoFactoryMock->method('getUserBo')->willReturn($userBoMock);
    App_BoFactory::setFactory($app_BoFactoryMock);

    $data = $accountController->update();

    $this->assertSame('render', $data[0]);
    $this->assertSame('edit', $data[1]);
    $this->assertSame([
      'user' => $userTest
        ->setFirstName(parameters()['firstName'])
        ->setLastName(parameters()['lastName'])
        ->setEmail(parameters()['email']),
      'errors' => ['email' => 'L\'adresse mail n\'est pas valide']
    ], $data[2]);
  }

  /**
   * @test
   * @covers AccountController
   */
  public function updateTestUserExistEmailAlreadyUse()
  {
    $accountController = new AccountController();
    setParameters(['userId' => '7', 'firstName' => 'indexTest007', 'lastName' => 'indexTest007', 'email' => 'indexTest007@a.fr']);

    $userTest = new UserModel();
    $userTest->setId(parameters()['userId']);

    $userBoMock = $this->createPartialMock(UserBoImpl::class, ['selectUserByUserId', 'selectUserByEmail']);
    $userBoMock->method('selectUserByUserId')->willReturn($userTest);
    $userBoMock->method('selectUserByEmail')->willReturn(new UserModel());

    $app_BoFactoryMock = $this->createPartialMock(App_BoFactory::class, ['getUserBo']);
    $app_BoFactoryMock->method('getUserBo')->willReturn($userBoMock);
    App_BoFactory::setFactory($app_BoFactoryMock);

    $data = $accountController->update();

    $this->assertSame('render', $data[0]);
    $this->assertSame('edit', $data[1]);
    $this->assertSame([
      'user' => $userTest
        ->setFirstName(parameters()['firstName'])
        ->setLastName(parameters()['lastName'])
        ->setEmail(parameters()['email']),
      'errors' => ['email' => 'L\'adresse mail est déjà utilisée par un autre utilisateur']
    ], $data[2]);
  }

  /**
   * @test
   * @covers AccountController
   */
  public function updateTestUserExistEmailNotAlreadyUse()
  {
    $accountController = new AccountController();
    setParameters(['userId' => '7', 'firstName' => 'indexTest007', 'lastName' => 'indexTest007', 'email' => 'indexTest007@a.fr']);

    $userTest = new UserModel();
    $userTest->setId(parameters()['userId']);

    $userBoMock = $this->createPartialMock(UserBoImpl::class, ['selectUserByUserId', 'selectUserByEmail', 'updateUser']);
    $userBoMock->method('selectUserByUserId')->willReturn($userTest);
    $userBoMock->method('selectUserByEmail')->willReturn(null);
    $userBoMock->method('updateUser')->willReturn(true);

    $app_BoFactoryMock = $this->createPartialMock(App_BoFactory::class, ['getUserBo']);
    $app_BoFactoryMock->method('getUserBo')->willReturn($userBoMock);
    App_BoFactory::setFactory($app_BoFactoryMock);

    $data = $accountController->update();

    $this->assertSame('render', $data[0]);
    $this->assertSame('index', $data[1]);
    $this->assertSame([
      'user' => $userTest
        ->setFirstName(parameters()['firstName'])
        ->setLastName(parameters()['lastName'])
        ->setEmail(parameters()['email']),
    ], $data[2]);
  }
}
