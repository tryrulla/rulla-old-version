<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('author_id');
            $table->foreign('author_id')
                ->references('id')
                ->on('users');

            $table->dateTime('starts_at');
            $table->dateTime('ends_at');

            $table->string('approval_status');

            // true if at least one item has been read out
            $table->boolean('started')
                ->default(false);

            $table->boolean('cancelled')
                ->default(false);

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
        Schema::dropIfExists('reservations');
    }
}
