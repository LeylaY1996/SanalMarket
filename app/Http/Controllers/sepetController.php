<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Contracts\InstanceIdentifier;
use\Cart;
use App\Models\urun;
use App\Models\Sepet;
use App\Models\SepetUrun;
use Validator;


class SepetController extends Controller
{

	//kullanıcı giriş yapmadan sepet sayfasını göremeyecek(middleware(auth) un controllerde kullanımı)
	//public function __construct(){
	//	$this->middleware('auth');
	//}

    public function index(){
    	return view('sepet');
    }

    public function ekle(){
    	//formdan gelen id degerini request ile alırız
    	$urun=urun::find(request('id'));
    	//kütüphanemizi kullanarak bu ürünü nasıl ekliyoruz
    	$cartItem=Cart::add($urun->slug, $urun->urun_adi,1,$urun->fiyati,['id'=>$urun->slug]);
        
        //bu döngü kullanıcı girişi yapıldıysa sepet kaydı oluşturuyoruz
        if(auth()->check())
        {
            //bir sepet oluşturulmuş ve bir daha sepet kaydı oluşturulmasını istemiyorsak
            //aktif sepet id sessionda var mı kontrol edelim
            $aktif_sepet_id=session('aktif_sepet_id');
            if(!isset($aktif_sepet_id)){
                   //öncelikle sepet kaydı oluşturcaz
                    $aktif_sepet=Sepet::create([
                        'kullanici_id'=>auth()->id()
                    ]);
                    $aktif_sepet_id=$aktif_sepet->id;
                    //aktif sepet idsinide sessiondada saklayabiliriz.
                    session()->put('aktif_sepet_id',$aktif_sepet_id);  
            }

            //şimdi ise sepete ürün ekleme mantığını oluşturcaz.Sepeturunmodel sınıfını kullanıcaz
            SepetUrun::updateOrCreate(
                //updateorcreate mantığı bu kaydı bulursa ikinci gönderdiğimiz parametrelerle güncelleme işlemini otomatik yapacak
                ['sepet_id'=>$aktif_sepet_id ,'urun_id'=>$urun->id],
                ['adet'=>$cartItem->qty, 'fiyati'=>$urun->fiyati,'durum'=>'Beklemede']
            );

        }    	  

        //sepete ekleme işleminden sonra sepet sayfasına yönlendirme yapabiliriz
    	return redirect()->route('sepet')
    	   ->with('mesaj_tur','success')
    	   ->with('mesaj','Ürün Sepete Eklendi');
    }

    public function kaldir($rowid){

        //sepetten bir ürünü kaldırdığımızd aynı zamanda veritabanındanda kalkması lazım
        //yine kullanıcı giriş yaptımı bunu kontrol edicez
        if(auth()->check()){
              $aktif_sepet_id=session('aktif_sepet_id');
              //cart sınıfının get metodu verilen rowidye ait olan sepet urun degerini elde ederiz
              $cartItem=Cart::get($rowid);
              //veritabanındaki deleted_at isimli kolona tarih eklenmiş olacak.
              SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id',$cartItem->id)->delete();
        }
        Cart::remove($rowid);

        return redirect()->route('sepet')
          ->with('mesaj_tur','success')
          ->with('mesaj','Ürün sepetten kaldırıldı.');
    }

    public function bosalt(){

         if(auth()->check()){
            //sepeti boşalt butonuna tıkladığımızda veritabanındaki verilerin silinme tarihleri eklencektir.
              $aktif_sepet_id=session('aktif_sepet_id');
              SepetUrun::where('sepet_id',$aktif_sepet_id)->delete();
        }
        Cart::destroy();

        return redirect()->route('sepet')
          ->with('mesaj_tur','success')
          ->with('mesaj','Sepetiniz boşaltıldı.');

    }

    public function guncelle($rowid){
        //ajax ile işlem yapıldığı için redirect komutuyla yönlendirme yapılmadı
        $validator=Validator::make(request()->all(),[
              'adet'=>'required|numeric|between:0,5'  

        ]);    

         if(auth()->check()){
            //sepeti boşalt butonuna tıkladığımızda veritabanındaki verilerin silinme tarihleri eklencektir.
              $aktif_sepet_id=session('aktif_sepet_id');
              $cartItem=Cart::get($rowid);

              if(request('adet')==0)
                //adet bilgisi sıfırsa veritabanından siler.
                 SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id',$cartItem->id)->delete();
              else
                 SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id',$cartItem->id)->update(['adet'=>request('adet')]);
        }
        //fails bir hata oluştuğu andaki
        if($validator->fails()){
            session()->flash('mesaj_tur','danger');
            session()->flash('mesaj','Adet değeri 1 ile 5 arasında olmalıdır.');

            return response()->json(['success'=>false]);
        }   //if bloguna girmezse aşagıdaki satırlar çalışacaktır.

        Cart::update($rowid,request('adet'));
        session()->flash('mesaj_tur','success');
        session()->flash('mesaj','Adet bilgisi güncellendi');

        return response()->json(['success'=>true]);
    }
}


