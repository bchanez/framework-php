<?php

use PHPUnit\Framework\TestCase;

include_once 'src/tools.php';
include_once 'src/parameters.php';

class RegistrationControllerTest extends TestCase
{
  /**
   * @test
   * @covers RegistrationController
   */
  public function indexTest()
  {
    $registrationController = new RegistrationController();

    $data = $registrationController->index();

    $this->assertSame('render', $data[0]);
    $this->assertSame('index', $data[1]);
    $this->assertFalse(isset($data[2]));
  }

  /**
   * @test
   * @covers RegistrationController
   */
  public function registerTestWithValidForm()
  {
    $registrationController = new RegistrationController();
    setParameters([
      'firstName' => 'registerTest001',
      'lastName'  => 'registerTest001',
      'birthDate' => '01/01/1990',
      'email'     => 'registerTest001@a.fr',
      'password'  => 'registerTest001'
    ]);

    $userBoMock = $this->createPartialMock(UserBoImpl::class, ['selectUserByEmail', 'insertUser']);
    $userBoMock->method('selectUserByEmail')->willReturn(null);
    $userBoMock->method('insertUser')->willReturn(1);

    $app_BoFactoryMock = $this->createPartialMock(App_BoFactory::class, ['getUserBo']);
    $app_BoFactoryMock->method('getUserBo')->willReturn($userBoMock);
    App_BoFactory::setFactory($app_BoFactoryMock);

    $data = $registrationController->register();

    $this->assertSame('redirect', $data[0]);
    $this->assertSame('?r=login', $data[1]);
    $this->assertFalse(isset($data[2]));
  }

  /**
   * @test
   * @covers RegistrationController
   */
  public function registerTestWithEmailAlreadyUse()
  {
    $registrationController = new RegistrationController();
    setParameters([
      'firstName' => 'registerTest002',
      'lastName'  => 'registerTest002',
      'birthDate' => '01/01/1990',
      'email'     => 'registerTest002@a.fr',
      'password'  => 'registerTest002'
    ]);

    $userBoMock = $this->createPartialMock(UserBoImpl::class, ['selectUserByEmail']);
    $userBoMock->method('selectUserByEmail')->willReturn(new UserModel());

    $app_BoFactoryMock = $this->createPartialMock(App_BoFactory::class, ['getUserBo']);
    $app_BoFactoryMock->method('getUserBo')->willReturn($userBoMock);
    App_BoFactory::setFactory($app_BoFactoryMock);

    $data = $registrationController->register();

    $this->assertSame('render', $data[0]);
    $this->assertSame('index', $data[1]);
    $this->assertSame([
      'values' => [
        'firstName' => parameters()['firstName'],
        'lastName'  => parameters()['lastName'],
        'birthDate' => parameters()['birthDate'],
        'email'     => parameters()['email'],
        'password'  => parameters()['password']
      ],
      'errors' => [
        'email' => 'L\'adresse mail est déjà utilisée par un autre utilisateur'
      ]
    ], $data[2]);
  }

  /**
   * @test
   * @covers RegistrationController
   */
  public function registerTestWithinvalidForm()
  {
    $registrationController = new RegistrationController();
    setParameters([
      'firstName' => 'registerTest003TooLong...........',
      'lastName'  => 'registerTest003tooLong............',
      'birthDate' => '01/01/199',
      'email'     => 'registerTest003',
      'password'  => '003'
    ]);

    $userBoMock = $this->createPartialMock(UserBoImpl::class, []);
    $app_BoFactoryMock = $this->createPartialMock(App_BoFactory::class, ['getUserBo']);
    $app_BoFactoryMock->method('getUserBo')->willReturn($userBoMock);
    App_BoFactory::setFactory($app_BoFactoryMock);

    $data = $registrationController->register();

    $this->assertSame('render', $data[0]);
    $this->assertSame('index', $data[1]);
    $this->assertSame([
      'values' => [
        'firstName' => parameters()['firstName'],
        'lastName'  => parameters()['lastName'],
        'birthDate' => parameters()['birthDate'],
        'email'     => false,
        'password'  => parameters()['password']
      ],
      'errors' => [
        'firstName' => 'Le prénom n\'est pas valide',
        'lastName'  => 'Le nom n\'est pas valide',
        'birthDate' => 'La date de naissance n\'est pas valide',
        'email'     => 'L\'adresse mail n\'est pas valide',
        'password'  => 'Le mot de passe doit contenir au moins 8 caractères'
      ]
    ], $data[2]);
  }
}
