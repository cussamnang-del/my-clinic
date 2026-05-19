<!doctype html>
<html lang="en" class="light-theme">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
  <link href="{{ assetUrl() }}/css/bootstrap.min.css" rel="stylesheet" />
  <link href="{{ assetUrl() }}/css/bootstrap-extended.css" rel="stylesheet" />
  <link href="{{ assetUrl() }}/css/style.css" rel="stylesheet" />
  <link href="{{ assetUrl() }}/css/icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins/bootstrap-icons/font/bootstrap-icons.css">
  <!-- loader-->
  <link href="{{ assetUrl() }}/css/pace.min.css" rel="stylesheet" />
  <title>Clinic Management System Login Form</title>
</head>

<body>

  <!--start wrapper-->
  <div class="wrapper">
    <!--start content-->
    <main class="authentication-content">
      <div class="container-fluid">
        <div class="authentication-card">
          <div class="card shadow rounded-0 overflow-hidden">
            <div class="row g-0">
              <div class="col-lg-6 bg-login d-flex align-items-center justify-content-center">
                <img src="{{ assetUrl() }}/images/error/login-img.jpg" class="img-fluid" alt="">
              </div>
              <div class="col-lg-6">
                <div class="card-body p-4 p-sm-5">
                  <h3 class="card-title mb-5 text-center">{{ __('Login') }}</h3>
                  <form method="POST" action="{{ route('login') }}" class="form-body">
                    @csrf
                    <div class="row g-3">
                      <div class="col-12">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <div class="ms-auto position-relative">
                          <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                              class="bi bi-envelope-fill"></i></div>
                          <input id="email" type="email"
                            class="form-control radius-30 ps-5 @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>
                        @error('email')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                      <div class="col-12">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <div class="ms-auto position-relative">
                          <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                              class="bi bi-lock-fill"></i></div>
                          <input id="password" type="password"
                            class="form-control radius-30 ps-5 @error('password') is-invalid @enderror" name="password"
                            required autocomplete="current-password">
                          @error('password')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                          <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                          </label>
                        </div>
                      </div>
                      <div class="col-6 text-end">
                        <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                      </div>
                      <div class="col-12">
                        <div class="d-grid">
                          <button type="submit" class="btn btn-primary radius-30">
                            {{ __('Login') }}
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!--end page main-->
  </div>
  <!--end wrapper-->
  <!--plugins-->
  <script src="{{ assetUrl() }}/js/jquery.min.js"></script>
  <script src="{{ assetUrl() }}/js/pace.min.js"></script>
</body>

</html>
