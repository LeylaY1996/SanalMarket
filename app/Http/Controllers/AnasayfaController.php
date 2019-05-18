<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UrunDetay;
use App\Models\Kategori;
use App\Models\urun;

class AnasayfaController extends Controller
{
    public function index(){
    	//veritabanından kategorileri çekip burada bir değişkene aktarcaz.


    	//burada ketegori sınıfını  kullanabilmemiz için yukarıda tanımlamamız gerek
    	//take komutuyla belirli sayıdaki kayıtları çekmemizi sağlar
    	$kategoriler=Kategori::whereRaw('ust_id is null')->take(8)->get();
    	//ust_id is null demek ana kategorileri al demek


        //ürünleri anasayfada çekmek için ama değeri 1 olanları
        $urunler_slider=Urun::select('urun.*')->join('urun_detay','urun_detay.urun_id','urun.id')->where('urun_detay.goster_slider',1)->orderBy('updated_at','desc')->first()->take(4)->get();

        //ilişkili tablolardaa verilerin çekilmesini sağlar.
        $urun_gunun_firsati=Urun::select('urun.*')->join('urun_detay','urun_detay.urun_id','urun.id')->where('urun_detay.goster_gunun_firsati',1)->orderBy('updated_at','desc')->first()->take(4);

        // dd($urun_gunun_firsati);
        $urunler_one_cikan=Urun::select('urun.*')->join('urun_detay','urun_detay.urun_id','urun.id')->where('urun_detay.goster_one_cikan',1)->orderBy('updated_at','desc')->first()->take(4)->get();

        $urunler_cok_satan=Urun::select('urun.*')->join('urun_detay','urun_detay.urun_id','urun.id')->where('urun_detay.goster_cok_satan',1)->orderBy('updated_at','desc')->first()->take(4)->get();

        $urunler_indirimli=Urun::select('urun.*')->join('urun_detay','urun_detay.urun_id','urun.id')->where('urun_detay.goster_indirimli',1)->orderBy('updated_at','desc')->first()->take(4)->get();

    	//veritabanından kategoriler tablosundan tüm verileri çekiyoruz.
        //çekmek istediğimiz her veriyi view içine yerleştirmek zorundayız.\
        return view('anasayfa',compact('kategoriler','urunler_slider','urun_gunun_firsati','urunler_one_cikan','urunler_cok_satan','urunler_indirimli'));
    	//kategorileri anasayfada göstereceğimiz için anasayfacontrolleri kullanırız.


    }
}