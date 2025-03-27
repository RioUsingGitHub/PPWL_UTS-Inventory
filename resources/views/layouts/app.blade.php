<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}" rel="stylesheet" />
    @stack('styles')
</head>

<body class="g-sidenav-show bg-gray-200">
    @php
        $title = $title ?? 'Dashboard';
    @endphp

    @auth
        @include('layouts.navbars.auth.sidenav')
    @endauth

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @auth
            @include('layouts.navbars.auth.topnav')
        @endauth

        <div class="container-fluid py-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>

        @auth
            @include('layouts.footers.auth.footer')
        @endauth
    </main>

    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }

        // Sidenav Toggle
        document.addEventListener('DOMContentLoaded', function() {
            var iconNavbarSidenav = document.getElementById('iconNavbarSidenav');
            var iconSidenav = document.getElementById('iconSidenav');
            var sidenav = document.getElementById('sidenav-main');
            var body = document.getElementsByTagName('body')[0];
            var className = 'g-sidenav-pinned';

            // Function to handle sidenav state based on screen size
            function handleSidenavState() {
                if (window.innerWidth >= 1200) {
                    body.classList.add(className);
                    sidenav.classList.add('bg-white');
                } else {
                    body.classList.remove(className);
                    sidenav.classList.remove('bg-white');
                }
            }

            // Initial state
            handleSidenavState();

            // Handle window resize
            window.addEventListener('resize', handleSidenavState);

            // Handle mobile toggle
            if (iconNavbarSidenav) {
                iconNavbarSidenav.addEventListener('click', function() {
                    if (!body.classList.contains(className)) {
                        body.classList.add(className);
                        setTimeout(function() {
                            sidenav.classList.add('bg-white');
                        }, 100);
                    } else {
                        body.classList.remove(className);
                        setTimeout(function() {
                            sidenav.classList.remove('bg-white');
                        }, 100);
                    }
                });
            }

            // Handle desktop/tablet toggle
            if (iconSidenav) {
                iconSidenav.addEventListener('click', function() {
                    if (body.classList.contains(className)) {
                        body.classList.remove(className);
                        setTimeout(function() {
                            sidenav.classList.remove('bg-white');
                        }, 100);
                    }
                });
            }

            // Close sidenav when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth < 1200) {
                    if (!sidenav.contains(e.target) && !iconNavbarSidenav.contains(e.target)) {
                        if (body.classList.contains(className)) {
                            body.classList.remove(className);
                            setTimeout(function() {
                                sidenav.classList.remove('bg-white');
                            }, 100);
                        }
                    }
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>