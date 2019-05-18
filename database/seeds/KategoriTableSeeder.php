<?php

use Illuminate\Database\Seeder;

class KategoriTableSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	//truncate komutu sayesinde tablodaki tüm verileri sıfırlayacaktır.
        DB::table('kategori')->truncate();

        //veri eklemek içinde insert komutu kullanılır.
       $id= DB::table('kategori')->insertGetId(['kategori_adi'=>'Elektronik','slug'=>'elektronik']);
       //gelen id degerine göre alt kategoriler oluşur
       DB::table("kategori")->insert(['kategori_adi'=>'Bilgisayar/Tablet','slug'=>'bilgisayar-tablet','ust_id'=>$id]);
       DB::table("kategori")->insert(['kategori_adi'=>'TV/Ses Sistemi','slug'=>'tv-sessistemi','ust_id'=>$id]);

       $id=DB::table('kategori')->insertGetId(['kategori_adi'=>'Kitap','slug'=>'kitap']);
        //gelen id degerine göre alt kategoriler oluşur
       DB::table("kategori")->insert(['kategori_adi'=>'Kitap/edebiyat','slug'=>'Kitap-edebiyat','ust_id'=>$id]);

        DB::table('kategori')->insert(['kategori_adi'=>'Dergi','slug'=>'dergi']);
        DB::table('kategori')->insert(['kategori_adi'=>'Mobilya','slug'=>'Mobilya']);
        DB::table('kategori')->insert(['kategori_adi'=>'Dekorasyon','slug'=>'dekorasyon']);
        DB::table('kategori')->insert(['kategori_adi'=>'Kozmetik','slug'=>'kozmetik']);
        DB::table('kategori')->insert(['kategori_adi'=>'Giyim','slug'=>'giyim']);
        DB::table('kategori')->insert(['kategori_adi'=>'Mutfak','slug'=>'mutfak']);
        DB::table('kategori')->insert(['kategori_adi'=>'Dergi','slug'=>'dergi']);
        DB::table('kategori')->insert(['kategori_adi'=>'Mobilya','slug'=>'Mobilya']);
        DB::table('kategori')->insert(['kategori_adi'=>'Dekorasyon','slug'=>'dekorasyon']);
        DB::table('kategori')->insert(['kategori_adi'=>'Kozmetik','slug'=>'kozmetik']);
        DB::table('kategori')->insert(['kategori_adi'=>'Giyim','slug'=>'giyim']);
        DB::table('kategori')->insert(['kategori_adi'=>'Mutfak','slug'=>'mutfak']);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
