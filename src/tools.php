<?php

function my_autoloader($name)
{
  $dir = '';
  if (stripos($name, 'Model') !== false) {
    $dir = 'model';
  } elseif (stripos($name, 'Controller') !== false) {
    $dir = 'controller';
  } elseif (stripos($name, 'Bo') !== false) {
    $dir = 'service/bo';
  } elseif (stripos($name, 'Dao') !== false) {
    $dir = 'service/dao';
  } elseif (stripos($name, 'Exception') !== false) {
    $dir = 'exception';
  }

  if (file_exists('src/' . $dir . '/' . $name . '.php')) {
    include_once $dir . '/' . $name . '.php';
  } else {
    if (isset($_SESSION['userId'])) {
      header('Location: ?r=home');
    } else {
      header('Location: ?r=login');
    }
  }
}

spl_autoload_register('my_autoloader');

function protectStringToDisplay($str) : String
{
  $str = trim($str);
  $str = utf8_encode($str);

  return htmlentities($str, ENT_QUOTES, 'UTF-8');
}

function dateFormat($date) : String
{
  return ($date)->format('d/m/Y');
}
function dateTimeFormat($dateTime) : String
{
  return ($dateTime)->format('d/m/Y H:i');
}
function dateTimeFormatWithSeconds($dateTime) : String
{
  return ($dateTime)->format('d/m/Y H:i:s');
}

function strtotimeFormat($strtotime) : String
{
  return date('d/m/Y', $strtotime);
}
