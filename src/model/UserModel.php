<?php

class UserModel
{
  private $id;
  private $firstName;
  private $lastName;
  private $birthDate;
  private $email;
  private $password;
  private $isAdmin;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId($id): UserModel
  {
    $this->id = $id;

    return $this;
  }

  public function getFirstName(): ?String
  {
    return $this->firstName;
  }

  public function setFirstName($firstName): UserModel
  {
    $this->firstName = $firstName;

    return $this;
  }

  public function getLastName(): ?String
  {
    return $this->lastName;
  }

  public function setLastName($lastName): UserModel
  {
    $this->lastName = $lastName;

    return $this;
  }

  public function getBirthDate(): ?DateTime
  {
    return $this->birthDate;
  }

  public function setBirthDate(?DateTime $birthDate): UserModel
  {
    $this->birthDate = $birthDate;

    return $this;
  }

  public function getEmail(): ?String
  {
    return $this->email;
  }

  public function setEmail($email): UserModel
  {
    $this->email = $email;

    return $this;
  }

  public function getPassword(): ?String
  {
    return $this->password;
  }

  public function setPassword($password): UserModel
  {
    $this->password = $password;

    return $this;
  }

  public function getIsAdmin(): ?bool
  {
    return $this->isAdmin;
  }

  public function setIsAdmin($isAdmin): UserModel
  {
    $this->isAdmin = $isAdmin;

    return $this;
  }
}
