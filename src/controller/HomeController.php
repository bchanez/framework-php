<?php

class HomeController extends Controller
{
  public function index(): array
  {
    return ['render', 'index'];
  }
}
