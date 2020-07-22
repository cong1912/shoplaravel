<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('attributes', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('parent_id')->unsigned()->nullable()->default(null);
      $table->foreign('parent_id')->references('id')->on('attributes')->onUpdate('cascade')->onDelete('set null');
      $table->string('name');
      $table->integer('order')->default(1);
      $table->string('slug')->unique();
      $table->boolean('status')->default(1);
      $table->string('icon')->nullable();
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
    Schema::dropIfExists('attributes');
  }
}
