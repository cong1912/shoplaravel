<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MenuController extends Controller
{
  /**
   * MenuController constructor.
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
    $menus = Menu::orderBy('order')->get();
    $pages = Page::get();
    return response(compact(["menus","pages"]), Response::HTTP_OK);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $result = Menu::create($this->validateRequest());
    return \Response::success(trans("messages.createSuccess"), $result, Response::HTTP_CREATED);
  }

  /**
   * Display the specified resource.
   *
   * @param \App\Models\Menu $menu
   * @return \Illuminate\Http\Response
   */
  public function show(Menu $menu)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Menu $menu
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Menu $menu)
  {
    $menu->update($this->validateRequest());
    return \Response::success(trans("messages.updateSuccess"), $menu->refresh());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Models\Menu $menu
   * @return \Illuminate\Http\Response
   */
  public function destroy(Menu $menu)
  {
    $menu->delete();
    return \Response::success(trans("messages.deleteSuccess"));
  }

  /**
   * @return array
   */
  protected function validateRequest(): array
  {
    return \Request::validate([
      "name" => "required",
      "parent_id" => "",
      "order" => "",
      "page_slug" => "",
      "is_homepage" => "",
      "status" => "",
    ]);
  }
}
