<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kullanici  extends Authenticatable
{   
    
    use SoftDeletes;
    //tablo adımızı belirtiyoruz
    protected $table="kullanici";
  
    //fillable ile create komutuyla oluşturacağımız yani doldurcağımız alan belirlenir
    protected $fillable = ['adsoyad', 'email', 'sifre','aktivasyon_anahtari','aktif_mi'];

    //veri çekme işlemi sonrasında kullanıcıların görmesini istemediğimiz gizli alanlarıda burada hidden özelliğiyle belirtebiliriz
    //hidden özelliği verdiğimiz değerdede srogulama işlemi yapamıyoruz.
    protected $hidden = ['sifre', 'aktivasyon_anahtari'];

    public function getAuthPassword(){
    	return $this->sifre;
    }

}