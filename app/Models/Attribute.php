<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
  use ListData;
  use SoftDeletes;

  protected $guarded = [];
  protected $hidden = ['deleted_at'];

  public function products()
  {
    return $this->belongsToMany("App\Models\Product", "product_attribute")->withTimestamps();
  }

  public function scopeGetData($query, $request)
  {
    return $this->getListData($query, $request);
  }

  public function scopeGetDataAttributes($query)
  {
    $array = $query->where("status", true)->orderBy('order')->withCount([
      'products' => function ($query) { $query->where('status', true); }
    ])->get();
    $level = 0;
    $newArray = [];
    if (count($array) > 0) {
      foreach ($array as $index=>$item) {
        $data = (object)[
          "id" => $item->id,
          "name" => $item->name,
          "slug" => $item->slug,
          "icon" => $item->icon,
          "products_count" => $item->products_count,
          "children" => array(),
        ];
        if ($item->parent_id === null) {
          $newArray[] = $data;
          $level = 0;
        } else {
          $level += 1;
          $tempItem = null;
          for ($i = 1; $i <= $level; $i++) {
            $tempItem = $i === 1 ? $newArray[count($newArray) - 1] : $tempItem->children[count($tempItem->children) - 1];
            if ($tempItem->id === intval($item->parent_id)) {
              $tempItem->children[] = $data;
              $level = $i;
            }
          }
        }
      }
    }
    return $newArray;
  }

  public function scopeGetDataAttributesByProduct($query, $productAttributes)
  {
    $temp = [];
    foreach ($productAttributes as $index=>$item) {
      $temp = array_merge($temp, $item->attributes_ids);
    }
    $temp = array_unique($temp);

    $array = $query->orderBy('order')->get();
    $allArray = [];
    foreach ($array as $item) {
      $allArray[$item->id . ""] = $item;
    }

    $newArray = [];
    if (count($array) > 0)
    foreach ($temp as $item) {
      $newArray[$item] = $allArray[$item];
      $newArray[$item]->name = $allArray[$allArray[$item]->parent_id]->name .": ". $allArray[$item]->name;
    }
    return $newArray;
  }
}
