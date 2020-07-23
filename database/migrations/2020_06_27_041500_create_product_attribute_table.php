<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributeTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('product_attribute', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('attribute_id')->unsigned();
      $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
      $table->integer('product_id')->unsigned();
      $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
    Schema::dropIfExists('product_attribute');
  }
}