<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urun', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug',160);
            $table->string('urun_adi',150);
            $table->text('aciklama');
            $table->decimal('fiyati',6,3);
            $table->timestamps();
            //bu özellik otomatik olarak veritabanında deleted_at isimli kolonu oluşturur(silinme tarihi)
            $table->softDeletes()->nullable();
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
        Schema::dropIfExists('urun');
    }
}
