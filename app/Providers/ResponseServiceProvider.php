<?php

namespace App\Providers;

use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap services.
   *
   * @param ResponseFactory $factory
   * @return void
   */
  public function boot(ResponseFactory $factory)
  {
    $factory->macro('success', function ($message = '', $data = null, $statusCode = Response::HTTP_OK) use ($factory) {
      $format = [
        'status' => 'success',
        'message' => $message,
        'data' => $data,
      ];

      return $factory->make($format, $statusCode);
    });

    $factory->macro('error', function (string $message = '', $errors = [], $statusCode = Response::HTTP_BAD_REQUEST) use ($factory) {
      $format = [
        'status' => 'error',
        'message' => $message,
        'errors' => $errors,
      ];

      return $factory->make($format, $statusCode);
    });
  }
}
