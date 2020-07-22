<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
  use CreatesApplication;

  protected function signIn($user = null)
  {
    $user = $user ?: factory("App\User")->create();
    $token = JWTAuth::fromUser($user);
    $this->withHeader('Authorization', 'Bearer ' . $token);
    return $user;
  }
}
