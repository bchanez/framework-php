<?php

use PHPUnit\Framework\TestCase;

$dotenv = Dotenv\Dotenv::createImmutable('.');
$dotenv->load();
include_once 'src/db.php';
include_once 'src/tools.php';

class UserDaoTest extends TestCase
{
  private $dbTampon;

  const FIRST_NAME = 'Francis';
  const LAST_NAME = 'Dupont';
  const BIRTH_DATE = '2000-01-13';
  const EMAIL = 'Francis.Dupont@gmail.com';
  const EMAIL2 = 'Francis.Dupon2@gmail.com';
  const PASSWORD = 'password';

  private $userDao;
  private $user;

  public function allFunctionToTest(): array
  {
    return [
      ['insertUser', 1, new UserModel(), null],
      ['deleteUser', 1, 0, null],
      ['selectUserByEmail', 1, '', null],
      ['selectUserByEmailAndPassword', 2, '', ''],
      ['selectUserByUserId', 1, 0, null],
      ['updateUser', 1, new UserModel(), null],
    ];
  }

  /** @before*/
  public function setUp(): void
  {
    parent::setUp();
    if ($this->dbTampon == null) {
      $this->dbTampon = db();
    }
    App_DaoFactory::setFactory(new App_DaoFactory());
    $this->userDao = App_DaoFactory::getFactory()->getUserDao();
    $this->user = new UserModel();
    $this->user
      ->setFirstName(self::FIRST_NAME)
      ->setLastName(self::LAST_NAME)
      ->setBirthDate(new DateTime(self::BIRTH_DATE))
      ->setEmail(self::EMAIL)
      ->setPassword(self::PASSWORD);

    $this->user2 = new UserModel();
    $this->user2
      ->setFirstName(self::FIRST_NAME)
      ->setLastName(self::LAST_NAME)
      ->setBirthDate(new DateTime(self::BIRTH_DATE))
      ->setEmail(self::EMAIL2)
      ->setPassword(self::PASSWORD);
  }

  /** @after */
  public function tearDown() : void
  {
    parent::tearDown();
    setDb($this->dbTampon);
  }

  /**
   * @test
   * @covers UserDaoImpl
   * @dataProvider allFunctionToTest
   */
  public function dbTest($function, $nbArg, $arg1, $arg2): void
  {
    global $db;
    $db = $this->createPartialMock(PDO::class, ['prepare', 'query']);
    $db->method('prepare')->willThrowException(new PDOException());
    $db->method('query')->willThrowException(new PDOException());

    $this->expectException(BDDException::class);

    switch ($nbArg) {
      case 0:
        $this->userDao->$function();
      break;
      case 1:
        $this->userDao->$function($arg1);
        break;
      case 2:
        $this->userDao->$function($arg1, $arg2);
        break;
      default:
        new Exception('nbArg not write');
    }
  }

  /**
   * @test
   * @covers UserDaoImpl
   */
  public function insertUserTest(): void
  {
    $userId = $this->userDao->insertUser($this->user);

    $this->assertNotNull($userId);
    $this->assertTrue($userId > 0);

    $this->userDao->deleteUser($userId);

    $this->expectException(BDDException::class);
    $userEmpty = new UserModel();
    $this->userDao->insertUser($userEmpty);
  }

  /**
   * @test
   * @covers UserDaoImpl
   */
  public function deleteUserTest(): void
  {
    $userId = $this->userDao->insertUser($this->user);

    $success = $this->userDao->deleteUser($userId);

    $this->assertTrue($success);
    $this->assertTrue($this->userDao->deleteUser(-1));
  }

  /**
   * @test
   * @covers UserDaoImpl
   */
  public function selectUserByEmailTest(): void
  {
    $userId = $this->userDao->insertUser($this->user);

    $userSelected = $this->userDao->selectUserByEmail(self::EMAIL);

    $this->assertNotNull($userSelected);
    $this->assertEquals(self::FIRST_NAME, $userSelected->getFirstName());
    $this->assertEquals(self::LAST_NAME, $userSelected->getLastName());
    $this->assertEquals(new DateTime(self::BIRTH_DATE), $userSelected->getBirthDate());
    $this->assertEquals(self::EMAIL, $userSelected->getEmail());

    $this->userDao->deleteUser($userId);

    $this->assertNull($this->userDao->selectUserByEmail('notAnEmail'));
  }

  /**
   * @test
   * @covers UserDaoImpl
   */
  public function selectUserByEmailAndPasswordTest(): void
  {
    $this->user->setPassword(password_hash($this->user->getPassword(), PASSWORD_DEFAULT));
    $userId = $this->userDao->insertUser($this->user);

    $userSelected = $this->userDao->selectUserByEmailAndPassword(self::EMAIL, self::PASSWORD);

    $this->assertNotNull($userSelected);
    $this->assertEquals(self::FIRST_NAME, $userSelected->getFirstName());
    $this->assertEquals(self::LAST_NAME, $userSelected->getLastName());
    $this->assertEquals(new DateTime(self::BIRTH_DATE), $userSelected->getBirthDate());
    $this->assertEquals(self::EMAIL, $userSelected->getEmail());

    $this->userDao->deleteUser($userId);

    $this->assertNull($this->userDao->selectUserByEmailAndPassword('', ''));
  }

  /**
   * @test
   * @covers UserDaoImpl
   */
  public function selectUserByUserIdTest()
  {
    $userId = $this->userDao->insertUser($this->user);

    $userSelected = $this->userDao->selectUserByUserId($userId);

    $this->assertNotNull($userSelected);
    $this->assertEquals($userId, $userSelected->getId());
    $this->assertEquals(self::FIRST_NAME, $userSelected->getFirstName());
    $this->assertEquals(self::LAST_NAME, $userSelected->getLastName());
    $this->assertEquals(new DateTime(self::BIRTH_DATE), $userSelected->getBirthDate());
    $this->assertEquals(self::EMAIL, $userSelected->getEmail());

    $this->userDao->deleteUser($userId);

    $this->assertNull($this->userDao->selectUserByUserId(-1));
  }

  /**
   * @test
   * @covers UserDaoImpl
   */
  public function updateUserTest()
  {
    $newFirstName = 'Jean';
    $newLastName = 'Claude';
    $newEmail = 'Jean.Claude@gmail.com';
    $userId = $this->userDao->insertUser($this->user);
    $userModified = $this->userDao->selectUserByUserId($userId);
    $userModified->setFirstName($newFirstName);
    $userModified->setLastName($newLastName);
    $userModified->setEmail($newEmail);

    $this->assertTrue($this->userDao->updateUser($userModified));

    $userModifiedSelected = $this->userDao->selectUserByUserId($userModified->getId());
    $this->assertNotNull($userModifiedSelected);
    $this->assertEquals($newFirstName, $userModifiedSelected->getFirstName());
    $this->assertEquals($newLastName, $userModifiedSelected->getLastName());
    $this->assertEquals($newEmail, $userModifiedSelected->getEmail());

    $this->userDao->deleteUser($userModified->getId());

    $userEmpty = new UserModel();
    $this->assertTrue($this->userDao->updateUser($userEmpty));
  }
}
