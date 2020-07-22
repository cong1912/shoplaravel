<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('order_items', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('order_id')->index();
      $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
      $table->unsignedInteger('product_attribute_id')->nullable();
      $table->foreign('product_attribute_id')->references('id')->on('product_attributes')->onDelete('set null');
      $table->unsignedInteger('product_id')->nullable();
      $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');

      $table->string('name');
      $table->text('name_attribute');
      $table->unsignedInteger('quantity');
      $table->decimal('price', 12, 0);
      $table->decimal('discount_price', 12, 0)->default(0);
      $table->decimal('total', 12, 0);
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('order_items');
  }
}
