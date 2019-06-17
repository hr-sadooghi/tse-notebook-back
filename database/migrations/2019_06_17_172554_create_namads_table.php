<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNamadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('namads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('symbol', 50)->unique()->nullable(false);//sf
            $table->string('id_code', 20)->nullable();
            $table->string('company_12_digit_name', 12)->nullable();//nc
            $table->integer('company_category_id')->nullable();//sc
            $table->string('company_name', 150);//cn
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
        Schema::dropIfExists('namads');
    }
}
