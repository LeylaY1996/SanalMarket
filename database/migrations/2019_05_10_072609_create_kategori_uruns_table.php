<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKategoriUrunsTable extends Migration
{
    public function up()
    {
        //bu tablo ara bir tablo olacak bu yüzden sadec kategori ve ürünle ilgili bilgi olacak
        Schema::create('kategori_uruns', function (Blueprint $table) {
            $table->increments('id');
            //unsigned sayesinde negatif değerler girilmeyecek
            $table->integer('kategori_id')->unsigned();
            $table->integer('urun_id')->unsigned();

            //eklediğimiz bu iki alan için foreign key tanımlaması yapacağız.

            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
            $table->foreign('urun_id')->references('id')->on('urun')->onDelete('cascade');

            //foreıgn key olarak tanımladığımız değerlerin eşitlenmesi için
            $table->engine='InnoDB';
        
        });
    }

    public function down()
    {
        Schema::dropIfExists('kategori_uruns');
    }
}
