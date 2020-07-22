<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ExampleTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function a_user_can_create_a_category_type()
  {
    $user = $this->signIn();

    $this->postJson(
      "/api/v1/category",
      $attributes = factory("App\Models\Category")->raw(["owner_id" => $user->id])
    )->assertStatus(Response::HTTP_CREATED)
      ->assertJsonStructure(["status", "message", "data"])
      ->assertJson(["data" => $attributes]);
  }
}
