<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductAttributeController extends Controller
{
  /**
   * ProductAttributeController constructor.
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
    $productAttributes = ProductAttribute::where("product_id", $request->get('id'))->orderBy('updated_at')->get();
    return response(compact(["productAttributes"]), Response::HTTP_OK);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $result = ProductAttribute::create($this->validateRequest());
    return \Response::success(trans("messages.createSuccess"), $result, Response::HTTP_CREATED);
  }

  /**
   * Display the specified resource.
   *
   * @param \App\Models\ProductAttribute $productAttribute
   * @return \Illuminate\Http\Response
   */
  public function show(ProductAttribute $productAttribute)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\ProductAttribute $productAttribute
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, ProductAttribute $productAttribute)
  {
    $productAttribute->update($this->validateRequest());
    return \Response::success(trans("messages.updateSuccess"), $productAttribute->refresh());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Models\ProductAttribute $productAttribute
   * @return \Illuminate\Http\Response
   */
  public function destroy(ProductAttribute $productAttribute)
  {
    $productAttribute->delete();
    return \Response::success(trans("messages.deleteSuccess"));
  }

  /**
   * @return array
   */
  protected function validateRequest(): array
  {
    return \Request::validate([
      "attributes_ids" => "required",
      "quantity" => "required",
      "price" => "required",
      "sale_price" => "",
      "product_id" => "required",
    ]);
  }
}
