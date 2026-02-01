<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vreator</title>
    
    
    
    <link href="{{ asset ('assets/compiled/png/VreatorLogo1.png')}}" rel="icon">
    


  <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/compiled/css/iconly.css') }}">
</head>

<body>
    <script src="{{ asset ('assets/static/js/initTheme.js') }}"></script>
    @include('layouts.components-creator.sidebar')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            
@yield('content')

@include('layouts.components-creator.footer')
        </div>
    </div>
    <script src="{{ asset ('assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset ('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    
    
    <script src="{{ asset ('assets/compiled/js/app.js') }}"></script>
    

    
<!-- Need: Apexcharts -->
<script src="{{ asset ('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset ('assets/static/js/pages/dashboard.js') }}"></script>

</body>

</html>