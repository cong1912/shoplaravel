<?php


namespace App\Models;


trait ListData
{
  public function getListData($query, $request)
  {
    if (isset($request->filters)) {
      $filters = json_decode($request->filters, true);
      foreach($filters as $key => $value){
        if (is_array($value)) {
          if (strtotime(current($value))) $query->whereBetween($key, $value);
          else if (strpos($key, ".") !== false) {
            $temp = explode(".", $key);
            $query->whereHas($temp[0], function($q) use ($temp, $value){
              $q->whereIn($temp[1], $value);
            });
          } else $query->whereIn($key, $value);
        } else if (strpos($key, ".") !== false) {
          $temp = explode(".", $key);
          $query->whereHas($temp[0], function($q) use ($temp, $value){
            $q->where($temp[1], $value);
          });
        } else $query->where($key, 'like', '%'.$value.'%');
      }
    }

    if (isset($request->sorts)) {
      $sorts = json_decode($request->sorts, true);
      foreach($sorts as $key => $value){
        if (strpos($key, "|") !== false) {
          $temp1 = explode("|", $key);
          $temp2 = explode(".", $temp1[0]);
          $query->join($temp2[0], $temp1[1], '=' ,$temp2[0] . ".id")
            ->orderBy($temp1[0], $value === "ascend" ? "asc" : "desc");
        } else $query->orderBy($key, $value === "ascend" ? "asc" : "desc");
      }
    }
    return isset($request->per_page) ? $query->paginate($request->per_page) : $query->get();
  }
}
