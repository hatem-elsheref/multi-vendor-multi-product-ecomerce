<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');//stock
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->string('model')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->longText('description');
            $table->float('price');
            $table->integer('qty');
            $table->text('colors')->nullable();//red,green,blue
            $table->text('sizes')->nullable();//s,m,l,xl
            $table->enum('quality_rate',[0,1,2,3,4,5])->default(0);//1,2,3,4,5
            $table->enum('value_rate',[0,1,2,3,4,5])->default(0);//1,2,3,4,5
            $table->enum('price_rate',[0,1,2,3,4,5])->default(0);//1,2,3,4,5
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
