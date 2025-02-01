<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing</title>

  <!-- Favicons -->
  <link href="{{ url('landing/assets/img/favicon.png') }}" rel="icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">


  <!-- Vendor CSS Files -->
  <link href="{{ url('landing/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ url('landing/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ url('landing/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ url('landing/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ url('landing/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ url('landing/assets/css/main.css') }}" rel="stylesheet">
  <style>

.logo-1 .logo img {
    border: none;
    outline: none;
    box-shadow: none;
}


    body, html {
      height: 100%;
      margin: 0;
    }
    .content-wrapper {
      display: flex;
      flex-direction: column;
      height: 100%;
      overflow-y: auto;
    }
    .content {
      flex: 1;
    }
    .small-box {
      position: relative;
      display: block;
      margin-bottom: 20px;
      box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    }
    .small-box .inner {
      padding: 10px;
    }
    .small-box h3 {
      font-size: 2.2em;
      margin: 0;
    }
    .small-box p {
      font-size: 1.2em;
    }
    .small-box .icon {
      top: 10px;
      right: 10px;
      z-index: 0;
    }
    .small-box-footer {
      display: block;
      padding: 3px 0;
      color: #fff;
      background: rgba(0,0,0,0.1);
      text-align: center;
      text-decoration: none;
    }
    .small-box-footer:hover {
      background: rgba(0,0,0,0.15);
    }
    .nav a {
     margin: 0 15px;
     text-decoration: none;
     color: black;
     font-weight: bold;
    }
    .main-container1 {
    height: 700px;
    }
    .logo-1 {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    margin-bottom: 20px;
    margin-left: 40px;
    }

    .logo-1 .logo {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }

    .logo-1 .logo img {
        display: block;
    }

    .tru-logo {
        max-width: 80px; /* Adjust the width */
        max-height: 80px; /* Adjust the height */
    }

    .city-logo img {
        max-width: 110px;
        max-height: 60px;
    }

    .pup-logo {
        max-width: 50px; /* Adjust the width */
        max-height: 50px; /* Adjust the height */
    }


    @media (max-width: 768px) {
        .logo-1 {

            margin: 10px 0; /* Reduce the margin for smaller screens */
        }

        .logo-1 .logo {
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center; /* Center align logos in mobile view */
        }



        .logo-1 .city-logo img {
            max-width: 90px; /* Ensure the city logo is proportionate */
            max-height: 60px;
        }

        .tru-logo {
            max-width: 70px; /* Keep consistent with others */
            max-height: 70px;
        }

        .pup-logo {
            max-width: 40px; /* Matches TRU logo size */
            max-height: 40px;
        }
    }

</style>

</head>
<body>
    <div class="header">
        <div class="date" id="dateTime"></div>
        {{-- <div class="links">
            <a href="CityNews.html">City News</a>
            <a href="event.html">Events</a>
            <a href="job-seekers.html">Job Seekers</a>
            <i class="fa-brands fa-facebook"></i>

            <a href="#"><img src="{{ url('landing/assets/img/fb.png') }}" alt="Social Media" style="height: 20px; width: 20px; border-radius: 36px; position: relative; right: 10px;"></a>
        </div> --}}
        <div class="relative inline-block text-left">
        <select 
    onchange="window.location.href = this.value"
    class="block w-28 rounded border border-gray-300 bg-white py-1 px-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-700 cursor-pointer"
>
    <option 
        value="{{ route('lang.switch', 'en') }}" 
        {{ app()->getLocale() == 'en' ? 'selected' : '' }}
    >
        English
    </option>
    <option 
        value="{{ route('lang.switch', 'fil') }}" 
        {{ app()->getLocale() == 'fil' ? 'selected' : '' }}
    >
        Filipino
    </option>
</select>

        </div>
    </div>
    <div class="logo-1">
    <div class="logo">
        <img class="tru-logo" src="{{ url('landing/assets/img/tru-picture.png') }}" alt="TRU Logo">
        <img class="pup-logo" src="{{ url('landing/assets/img/san pedro.png') }}" alt="San pedro Logo">

        <div class="city-logo">
            <img src="{{ url('landing/assets/img/San_Pedro_City.png') }}" alt="San Pedro City">
        </div>
        <img class="pup-logo" src="{{ url('landing/assets/img/pup-logo.png') }}" alt="PUP Logo">


    </div>  

    <div class="nav">
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ route('landing.index') }}" 
                       class="{{ request()->routeIs('landing.index') ? 'active' : '' }}">
                    Home
                </a></li>
                <li><a href="{{ route('landing.about') }}" 
                       class="{{ request()->routeIs('landing.about') ? 'active' : '' }}">
                    {{ __('messages.about') }}
                </a></li>
                <li><a href="{{ route('landing.staff') }}" 
                       class="{{ request()->routeIs('landing.staff') ? 'active' : '' }}">
                    Staff
                </a></li>
                <li>
                    @if (Route::has('login'))
                        @auth
                            @php $user = auth()->user(); @endphp
                            @if($user->role == 'admin')
                                <a href="{{ url('/admin/dashboard') }}" 
                                   class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ url('user/dashboard') }}" 
                                   class="{{ request()->is('user/dashboard') ? 'active' : '' }}">
                                    Dashboard
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" 
                               class="{{ request()->routeIs('login') ? 'active' : '' }}">
                               {{ __('messages.login') }}
                            </a>
                        @endauth
                    @endif
                </li>
                <li>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" 
                           class="{{ request()->routeIs('register') ? 'active' : '' }}">
                           {{ __('messages.register') }}
                        </a>
                    @endif
                </li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
    </div>
</div>

<style>
    .language-switcher select {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
        border-radius: 0.375rem;
        border: 1px solid #d1d5db;
        background-color: white;
        cursor: pointer;
    }
    
    .language-switcher select:focus {
        outline: none;
        ring: 2px;
        ring-color: #6366f1;
        border-color: #6366f1;
    }
</style>

@yield('content')
<script>
    function formatDate(date) {
      const options = {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
        hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true
      };
      return date.toLocaleString('en-US', options);
    }

    function updateDateTime() {
      const currentDate = new Date();
      const formattedCurrentDate = formatDate(currentDate);
      document.getElementById('dateTime').textContent = formattedCurrentDate;
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>

 <!-- Vendor JS Files -->
 <script src="{{ asset('landing/assets/vendor/php-email-form/validate.js') }}"></script>
 <script src="{{ asset('landing/assets/vendor/aos/aos.js') }}"></script>
 <script src="{{ asset('landing/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
 <script src="{{ asset('landing/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

 <!-- Main JS File -->
 <script src="{{ asset('landing/assets/js/main.js') }}"></script>
 <script src="{{ asset('landing/assets/js/mains.js') }}"></script>
 {{-- <script src="{{ asset('landing/plugins/jquery-knob/jquery.knob.min.js') }}"></script> --}}

 @include('chatbot.chatbot')
</body>
</html>
