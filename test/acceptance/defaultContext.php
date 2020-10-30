<?php

use Behat\Behat\Context\Context;

$dotenv = Dotenv\Dotenv::createImmutable('.');
$dotenv->load();
include_once 'src/db.php';
include_once 'src/tools.php';

/**
 * Defines application features from the specific context.
 */
class defaultContext implements Context
{
  /**
   * Initializes context.
   *
   * Every scenario gets its own context instance.
   * You can also pass arbitrary arguments to the
   * context constructor through behat.yml.
   */
  public function __construct()
  {
    Universe::getUniverse()->getSession()->restart();
  }

  public function __destruct()
  {
    $this->deleteUsersUniverse();
    Universe::getUniverse()->setUser(null);
  }

  private function deleteUsersUniverse()
  {
    $userBo = App_BoFactory::getFactory()->getUserBo();

    $users = [Universe::getUniverse()->getUser()];
    foreach ($users as $user) {
      if ($user != null) {
        $user = $userBo->selectUserByEmail($user->getEmail());
        if ($user != null && !$user->getIsAdmin()) {
          $userBo->deleteUser($user->getId());
        }
      }
    }
  }
}
