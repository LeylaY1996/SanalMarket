<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SepetUrun extends Model
{
    //softdelete yapısını kullanacağımız için 
    use SoftDeletes;
    //tablomuzun adını ayaarlayalım
    protected $table="sepet_urun";
    //tüm kolonların doğrudan eklenebilir olduğu
    protected $guarded=[]; 

    public function urun(){
    	return $this->belongsTo('App\Models\Urun');
    }

}
