<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturedProductsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('featured_products', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('product_id');
      $table->unsignedBigInteger('user_id')->nullable();
      $table->unsignedBigInteger('approve_by')->nullable();
      $table->string('status')->default('WAITING');
      $table->timestamps();

      $table->foreign('product_id')->references('id')->on('products')->onDelete('CASCADE');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
      $table->foreign('approve_by')->references('id')->on('users')->onDelete('set null');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('featured_products');
  }
}
