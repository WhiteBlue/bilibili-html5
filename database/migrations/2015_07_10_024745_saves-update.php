<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SavesUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saves', function($table)
        {
            $table->integer('play')->unsigned();
            $table->date('create');
            $table->string('author', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saves', function($table)
        {
            $table->dropColumn('play');
            $table->dropColumn('create');
            $table->dropColumn('author');
        });
    }
}
