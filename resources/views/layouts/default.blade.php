@include('partials.header')
@include('partials.sidebar')
@include('partials.navbar')

@yield('content')

 <!-- Footer Start -->
 <div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded-top p-4">
        <div class="row">
            <div class="col-12 col-sm-6 text-center text-sm-start">
                &copy; <a href="#">Rafa Store - 2023</a>, All Right Reserved. 
            </div>
            <div class="col-12 col-sm-6 text-center text-sm-end">
                Designed By <a href="#">IT Team</a>
            </br>
           
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->
</div>
<!-- Content End -->

@stack('prepend-script')
@include('partials.footer')
@stack('addon-script')