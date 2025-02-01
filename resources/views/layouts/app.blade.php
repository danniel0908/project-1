<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    {{-- fabicon --}}
    <link href="{{ asset('landing/assets/img/favicon.png') }}" rel="icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset ('plugins/fontawesome-free/css/all.min.css ')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset( 'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css ')}}">
    <!-- iCheck -->

    <link rel="stylesheet" href="{{asset ('plugins/icheck-bootstrap/icheck-bootstrap.min.css ')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset ('plugins/jqvmap/jqvmap.min.css ')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset ('dist/css/adminlte.min.css ')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset ('plugins/overlayScrollbars/css/OverlayScrollbars.min.css ')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset ('plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset ('plugins/summernote/summernote-bs4.min.css')}}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset ('plugins/datatables-buttons/css/buttons.bootstrap4.min.css ')}}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .file-update-popup {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                z-index: 1000;
                width: 90%;
                max-width: 400px;
            }

            .popup-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 999;
                display: none;
            }

            .popup-close {
                position: absolute;
                top: 10px;
                right: 10px;
                cursor: pointer;
                font-size: 20px;
            }
    </style>
    
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

    @extends('modals.delete_modal')

    <!-- Navbar -->
    @include('layouts.header')

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link text-center">
            <?php
            $userRole = request()->user()->role ?? '';
            if ($userRole == 'admin') {
                echo '<img src="' . asset('landing/assets/img/tru-picture.png') . '" alt="Admin Logo" class="img-fluid" style="max-height: 100px; width: auto;">';
            } elseif ($userRole == 'tmu') {
                echo '<img src="' . asset('image/tmulogo.png') . '" alt="User Logo" class="img-fluid" style="max-height: 33px; width: auto;">';
            } else {
                echo '<img src="' . asset('image/userlogo.jpg') . '" alt="Default Logo" class="img-fluid" style="max-height: 33px; width: auto;">';
            }
            ?>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <a href="#" class="d-block">{{ $userInfo['fullName'] }}</a>
                    <a href="#" class="d-block">-{{$userInfo['role']}}</a>
                </div>
            </div>


        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{ asset('admin/dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>

        <li class="nav-item {{ Request::is('profile*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                    Profile
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('profile.edit')}}" class="nav-link {{ Request::routeIs('profile.edit') ? 'active' : '' }}">
                        <p>Profile</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <p>Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>

        <li class="nav-item {{ Request::is('users*', 'officers*', 'tmu_officers*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-plus-square"></i>
                <p>
                    Extras
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('users') }}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Users/Drivers</p>
                    </a>
                </li>
                @if ($userRole == 'superadmin')
                    <li class="nav-item">
                        <a href="{{ url('officers') }}" class="nav-link {{ Request::is('officers*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>TRU Office</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('tmu_officers') }}" class="nav-link {{ Request::is('tmu_officers*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>TMU Office</p>
                        </a>
                    </li>
                @endif
            </ul>
        </li>

        <li class="nav-header">Services</li>

        @if ($userRole == 'superadmin')
            <li class="nav-item">
                <a href="{{ route('TodaApp.history') }}" class="nav-link {{ Request::routeIs('TodaApp.history') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>History</p>
                </a>
            </li>
        @endif

        @if ($userRole == 'admin' || $userRole == 'superadmin')
            <!-- TODA Section -->
            <li class="nav-item {{ Request::routeIs('TODAapplication.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                        TODA
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('TODAapplication.index')}}" class="nav-link {{ Request::routeIs('TODAapplication.index') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>LIST</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('TODAapplication.create')}}" class="nav-link {{ Request::routeIs('TODAapplication.create') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create Application</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- PODA Section -->
            <li class="nav-item {{ Request::routeIs('PODAapplication.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                        PODA
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('PODAapplication.index')}}" class="nav-link {{ Request::routeIs('PODAapplication.index') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>LIST</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('PODAapplication.create')}}" class="nav-link {{ Request::routeIs('PODAapplication.create') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create Application</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- PUJ/PUB/FX Section -->
            <li class="nav-item {{ Request::routeIs('PPFapplication.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                        PUJ/PUB/FX
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('PPFapplication.index')}}" class="nav-link {{ Request::routeIs('PPFapplication.index') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>LIST</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('PPFapplication.create')}}" class="nav-link {{ Request::routeIs('PPFapplication.create') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create Application</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Private Service Section -->
            <li class="nav-item {{ Request::routeIs('ServiceApplication.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                        Private Service
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('ServiceApplication.index')}}" class="nav-link {{ Request::routeIs('ServiceApplication.index') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>LIST</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('ServiceApplication.create')}}" class="nav-link {{ Request::routeIs('ServiceApplication.create') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create Application</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Dropping Section -->
            <li class="nav-item {{ Request::routeIs('TODADropping.*', 'PODAdropping.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                        DROPPING
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <!-- TODA Dropping -->
                    <li class="nav-item {{ Request::routeIs('TODADropping.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <p>TODA</p>
                            <i class="fas fa-angle-left right"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('TODADropping.index')}}" class="nav-link {{ Request::routeIs('TODADropping.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>LIST</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('TODADropping.create')}}" class="nav-link {{ Request::routeIs('TODADropping.create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>CREATE</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- PODA Dropping -->
                    <li class="nav-item {{ Request::routeIs('PODAdropping.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <p>PODA</p>
                            <i class="fas fa-angle-left right"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('PODAdropping.index')}}" class="nav-link {{ Request::routeIs('PODAdropping.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>LIST</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('PODAdropping.create')}}" class="nav-link {{ Request::routeIs('PODAdropping.create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>CREATE</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        @endif

        <li class="nav-header">Customer Service</li>
        <li class="nav-item">
            <a href="{{route('admin.tickets.index')}}" class="nav-link {{ Request::routeIs('admin.tickets.*') ? 'active' : '' }}">
                <i class="far fa-comments nav-icon"></i>
                <p>Tickets</p>
            </a>
        </li>
    </ul>
</nav>
        <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    @yield('content')



    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <style>
    /* Add these styles in your head section or CSS file */

    /* Adjust main sidebar height and scrolling */
    .main-sidebar {
        height: 100vh;
        overflow-y: hidden; /* Prevent double scrollbars */
    }

    /* Adjust sidebar content */
    .sidebar {
        height: calc(100vh - 4.5rem) !important;
        overflow-y: auto !important;
        padding-bottom: 100px; /* Add padding at bottom to show all content */
    }

    /* Make sure content doesn't get cut off */
    .nav-sidebar {
        padding-bottom: 60px; /* Extra padding for nav items */
    }

    /* Improve sidebar scroll visibility */
    .sidebar::-webkit-scrollbar {
        width: 5px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: #343a40;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    /* Ensure dropdown menus are visible */
    .nav-treeview {
        display: none; /* Hidden by default */
    }

    .menu-is-opening > .nav-treeview,
    .menu-open > .nav-treeview {
        display: block !important; /* Show when parent is open */
    }

    /* Adjust nested items padding */
    .nav-treeview .nav-treeview {
        padding-left: 1rem;
    }

    /* Fix sidebar height on mobile */
    @media (max-width: 768px) {
        .main-sidebar {
            height: 100%;
        }
        
        .sidebar {
            height: calc(100vh - 3rem) !important;
        }
    }


    .nav-sidebar .nav-link.active {
    background-color: #007bff !important;
    color: #ffffff !important;
}

/* Active state for parent items when child is selected */
.nav-sidebar .nav-item.menu-open > .nav-link {
    background-color: rgba(255, 255, 255, 0.1);
}

/* Active state for child items */
.nav-treeview > .nav-item > .nav-link.active {
    background-color: rgba(0, 123, 255, 0.9) !important;
    color: #ffffff !important;
}

/* Hover state */
.nav-sidebar .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

/* Active parent menu indicator */
.nav-sidebar .nav-item.menu-open > .nav-link i.right {
    transform: rotate(90deg);
}

/* Transition for smooth state changes */
.nav-sidebar .nav-link {
    transition: all 0.3s ease;
}
    </style>

    <script>
    // Add this JavaScript at the bottom of your page
    $(document).ready(function() {
        // Initialize menu state
        $('.nav-sidebar .has-treeview').each(function() {
            if ($(this).hasClass('menu-open')) {
                $(this).find('> .nav-treeview').show();
            }
        });

        // Handle menu clicks
        $('.nav-sidebar .has-treeview > .nav-link').on('click', function(e) {
            e.preventDefault();
            var $parentLi = $(this).parent('li');
            $parentLi.siblings('.has-treeview').removeClass('menu-open').find('.nav-treeview').slideUp();
            $parentLi.toggleClass('menu-open');
            $parentLi.find('> .nav-treeview').slideToggle();
        });

        // Ensure proper scroll height calculation
        function adjustSidebarHeight() {
            var windowHeight = window.innerHeight;
            var headerHeight = $('.main-header').outerHeight() || 0;
            $('.sidebar').css('height', `calc(${windowHeight}px - ${headerHeight}px)`);
        }

        // Run on load and resize
        adjustSidebarHeight();
        $(window).on('resize', adjustSidebarHeight);
    });
    </script>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src= "{{ asset('plugins/jquery-ui/jquery-ui.min.js ')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js ')}}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparklines/sparkline.js ')}}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>

    <!-- jQuery Knob Chart -->
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js' )}}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js' )}}" ></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js' )}}" ></script>
    <!-- Summernote -->
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js' )}}" ></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js' )}}" ></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Update file input label to show selected filename
document.getElementById('excelFile').addEventListener('change', function() {
    // Get the file name from the input
    let fileName = this.files[0]?.name || 'Choose Excel file';
    
    // Update the label text
    let label = this.nextElementSibling;
    label.textContent = fileName;
});

// Handle form submission and loading display
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    // Show loading overlay
    const loadingOverlay = document.getElementById('loadingOverlay');
    loadingOverlay.style.display = 'block';

    // Disable submit button to prevent double submission
    const submitButton = this.querySelector('button[type="submit"]');
    submitButton.disabled = true;

    // Add loading state to button
    const originalButtonContent = submitButton.innerHTML;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Uploading...';

    // Handle form submission completion
    this.addEventListener('submit', function() {
        // If the form submission is handled by the browser (full page reload),
        // the overlay will automatically disappear when the page reloads
    });

    // Optional: Handle AJAX submission
    // If you're using AJAX to submit the form, you would handle it here
    // Example with Fetch API:
    /*
    e.preventDefault();
    fetch(this.action, {
        method: 'POST',
        body: new FormData(this)
    })
    .then(response => response.json())
    .then(data => {
        // Handle success
        loadingOverlay.style.display = 'none';
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonContent;
    })
    .catch(error => {
        // Handle error
        loadingOverlay.style.display = 'none';
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonContent;
        alert('Upload failed. Please try again.');
    });
    */
});
    </script>
 </body>
 </html>



