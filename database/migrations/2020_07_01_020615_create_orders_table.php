<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('orders', function (Blueprint $table) {
      $table->increments('id');

      $table->unsignedInteger('discount_id')->nullable();
      $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('set null');

      $table->string('code')->unique();
      $table->enum('status', ['pending', 'processing', 'completed', 'decline'])->default('pending');

      $table->decimal('base_total_price', 12, 0);
      $table->decimal('shipping_cost', 12, 0);
      $table->decimal('grand_total', 12, 0);
      $table->decimal('discount_total', 12, 0)->default(0);
      $table->unsignedInteger('item_count');
      $table->string('full_name');
      $table->text('address');
      $table->string('phone_number');
      $table->string('email');
      $table->text('notes')->nullable();
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
    Schema::dropIfExists('orders');
  }
}
