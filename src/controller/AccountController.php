<?php

class AccountController extends Controller
{
  public function index(): array
  {
    $userBo = App_BoFactory::getFactory()->getUserBo();

    $user = $userBo->selectUserByUserId(parameters()['userId']);

    if (isset($user) && $user->getId() > 0) {
      $data['user'] = $user;

      return ['render', 'index', $data];
    }

    return ['redirect', '?r=home'];
  }

  public function edit(): array
  {
    $userBo = App_BoFactory::getFactory()->getUserBo();

    $user = $userBo->selectUserByUserId(parameters()['userId']);

    if (isset($user) && $user->getId() > 0) {
      $data['user'] = $user;

      return ['render', 'edit', $data];
    }

    return ['redirect', '?r=home'];
  }

  public function update(): array
  {
    $userBo = App_BoFactory::getFactory()->getUserBo();

    $user = $userBo->selectUserByUserId(parameters()['userId']);

    if (isset($user) && $user->getId() > 0) {
      $user
        ->setFirstName(parameters()['firstName'])
        ->setLastName(parameters()['lastName'])
        ->setEmail(parameters()['email']);
      $data['user'] = $user;

      $email = filter_var(parameters()['email'], FILTER_VALIDATE_EMAIL);
      if ($email === false) {
        $data['errors']['email'] = 'L\'adresse mail n\'est pas valide';

        return ['render', 'edit', $data];
      } elseif ($email == $user->getEmail() && $userBo->selectUserByEmail($email) !== null) {
        $data['errors']['email'] = 'L\'adresse mail est déjà utilisée par un autre utilisateur';

        return ['render', 'edit', $data];
      }

      $userBo->updateUser($user);

      return ['render', 'index', $data];
    }

    return ['redirect', '?r=home'];
  }
}
