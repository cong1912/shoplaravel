<?php

namespace App\Http\Controllers\Web\V1;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Slide;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class HomeController extends Controller
{
  public function admin()
  {
    return view("admin");
  }

  public function index()
  {
    $brands = Brand::where("status", true)->orderBy('order')->get();
    $slides = Slide::where("status", true)->orderBy('order')->get();
    $menus = Menu::where("status", true)->orderBy('order')->get();
    $array = Category::getDataCategories();
    $categories = $array['categories'];
    $featured = $array['featured'];

    $discount = Discount::getDiscount();
    $productFeatured = Product::where([
      ['featured', '=', true],
      ['status', '=', true],
    ])->orderBy('updated_at')->getFormat(null,null, $discount);

    $productNew = Product::where("status", true)->orderBy('updated_at')->take(16)->getFormat(null,null, $discount);

    return view("welcome", compact(["categories","featured","brands","productFeatured","productNew","slides","menus"]));
  }

  public function search(Request $request)
  {
    $menus = Menu::where("status", true)->orderBy('order')->get();
    $inputs = $request->all();
    $array = Category::getDataCategories();
    $categories = $array['categories'];
    $featured = $array['featured'];

    $attributes = Attribute::getDataAttributes();
    $filterCategories = Category::where([
      ['status', '=', '1'],
      ['parent_id', '!=', null]
    ])->orderBy('order')->withCount([
      'products' => function ($query) { $query->where('status', true); }
    ])->having('products_count','>',0)->get();
    $brands = Brand::orderBy('order')->withCount([
      'products' => function ($query) { $query->where('status', true); }
    ])->having('products_count','>',0)->get();
    $selects = $this->selectSort();

    $discount = Discount::getDiscount();
    $products = Product::where([
        ['products.status', '=', true],
        ['products.name', 'like', '%' .$inputs["product"]. '%'],
      ]);
    $arrayFilter = $products->getFilterInputs($inputs, $discount);
    $products = $arrayFilter["query"];
    $arrayFilter["inputs"]["product"] = $inputs["product"];
    $inputs = $arrayFilter["inputs"];

    return view("search", compact(["categories","featured","brands","attributes","products","filterCategories","inputs","selects","brands","menus"]));
  }

  public function brand(Request $request, $slug)
  {
    $menus = Menu::where("status", true)->orderBy('order')->get();
    $brands = Brand::orderBy('order')->get();
    $array = Category::getDataCategories();
    $categories = $array['categories'];
    $featured = $array['featured'];

    $attributes = Attribute::getDataAttributes();
    $filterCategories = Category::where([
      ['status', '=', '1'],
      ['parent_id', '!=', null]
    ])->orderBy('order')->withCount([
      'products' => function ($query) { $query->where('status', true); }
    ])->having('products_count','>',0)->get();
    $brand = Brand::firstWhere("slug",$slug);
    $selects = $this->selectSort();

    $discount = Discount::getDiscount();
    $inputs = $request->all();
    $products = Brand::find($brand->id)->products()->where('products.status', true);
    $arrayFilter = $products->getFilterInputs($inputs, $discount);
    $products = $arrayFilter["query"];
    $inputs = $arrayFilter["inputs"];

    return view("brand", compact(["categories","featured","brands","attributes","products","brand","filterCategories","inputs","selects","menus"]));
  }

  public function category(Request $request, $slug)
  {
    $menus = Menu::where("status", true)->orderBy('order')->get();
    $brands = Brand::orderBy('order')->withCount([
      'products' => function ($query) { $query->where('status', true); }
    ])->having('products_count','>',0)->get();
    $array = Category::getDataCategories();
    $categories = $array['categories'];
    $featured = $array['featured'];

    $attributes = Attribute::getDataAttributes();
    $category = Category::firstWhere("slug",$slug);
    $selects = $this->selectSort();

    $discount = Discount::getDiscount();
    $inputs = $request->all();
    $products = Category::find($category->id)->products()->where('products.status', true);
    $arrayFilter = $products->getFilterInputs($inputs, $discount);
    $products = $arrayFilter["query"];
    $inputs = $arrayFilter["inputs"];

    return view("category", compact(["categories","featured","brands","attributes","products","category","inputs","selects","menus"]));
  }

  public function product($slug)
  {
    $menus = Menu::where("status", true)->orderBy('order')->get();
    $brands = Brand::orderBy('order')->get();
    $array = Category::getDataCategories();
    $categories = $array['categories'];
    $featured = $array['featured'];
    $discount = Discount::getDiscount();
    $products = Product::inRandomOrder()->limit(10)->getFormat(null, null, $discount);

    $product = Product::where("slug",$slug)->with(["brand:id,name,slug","productAttributes" => function ($query) {
      $query->where("quantity", ">", 0);
    }])->getFormat(null, null, $discount)[0];

    $attributes = Attribute::getDataAttributesByProduct($product->productAttributes);
    return view("product", compact(["categories","featured","brands","product", "products", "attributes","menus"]));
  }

  public function page($slug)
  {
    $menus = Menu::where("status", true)->orderBy('order')->get();
    $brands = Brand::orderBy('order')->get();
    $array = Category::getDataCategories();
    $categories = $array['categories'];
    $featured = $array['featured'];

    $page = Page::where("slug",$slug)->first();
    return view("page", compact(["categories","featured","brands","page","menus"]));
  }

  public function cart()
  {
    $menus = Menu::where("status", true)->orderBy('order')->get();
    $brands = Brand::orderBy('order')->get();
    $array = Category::getDataCategories();
    $categories = $array['categories'];
    $featured = $array['featured'];

    return view("cart", compact(["categories","featured","brands","menus"]));
  }

  public function postCart(Request $request)
  {
    $ids = $request->all();
    $discount = Discount::getDiscount();
    return ProductAttribute::getFormat($ids, $discount);
  }

  public function postOrder(Request $request)
  {
    $data = $request->all();
    if (!isset($data["product"]) || count($data["product"]) === 0 ) return false;
    $discount = Discount::getDiscount();

    if ($discount) $data["input"]["discount_id"] = $discount->id;

    $result = Order::generateCode($data["input"]);
    $resultArray = [];
    $productAttributes = ProductAttribute::find($data["ids"]);
    $update = [
      "base_total_price" => 0,
      "shipping_cost" => 0,
      "grand_total" => 0,
      "discount_total" => 0,
    ];
    foreach ($data["product"] as $item) {
      foreach ($productAttributes as $subItem) {
        if ($item["product_attribute_id"] == $subItem["id"]) {
          if ($discount && !$item->sale_price && (
              !isset($discount['condition'])
              || (isset($discount['condition']) && count($discount['productIds']) > 0 && in_array($item->product_id, $discount['productIds']))
            )
          ) {
            $item["discount_price"] = ($discount->percent_off / 100) * $subItem->price;
            $item["price"] = $subItem->price - $item["discount_price"];
            $update["discount_total"] += $item["discount_price"];
            $item["total"] = $item["price"] * $item['quantity'];
          }
          $item["order_id"] = $result->id;
          unset($item["linkImage"]);
          unset($item["url"]);
          unset($item["maxQuantily"]);
          $update["base_total_price"] += $item["total"];
          $resultArray[] = OrderItem::create($item);
          $subItem->update(["quantity" => $subItem->quantity - $item['quantity']]);
        }
      }
    }
    $update["shipping_cost"] = $update["base_total_price"] < 500000 ? 35000 : 0;
    $update["grand_total"] = $update["base_total_price"] < 500000 ? $update["base_total_price"] + 35000 : $update["base_total_price"];
    $result->update($update);
    return ["order" => $result->refresh(), "orderItem" => $resultArray];
  }

  /**
   * @return array
   */
  protected function selectSort(): array
  {
    $data = [
      "|sorts|" => [
        ["value" => "updated_at", "text" => __('client.sortByPopularity')],
        ["value" => "name", "text" => __('client.sortByName')],
        ["value" => "price", "text" => __('client.sortByPrice')],
      ],
      "|per_page|" => [
        ["value" => "10", "text" => "10 ".__('client.product')],
        ["value" => "15", "text" => "15 ".__('client.product')],
        ["value" => "30", "text" => "30 ".__('client.product')],
        ["value" => "50", "text" => "50 ".__('client.product')],
      ],
    ];
    return $data;
  }
}
