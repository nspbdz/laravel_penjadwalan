<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</script>
<nav class="navbar navbar-expand-lg main-navbar">

    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li>
                <button class="navbar-toggler" type="button" id="sidebarToggle">
                    <i class="fas fa-bars"></i> asd213
                </button>
                <a href="#" data-toggle="sidebar"  id="sidebarToggle"   class="nav-link nav-link-lg">
                    <i class="fas fa-bars"></i>

                </a>
            </li>
            <li>
                <a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none">
                    <i class="fas fa-search"></i>
                </a>
            </li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, Admin</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">

                <a class="dropdown-item has-icon text-danger" onclick="event.preventDefault();
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log('clicked');
        var sidebarToggle = document.getElementById("sidebarToggle");
        var sidebarWrapper = document.getElementById("sidebar-wrapper");

        if (sidebarToggle && sidebarWrapper) {
            sidebarToggle.addEventListener("click", function() {
                sidebarWrapper.classList.toggle("active");
            });
        }
    });
    // $(document).ready(function() {

    //     document.addEventListener("DOMContentLoaded", function() {
    //         var sidebarToggle = document.getElementById("sidebarToggle");
    //         var sidebarWrapper = document.getElementById("sidebar-wrapper");

    //         sidebarToggle.addEventListener("click", function() {
    //             sidebarWrapper.classList.toggle("active");
    //         });
    //     });
    // });
</script>

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


    </aside>
</div>
