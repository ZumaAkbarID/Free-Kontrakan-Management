<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login | {{ config('app.name') }}</title>
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
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="{{ url('/') }}/assets/images/logo.svg">
                </div>
                <h4>Assalamualaikum Gantenk</h4>
                <h6 class="font-weight-light">Lojin Sek.</h6>

                <form class="pt-3" method="POST">
                  @csrf
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username" name="username" value="{{ old('username') }}" required>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" name="password" required>
                  </div>
                  <div class="mt-3">
                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">LOJIN</button>
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" name="remember" class="form-check-input"> Inggat gweh </label>
                    </div>
                    <a href="#" class="auth-link text-black">Lali password? Klik iki</a>
                  </div>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
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
    <!-- endinject -->
  </body>
</html>