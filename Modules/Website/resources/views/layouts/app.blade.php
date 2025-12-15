{{-- Modules/Website/resources/views/layouts/app.blade.php --}}
<html lang="en" dir="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ setting('seo_description') }}">
    <meta name="keywords" content="{{ setting('seo_keywords') }}">
    <meta name="title" content="{{ setting('seo_title') }}">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ setting('favicon') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ setting('favicon') }}" type="image/x-icon">
    <title>{{ setting('site_name') }}</title>

    <link rel="stylesheet" href="{{ asset('modules/website/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/website/css/app.css') }}">

    @stack('styles')
</head>

<body>
    <div id="root">
        <div class="min-vh-100 bg-light">
            <x-website::layouts.headerwebsite />

            <div class="container-fluid px-0" style="max-width: 100%; padding-top: 13rem;">
                <div class="row g-0 mx-0">
                    

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('modules/website/js/app.js') }}"></script>

    @stack('scripts')
</body>

</html>
