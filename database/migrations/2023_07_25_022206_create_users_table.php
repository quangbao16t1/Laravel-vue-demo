<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('first_name');
      $table->string('last_name');
      $table->string('email')->unique();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->string('address')->nullable();
      $table->string('phone_number')->nullable();
      $table->unsignedInteger('role_id');
      $table->unsignedBigInteger('company_id')->nullable();
      $table->string('api_token', 80)->unique()->nullable()->default(null);
      $table->timestamps();

      $table->foreign('role_id')->references('id')->on('roles')->onDelete('CASCADE');
      $table->foreign('company_id')->references('id')->on('companies')->onDelete('CASCADE');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('users');
  }
}
