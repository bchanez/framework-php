<?php

class UserBoImpl implements IUserBo
{
  public function selectUserByUserId(int $auctionId): ?UserModel
  {
    $userDao = App_DaoFactory::getFactory()->getUserDao();

    return $userDao->selectUserByUserId($auctionId);
  }

  public function selectUserByEmailAndPassword(string $email, string $password): ?UserModel
  {
    $userDao = App_DaoFactory::getFactory()->getUserDao();

    return $userDao->selectUserByEmailAndPassword($email, $password);
  }

  public function selectUserByEmail(string $email): ?UserModel
  {
    $userDao = App_DaoFactory::getFactory()->getUserDao();

    return $userDao->selectUserByEmail($email);
  }

  public function insertUser(UserModel $user): ?int
  {
    $userDao = App_DaoFactory::getFactory()->getUserDao();

    $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));

    return $userDao->insertUser($user);
  }

  public function updateUser(UserModel $user): bool
  {
    $userDao = App_DaoFactory::getFactory()->getUserDao();

    return $userDao->updateUser($user);
  }

  public function deleteUser(int $userId): bool
  {
    $userDao = App_DaoFactory::getFactory()->getUserDao();

    if ($userId != 1) {
      $success = $userDao->deleteUser($userId);
    }

    return $success;
  }
}
