<!DOCTYPE html>
<html data-bs-theme-mode="dark">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Limit Sample</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @yield('css')
</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block m-t-xs font-bold">{{ ucwords(session('user')['name']) }}</span>
                                <span class="text-muted text-xs block">{{ implode(', ', session('roles')) }}</span>
                            </a>
                        </div>
                        <div class="logo-element">
                            LS
                        </div>
                    </li>
                    @if (
                        in_array('Admin', session('roles', [])) ||
                        (in_array('Supervisor', session('roles', [])) && session('user')['detail_dept_id'] == '15') || (in_array('Supervisor', session('roles', [])) && session('user')['detail_dept_id'] == '16') ||
                        (in_array('Department Head', session('roles', [])) && session('user')['detail_dept_id'] == '15')
                    )

                    <li class="{{ Request::is('/*') ? 'active' : '' }}">
                        <a href="{{ url('/') }}"><i class="fa fa-dashboard"></i><span class="nav-label">Dashboard</span></a>
                    </li>
                    @endif
                    <li class="{{ Request::is('limit-sample*') ? 'active' : '' }}">
                        <a href="{{ url('/limit-sample/model') }}"><i class="fa fa-th-large"></i><span
                                class="nav-label">Limit Sample</span></a>
                    </li>
                    <li class="{{ Request::is('all-limit-sample*') ? 'active' : '' }}">
                        <a href="{{ url('/all-limit-sample') }}"><i class="fa fa-th"></i><span
                                class="nav-label">All Limit Sample</span></a>
                    </li>
                    @if ((in_array('Supervisor', session('roles', [])) && session('user')['detail_dept_id'] == '15') || (in_array('Supervisor', session('roles', [])) && session('user')['detail_dept_id'] == '16') ||
                    (in_array('Department Head', session('roles', [])) && session('user')['detail_dept_id'] == '15'))
                    <li class="{{ Request::is('need-approve*') ? 'active' : '' }}">
                        <a href="{{ url('/need-approve') }}"><i class="fa fa-clock-o"></i><span
                                class="nav-label">Need Approve</span></a>
                    </li>
                    @endif
                    @if (
                        in_array('Admin', session('roles', [])) ||
                        (in_array('Supervisor', session('roles', [])) && session('user')['detail_dept_id'] == '15') || (in_array('Supervisor', session('roles', [])) && session('user')['detail_dept_id'] == '16') ||
                        (in_array('Department Head', session('roles', [])) && session('user')['detail_dept_id'] == '15')
                    )
                    <li class="{{ Request::is('activity') ? 'active' : '' }}">
                        <a href="{{ url('/activity') }}"><i class="fa fa-user-o"></i><span class="nav-label">Activity</span></a>
                    </li>
                    <li class="{{ Request::is('*expired') ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-warning"></i> <span class="nav-label">Expired</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="{{ Request::is('all-expired') ? 'active' : '' }}"><a href="{{ route('limitSample.allExpired') }}">Sudah Expired</a></li>
                            <li class="{{ Request::is('will-expired') ? 'active' : '' }}"><a href="{{ route('limitSample.willExpired') }}">Akan Expired</a></li>
                            {{-- <li><a href="carousel.html">Dilaporkan</a></li> --}}
                        </ul>
                    </li>
                    <li class="{{ Request::is('arsip') ? 'active' : '' }}">
                        <a href="{{ url('/arsip') }}"><i class="fa fa-history"></i><span class="nav-label">Arsip</span></a>
                    </li>
                    @endif
                    {{-- <li id="managementMenu">
                        <a href="#"><i class="fa fa-th-large"></i><span class="nav-label">Manajemen Perpus</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="{{ Request::is('books*') ? 'active' : '' }}">
                                <a href="{{ url('/books') }}">
                                    <i class="fa fa-book"></i> Daftar Buku
                                </a>
                            </li>
                            <li class="{{ Request::is('members*') ? 'active' : '' }}">
                                <a href="{{ url('/members') }}">
                                    <i class="fa fa-address-card"></i> Anggota
                                </a>
                            </li>
                            <li class="{{ Request::is('loans*') ? 'active' : '' }}">
                                <a href="{{ url('/loans') }}">
                                    <i class="fa fa-toggle-up"></i> Peminjaman & Pengembalian
                                </a>
                            </li>
                            <li class="{{ Request::is('reservations*') ? 'active' : '' }}">
                                <a href="{{ url('/reservations') }}">
                                    <i class="fa fa-slideshare"></i> Reservasi
                                </a>
                            </li>
                            <li class="{{ Request::is('lost-books*') ? 'active' : '' }}">
                                <a href="{{ url('/lost-books') }}">
                                    <i class="fa fa-recycle"></i> Kerusakan Buku
                                </a>
                            </li>
                        </ul>
                    </li> --}}
                    {{-- <li>
                        <a href=""><i class="fa fa-users"></i> <span class="nav-label">Manajemen Staff</span></a>
                    </li> --}}
                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom mb-4">
                <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i
                                class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message">{{ ucwords(session('user')['name']) }}</span>
                        </li>
                        @if (session('status_login') != 'local')
                        <li class="pr-3 d-inline">
                            <a href="{{ url('http://10.14.179.250:2222/dashboard') }}" class="p-0 pt-2"><button  class="btn btn-secondary">Ke Portal</button></a>
                        </li>
                        @endif
                        @if (session('status_login') == 'local')
                        <li class="pr-3">
                            <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                                @csrf
                                <button type="submit" class="btn btn-danger" id="logoutBtn">
                                    <i class="fa fa-sign-out"></i> Log out
                                </button>
                            </form>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>


            @yield('header')
            <div class="wrapper wrapper-content">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </div>
            <div class="footer">
                <div class="float-right">
                    <strong>Limit Sample</strong>
                </div>
                <div>
                    <strong>Copyright</strong> Portal Astra Juoku Indonesia. &copy; 2024
                </div>
            </div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Updated jQuery version -->
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    {{-- datepicker --}}
    <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

    <!-- SUMMERNOTE -->
    <script src="{{ asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote-cleaner/0.7.0/summernote-cleaner.min.js"></script>
    <!-- Jasny -->
    <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
    <!-- Flot -->
    <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.symbol.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.time.js') }}"></script>


    <!-- Peity -->
    <script src="{{ asset('js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('js/demo/peity-demo.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- jQuery UI -->
    {{-- <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script> --}}

    <!-- Jvectormap -->
    <script src="{{ asset('js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

    <!-- EayPIE -->
    <script src="{{ asset('js/plugins/easypiechart/jquery.easypiechart.js') }}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{ asset('js/demo/sparkline-demo.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    @yield('script')
    <script>
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    </script>
    <script>
        document.getElementById('logoutForm').addEventListener('submit', function() {
            document.getElementById('logoutBtn').disabled = true;
        });
    </script>
    {{-- <script type="text/javascript">
        $(document).ready(function() {
            // Check if any child <li> elements are active
            if ($('#managementMenu').find('li.active').length > 0) {
                // Open the collapse menu if any child <li> is active
                $('#managementMenu .collapse').addClass('in');
            }
        });
    </script> --}}
</body>

</html>
