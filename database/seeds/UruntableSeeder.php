<?php

use Illuminate\Database\Seeder;
use App\Models\Urun;
use App\Models\UrunDetay;


class UruntableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker\Generator $faker)
    {
        //foreign key hatalarını göz ardı etmek için
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        //urun tablomuzu tamamen boşaltmış olduk
        Urun::truncate();
        UrunDetay::truncate();
        $urun_adi=$faker->sentence(2);

        //30 tane ürün ekleme işlemini gerçekleştiriyoruz.
        for($i=0;$i<30;$i++){
            $urun_adi=$faker->streetName;

            $urun=Urun::create([
            'urun_adi'=>$urun_adi,
            'slug'=>str_slug($urun_adi),
            'aciklama'=>$faker->sentence(20),
            'fiyati'=>$faker->randomFloat(3,1,20)

        ]);

            //urune ait detay bilgilerini oluşturmak için;
        $detay=$urun->detay()->create([
            //oluşan tablodaki degerler rastgele olarak rand fonku yardımıyla oluşacaktır
            'goster_slider'=>rand(0,1),
            'goster_gunun_firsati'=>rand(0,1),
            'goster_one_cikan'=>rand(0,1),
            'goster_cok_satan'=>rand(0,1),
            'goster_indirimli'=>rand(0,1)
        ]);

        }
        //tüm komutlar calıştıktan sonra tekrardan bunu açmammız lazım
         DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
