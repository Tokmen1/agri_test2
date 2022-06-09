<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldAddOns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_add_ons', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('name');
            $table->double('amount_per_ha');
            $table->double('cost');
            $table->date('date_from');
            $table->date('date_to')->nullable();
            $table->foreignId('field_id')
                ->constrained('fields')
                ->onDelete('cascade');
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
        Schema::dropIfExists('field_add_ons');
    }
}
