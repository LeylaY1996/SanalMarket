{{-- anasayfaya yönlendirme yapıldıktan sonra with ile gönderdikten sonra sessionda tutulduğu için burada mesaj bilgisi varsa döngüye gir.--}}
         @if(session()->has('mesaj'))
            <div class="container">
                <div class="alert alert-{{ session('mesaj_tur') }}">{{ session('mesaj') }}</div>
            </div>
         @endif