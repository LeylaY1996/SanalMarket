<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Kullanici;
use App\Mail\KullaniciKayitMail;
use Mail;
use Cart;
class KullaniciController extends Controller
{
	//controller içindeki metodlara sadece giriş yapmamış kişilerin erişmesini istiyorsak middleware(guest) tanımıyla yapıyoruz.
	public function __construct(){
		//yapıcı metodumuzu oluşturup middleware tanımlaması yapıyoruz.
		$this->middleware('guest')->except('oturumukapat');
		//except olayı haricinde mantığı yani oturumukapat metoduna giriş yapmamış olan kişiler erişemeyecek.
	}

	public function giris_form(){
		return view('kullanici.oturumac');
	}

	public function giris(){
		//giris yaptıktan sonra gelen ne tür bilgileri dogrulayacaksak validate içine yazılır.
		$this->validate(request(),[
			'email'=>'required|email',
			'sifre'=>'required'
		]);

		//laravelin özelliklerinden olan attemp komutuyla gelen bilgileri gönderebiliriz
		if(auth()->attempt(['email'=>request('email'),'password'=>request('sifre')] , request()->has('benihatırla')))
		{
			//session bilgimizi yenileyelim
			request()->session()->regenerate();

			//kullanici id yi giriş yapan kullanıcının idsinden almak gerekir bulamazsa bu degere ait olan kullanıcıyı veritabanında oluşturacaktır.
			$aktif_sepet_id=Sepet::firstOrCreate(['kullanici_id'=>auth()->id()])->id;
			session()->put('aktif_sepet_id',$aktif_sepet_id);

			//eğer içinde ürün varsa
			if(Cart::count()>0){
				foreach (Cart::content() as $cartItem) {
					SepetUrun::updateOrCreate(
						['sepet_id'=>$aktif_sepet_id,'urun_id'=>$cartItem->id]
						['adet'=>$cartItem->qty,'fiyati'=>$cartItem->price,'durum'=>'Beklemede']
					);
				}
			}

			Cart::destroy();
			$sepetUrunler=SepetUrun::where ('sepet_id',$aktif_sepet_id)->get();
			foreach ($sepetUrunler as $sepetUrun) {
				Cart::add($sepetUrun->urun->id , $sepetUrun->urun->urun_adi , $sepetUrun->adet , $sepetUrun->urun->fiyati ,['slug'=>$sepetUrun->urun->slug]);
			}
			//kullanıcı herhangi bir sayfaya giriş yapmak istediğinde yetki hatası aldığında giriş sayfasına yönlendirilecektir
			//şimdi anasayfaya yönlendirme yaptık
			 return redirect()->intended('/');

		}else{
			//kullanıcı girişi gerçekleşmezse hata mesajı verilir.
			$errors=['email'=>'Hatalı giriş'];
			//tekrar giriş yaptığımız sayfaya yönlendirme yaparız.
			return back()->withErrors($errors);
		}
	}


	public function kaydol_form(){
		return view('kullanici.kaydol');
	} 

	public function kaydol(){
		//formdan gelen verileri alarak kaydolma işlemini halledeceğiz.
		//kullanici modeli kullanarak bir kayıt oluşturma işlemini oluşturuyoruz.


		//laravelde bir kayıt işleminden önce bir doğrulama işlemi yapabiliyoruz 
		$this->validate(request(),[
			//adsoyadın girilmesi zorunlu olan alanıdır.(required)
			//birden fazla dogrulama işlemi yapmak istiyorsak | koyup bağlıyoruz
			'adsoyad'=>'required|min:5|max:60',

			//unique sayesinde daha önce girilen bir mail adresinin tekrar kaydını yaptırmayacaktır.
			'email'=>'required|email|unique:kullanici',
			//confirmed -> girilen şifrenin tekrarının olacağını ve eşit olması gerektiğini belirtir.
			'sifre'=>'required|confirmed|min:5|max:15',
		]);

		$kullanici=Kullanici::create([
			//sırasıyla veritabanına ekleyceğimiz kayıtları belirtiyoruz.
			//request ile formdan gelen degerleri alabiliriz.
			'adsoyad'=>request('adsoyad'),
			'email'=>request('email'),
			'sifre'=>Hash::make(request('sifre')),
			//60 karakterlik rastgele bir metin oluşcak
			'aktivasyon_anahtari'=>Str::random(60),
			'aktif_mi'=>0
		]); 

		//göndereceğimiz kişiye ait mail adresi
		//requestlede formda gelen mail adresi olmalı
		//cc başka kişilere.bcc gizli kişilere
		Mail::to(request('email'))->send(new KullaniciKayitMail($kullanici));
		//kullanici verilerini veritabanına ekledikten sonra sisteme girişide otomatik olarak gerçekleştirebiliriz
		//özel bir komut olan auth ile sağlarız
		auth()->login($kullanici);

		return redirect()->route('anasayfa');
	}
	public function aktiflestir($anahtar){
		//gelen anahtarla ait kullanıcıyı bulucaz ve bu kullanıcının kaydını değiştircez
		//aktivasyon anahtarıyla,anahtarın eşit olduğu değeri bulup aktifleştircez
		$kullanici=Kullanici::where('aktivasyon_anahtari',$anahtar)->first();
			if(!is_null($kullanici)){//içine gelen kayıt varsa
				$kullanici->aktivasyon_anahtari=null;
				$kullanici->aktif_mi=1;
				$kullanici->save();
				//kullanici bilgilerini kaydettikten sonra bağlantımızı redirect komutuyla anasayfaya yönlendirebiliyoruzmesaj bilgisiyle beraber.
				return redirect()->to('/')
				->with('mesaj','Kullanıcı kaydınız aktifleştirildi.')
				->with('mesaj_tur','success');
			}else{
				return redirect()->to('/')
				->with('mesaj','Kullanıcı kaydınız aktifleştirilemedi.')
				->with('mesaj_tur','warning');
			}
	}
	
	public function oturumukapat(){
			//çıkış işlemi logout ile sağlandı.
			auth()->logout();

			//session içinde yer alan bilgileride sıfırlıyoruz.
			request()->session()->flush();

			//yine session id degerinide sıfırlarız.
			request()->session()->regenerate();

			//çıkış işleminden sonrada anasayfaya yönlendirme yapabiliriz
			return redirect()->route('anasayfa');


	}
}
