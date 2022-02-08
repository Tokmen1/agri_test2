<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHarvestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harvest', function (Blueprint $table) {
            $table->id();
            $table->double('quantity');
            $table->double('sell_price');
            $table->date('date_from');
            $table->date('date_to')->nullable();
            $table->foreignId('field_id')
                ->constrained('fields')
                ->onDelete('cascade');;
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
        Schema::dropIfExists('harvest');
    }
}
