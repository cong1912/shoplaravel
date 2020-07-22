<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('slides', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->text('body')->nullable();
      $table->string('image');
      $table->string('url')->nullable();
      $table->string('button')->nullable();
      $table->integer('order')->default(1);
      $table->enum('position', ['left', 'center', 'right'])->default('left');
      $table->boolean('status')->default(1);
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
    Schema::dropIfExists('slides');
  }
}
