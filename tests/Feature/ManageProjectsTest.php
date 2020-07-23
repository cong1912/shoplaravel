<?php
namespace Tests\Feature;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
class ManageProjectsTest extends TestCase
{
  use WithFaker,RefreshDatabase;
  /** @test */
  function it_displays_the_home_page(){
    $response = $this->get('/');
    $response->assertStatus(200);
  }
  /** @test */
  function it_displays_the_cart_page()
  {
    $response = $this->get('/cart');
    $response->assertStatus(200);
  }
  /** @test */
  function it_displays_the_category_page()
  {
    $post = factory(category::class)->create();
    $response = $this->get("/category/{$post->slug}");
    $response->assertStatus(200);
  }
  /** @test */
  function it_displays_the_brand_page()
  {
    $post = factory(Brand::class)->create();
    $response = $this->get("/brand/{$post->slug}");
    $response->assertStatus(200);
  }
  /** @test */
  function it_displays_the_product_page()
  {
    $post = factory(Product::class)->create();
    $response = $this->get("/product/{$post->slug}");
    $response->assertStatus(200);
  }
  /** @test */
  function it_displays_the_page_page()
  {
    $post = factory(Page::class)->create();
    $response = $this->get("/page/{$post->slug}");
    $response->assertStatus(200);
  }


}
