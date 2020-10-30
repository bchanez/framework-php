<?php

class UserDaoImpl implements IUserDao
{
  public function insertUser(UserModel $user): ?int
  {
    $request = 'INSERT INTO User(firstName, lastName, email, password, birthDate) VALUES (?, ?, ?, ?, ?)';

    try {
      $birthDate = ($user->getBirthDate() != null) ? ($user->getBirthDate())->format('Y-m-d') : null;
      $query = db()->prepare($request);
      $query->execute([utf8_decode($user->getFirstName()), utf8_decode($user->getLastName()), utf8_decode($user->getEmail()), $user->getPassword(), $birthDate]);
    } catch (PDOException $Exception) {
      throw new BDDException($Exception->getMessage(), $Exception->getCode());
    }

    return db()->lastInsertId();
  }

  public function updateUser(UserModel $user): bool
  {
    $success = false;
    $request = 'UPDATE User SET firstName = ?, lastName = ?, email = ? WHERE id = ?';

    try {
      $query = db()->prepare($request);
      $success = $query->execute([utf8_decode($user->getFirstName()), utf8_decode($user->getLastName()), utf8_decode($user->getEmail()), $user->getId()]);
    } catch (PDOException $Exception) {
      throw new BDDException($Exception->getMessage(), $Exception->getCode());
    }

    return $success;
  }

  public function deleteUser(int $userId): bool
  {
    $success = false;
    $request = 'DELETE FROM User WHERE id=?';

    try {
      $query = db()->prepare($request);
      $success = $query->execute([$userId]);
    } catch (PDOException $Exception) {
      throw new BDDException($Exception->getMessage(), $Exception->getCode());
    }

    return $success;
  }

  public function selectUserByUserId(int $userId): ?UserModel
  {
    $userSelected = null;
    $request = 'SELECT id, firstName, lastName, email, birthDate, isAdmin FROM User WHERE id=?';

    try {
      $query = db()->prepare($request);
      $query->execute([$userId]);
      $userSelected = $query->fetch();
    } catch (PDOException $Exception) {
      throw new BDDException($Exception->getMessage(), $Exception->getCode());
    }

    $user = null;
    if ($userSelected) {
      $user = new UserModel();
      $user
        ->setId($userSelected['id'])
        ->setFirstName(protectStringToDisplay($userSelected['firstName']))
        ->setLastName(protectStringToDisplay($userSelected['lastName']))
        ->setEmail(protectStringToDisplay($userSelected['email']))
        ->setBirthDate(new DateTime($userSelected['birthDate']))
        ->setIsAdmin($userSelected['isAdmin']);
    }

    return $user;
  }

  public function selectUserByEmailAndPassword(string $email, string $password): ?UserModel
  {
    $firstUser = null;
    $request = 'SELECT id, firstName, lastName, email, birthDate, isAdmin, password FROM User WHERE email=?';

    try {
      $query = db()->prepare($request);
      $query->execute([$email]);
      $firstUser = $query->fetch();
    } catch (PDOException $Exception) {
      throw new BDDException($Exception->getMessage(), $Exception->getCode());
    }

    $user = null;
    if ($firstUser && is_array($firstUser) && password_verify($password, $firstUser['password'])) {
      $user = new UserModel();
      $user
        ->setId($firstUser['id'])
        ->setFirstName(protectStringToDisplay($firstUser['firstName']))
        ->setLastName(protectStringToDisplay($firstUser['lastName']))
        ->setEmail(protectStringToDisplay($firstUser['email']))
        ->setBirthDate(new DateTime($firstUser['birthDate']))
        ->setIsAdmin($firstUser['isAdmin']);
    }

    return $user;
  }

  public function selectUserByEmail(string $email): ?UserModel
  {
    $firstUser = null;
    $request = 'SELECT * FROM User WHERE email=?';

    try {
      $query = db()->prepare($request);
      $query->execute([$email]);
      $firstUser = $query->fetch();
    } catch (PDOException $Exception) {
      throw new BDDException($Exception->getMessage(), $Exception->getCode());
    }

    $user = null;
    if ($firstUser) {
      $user = new UserModel();
      $user
        ->setId($firstUser['id'])
        ->setFirstName(protectStringToDisplay($firstUser['firstName']))
        ->setLastName(protectStringToDisplay($firstUser['lastName']))
        ->setEmail(protectStringToDisplay($firstUser['email']))
        ->setBirthDate(new DateTime($firstUser['birthDate']))
        ->setIsAdmin($firstUser['isAdmin']);
    }

    return $user;
  }
}
