<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Discount extends Model
{
  use ListData;
  use SoftDeletes;

  protected $guarded = [];
  protected $hidden = ['deleted_at'];

  public function getConditionAttribute($value)
  {
    return json_decode($value);
  }
  public function setConditionAttribute($value)
  {
    $this->attributes['condition'] =  json_encode($value);
  }

  public function setStartAtAttribute($value)
  {
    $this->attributes['start_at'] =  Carbon::parse($value);
  }

  public function setEndAtAttribute($value)
  {
    $this->attributes['end_at'] =  Carbon::parse($value);
  }

  public function scopeGetDiscount($query)
  {
    $now = Carbon::now();

    $discount = $query->where([
      ['status', '=', true],
      ['start_at', '<=', $now],
      ['end_at', '>=', $now],
    ])->orderByDesc('priority')->orderBy('start_at')->first();

    if (isset($discount) && isset($discount["condition"])) {
      $array = [];
      foreach ($discount["condition"] as $key=>$item) {
        $array[$key] = [];
        if (isset($item)) {
          switch ($key) {
            case "categories":
              $query = Category::whereIn("id", $item)->where('status', true)->with(["products" => function ($query) {
                $query->where('status', true);
              }])->get();
              break;
            case "brands":
              $query = Brand::whereIn("id", $item)->where('status', true)->with(["products" => function ($query) {
                $query->where('status', true);
              }])->get();
              break;
          }
          foreach ($query as $queryItem) {
            foreach ($queryItem["products"] as $productItem) {
              $array[$key][] = $productItem->id;
              $array[$key] = array_unique($array[$key]);
            }
          }
        }
      }
      if (isset($discount["condition"]->categories) && isset($discount["condition"]->brands)) {
        $array = array_values(array_intersect($array["categories"], $array["brands"]));
      } else $array = array_merge($array["categories"], $array["brands"]);
      $discount["productIds"] = $array;
    }
    return isset($discount) ? $discount : false;
  }

  public function scopeGetData($query, $request)
  {
    return $this->getListData($query, $request);
  }
}
