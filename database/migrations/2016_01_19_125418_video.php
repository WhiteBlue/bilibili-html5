<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class Video extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function ($table) {
            $table->bigIncrements('aid');
            $table->string('title');
            $table->string('author');
            $table->string('description');
            $table->timestamp('created');
            $table->dateTime('created_at');
            $table->string('face');
            $table->string('typename');
            $table->integer('pages');
            $table->string('list');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
