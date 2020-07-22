<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api\V1', 'prefix' => 'v1','middleware' => ['language']], function ($router) {
  Route::post("check-slug", "AuthController@checkSlug");
  Route::apiResources([
    'auth' => 'AuthController',
    'media' => 'MediaController',
    'category' => 'CategoryController',
    'brand' => 'BrandController',
    'product' => 'ProductController',
    'attribute' => 'AttributeController',
    'product-attribute' => 'ProductAttributeController',
    'page' => 'PageController',
    'menu' => 'MenuController',
    'slide' => 'SlideController',
    'discount' => 'DiscountController',
    'order' => 'OrderController',
  ]);
});
