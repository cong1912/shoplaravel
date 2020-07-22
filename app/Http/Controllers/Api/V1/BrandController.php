<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
  /**
   * BrandController constructor.
   */
  public function __construct()
  {
    $this->middleware('auth:api');
    auth()->shouldUse('api');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $brands = Brand::orderBy('order')->get();
    return response(compact(["brands"]), Response::HTTP_OK);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $result = Brand::create($this->validateRequest("store"));
    return \Response::success(trans("messages.createSuccess"), $result, Response::HTTP_CREATED);
  }

  /**
   * Display the specified resource.
   *
   * @param \App\Models\Brand $brand
   * @return \Illuminate\Http\Response
   */
  public function show(Brand $brand)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Brand $brand
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Brand $brand)
  {
    $brand->update($this->validateRequest("update"));
    return \Response::success(trans("messages.updateSuccess"), $brand->refresh());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Models\Brand $brand
   * @return \Illuminate\Http\Response
   */
  public function destroy(Brand $brand)
  {
    $brand->delete();
    return \Response::success(trans("messages.deleteSuccess"));
  }

  protected function validateRequest($query): array
  {
    $data = \Request::validate([
      "name" => "required",
      "order" => "required",
      "slug" => $query === "store" ? "unique:brands,slug" : "required",
      "logo" => "",
    ]);
    if (empty($data["slug"])) $data["slug"] = Str::slug($data["name"], "-");
    return $data;
  }
}
