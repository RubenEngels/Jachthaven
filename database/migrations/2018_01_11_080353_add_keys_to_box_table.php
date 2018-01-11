<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKeysToBoxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boxes', function (Blueprint $table) {
          $table->double('length')->after('isWalplaats')->nullable();
          $table->double('width')->after('isWalplaats')->nullable();
          $table->double('depth')->after('isWalplaats')->nullable();
          $table->integer('pier_id')->after('isWalplaats')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boxes', function (Blueprint $table) {
          $table->dropColumn(['length', 'width', 'depth', 'pier_id']);
        });
    }
}
