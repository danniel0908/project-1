@extends('landing.layout')
<title>Index</title>

@section('content')
<section id="hero" class="hero section">
    <div class="hero-bg">
        <img src="{{ url('landing/assets/img/sanpedro.jpg') }}" alt="">
    </div>
    <div class="container text-center">
        <div class="d-flex flex-column justify-content-start align-items-center" style = "width: 100%">
            <div class = "welcome">
                <h1 data-aos="fade-up" class="">{{ __('messages.welcome_message') }}<span style="margin-left: 10px;">PERMISO</span></h1>
                <p data-aos="fade-up" data-aos-delay="100" class="">{{ __('messages.description') }}<br></p>
            </div>
            <div class="d-flex">
                <a href="{{ route('landing.about') }}" class="btn-get-started">{{ __('messages.get_started') }}</a>
                <a href="{{('landing/Videos.mp4')}}" class="glightbox btn-watch-video d-flex align-items-center" data-type="video" data-autoplay="false" data-controls="true"><i class="bi bi-play-circle"></i><span>{{ __('messages.watch_video') }}</span></a>
            </div>
        </div>
    </div>
</section>
</div>
<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<!-- Preloader -->


@endsection

