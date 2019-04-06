<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('fieldable');
            $table->string('name');
            $table->unsignedInteger('field_order')->nullable();
            $table->timestamps();
        });

        Schema::create('field_rows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('fieldable');
        });

        Schema::create('field_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('fieldable');

            $table->bigInteger('field_id')->unsigned();
            $table->foreign('field_id')->references('id')
                ->on('fields')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->bigInteger('field_rows_id')->unsigned();
            $table->foreign('field_rows_id')->references('id')
                ->on('field_rows')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->binary('value');
            $table->unique(['field_id', 'field_rows_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('field_values');
        Schema::dropIfExists('field_rows');
        Schema::dropIfExists('fields');
    }
}
