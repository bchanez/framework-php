<?php

class Universe
{
  private static $_instance;
  private static $session;
  private $user;

  public static function getUniverse(): Universe
  {
    if (!self::$_instance) {
      self::$_instance = new self;
      self::init();
    }

    return self::$_instance;
  }

  private static function init()
  {
    $driver = new \Behat\Mink\Driver\GoutteDriver();
    self::$session = new \Behat\Mink\Session($driver);
  }

  public function getSession(): \Behat\Mink\Session
  {
    return self::$session;
  }

  public function getUser(): ?UserModel
  {
    return $this->user;
  }

  public function setUser(?UserModel $user): Universe
  {
    $this->user = $user;

    return $this;
  }
}
