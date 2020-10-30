<?php

class LogoutController extends Controller
{
  public function index(): array
  {
    session_destroy();

    return ['redirect', '?r=login'];
  }
}
