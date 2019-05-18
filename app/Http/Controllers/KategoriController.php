<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index($slug_kategoriadi){
    	$kategori=Kategori::where('slug',$slug_kategoriadi)->firstOrFail();
    	$alt_kategoriler=Kategori::where('ust_id',$kategori->id)->get();

    	//kategoribladede hreflerle yönlendirme yaptığımız değerleri orderları requestle alabiliriz
    	$order=request('order');
    	//distinct aynı verilerin tekrarlanmasını önleyecek
    	if($order=='coksatanlar'){

    			$urunler=$kategori->urunler()
    			->distinct()
    			->join('urun_detay','urun_detay.urun_id','urun.id')
    			->orderBy('urun_detay.goster_cok_satan','desc')
    			->paginate(2);

    	}else if($order=='yeni'){
    		//yeniolmasını oluşturma tarihine göre filtreleriz
    		$urunler=$kategori->urunler()
    		->distinct()
    		->orderByDesc('updated_at')
    		->paginate(2);

    	}else{

    		$urunler=$kategori->urunler()
    		->distinct()
    		->paginate(2);
    	}

    	return view('kategori',compact('kategori','alt_kategoriler','urunler'));
    }
}
