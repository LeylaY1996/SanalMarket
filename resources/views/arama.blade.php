@extends('layouts.master')
@section('content')

			<div class="container">

				<ol class="breadcrumb">
					<li><a href="{{route('anasayfa')}}">Anasayfa</a></li>
					<li class="active">Arama Sonucu</li>
				</ol>

				<div class="products bg-content">
					<div class="row">
						{{--Arama sonucunda hiçbir ürün bulunamazsa uyarı mesajı vercez--}}
						@if ($urunler->count()==0)
							<div class="col-md-12 text-center">
								Bir ürün bulunamadi!
							</div>
						@endif

						@foreach($urunler as $urun)
						<div class="col-md-3 product">
							<a href="{{route('urun',$urun->slug)}}">
								<img src="http://lorempixel.com/400/485/food/1" alt="{{$urun->urun_adi}}">
							</a>
							<p>
								<a href="{{route('urun',$urun->slug)}}">
									{{$urun->urun_adi }}
								</a>
							</p>
							<p class="price">{{$urun->fiyati}}₺</p>
						</div>
						@endforeach
					</div>
					{{--links fonknu sayfalandırmayla ilgili bağlantıları otomatik sağlar.
						links fonknu sayesinde sayfada ilerlemek içn sayfa numaraları gelecektir.
						appends ile linke otomatik olarak eklemede yapabiliriz. e   
						--}}
					
				</div>
				{{$urunler->appends(['aranan'=>old('aranan')])->links()}}
			</div>
@endsection