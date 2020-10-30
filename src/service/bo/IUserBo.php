<?php

interface IUserBo
{
  public function selectUserByUserId(int $userId): ?UserModel;

  public function selectUserByEmailAndPassword(string $email, string $password): ?UserModel;

  public function selectUserByEmail(string $email): ?UserModel;

  public function insertUser(UserModel $user): ?int;

  public function updateUser(UserModel $user): bool;

  public function deleteUser(int $userId): bool;
}
