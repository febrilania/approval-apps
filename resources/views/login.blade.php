<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="">
    <meta name="author" content="Themepixels">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('Dashbyte/HTML/dist/assets/img/favicon.png')}}">

    <title>DashByte - Premium Dashboard Template</title>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset('Dashbyte/HTML/dist/lib/remixicon/fonts/remixicon.css')}}">
    <link rel="stylesheet" href="{{asset('Dashbyte/HTML/dist/lib/jqvmap/jqvmap.min.css')}}">
    <link rel="stylesheet" href="{{asset('Dashbyte/HTML/dist/lib/apexcharts/apexcharts.css')}}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('Dashbyte/HTML/dist/assets/css/style.min.css')}}">
</head>

<body>
    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="col-12 px-3 col-md-5">
            <div class="shadow-lg p-3 mb-5 bg-body rounded">
                <form method="POST" action="{{route('login')}}">
                    @csrf
                    <div class="mb-3 d-flex align-items-center justify-content-center">
                        <h1 class="fs-1 fw-bold">Login</h1>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username"
                            value="{{old('username')}}">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            value="{{old('password')}}">
                    </div>
                    <button type="submit" class="btn btn-primary align-self-end">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="{{('Dashbyte/HTML/dist/lib/jquery/jquery.min.js')}}"></script>
    <script src="{{('Dashbyte/HTML/dist/lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{('Dashbyte/HTML/dist/lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{('Dashbyte/HTML/dist/lib/chart.js/chart.min.js')}}"></script>
    <script src="{{('Dashbyte/HTML/dist/lib/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{('Dashbyte/HTML/dist/lib/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    <script src="{{('Dashbyte/HTML/dist/lib/apexcharts/apexcharts.min.js')}}"></script>

    <script src="{{('Dashbyte/HTML/dist/assets/js/script.js')}}"></script>
    <script src="{{('Dashbyte/HTML/dist/assets/js/db.data.js')}}"></script>
    <script src="{{('Dashbyte/HTML/dist/assets/js/db.sales.js')}}"></script>
</body>

</html>