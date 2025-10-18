<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row min-vh-100 d-flex justify-content-center align-items-center">

            <div class="col-xl-6 col-lg-8 col-md-9 col-12"> <!-- Lebar card lebih kecil di desktop -->

                <div class="card o-hidden border-0 shadow-lg mx-auto" style="max-width: 500px;"> <!-- Atur max-width -->
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Admin Area</h1>
                                    </div>
                                    <form class="user" action="/cek-login" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp" name="email"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="password"
                                                id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        @include('partials.alerts')
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

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
</body>

</html>
