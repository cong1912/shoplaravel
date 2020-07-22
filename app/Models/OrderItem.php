<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
  use ListData;
  use SoftDeletes;

  protected $guarded = [];
  protected $hidden = ['deleted_at'];

  public function scopeGetData($query, $request)
  {
    return $this->getListData($query, $request);
  }

  public function order()
  {
    return $this->belongsTo("App\Models\Order");
  }

}
