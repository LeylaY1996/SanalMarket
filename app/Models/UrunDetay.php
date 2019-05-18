<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrunDetay extends Model
{
    protected $table="urun_detay";

    //buradad created_at ve updated_at gibi kolonların oluşmasını istemezsek false yaparız 
    public $timestamp=false;


    public function urun(){
    	//belogsto->hasone a karşılıktır
    	//urun modelindeki fonksiyona ulaşmak için
    	return $this->belongsTo('App\Models\urun');
    }
}
