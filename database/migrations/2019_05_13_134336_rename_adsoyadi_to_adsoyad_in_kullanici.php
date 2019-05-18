<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameAdsoyadiToAdsoyadInKullanici extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kullanici', function (Blueprint $table) {
            //
            $table->rename('adsoyadi', 'adsoyad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kullanici', function (Blueprint $table) {
            
            $table->rename('adsoyad', 'kullanici');
        });
    }
}
