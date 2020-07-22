<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('discounts', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->integer('percent_off');
      $table->timestamp('start_at');
      $table->timestamp('end_at')->nullable();
      $table->integer('priority')->default(0);
//      $table->string('code')->unique();
//      $table->string('type');
//      $table->integer('value')->nullable();
      $table->json("condition")->nullable();
      $table->decimal('total', 12, 0)->default(0);
      $table->boolean('status')->default(0);
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**n
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('discounts');
  }
}
