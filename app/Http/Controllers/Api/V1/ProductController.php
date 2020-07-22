<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
  /**
   * ProductController constructor.
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
  public function index(Request $request)
  {
    $result = Product::with(["author:id,name", "categories:category_id,name", "brand:id,name", "productAttributes"])->getData($request);
    return response($result, Response::HTTP_OK);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $result = auth()->user()->posts()->create($this->validateRequest("store"));
    if ($request->has("category_id")) {
      $result->categories()->attach($request->input("category_id"));
    }
    return \Response::success(trans("messages.createSuccess"), $result, Response::HTTP_CREATED);
  }

  /**
   * Display the specified resource.
   *
   * @param \App\Models\Product $product
   * @return \Illuminate\Http\Response
   */
  public function show(Product $product)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param Product $product
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Product $product)
  {
    if ($request->has("attributes_ids")) {
      $product->attributes()->sync($request->input("attributes_ids"));
    } else if ($request->method() === "PUT") {
      $product->update($this->validateRequest("update"));
      if ($request->has("category_id")) $product->categories()->sync($request->input("category_id"));
    } else {
      $data = \Request::validate([
        "status" => "",
        "featured" => "",
      ]);
      $product->update($data);
    }
    return \Response::success(trans("messages.updateSuccess"), $product->refresh());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Models\Product $product
   * @return \Illuminate\Http\Response
   */
  public function destroy(Product $product)
  {
    $product->delete();
    return \Response::success(trans("messages.deleteSuccess"));
  }

  /**
   * @return array
   */
  protected function validateRequest($query): array
  {
    return \Request::validate([
      "name" => "required",
      "brand_id" => "required",
      "description" => "",
      "media" => "",
      "price" => "required",
      "slug" => $query === "store" ? "unique:products,slug" : "required",
      "sale_price" => "",
      "status" => "",
      "featured" => "",
      "summary" => "",
    ]);
  }
}
