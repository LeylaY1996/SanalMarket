<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Kullanici;

class KullaniciKayitMail extends Mailable
{
    use Queueable, SerializesModels;

    public $kullanici;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Kullanici $kullanici)
    {
        //mailviewin içinde ekstra bir değşiiken kullanmak istiyorsak burada belirtmeliyiz
        $this->kullanici=$kullanici;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        //mail ayarları buradan yapılır
        return $this
            //from kimden gönderileceği
            //->from('leylay1996@gmail.com') kimden geldiğini sürekli belirtmemek için env dosyasına tanımladık
            //konu başlığı
            ->subject(config('app.name').'-Kullanıcı Kaydı')
            //mail içeriği view kısmından ayarlanır
            //kullanici_kayit isminde view dosyası oluşturulur
            ->view('mails.kullanici_kayit');
    }
}
