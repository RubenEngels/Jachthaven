<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boxes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('public_id');
            $table->boolean('isWalplaats');
            $table->timestamps();
        });

        Schema::table('boats', function(Blueprint $table) {
          $table->integer('box_id')->nullable();
        });

        for ($i=0; $i < 200; $i++) {
          App\Box::create([
            'public_id' => $i,
            'isWalplaats' => false
          ]);
        }
        for ($i=0; $i < 200; $i++) {
          if ($i % 10 == 0 OR $i == 0) {
            $pier = Pier::create([
              'public_id' => $pier_id + 1,
            ]);
            $pier_id = $pier->id;
          }
          Box::create([
            'public_id' => $i + 1,
            'isWalplaats' => false,
            'pier_id' => $pier_id
          ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boxes');

        Schema::table('boats', function (Blueprint $table) {
          $table->dropColumn(['box_id']);
        });
    }
}
