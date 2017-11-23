<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Settings;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->float('ligplaats_huur_prijs')->default(5.95);
            $table->float('box_jaar_huur')->default(350.00);
            $table->float('toeristen_belasting')->default(0.84);
            $table->integer('btw')->default(21);
            $table->float('inschrijf_geld')->default(45);
            $table->float('lidmaatschap_prijs')->default(25);
            $table->string('kraan_tijd_vereist')->default(30);
            $table->timestamps();
        });
        
        Settings::create([]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
