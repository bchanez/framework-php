<?php

$parameters = [];

if (isset($_POST)) {
  foreach ($_POST as $k => $v) {
    $parameters[$k] = $v;
  }
}

if (isset($_GET)) {
  foreach ($_GET as $k => $v) {
    $parameters[$k] = $v;
  }
}

function parameters(): array
{
  global $parameters;

  return $parameters;
}

function setParameters(?array $newParameters): void
{
  global $parameters;
  $parameters = $newParameters;
}
