<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DiscountController extends Controller
{
  /**
   * DiscountController constructor.
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
    $result = Discount::getData($request);
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
    $result = Discount::create($this->validateRequest());
    return \Response::success(trans("messages.createSuccess"), $result, Response::HTTP_CREATED);
  }

  /**
   * Display the specified resource.
   *
   * @param \App\Models\Discount $discount
   * @return \Illuminate\Http\Response
   */
  public function show(Discount $discount)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Discount $discount
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Discount $discount)
  {
    if ($request->method() === "PUT") {
      $discount->update($this->validateRequest());
    } else {
      $data = \Request::validate([
        "status" => "",
      ]);
      $discount->update($data);
    }
    return \Response::success(trans("messages.updateSuccess"), $discount->refresh());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Models\Discount $discount
   * @return \Illuminate\Http\Response
   */
  public function destroy(Discount $discount)
  {
    $discount->delete();
    return \Response::success(trans("messages.deleteSuccess"));
  }

  /**
   * @return array
   */
  protected function validateRequest(): array
  {
    return \Request::validate([
      "name" => "required",
      "percent_off" => "required",
      "start_at" => "required",
      "end_at" => "required",
      "priority" => "",
      "condition" => "",
      "status" => "",
    ]);
  }
}
