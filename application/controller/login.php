<?php

  class Login extends Controller
  {
  function __construct($param)
  {
    parent::__construct($param);
    $this->content();
    echo (json_encode($_COOKIE));
  }
  }