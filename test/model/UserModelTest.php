<?php

use PHPUnit\Framework\TestCase;

include_once 'src/tools.php';

class UserModelTest extends TestCase
{
  /**
   * @test
   * @covers UserModel
  */
  public function getterSetterTest()
  {
    $user = new UserModel();
    $id = 0;
    $firstName = 'Francis';
    $lastName = 'Dupont';
    $birthDate = new DateTime('2000-01-13');
    $email = 'Francis.Dupont@gmail.com';
    $password = 'password';
    $isAuthorize = 1;
    $isAdmin = false;

    $user
      ->setId($id)
      ->setFirstName($firstName)
      ->setLastName($lastName)
      ->setBirthDate($birthDate)
      ->setEmail($email)
      ->setPassword($password)
      ->setIsAdmin($isAdmin);

    $this->assertSame($user->getId(), $id);
    $this->assertSame($user->getFirstName(), $firstName);
    $this->assertSame($user->getLastName(), $lastName);
    $this->assertSame($user->getBirthDate(), $birthDate);
    $this->assertSame($user->getEmail(), $email);
    $this->assertSame($user->getPassword(), $password);
    $this->assertSame($user->getIsAdmin(), $isAdmin);
  }
}
