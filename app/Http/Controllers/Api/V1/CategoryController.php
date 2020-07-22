<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
  /**
   * CategoryController constructor.
   */
  public function __construct()
  {
    $this->middleware('auth:api');
    auth()->shouldUse('api');
  }

  /**
   * Display a listing of the resource.
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
   */
  public function index()
  {
    $categorys = Category::orderBy('order')->get();
    return response(compact(["categorys"]), Response::HTTP_OK);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $result = Category::create($this->validateRequest("store"));
    return \Response::success(trans("messages.createSuccess"), $result, Response::HTTP_CREATED);
  }

  /**
   * Display the specified resource.
   *
   * @param \App\Models\Category $category
   * @return \Illuminate\Http\Response
   */
  public function show(Category $category)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Category $category
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Category $category)
  {
    $category->update($this->validateRequest("update"));
    return \Response::success(trans("messages.updateSuccess"), $category->refresh());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Models\Category $category
   * @return \Illuminate\Http\Response
   */
  public function destroy(Category $category)
  {
    $category->delete();
    return \Response::success(trans("messages.deleteSuccess"));
  }

  /**
   * @return array
   */
  protected function validateRequest($query): array
  {
    return \Request::validate([
      "name" => "required",
      "order" => "required",
      "parent_id" => "",
      "slug" => $query === "store" ? "unique:categories,slug" : "required",
      "description" => "",
      "featured" => "",
      "image" => "",
      "icon" => "",
    ]);
  }
}
