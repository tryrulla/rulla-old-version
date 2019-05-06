<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemInstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_instances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label')->nullable();

            $table->bigInteger('type_id')->unsigned()->nullable();
            $table->foreign('type_id')
                ->references('id')
                ->on('item_types');

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
        Schema::dropIfExists('item_instances');
    }
}
