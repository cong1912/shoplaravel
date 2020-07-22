<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Category
 *
 * @property-read \App\User $owner
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category getData($request)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category query()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category withoutTrashed()
 * @mixin \Eloquent
 */
class Category extends Model
{
  use ListData;
  use SoftDeletes;

  protected $guarded = [];
  protected $hidden = ['deleted_at'];

  public function products()
  {
    return $this->belongsToMany("App\Models\Product", "product_category")->withTimestamps();
  }

  public function scopeGetData($query, $request)
  {
    return $this->getListData($query, $request);
  }

  public function scopeGetDataCategories()
  {
    $array = $this->where("status", true)->orderBy('order')->withCount([
      'products' => function ($query) { $query->where('status', true); }
      ])->get();
    $numberRowInCol = intval(ceil(count($array) / 3));
    $level = 0;
    $col = 0;
    $newArray = [];
    $featured = [];
    if ($array) {
      foreach ($array as $index=>$item) {
        $data = (object)[
          "id" => $item->id,
          "name" => $item->name,
          "url" => $item->slug,
          "icon" => $item->icon,
          "products_count" => $item->products_count,
          "children" => array(),
        ];
        if ($item->featured) $featured[] = $item;
        if ($index % $numberRowInCol === 0) $col++;
        if ($item->parent_id === null) {
          $data->col = $col;
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
    return [
      "categories" => $newArray,
      "featured" => $featured,
    ];
  }
}
