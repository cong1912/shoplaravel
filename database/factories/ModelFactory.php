<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Slide;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


$factory->define(User::class, function (Faker $faker) {
  return [
    'name' => $faker->name,
    'email' => $faker->unique()->safeEmail,
    'email_verified_at' => now(),
    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    'remember_token' => Str::random(10),
  ];
});

$arrayIcon = ["la-tshirt", "la-shopping-bag", "la-gift", "la-shoe-prints", "la-medkit"];
$arrayParent = [null,1,1,1,1,1,1,1,1,null,10,10,10,null,14,14,14,null,18,18,null,21,21,21];
$arrayFeatured = [0,0,0,0,0,0,0,0,0,1,0,0,0,1,0,0,0,1,0,0,1,0,0,0];

$factory->define(Category::class, function (Faker $faker) use ($arrayIcon, $arrayParent, $arrayFeatured) {
  static $order = 1;
  $name = $faker->sentence(2);
  $slug = Str::slug($name, "-");
  $parentId = $arrayParent[$order - 1];
  $featured = $arrayFeatured[$order - 1];
  return [
    "name" => "C. ".$name,
    "order" => $order++,
    "parent_id" => $parentId,
    "slug" => $slug,
    "description" => $faker->text(10),
    "featured" => $featured,
    "image" => $faker->imageUrl($width = 640, $height = 480),
    "icon" => $arrayIcon[mt_rand(0,4)],
  ];
});

$factory->define(Attribute::class, function (Faker $faker) use ($arrayIcon, $arrayParent) {
  static $order = 1;
  $name = $faker->sentence(2);
  $slug = Str::slug($name, "-");
  $parentId = $arrayParent[$order - 1];
  return [
    "name" => "A. ".$name,
    "order" => $order++,
    "parent_id" => $parentId,
    "slug" => $slug,
    "icon" => $arrayIcon[mt_rand(0,4)],
  ];
});

$factory->define(Brand::class, function (Faker $faker) use ($arrayIcon) {
  static $order = 1;
  $title = $faker->sentence(2);
  $slug = Str::slug($title, "-");
  return [
    "name" => $title,
    "order" => $order++,
    "slug" => $slug,
    "logo" => $faker->imageUrl($width = 640, $height = 480),
  ];
});

$factory->define(Product::class, function (Faker $faker) {
  $name = $faker->sentence(2);
  $slug = Str::slug($name, "-");
  $price = $faker->numberBetween(100000, 9999999);
  return [
    "author_id" => function () {
      return User::all()->random();
    },
    "brand_id" => function () {
      return Brand::all()->random();
    },
    "name" => $name,
    "summary" => $faker->text(500),
    "description" => $faker->paragraph(50),
    "media" => "[\"".$faker->imageUrl($width = 640, $height = 480)."\",\"".$faker->imageUrl($width = 640, $height = 480)."\",\"".$faker->imageUrl($width = 640, $height = 480)."\",\"".$faker->imageUrl($width = 640, $height = 480)."\",\"".$faker->imageUrl($width = 640, $height = 480)."\",\"".$faker->imageUrl($width = 640, $height = 480)."\",\"".$faker->imageUrl($width = 640, $height = 480)."\"]",
    "price" => $price,
    "slug" => $slug,
    "sale_price" => mt_rand(0,1) ? $faker->numberBetween(100000, $price) : null,
    "status" => mt_rand(0,1),
    "featured" =>  mt_rand(0,1),
    "updated_at" => $faker->dateTimeBetween("-4 weeks")
  ];
});
//    "created_at" => $faker->dateTimeBetween('-2 month', '+2 month')

$factory->define(ProductAttribute::class, function (Faker $faker) {
  $price = $faker->numberBetween(100000, 9999999);
  return [
    "attributes_ids" => function () {
      $data = Attribute::whereNotNull("parent_id")->inRandomOrder()->limit(mt_rand(1,5))->get();
      $newData = [];
      foreach ($data as $item) {
        $newData[] = $item->id . "";
      }
      return $newData;
    },
    "product_id" => function () {
      return Product::all()->random();
    },
    "quantity" => $faker->numberBetween(0, 10),
    "price" => $price,
    "sale_price" => mt_rand(0,1) ? $faker->numberBetween(100000, $price) : null,
  ];
});

$factory->define(Page::class, function (Faker $faker) use ($arrayIcon, $arrayParent) {
  $name = $faker->sentence(2);
  $slug = Str::slug($name, "-");
  return [
    "name" => $name,
    "body" => $faker->paragraph(50),
    "slug" => $slug,
  ];
});

$factory->define(Menu::class, function (Faker $faker) use ($arrayIcon, $arrayParent) {
  static $order = 1;
  return [
    "name" => $faker->sentence(1),
    "parent_id" => null,
    "is_homepage" => $order === 1,
    "order" => $order++,
    "page_slug" => function () {
      return Page::all()->random()->slug;
    },
    "status" => mt_rand(0,1),
  ];
});

$factory->define(Slide::class, function (Faker $faker) {
  $array = ['left', 'center', 'right'];
  $number = mt_rand(0,2);
  return [
    "name" => $faker->sentence(4),
    "body" => $faker->sentence(8),
    "image" => $faker->imageUrl($width = 640, $height = 480),
    "url" => "/",
    "button" => $faker->sentence(2),
    "position" => $array[$number],
  ];
});

