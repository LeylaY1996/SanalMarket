<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class urun extends Model
{
    use SoftDeletes;

    //bu tablo adından ulaşılacaağını belirttik
    protected $table="urun";
  
    protected $guarded=[];

    //bir ürüne ait kategorileri çekmek istersek
    //belongstomany çoka çok mimarisini sağlar.
     public function kategoriler(){
    	return $this->belongsToMany('App\Models\Kategori','kategori_uruns'); 
    }

    public function detay(){
    	//urunmodel içerisinde ürüne ait olan detay bilgilerini çekebilmek için hasone ile çekebiliyoruz.
    	return $this->hasOne('App\Models\UrunDetay');
    }
}
