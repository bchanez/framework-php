<?php

$dotenv->required(['host', 'port', 'dbname', 'user', 'password']);
$db = new PDO('mysql:host=' . $_ENV['host'] . ';port=' . $_ENV['port'] . ';dbname=' . $_ENV['dbname'], $_ENV['user'], $_ENV['password']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

setDb($db);

function db(): PDO
{
  global $db;

  return $db;
}

function setDb(PDO $newDb): void
{
  global $db;
  $db = $newDb;
}
