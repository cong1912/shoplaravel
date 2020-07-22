<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
  use ListData;
  use SoftDeletes;

  protected $guarded = [];
  protected $hidden = ['deleted_at'];
  protected $with = ['orderItem'];

  public function scopeGetData($query, $request)
  {
    return $this->getListData($query, $request);
  }

  /**
   * Generate order code
   *
   * @return string
   */
  public static function scopeGenerateCode($query, $data)
  {
    $dateCode = date('Y') . '/' .self::_integerToRoman(date('d')). '/' .self::_integerToRoman(date('m')). '/';

    $lastOrder = self::select([\DB::raw('MAX(orders.code) AS last_code')])
      ->where('code', 'like', $dateCode . '%')
      ->first();

    $lastOrderCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;

    $orderCode = $dateCode . '00001';
    if ($lastOrderCode) {
      $lastOrderNumber = str_replace($dateCode, '', $lastOrderCode);
      $nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);

      $orderCode = $dateCode . $nextOrderNumber;
    }

    if (self::_isOrderCodeExists($orderCode)) {
      return generateOrderCode();
    }
    $data["code"] = $orderCode;

    return $query->create($data);
  }

  /**
   * Check if the generated order code is exists
   *
   * @param string $orderCode order code
   *
   * @return void
   */
  private static function _isOrderCodeExists($orderCode)
  {
    return Order::where('code', '=', $orderCode)->exists();
  }

  /**
   * Convert number to roman
   *
   * @param int $integer name
   *
   * @return string
   */
  public static function _integerToRoman($integer)
  {
    $integer = intval($integer);
    $result = '';

    // Create a lookup array that contains all of the Roman numerals.
    $lookup = ['M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1];

    foreach ($lookup as $roman => $value) {
      $matches = intval($integer/$value);
      $result .= str_repeat($roman, $matches);
      $integer = $integer % $value;
    }

    return $result;
  }

  public static function scopeChangeOrder($query, $status, $array)
  {
    if(isset($query->discount_id)) {
      $discount = Discount::find($query->discount_id);
      $total = $status === "decline" ? $discount->total - $query->grand_total : $discount->total + $query->grand_total;
      $discount->update(["total" => $total]);
    };
    if ($array && count($array) > 0) {
      $ids = [];
      foreach ($array as $item) {
        $ids[] = $item->product_attribute_id;
      }
      $productAttributes = ProductAttribute::find($ids);
      foreach ($array as $item) {
        foreach ($productAttributes as $subItem) {
          if ($item["product_attribute_id"] == $subItem["id"]) {
            $quantity = $status === "decline" ? $subItem->quantity + $item['quantity'] : $subItem->quantity - $item['quantity'];
            $subItem->update(["quantity" => $quantity]);
          }
        }
      }
    }
  }

  public function orderItem()
  {
    return $this->hasMany("App\Models\OrderItem");
  }
}
