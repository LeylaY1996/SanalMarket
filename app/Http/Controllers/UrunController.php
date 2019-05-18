<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//urun modelini kullandığımız için namespace tanımınıda ekliyoruz
use App\Models\urun;

class UrunController extends Controller
{
    public function index($slug_urunadi){

    	$urun=urun::whereSlug($slug_urunadi)->firstOrFail();
    	$kategoriler=$urun->kategoriler()->distinct()->get();
    		return view('urun',compact('urun'));

    }
    public function ara(){
    	//öncelikle formdan gönderdiğimiz veriyi almamız gerekmektedir
    	//birincisi requestle bir formdan gönderilen herhangi bir input degerini
    	$aranan=request()->input('aranan');
    	//aranan degerine ait urunleri bulalım
    	//orwhere ekstra bir sorgu oluşturmaya yarar
    	//arama işlemini sadec ürün adında değilde açıklama kısmındada geçebilir
    	$urunler=urun::where('urun_adi','like', "$aranan%")
    		->orWhere('aciklama','like',"%$aranan%")
    		->paginate(8);
    		// dd($urunler);

    		//paginate görmek istediğimiz kayıt sayısını verir listelemeyi sağlar
    		request()->flash();

    	return view('arama' , compact('urunler','aranan'));

    }
}
