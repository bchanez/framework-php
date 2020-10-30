<?php

function checkUrl($expectedUrl)
{
  $expectedUrl = $_ENV['path'] . $expectedUrl;
  $session = Universe::getUniverse()->getSession();
  $currentUrl = $session->getCurrentUrl();

  if ($session->getStatusCode() !== 200) {
    throw new Exception('status code is not 200');
  }
  if ($currentUrl !== $expectedUrl) {
    throw new Exception('The current url "' . $currentUrl . '" is not the expected one "' . $expectedUrl . '"');
  }
}

function checkUrlPartial($session, $expectedUrl)
{
  $expectedUrl = $_ENV['path'] . $expectedUrl;
  $currentUrl = $session->getCurrentUrl();

  if ($session->getStatusCode() !== 200) {
    throw new Exception('status code is not 200');
  }
  if (strpos($currentUrl, $expectedUrl) === false) {
    throw new Exception('The current url "' . $currentUrl . '" do not contain "' . $expectedUrl . '"');
  }
}

function visiteUrl($url)
{
  $session = Universe::getUniverse()->getSession();
  $session->visit($url);
  if ($session->getStatusCode() !== 200) {
    throw new Exception('Failed to access to the url, please, check the path variable');
  }
}

function connect($session, UserModel $user)
{
  checkUrl('/?r=login');

  $session->getPage()->find(
    'css',
    'input[name="email"]'
  )->setValue($user->getEmail());
  $session->getPage()->find(
    'css',
    'input[name="password"]'
  )->setValue($user->getPassword());

  $session->getPage()->find(
    'css',
    'input[type="submit"]'
  )->click();

  checkUrl('/?r=home');
}

function disconnect()
{
  //todo : find a way to click on the disconnect button
  visiteUrl('/?r=logout');

  checkUrl('/?r=login');
}
