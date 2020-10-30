<?php

class RegistrationController extends Controller
{
  public function index(): array
  {
    return ['render', 'index'];
  }

  public function register(): array
  {
    $userBo = App_BoFactory::getFactory()->getUserBo();

    $data['values']['firstName'] = filter_var(parameters()['firstName']);
    $data['values']['lastName'] = filter_var(parameters()['lastName']);
    $data['values']['birthDate'] = filter_var(parameters()['birthDate']);
    $data['values']['email'] = filter_var(parameters()['email'], FILTER_VALIDATE_EMAIL);
    $data['values']['password'] = filter_var(parameters()['password'], FILTER_UNSAFE_RAW);

    if ($data['values']['firstName'] && strlen($data['values']['firstName']) > 29) {
      $data['errors']['firstName'] = 'Le prénom n\'est pas valide';
    }
    if ($data['values']['lastName'] && strlen($data['values']['lastName']) > 29) {
      $data['errors']['lastName'] = 'Le nom n\'est pas valide';
    }
    if (
      !(preg_match('#^(\d{2})/(\d{2})/(\d{4})$#', $data['values']['birthDate'], $matches)
        && checkdate($matches[2], $matches[1], $matches[3]))
    ) {
      $data['errors']['birthDate'] = 'La date de naissance n\'est pas valide';
    }
    if ($data['values']['email'] === false) {
      $data['errors']['email'] = 'L\'adresse mail n\'est pas valide';
    }
    if ($data['values']['password'] && strlen($data['values']['password']) < 8) {
      $data['errors']['password'] = 'Le mot de passe doit contenir au moins 8 caractères';
    }

    if (isset($data['errors'])) {
      return ['render', 'index', $data];
    }

    if ($userBo->selectUserByEmail($data['values']['email']) !== null) {
      $data['errors']['email'] = 'L\'adresse mail est déjà utilisée par un autre utilisateur';

      return ['render', 'index', $data];
    }

    $user = new UserModel();
    $user
      ->setFirstName($data['values']['firstName'])
      ->setLastName($data['values']['lastName'])
      ->setBirthDate(new DateTime($data['values']['birthDate']))
      ->setEmail($data['values']['email'])
      ->setPassword($data['values']['password']);
    $userBo->insertUser($user);

    return ['redirect', '?r=login'];
  }
}
