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

<style>
    .img {
        width: 100%;
        /* Mengatur lebar gambar penuh */
        height: 100vh;
        /* Mengatur tinggi gambar sesuai tinggi viewport */
        object-fit: cover;
        /* Memastikan gambar mengisi seluruh area tanpa merusak aspek rasio */
        object-position: center;
        /* Menjaga gambar tetap terpusat */
    }

    .image-overlay {
        position: relative;
    }

    .image-overlay::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        /* Menggunakan warna hitam dengan transparansi */
        z-index: 1;
        /* Menempatkan overlay di atas gambar */
    }

    .logo-img {
        width: 100%;
        max-width: 350px;
        /* Menetapkan ukuran maksimal untuk logo */
        height: auto;
        display: block;
        margin: 0 auto;
    }
</style>

<body class="page-sign d-block py-0">

    <div class="row g-0">
        <div class="col-md-7 col-lg-5 col-xl-4 col-wrapper">
            <div class="card card-sign">
                <div class="card-header">
                    <img src="{{asset('image/logo upb.png')}}" alt="Logo" class="logo-img mb-5">
                    <a href="../" class="header-logo ">SIPEBA</a>
                    <h3 class="card-title mb-5">Sistem Pengadaan Barang</h3>
                    <h3 class="card-title">Sign In</h3>
                    <p class="card-text">Welcome back! Please signin to continue.</p>
                </div><!-- card-header -->
                <div class="card-body">
                    <form method="POST" action="{{route('login')}}">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="{{ old('username') }}">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                value="{{ old('password') }}">
                        </div>
                        <button type="submit" class="btn btn-primary align-self-end">Submit</button>
                    </form>


                </div><!-- card-body -->

            </div><!-- card -->
        </div><!-- col -->
        <div class="col d-none d-lg-block">
            <div class="image-overlay">
                <img src="{{asset('image/upb.webp')}}" class="img" alt="">
            </div>
        </div>
    </div><!-- row -->

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
    <script>
        'use script'

      var skinMode = localStorage.getItem('skin-mode');
      if(skinMode) {
        $('html').attr('data-skin', 'dark');
      }
    </script>
</body>

</html>