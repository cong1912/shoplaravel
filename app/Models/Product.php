<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
  use ListData;
  use SoftDeletes;
  protected $guarded = ["sold_count"];

  public function scopeGetData($query, $request)
  {
    return $this->getListData($query, $request);
  }

  public function scopeFilterBrand($query, $input)
  {
    return $query
      ->join('brands', 'products.brand_id', '=', 'brands.id')
      ->whereIn('brands.slug', function($query) use($input) {
        $query->select('brands.slug')->from('products')
          ->join('brands', 'products.brand_id', '=', 'brands.id')
          ->whereIn('brands.slug', $input);
      });
  }

  public function scopeFilterAttribute($query, $input)
  {
    return $query
      ->join('product_attribute', 'products.id', '=', 'product_attribute.product_id')
      ->whereIn('product_attribute.attribute_id', function($query) use($input) {
        $query->select('product_attribute.attribute_id')->from('products')
          ->join('product_attribute', 'products.id', '=', 'product_attribute.product_id')
          ->join('attributes', 'product_attribute.attribute_id', '=', 'attributes.id')
          ->whereIn('attributes.slug', $input);
      });
  }

  public function scopeFilterCategory($query, $input)
  {
    return $query
      ->join('product_category', 'products.id', '=', 'product_category.product_id')
      ->whereIn('product_category.category_id', function($query) use($input) {
        $query->select('product_category.category_id')->from('products')
          ->join('product_category', 'products.id', '=', 'product_category.product_id')
          ->join('categories', 'product_category.category_id', '=', 'categories.id')
          ->whereIn('categories.slug', $input);
      });
  }

  public function scopeGetFormat($query, $pageSize, $page, $discount) {
    $query = $query->withCount([
      'productAttributes' => function ($query) { $query->where('quantity', '>', 0); }
    ])->having('product_attributes_count','>',0);

    $array = isset($pageSize) ? $query->paginate($pageSize,['*'],"|page|",$page) : $query->get();
    $now = Carbon::now()->weekOfYear;
    foreach ($array as $index=>$item) {
      if ($discount && !$item->sale_price && (
        !isset($discount['condition'])
        || (isset($discount['condition']) && count($discount['productIds']) > 0 && in_array($item->id, $discount['productIds']))
        )
      ) {
        $item->sale_price = $item->price - (($discount->percent_off / 100) * $item->price);
      }
      $item->new = ($now - Carbon::parse($item->updated_at)->weekOfYear) < 3;
      $item->media = json_decode($item->media);
    }
    return $array;
  }

  public function scopeGetFilterInputs($query, $inputs, $discount)
  {
    $inputs["max_price"] = $query->max("price");
    $inputs["min_price"] = $query->min("price");
    if (!isset($inputs["min_price"], $inputs["max_price"])) {
      $inputs["min_price"] = "0000";
      $inputs["max_price"] = "0000";
    }
    $sort = "updated_at";
    $pageSize = "10";
    $page = "1";
    if (count($inputs) > 0) {
      foreach($inputs as $key => $value) {
        $inputs[$key] = json_decode($value);
        switch ($key) {
          case "|category|":
            $query = $query->filterCategory($inputs[$key]);
            break;
          case "|brand|":
            $query = $query->filterBrand($inputs[$key]);
            break;
          case "|attribute|":
            $query = $query->filterAttribute($inputs[$key]);
            break;
          case "|price_range|":
            $query = $query->whereBetween('products.price', [($inputs[$key][0] - 1) * 1000, ($inputs[$key][1] + 1) * 1000]);
            break;
          case "|sorts|":
            $sort = $inputs[$key];
            break;
          case "|per_page|":
            $pageSize = $inputs[$key];
            break;
          case "|page|":
            $page = $inputs[$key];
            break;
        }
      };
    }
    $query = $query->orderBy((count($inputs) > 0 ? "products." : "").$sort, "asc")->getFormat($pageSize, $page, $discount);
    return [
      "query" => $query,
      "inputs" => $inputs
    ];
  }

  public function categories()
  {
    return $this->belongsToMany("App\Models\Category", "product_category")->withTimestamps();
  }

  public function attributes()
  {
    return $this->belongsToMany("App\Models\Attribute", "product_attribute")->withTimestamps();
  }

  public function author()
  {
    return $this->belongsTo("App\User");
  }

  public function brand()
  {
    return $this->belongsTo("App\Models\Brand");
  }

  public function productAttributes()
  {
    return $this->hasMany("App\Models\ProductAttribute");
  }
}
