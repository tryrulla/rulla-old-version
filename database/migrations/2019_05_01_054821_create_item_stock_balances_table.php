<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemStockBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_stock_balances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('amount');

            $table->bigInteger('type_id')->unsigned()->nullable();
            $table->foreign('type_id')
                ->references('id')
                ->on('item_types');

            $table->bigInteger('location_id')->unsigned()->nullable();
            $table->foreign('location_id')
                ->references('id')
                ->on('locations');

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
        Schema::dropIfExists('item_stock_balances');
    }
}
