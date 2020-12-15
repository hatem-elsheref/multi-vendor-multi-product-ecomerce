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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('stock')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('image')->default('uploads/users/default-user.png');
            $table->enum('role',['admin','seller','customer'])->default('customer');
            $table->enum('status',['blocked','unblocked'])->default('unblocked');
            $table->string('password');
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->dateTime('plan_starting_date')->nullable();
            $table->boolean('is_best_seller')->default(false);
            $table->string('tmp_key')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // remove plan will remove the seller and his products and orders
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
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
