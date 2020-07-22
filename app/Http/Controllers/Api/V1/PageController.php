<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PageController extends Controller
{
  /**
   * PageController constructor.
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
    $result = Page::getData($request);
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
    $result = Page::create($this->validateRequest("store"));
    return \Response::success(trans("messages.createSuccess"), $result, Response::HTTP_CREATED);
  }

  /**
   * Display the specified resource.
   *
   * @param \App\Models\Page $page
   * @return \Illuminate\Http\Response
   */
  public function show(Page $page)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Page $page
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Page $page)
  {
    $page->update($this->validateRequest("update"));
    return \Response::success(trans("messages.updateSuccess"), $page->refresh());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Models\Page $page
   * @return \Illuminate\Http\Response
   */
  public function destroy(Page $page)
  {
    $page->delete();
    return \Response::success(trans("messages.deleteSuccess"));
  }

  /**
   * @return array
   */
  protected function validateRequest($query): array
  {
    return \Request::validate([
      "name" => "required",
      "body" => "",
      "slug" => $query === "store" ? "unique:pages,slug" : "required",
    ]);
  }
}
