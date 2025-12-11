<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Multikart admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Multikart admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ asset('modules/dashboard/images/dashboard/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('modules/dashboard/images/dashboard/favicon.png') }}" type="image/x-icon">
    <title>Multikart - Premium Admin Template</title>

    <!-- Google font-->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,500;1,600;1,700;1,800;1,900&amp;display=swap">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap">


    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{ asset('modules/dashboard/css/vendors/font-awesome.css') }}">

    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('modules/dashboard/css/vendors/flag-icon.css') }}">

    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('modules/dashboard/css/vendors/icofont.css') }}">

    <!-- Prism css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('modules/dashboard/css/vendors/prism.css') }}">

    <!-- Chartist css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('modules/dashboard/css/vendors/chartist.css') }}">

    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('modules/dashboard/css/vendors/bootstrap.css') }}">

    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('modules/dashboard/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modules/dashboard/css/ck-editor.css') }}">


        <style>
        .card .card-header h5 {
            color: red !important;
        }
    </style>
    @stack('styles')
    <script src="chrome-extension://mooikfkahbdckldjjndioackbalphokd/assets/prompt.js"></script>
</head>

<body>

    <!-- page-wrapper Start-->
    <div class="page-wrapper">

        <!-- Page Header Start-->
        <x-dashboard::dashboardheader />
        <!-- Page Header Ends -->

        <!-- Page Body Start-->
        <div class="page-body-wrapper">

            <!-- Page Sidebar Start-->
            <x-dashboard::dashboardsidebar />
            <!-- Page Sidebar Ends-->

            <!-- Right sidebar Start-->
            <x-dashboard::dashboardrightsidebar />
            <!-- Right sidebar Ends-->

            <div class="page-body">
                <!-- Container-fluid starts-->
                @yield('breadcrumbs')

                <!-- Container-fluid Ends-->
                <!-- Container-body start-->
                @yield('content')
                <!-- Container-body Ends-->



            </div>

            <!-- footer start-->
            <x-dashboard::dashboardfooter />
            <!-- footer end-->

            {{-- alert start --}}
            {{-- <x-dashboard::form.alert-message/> --}}
            <x-dashboard::alert/>
            {{-- alert end --}}
        </div>
    </div>

    <!-- latest jquery-->
    <script src="{{ asset('modules/dashboard/js/jquery-3.3.1.min.js') }}"></script>

    <!-- Bootstrap js-->
    <script src="{{ asset('modules/dashboard/js/bootstrap.bundle.min.js') }}"></script>

    <!-- feather icon js-->
    <script src="{{ asset('modules/dashboard/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('modules/dashboard/js/icons/feather-icon/feather-icon.js') }}"></script>

    <!-- Sidebar jquery-->
    <script src="{{ asset('modules/dashboard/js/sidebar-menu.js') }}"></script>

    <!--chartist js-->
    <script src="{{ asset('modules/dashboard/js/chart/chartist/chartist.js') }}"></script>

    <!--chartjs js-->
    <script src="{{ asset('modules/dashboard/js/chart/chartjs/chart.min.js') }}"></script>

    <!-- lazyload js-->
    <script src="{{ asset('modules/dashboard/js/lazysizes.min.js') }}"></script>

    <!--copycode js-->
    <script src="{{ asset('modules/dashboard/js/prism/prism.min.js') }}"></script>
    <script src="{{ asset('modules/dashboard/js/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ asset('modules/dashboard/js/custom-card/custom-card.js') }}"></script>

    <!--counter js-->
    <script src="{{ asset('modules/dashboard/js/counter/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('modules/dashboard/js/counter/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('modules/dashboard/js/counter/counter-custom.js') }}"></script>

    <!--peity chart js-->
    <script src="{{ asset('modules/dashboard/js/chart/peity-chart/peity.jquery.js') }}"></script>

    <!-- Apex Chart Js -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!--sparkline chart js-->
    <script src="{{ asset('modules/dashboard/js/chart/sparkline/sparkline.js') }}"></script>

    <!--Customizer admin-->
    <script src="{{ asset('modules/dashboard/js/admin-customizer.js') }}"></script>
    <ul class="custom-theme">
        <li class="demo-li"><a href="{{ route('home') }}" target="_blank">Front end</a></li>
        <li class="btn-rtl">RTL</li>
        <li class="btn-dark-setting">Dark</li>
    </ul>

    <!--dashboard custom js-->
    <script src="{{ asset('modules/dashboard/js/dashboard/default.js') }}"></script>

    <!--right sidebar js-->
    <script src="{{ asset('modules/dashboard/js/chat-menu.js') }}"></script>

    <!--height equal js-->
    <script src="{{ asset('modules/dashboard/js/height-equal.js') }}"></script>

    <!-- lazyload js-->
    <script src="{{ asset('modules/dashboard/js/lazysizes.min.js') }}"></script>

    <!--script admin-->
    <script src="{{ asset('modules/dashboard/js/admin-script.js') }}"></script>


    <svg id="SvgjsSvg1001" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1"
        xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev"
        style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;">
        <defs id="SvgjsDefs1002"></defs>
        <polyline id="SvgjsPolyline1003" points="0,0"></polyline>
        <path id="SvgjsPath1004" d="M0 0 "></path>
    </svg>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function showDeleteConfirm(id, config) {
                // استبدال :item بالاسم الحقيقي
                const text = config.text.replace(':item', `<strong class="text-danger">${config.itemName}</strong>`);

                Swal.fire({
                    title: config.title,
                    html: text,
                    icon: config.icon,
                    showCancelButton: true,
                    confirmButtonColor: config.confirmButtonColor,
                    cancelButtonColor: config.cancelButtonColor,
                    confirmButtonText: `<i class="fa fa-trash"></i> ${config.confirmButtonText}`,
                    cancelButtonText: `<i class="fa fa-ban"></i> ${config.cancelButtonText}`,
                    reverseButtons: true,
                    focusCancel: true,
                    customClass: {
                        popup: 'animated zoomIn faster',
                        confirmButton: 'btn btn-danger px-4',
                        cancelButton: 'btn btn-secondary px-4 me-3'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }
        </script>
    @stack('scripts')

</body>

</html>
