<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title . ' | ' . config('app.name') }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ url('/') }}/assets/images/favicon.ico" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:/partials/_navbar.html -->
      @include('Partials._navbar')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:/partials/_sidebar.html -->
        @include('Partials._sidebar')

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            @yield('content')
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:/partials/_footer.html -->
          @include('Partials._footer')
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ url('/') }}/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ url('/') }}/assets/js/off-canvas.js"></script>
    <script src="{{ url('/') }}/assets/js/hoverable-collapse.js"></script>
    <script src="{{ url('/') }}/assets/js/misc.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('Partials.sweetalert2')
    @yield('script')
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
  </body>
</html>