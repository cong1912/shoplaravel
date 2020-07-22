<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SlideController extends Controller
{
  /**
   * SlideController constructor.
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
    $slides = Slide::orderBy('order')->get();
    return response(compact(["slides"]), Response::HTTP_OK);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $result = Slide::create($this->validateRequest());
    return \Response::success(trans("messages.createSuccess"), $result, Response::HTTP_CREATED);
  }

  /**
   * Display the specified resource.
   *
   * @param \App\Models\Slide $slide
   * @return \Illuminate\Http\Response
   */
  public function show(Slide $slide)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Slide $slide
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Slide $slide)
  {
    $slide->update($this->validateRequest());
    return \Response::success(trans("messages.updateSuccess"), $slide->refresh());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Models\Slide $slide
   * @return \Illuminate\Http\Response
   */
  public function destroy(Slide $slide)
  {
    $slide->delete();
    return \Response::success(trans("messages.deleteSuccess"));
  }

  /**
   * @return array
   */
  protected function validateRequest(): array
  {
    return \Request::validate([
      "name" => "required",
      "body" => "",
      "image" => "required",
      "url" => "",
      "button" => "",
      "order" => "",
      "position" => "",
      "status" => "",
    ]);
  }
}
