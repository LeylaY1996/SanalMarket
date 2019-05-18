<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
	use SoftDeletes;
    //vereceğimiz değere göre tabloya erişim sağlayacağızdır.
    protected $table="kategori";
  
	//protected $fillable=['kategori_adi','slug'];
	protected $guarded=[];
    //const DELETED_AT='silinme tarihi';


	//bir kategoriye ait ürünleri çekmek istersek
    public function urunler(){
    	return $this->belongsToMany('App\Models\Urun','kategori_uruns');
    }
}

