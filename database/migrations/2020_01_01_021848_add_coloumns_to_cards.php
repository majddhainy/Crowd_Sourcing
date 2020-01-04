<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnsToCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workshops', function (Blueprint $table) {
            $table->boolean('can_vote')->default(0);
            $table->boolean('can_submit')->default(0);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('can_vote');
            $table->dropColumn('can_submit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('can_vote')->default(0);
            $table->boolean('can_submit')->default(0);
        });
        Schema::table('workshops', function (Blueprint $table) {
            $table->dropColumn('can_vote');
            $table->dropColumn('can_submit');
        });
    }
}
