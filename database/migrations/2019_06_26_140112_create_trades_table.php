<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('unit_price')->comment('قیمت هر واحد');
            $table->unsignedBigInteger('units')->comment('تعداد واحدهای معامله شده');
            $table->enum('type', ['sell', 'buy'])->comment('نوع معامله');
            $table->unsignedBigInteger('wage')->comment('کارمزد معاله')->nullable();
            $table->unsignedBigInteger('total_amount')->comment('جمع مبلغ واحدها و کارمزد برا خرید و مبلغ نهایی پس از کسر کارمزد برای فروش ')->nullable();
            $table->enum('status', ['done', 'half', 'going'])->comment('نوع معامله');
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
        Schema::dropIfExists('trades');
    }
}
