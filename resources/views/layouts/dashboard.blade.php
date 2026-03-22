<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%234f46e5'/><text y='72' x='50' text-anchor='middle' font-size='60' font-family='sans-serif'>🏪</text></svg>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ Route('dashboard') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="https://minamaherwanis.github.io/Portfolio/" class="nav-link">Contact</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->


                <!-- Messages Dropdown Menu -->

                <!-- Notifications Dropdown Menu -->
                <x-dashboard.notifications-menu count="7" />
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ Route('dashboard') }}" class="brand-link d-flex align-items-center"
                style="padding: 20px 24px; border-bottom: 1px solid rgba(255,255,255,0.08); text-decoration:none; gap: 14px;">

                <div
                    style="
            width: 44px; height: 44px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(79,70,229,0.45);
            margin-left: 8px;
        ">
                    <i class="fas fa-store" style="color:white; font-size:20px;"></i>
                </div>

                <div>
                    <div
                        style="
                font-size: 15px;
                font-weight: 700;
                color: white;
                letter-spacing: 0.02em;
                line-height: 1.2;
            ">
                        Multi Store</div>
                    <div
                        style="
                font-size: 11px;
                color: rgba(255,255,255,0.4);
                letter-spacing: 0.1em;
                text-transform: uppercase;
            ">
                        Dashboard</div>
                </div>

            </a>




            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="sidebar">
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
                        <div class="image">
                            <img src="{{ asset('dist/img/avatar4.png') }}" class="img-circle elevation-2"
                                alt="User Image" style="width:40px; height:40px; object-fit:cover;">
                        </div>
                        <div class="info d-flex flex-column gap-1 ms-2">
                            <a href="{{ route('admin.profile.edit') }}"
                                class="d-block fw-semibold text-white text-decoration-none" style="font-size:14px;">
                                {{ Auth::user()->name }}
                            </a>
                            <form action="{{ route('logout') }}" method="post" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-sm px-2 py-0"
                                    style="font-size:11px; background:rgba(255,255,255,0.1); 
                               border:1px solid rgba(255,255,255,0.2); 
                               color:rgba(255,255,255,0.7);
                               border-radius:4px;
                               transition: all 0.2s;"
                                    onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.color='white'"
                                    onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.color='rgba(255,255,255,0.7)'">
                                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- SidebarSearch Form -->


                    {{-- @include('layouts.partials.nav') --}}

                    <x-nav />

                </div>
                <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('title')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @section('breadcrumb')
                                    <li class="breadcrumb-item active">Home</li>
                                @show

                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2025-2027 <a
                    href="https://minamaherwanis.github.io/Portfolio/">Developer</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script>
        const userID = "{{ Auth::id() }}";
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
