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
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('Dashbyte/HTML/dist/assets/img/U_P.png')}}">

    <title>SIPEBA - Universitas Peradaban</title>
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset('Dashbyte/HTML/dist/lib/remixicon/fonts/remixicon.css')}}">
    <link rel="stylesheet" href="{{asset('Dashbyte/HTML/dist/lib/jqvmap/jqvmap.min.css')}}">
    <link rel="stylesheet" href="{{asset('Dashbyte/HTML/dist/lib/apexcharts/apexcharts.css')}}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('Dashbyte/HTML/dist/assets/css/style.min.css')}}">
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <a href="../" class="sidebar-logo">dashbyte</a>
        </div><!-- sidebar-header -->
        <div id="sidebarMenu" class="sidebar-body">
            <div class="nav-group show">
                <a href="#" class="nav-label">Dashboard</a>
                <ul class="nav nav-sidebar">
                    <li class="nav-item">
                        <a href="{{route('dashboardPerencanaan')}}" class="nav-link"><i class="ri-dashboard-line"></i>
                            <span>Dashboard</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('itemPerencanaan')}}" class="nav-link"><i class="ri-grid-fill"></i>
                            <span>Item</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('PRperencanaan')}}" class="nav-link"><i class="ri-draft-line"></i>
                            <span>Request</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="ri-file-list-line"></i>
                            <span>Report</span></a>
                    </li>
                </ul>
            </div><!-- nav-group -->
        </div><!-- sidebar-body -->
        <div class="sidebar-footer">
            <div class="sidebar-footer-top">
                <div class="sidebar-footer-thumb">
                    <img src="{{ asset('storage/items/'.Auth::user()->profile_picture) }}" alt="">
                </div><!-- sidebar-footer-thumb -->
                <div class="sidebar-footer-body">
                    <h6><a href="../pages/profile.html">{{Auth::user()->name}}</a></h6>
                </div><!-- sidebar-footer-body -->
                <a id="sidebarFooterMenu" href="" class="dropdown-link"><i class="ri-arrow-down-s-line"></i></a>
            </div><!-- sidebar-footer-top -->
            <div class="sidebar-footer-menu" style="margin-bottom: 100px">
                <nav class="nav">
                    <a href="{{route('editProfilePerencanaan')}}"><i class="ri-edit-2-line"></i> Edit
                        Profile</a>
                    <a href="{{route('profilePerencanaan')}}"><i class="ri-profile-line"></i> View Profile</a>
                </nav>
                <hr>
                <nav class="nav">
                    <a href="{{route('logout')}}"><i class="ri-logout-box-r-line"></i> Log Out</a>
                </nav>
            </div><!-- sidebar-footer-menu -->
        </div><!-- sidebar-footer -->
    </div><!-- sidebar -->

    <div class="header-main px-3 px-lg-4">
        <a id="menuSidebar" href="#" class="menu-link me-3 me-lg-4"><i class="ri-menu-2-fill"></i></a>

        <div class="form-search me-auto">
            <input type="text" class="form-control" placeholder="Search">
            <i class="ri-search-line"></i>
        </div><!-- form-search -->

        <div class="dropdown dropdown-skin">
            <a href="" class="dropdown-link" data-bs-toggle="dropdown" data-bs-auto-close="outside"><i
                    class="ri-settings-3-line"></i></a>
            <div class="dropdown-menu dropdown-menu-end mt-10-f">
                <label>Skin Mode</label>
                <nav id="skinMode" class="nav nav-skin">
                    <a href="" class="nav-link active">Light</a>
                    <a href="" class="nav-link">Dark</a>
                </nav>
                <hr>
                <label>Sidebar Skin</label>
                <nav id="sidebarSkin" class="nav nav-skin">
                    <a href="" class="nav-link active">Default</a>
                    <a href="" class="nav-link">Prime</a>
                    <a href="" class="nav-link">Dark</a>
                </nav>
            </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
        <div class="dropdown dropdown-profile ms-3 ms-xl-4">
            <a href="" class="dropdown-link" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                <div class="avatar online"><img src="{{Auth::user()->profile_picture}}" alt=""></div>
            </a>
            <div class="dropdown-menu dropdown-menu-end mt-10-f">
                <div class="dropdown-menu-body">
                    <div class="avatar avatar-xl online mb-3"><img
                            src="{{ asset('storage/items/'.Auth::user()->profile_picture) }}" alt=""></div>
                    <h5 class="mb-1 text-dark fw-semibold">{{Auth::user()->name}}</h5>

                    <nav class="nav">
                        <a href="{{route('editProfilePerencanaan')}}"><i class="ri-edit-2-line"></i> Edit
                            Profile</a>
                        <a href="{{route('profilePerencanaan')}}"><i class="ri-profile-line"></i> View Profile</a>
                    </nav>
                    <hr>
                    <nav class="nav">
                        <a href="{{route('logout')}}"><i class="ri-logout-box-r-line"></i> Log Out</a>
                    </nav>
                </div><!-- dropdown-menu-body -->
            </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
    </div><!-- header-main -->

    <div class="main main-app p-3 p-lg-4">
        <div class="d-flex align-items-center justify-content-between mb-4">

        </div>
        <div class="main-footer mt-5">
            <span>&copy; 2023. Dashbyte. All Rights Reserved.</span>
            <span>Created by: <a href="http://themepixels.me" target="_blank">Themepixels</a></span>
        </div><!-- main-footer -->
    </div><!-- main -->


    <script src="{{asset('Dashbyte/HTML/dist/lib/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('Dashbyte/HTML/dist/lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('Dashbyte/HTML/dist/lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('Dashbyte/HTML/dist/lib/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{asset('Dashbyte/HTML/dist/lib/jqvmap/maps/jquery.vmap.world.js')}}"></script>
    <script src="{{asset('Dashbyte/HTML/dist/lib/apexcharts/apexcharts.min.js')}}"></script>

    <script src="{{asset('Dashbyte/HTML/dist/assets/js/script.js')}}"></script>
    <script src="{{asset('Dashbyte/HTML/dist/assets/js/db.data.js')}}"></script>
    <script src="{{asset('Dashbyte/HTML/dist/assets/js/db.analytics.js')}}"></script>

</body>

</html>