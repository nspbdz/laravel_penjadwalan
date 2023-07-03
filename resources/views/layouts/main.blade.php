<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Blank Page &mdash; Stisla</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

    <!-- Datatables -->
    <link rel="stylesheet" href="{{asset('assets/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">

    <!-- Summernote -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                        <!-- <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li> -->
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <!-- <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1"> -->
                            <div class="d-sm-none d-lg-inline-block">Hi,
                                @if (Auth::check())
                                {{auth()->user()->name}}
                                @else
                                @endif
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}

                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="index.html">Penjadwalan JTI</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="index.html">PJTI</a>
                    </div>
                    <ul class="sidebar-menu">

                        <li class="menu-header">Pages</li>

                        <li><a class="nav-link collapsed" href="/">
                                <span>Dashboard</span>
                            </a></li>

                        <li><a class="nav-link collapsed" href="/day">
                                <span>Hari</span>
                            </a></li>

                        <li><a class="nav-link collapsed" href="/hour">
                                <span>Jam</span>
                            </a></li>
                        <li><a class="nav-link collapsed" href="/lecture">
                                <span>Dosen</span>
                            </a></li>
                        <li><a class="nav-link collapsed" href="/course">
                                <span>Mata Kuliah</span>
                            </a></li>
                        <li><a class="nav-link collapsed" href="/room">
                                <span>Ruangan</span>
                            </a></li>
                        <li><a class="nav-link collapsed" href="/support">
                                <span>pengampu</span>
                            </a></li>
                        <li><a class="nav-link collapsed" href="/schedule ">
                                <span>jadwal kuliah</span>
                            </a></li>
                        <li><a class="nav-link collapsed" href="/wtb">
                                <span>waktu tidak tersedia </span>
                            </a></li>
                        <li><a class="nav-link collapsed" href="/wb">
                                <span>waktu tersedia </span>
                            </a></li>


                </aside>
            </div>



            <!-- Main Content -->
            <div class="main-content">
                <br>
                <br>
                @yield('content')
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2023 <div class="bullet">
                    </div>
                    <div class="footer-right">

                    </div>
            </footer>
        </div>
    </div>



    <script src="{{asset('assets/modules/jquery.min.js')}}"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script src="{{asset('assets/modules/popper.js')}}"></script>
    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <!-- <script src="{{asset('assets/plugins/sweetalert2')}}"></script>
    <script src="{{asset('assets/plugins/sweetalert2-theme-bootstrap-4')}}"></script>
    <script src="{{asset('assets/modules/sweetalert/sweetalert.min.js')}}"></script> -->
    <script src="{{asset('assets/modules/tooltip.js')}}"></script>
    <script src="{{asset('assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
    <script src="{{asset('assets/modules/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/stisla.js')}}"></script>

    <!-- Template JS File -->
    <script src="{{asset ('assets/js/scripts.js')}}"></script>
    <script src="{{asset ('assets/js/custom.js')}}"></script>

    <!-- Datatables -->
    <script src="{{asset('assets/modules/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('assets/modules/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- summernote -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.js"></script>

    @yield('script');

    <script>
        // $(document).ready(function() {
        //     $('#isi_surat').summernote({
        //         height: '400'
        //     });
        //     var $surat = $('textarea[name="#isi_surat"]').html($('#isi_surat').code());
        //     var textareaValue = $('#isi_surat').code();

        // });
    </script>

    @stack('scripts')

</body>

</html>