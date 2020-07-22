<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
  /**
   * AttributeController constructor.
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
    $attributes = Attribute::orderBy('order')->get();
    return response(compact(["attributes"]), Response::HTTP_OK);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $result = Attribute::create($this->validateRequest("store"));
    return \Response::success(trans("messages.createSuccess"), $result, Response::HTTP_CREATED);
  }

  /**
   * Display the specified resource.
   *
   * @param \App\Models\Attribute $attribute
   * @return \Illuminate\Http\Response
   */
  public function show(Attribute $attribute)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Attribute $attribute
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Attribute $attribute)
  {
    $attribute->update($this->validateRequest("update"));
    return \Response::success(trans("messages.updateSuccess"), $attribute->refresh());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Models\Attribute $attribute
   * @return \Illuminate\Http\Response
   */
  public function destroy(Attribute $attribute)
  {
    $attribute->delete();
    return \Response::success(trans("messages.deleteSuccess"));
  }


  /**
   * @return array
   */
  protected function validateRequest($query): array
  {
    $data = \Request::validate([
      "name" => "required",
      "order" => "required",
      "parent_id" => "",
      "slug" => $query === "store" ? "unique:attributes,slug" : "required",
      "icon" => "",
    ]);
    if (empty($data["slug"])) $data["slug"] = Str::slug($data["name"], "-");
    return $data;
  }
}
