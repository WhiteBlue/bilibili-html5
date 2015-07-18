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
            $table->string('aid');
            $table->string('mid');
            $table->string('cid');
            $table->string('typename');
            $table->string('title');

            $table->integer('play');
            $table->integer('review');
            $table->integer('video_review');
            $table->integer('favorites');
            $table->integer('coins');
            $table->integer('pages');

            $table->string('author');
            $table->string('face');
            $table->text('description');
            $table->string('tag');

            $table->string('pic');
            $table->time('created_at');

            $table->string('offsite');

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
