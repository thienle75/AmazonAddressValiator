<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->enum('type', ['civic','pobox','pobox_civic','rural','rural_civic']);
            $table->string('name');
            $table->integer('street_number')->unsigned();
            $table->string('street_name');
            $table->string('street_type');
            $table->string('street_direction');
            $table->string('city');
            $table->string('postal_code');
            $table->string('province');
            $table->string('country');
            $table->string('suite');
            $table->string('buzzer');
            $table->string('pobox');
            $table->string('rural_route');
            $table->string('station');
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('addresses');
    }

}
