<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Mail\OrderShipped;
use App\Models\Discount;
use App\Models\Order;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
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
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $result = Order::with(["orderItem"])->getData($request);
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
    //
  }

  /**
   * Display the specified resource.
   *
   * @param \App\Models\Order $order
   * @return \Illuminate\Http\Response
   */
  public function show(Order $order)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Order $order
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Order $order)
  {
    if ($request->method() === "PATCH") {
      $data = \Request::validate([
        "status" => "",
      ]);
      if ($order->status === "pending" && $data["status"] !== "pending") {
        $order->changeOrder($data["status"], null);
//        Mail::to($order->email)->send(new OrderShipped($order));
      }
      switch ($data["status"]) {
        case "decline":
          $order->changeOrder($data["status"], $order->orderItem);
          $discount = Discount::find($order->discount_id);
          $discount->update(["total" => $discount->total - $order->discount_total]);
          break;
      }
      if ($order->status === "decline" && $data["status"] !== "decline") {
        $order->changeOrder($data["status"],$order->orderItem);
        $discount = Discount::find($order->discount_id);
        $discount->update(["total" => $discount->total + $order->discount_total]);
      }
      $order->update($data);
    }
    return \Response::success(trans("messages.updateSuccess"), $order->refresh());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Models\Order $order
   * @return \Illuminate\Http\Response
   */
  public function destroy(Order $order)
  {
    //
  }
}
