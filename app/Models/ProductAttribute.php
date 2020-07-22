<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttribute extends Model
{
  use ListData;
  use SoftDeletes;

  protected $guarded = [];
  protected $hidden = ['deleted_at'];

  public function scopeGetData($query, $request)
  {
    return $this->getListData($query, $request);
  }

  public function getAttributesIdsAttribute($value)
  {
    return json_decode($value);
  }
  public function setAttributesIdsAttribute($value)
  {
    $this->attributes['attributes_ids'] = json_encode($value);
  }

  public function product()
  {
    return $this->belongsTo("App\Models\Product");
  }

  public function scopeGetFormat($query, $ids, $discount)
  {
    $array = $query->find($ids);
    foreach ($array as $index=>$item) {
      if ($discount && !$item->sale_price && (
          !isset($discount['condition'])
          || (isset($discount['condition']) && count($discount['productIds']) > 0 && in_array($item->product_id, $discount['productIds']))
        )
      ) {
        $item->sale_price = $item->price - (($discount->percent_off / 100) * $item->price);
      }
    }
    return $array;
  }
}
