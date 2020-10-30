<?php

class App_BoFactory
{
  private static $_instance;

  public static function setFactory(?App_BoFactory $f)
  {
    self::$_instance = $f;
  }

  public static function getFactory(): App_BoFactory
  {
    if (!self::$_instance) {
      self::$_instance = new self;
    }

    return self::$_instance;
  }

  public function getUserBo(): UserBoImpl
  {
    return new UserBoImpl();
  }
}
