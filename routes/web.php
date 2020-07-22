<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Web\V1'], function ($router) {
  app()->setLocale('vi');
  Route::get('/', 'HomeController@index');
  Route::get('/category/{slug}', 'HomeController@category');
  Route::get('/brand/{slug}', 'HomeController@brand');
  Route::get('/product/{slug}', 'HomeController@product');
  Route::get('/search', 'HomeController@search');
  Route::get('/page/{slug}', 'HomeController@page');
  Route::get('/cart', 'HomeController@cart');
  Route::post('/cart', 'HomeController@postCart');
  Route::post('/order', 'HomeController@postOrder');
  Route::get('/administrator', 'HomeController@admin');
  Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
  });
  Route::get('/link-storage', function () {
    Artisan::call('storage:link');
//    $targetFolder = $_SERVER['DOCUMENT_ROOT'].'/storage/app/public';
//    $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/public/storage';
//    symlink($targetFolder,$linkFolder);
//    echo 'Symlink process successfully completed';
  });
});

