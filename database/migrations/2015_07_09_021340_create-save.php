<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSave extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saves', function ($table) {
            $table->increments('id');
            $table->integer('sort_id')->unsigned();
            $table->string('aid', 30);
            $table->string('title', 50);
            $table->string('content', 200);
            $table->string('href', 100);
            $table->string('img', 100);
            $table->timestamps();
            $table->foreign('sort_id')
                ->references('id')->on('sorts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('saves');
    }
}
