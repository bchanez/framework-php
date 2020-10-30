<?php

require __DIR__ . '/vendor/autoload.php';

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

include_once 'src/db.php';
include_once 'src/tools.php';
session_start();
include_once 'src/controller/route.php';
