<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

  /**
   * AuthController constructor.
   */
  public function __construct()
  {
    $this->middleware('auth:api', ['except' => ['index']]);
    auth()->shouldUse('api');
  }


  /**
   * @return mixed
   */
  public function index()
  {
    $credentials = request(['email', 'password']); // !$token = auth()->setTTL(1)->attempt($credentials)

    if (!$token = auth()->attempt($credentials)) {
      return \Response::error(trans("messages.unauthorized"), Response::HTTP_UNAUTHORIZED);
    }

    return $this->respondWithToken($token);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(Request $request)
  { // auth()->setTTL(1)->refresh()
    return $this->respondWithToken(auth()->refresh());
  }

  /**
   * Display the specified resource.
   *
   * @param \App\User $user
   * @return \Illuminate\Http\Response
   */
  public function show(User $user)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\User $user
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, User $user)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\User $user
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $user)
  {
    //
  }

  /**
   * Check slug.
   *
   * @param \App\User $user
   * @return \Illuminate\Http\Response
   */
  public function checkSlug(Request $request){
    $data = $request->all();
    $check = true;
    $rows = DB::table($data["model"])->where("slug", $data["slug"])->get();
    if (isset($data["id"]) && count($rows) > 0) {
      foreach($rows as $row) {
        if ($check && $row->id !== $data["id"]) $check = false;
      }
    } else {
      $check = count($rows) === 0;
    }
    return \Response::success(null, $check);
  }

  /**
   * Get the token array structure.
   *
   * @param  string $token
   *
   * @return \Illuminate\Http\JsonResponse
   */
  protected function respondWithToken($token)
  {
    $user = auth()->user();
    $user->token = "Bearer " . $token;
    $user->expires_in = (strtotime("now") + (auth()->factory()->getTTL() * 60))  * 1000;

    return \Response::success(trans("messages.getTokenSuccess"), $user);
  }
}
