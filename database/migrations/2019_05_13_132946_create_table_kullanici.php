<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableKullanici extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kullanici', function (Blueprint $table) {
            $table->increments('id');
            $table->string('adsoyad',60);
            $table->string('email',150)->unique();
            $table->string('sifre',60);
            $table->string('aktivasyon_anahtari',60)->nullable();
            $table->boolean('aktif_mi')->default(0);
            
            $table->timestamps();

            $table->engine='InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_kullanici');
    }
}
