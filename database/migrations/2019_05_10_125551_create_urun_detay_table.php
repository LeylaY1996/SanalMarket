<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrunDetayTable extends Migration
{
    
    public function up()
    {
        Schema::create('urun_detay', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('urun_id')->unsigned()->unique();
            //varsayılan olarak sıfır değeri verildi bu gösterilmeyecektir.
            $table->boolean('goster_slider')->default(0);
            $table->boolean('goster_gunun_firsati')->default(0);
            $table->boolean('goster_one_cikan')->default(0);
            $table->boolean('goster_cok_satan')->default(0);
            $table->boolean('goster_indirimli')->default(0);
            $table->timestamps();

            //urun tablosuyla eşleştirme yapıldı(foreıgn key sayesinde)
            $table->foreign('urun_id')->references('id')->on('urun')->onDelete('cascade');

            //ondelete(cascade) işlemi urundetay tablosunda silindiğinde urun tablosundada silinmesini sağlar.

            //foreıgn key olarak tanımladığımız değerlerin eşitlenmesi için
            $table->engine='InnoDB';
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('urun_detay');
    }
}
