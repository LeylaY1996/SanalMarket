<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'AnasayfaController@index')->name('anasayfa');


Route::get('/kategori/{slug_kategoriadi}','KategoriController@index')->name('kategori');

Route::get('/urun/{slug_urunadi}','UrunController@index')->name('urun');

Route::post('/ara', 'UrunController@ara')->name('urun_ara');
Route::get('/ara', 'UrunController@ara')->name('urun_ara');


Route::group(['prefix'=>'sepet'], function(){
	Route::get('/','sepetController@index')->name('sepet');
	Route::post('/ekle', 'sepetController@ekle')->name('sepet.ekle');
	Route::delete('/kaldir/{rowid}','sepetController@kaldir')->name('sepet.kaldir');
	Route::delete('/bosalt','sepetController@bosalt')->name('sepet.bosalt');
	Route::patch('/guncelle/{rowid}','sepetController@guncelle')->name('sepet.guncelle');
});


//tek route tanımı için middleware('auth') kısmı
//Route::get('/sepet','sepetController@index')->name('sepet')->middleware('auth');

//sadece giriş yapmış kullanıcıların(bunuda middleware-auth komutları sağlar) göreceği sayfaları grupladık.
Route::group( ['middleware'=>'auth'], function(){

	Route::get('/odeme','OdemeController@index')->name('odeme');
	Route::get('/siparis','siparisController@index')->name('siparisler');
	Route::get('/siparis/{id}','siparisController@detay')->name('siparis');
});


Route::group(['prefix'=>'kullanici'],function(){
		Route::get('/kaydol','KullaniciController@kaydol_form')->name('kullanici.kaydol');
		Route::post('/kaydol','KullaniciController@kaydol');

		Route::get('/oturumac','KullaniciController@giris_form')->name('kullanici.oturumac');
		Route::post('/oturumac','KullaniciController@giris');

		Route::get('/aktiflestir{anahtar}','KullaniciController@aktiflestir')->name('aktiflestir');

		Route::post('/oturumukapat','KullaniciController@oturumukapat')->name('kullanici.oturumukapat');
});

Route::get('/test/mail' ,function(){
	$kullanici=\App\Models\Kullanici::find(1);
	return new App\Mail\KullaniciKayitMail($kullanici);
});