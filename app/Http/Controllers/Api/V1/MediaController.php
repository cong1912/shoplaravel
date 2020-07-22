<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
  /**
   * MediaController constructor.
   */
  protected $mimeTypes;
  protected $root;
  public function __construct()
  {
    $this->middleware('auth:api');
    auth()->shouldUse('api');
    $this->mimeTypes = explode(',',config('filesystems.mime_type'));
    $this->root = "/public";
  }

  /**
   * Display a listing of the resource.
   * @param Request $request
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
   */
  public function index(Request $request)
  {
    $path = $this->root . $request->get('path');

    $filesList = collect(Storage::files($path))->sortByDesc(function ($file) {
      return Storage::lastModified($file);
    });
    $foldersList = Storage::directories($path);

    $data = [];

    foreach ($foldersList as $value) {
      array_push($data,$this->folderInfo($value));
    }
    foreach ($filesList as $value) {
      $fileTemp = $this->fileInfo($value);
      if ($fileTemp) array_push($data, $fileTemp);
    }
    return response($data, Response::HTTP_OK);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $type = $request->get('type');
    $path = $this->root . $request->get('path');
    if ($type == 'folder'){
      $fullPath = $path . '/' . $request->get('name');
      if (!$this->folderIsExist($path, $fullPath)){
        Storage::makeDirectory($fullPath);
        return \Response::success(trans("messages.createSuccess"), null, Response::HTTP_CREATED);
      }else{
        return \Response::error(trans("messages.alreadyExists"), null, Response::HTTP_CONFLICT);
      }
    } else {
      $file = $request->file('file');
      $filePath = Storage::putFile("temp", $file);
      $fileType = Storage::mimeType($filePath);
      if (!in_array($fileType, $this->mimeTypes)){
        $this->delFile($filePath);
        return \Response::error(trans("messages.unsupportedFileType"), null, Response::HTTP_CONFLICT);
      }else{
        $this->delFile($filePath);
        $data = Storage::putFile($path, $file);
        return \Response::success(trans("messages.createSuccess"), $data, Response::HTTP_OK);
      }
    }
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $type = $request->get('type');
    $path = $request->get('path');
    if ($type == 'folder'){
      $filesList = Storage::files($path);
      $foldersList = Storage::directories($path);
      if (count($filesList) === 0 && count($foldersList) === 0) {
        $data = Storage::deleteDirectory($path);
      } else {
        return \Response::error(trans("messages.theFolderNeedsEmpty"), Response::HTTP_CONFLICT);
      }
    }else{
      $data = Storage::delete($path);
    }

    if (!$data){
      return \Response::error(trans("messages.fileDoesNotExist"), Response::HTTP_CONFLICT);
    }else{
      return \Response::success(trans("messages.deleteSuccess"));
    }

  }

  /**
   * get file info by file Path
   *
   * @param $filePath
   * @return array
   */
  public function fileInfo($filePath)
  {
    $fileName = explode('/', $filePath);
    if (end($fileName) != ".gitignore") {
      return [
        'origin'       => $filePath,
        'name'         => end($fileName),
        'type'         => explode('/', Storage::mimeType($filePath))[0],
        'url'          => Storage::url($filePath),
        'size'         => $this->fileSize($filePath),
        'lastModified' => date('Y-m-d H:i:s', Storage::lastModified($filePath))
      ];
    }else{
      return null;
    }
  }

  /**
   * get file info by file Path
   *
   * @param $folderPath
   * @return array
   */
  public function folderInfo($folderPath)
  {
    $folderName = explode('/', $folderPath);
    return [
      'origin' => $folderPath,
      'name'   => end($folderName),
      'type'   => 'folder',
      'url'    => Storage::url($folderPath),
    ];
  }

  /**
   * change the format of size
   *
   * @param $filePath
   * @return String
   */
  function fileSize($filePath) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $size = Storage::size($filePath);
    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;

    return round($size, 2).$units[$i];
  }

  /**
   * get all folders
   *
   * @param $current
   * @param $newDirectory
   * @return bool
   */
  public function folderIsExist($current, $newDirectory)
  {
    $folders = Storage::directories($current);
    return in_array($newDirectory, $folders);
  }

  /**
   * delete file
   *
   * @param $filePath
   * @return bool
   */
  public function delFile($filePath)
  {
    if (Storage::exists($filePath)) {
      return Storage::deleteDirectory("temp");
    }else{
      return false;
    }
  }
}
