<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('products', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('author_id');
      $table->unsignedInteger('brand_id')->unsigned()->nullable()->default(null);;
      $table->foreign('brand_id')->references('id')->on('brands')->onUpdate('cascade')->onDelete('set null');
      $table->string('name');
      $table->string('summary', 500)->nullable();
      $table->text('description')->nullable();
      $table->text('media')->nullable();
      $table->decimal('price', 12, 0)->nullable();
      $table->string('slug')->unique();
      $table->decimal('sale_price', 12, 0)->nullable();
      $table->boolean('status')->default(1);
      $table->boolean('featured')->default(0);
      $table->unsignedInteger('sold_count')->default(0);
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('products');
  }
}
