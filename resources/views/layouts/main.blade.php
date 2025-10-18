<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="ADMIN AREA">
    <meta name="author" content="BLADEWARE">

    <title>ADMIN BLADEWARE</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/select2/select2.min.css')}}" rel="stylesheet" />
    <style>
        .text-black {
            color:black!important;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard">
                <div class="sidebar-brand-text mx-3">
                    {{ Auth::user()->level == 0 ? 'ADMIN' : 'Operator' }}
                </div>
            </a>

            <hr class="sidebar-divider my-0">
            <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin/dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <hr class="sidebar-divider my-0">
            <li class="nav-item {{ Request::is('admin/users') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin/users') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
            <hr class="sidebar-divider my-0">
            <li class="nav-item {{ Request::is('admin/products') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin/products') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Products</span>
                </a>
            </li>
            <hr class="sidebar-divider my-0">
            <li class="nav-item {{ Request::is('admin/deposits') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin/deposits') }}">
                    <i class="fas fa-fw fa-wallet"></i>
                    <span>Deposits</span>
                </a>
            </li>
            <hr class="sidebar-divider my-0">
            <li class="nav-item {{ Request::is('admin/withdrawals') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin/withdrawals') }}">
                    <i class="fas fa-fw fa-dollar-sign"></i>
                    <span>Withdrawals</span>
                </a>
            </li>
            <hr class="sidebar-divider my-0">
            <li class="nav-item {{ Request::is('admin/log-admin') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin/log-admin') }}">
                    <i class="fas fa-fw fa-history"></i>
                    <span>Log</span>
                </a>
            </li>
            <hr class="sidebar-divider my-0">
            <li class="nav-item {{ Request::is('admin/settings') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin/settings') }}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw" style="font-size:30px;"></i>
                                <!-- Counter - Alerts -->
                                @if ($pendingWithdrawalsCount > 0)
                                    <span class="badge badge-danger badge-counter">
                                        {{ $pendingWithdrawalsCount }}
                                    </span>
                                @endif
                            </a>

                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notification
                                </h6>

                                @if ($pendingWithdrawals->isEmpty())
                                    <a class="dropdown-item d-flex align-items-center">
                                        <div class="text-center w-100">
                                            No Data Available
                                        </div>
                                    </a>
                                @else
                                    @foreach ($pendingWithdrawals as $withdrawal)
                                        <a class="dropdown-item d-flex align-items-center" href="/admin/withdrawals">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-success">
                                                    <i class="fas fa-donate text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">{{ \Carbon\Carbon::parse($withdrawal->created_at)->format('F j, Y') }}</div>
                                                New Withdrawal Request From <strong>{{ $withdrawal->user_name }}</strong> Needs Review!
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->level == 0 ? 'ADMIN' : 'Operator' }}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('assets/img/tx1.png') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Admin Bladeware 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    @include('partials.alerts')

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Select2 -->
    <script src="{{asset('assets/vendor/select2/select2.min.js')}}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            var message = "";
            var bgColor = "rgba(0, 0, 0, 0.5)"; // Hitam transparan 50%
            var textColor = "#ffffff"; // Warna teks putih
            var borderColor = "rgba(255, 255, 255, 0.3)"; // Border putih transparan

            @if (session('success'))
                message = "{{ session('success') }}";
            @elseif (session('error'))
                message = "{{ session('error') }}";
            @elseif ($errors->any())
                message = "<ul>";
                @foreach ($errors->all() as $error)
                    message += "<li>{{ $error }}</li>";
                @endforeach
                message += "</ul>";
            @endif

            if (message !== "") {
                $("#alertText").html(message);
                $("#alertMessage").css({
                    "background-color": bgColor,
                    "color": textColor,
                    "border": "1px solid " + borderColor
                });
                $("#alertContainer").fadeIn(); // Munculkan alert

                // Hilangkan alert setelah 5 detik
                setTimeout(function() {
                    $("#alertContainer").fadeOut(500);
                }, 5000);
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("alertsDropdown").addEventListener("click", function () {
                fetch("/admin/read-notifications", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Notifications marked as read:", data.message);
                })
                .catch(error => console.error("Error updating notifications:", error));
            });
        });
        </script>

    @yield('customScript')

</body>

</html>
