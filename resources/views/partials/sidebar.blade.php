<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="{{ route('home') }}" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>RAFASTORE</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">{{ strtoupper($user['nm_ptg']) }}</h6>
                        <span>{{ $user['status'] }}</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="{{ url('/') }}" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>File</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="{{ route('users') }}" class="dropdown-item"><i class="fas fa-user"></i> Pengguna</a>
                            <a href="#" class="dropdown-item"><i class="fas fa-cubes"></i> Barang</a>
                        </div>
                    </div>
                    <a href="{{ url('/') }}" class="nav-item nav-link"><i class="fas fa-cash-register"></i> Transaksi</a>
                    <a href="{{ url('/') }}" class="nav-item nav-link"><i class="fas fa-chart-line"></i> Laporan</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->