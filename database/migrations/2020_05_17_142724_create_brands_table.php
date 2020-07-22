<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('brands', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name', 45);
      $table->integer('order')->default(1);
      $table->string('slug');
      $table->string('logo')->nullable();
      $table->boolean('status')->default(1);
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
    Schema::dropIfExists('brands');
  }
}
