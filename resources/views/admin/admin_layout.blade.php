@include('admin.layouts.partials.head')
<body>
  <script>
    const onErrorImage = (e) => {
      e.target.src = "{{ errorImageUrl() }}";
    };
  </script>
  <!--start wrapper-->
  <div class="wrapper">
    <!--start top header-->
      @include('admin.layouts.partials.top_nav')
      <!--end top header-->

      <!--start sidebar -->
        @include('admin.layouts.partials.left_sidebar')
       <!--end sidebar -->

       <!--start content-->
          <main class="page-content">

              <!--breadcrumb-->
              <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Pages</div>
                <div class="ps-3">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                      <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">@yield('breadcrumb')</li>
                    </ol>
                  </nav>
                </div>
              </div>
              <!--end breadcrumb-->
            @yield('content')

          </main>
       <!--end page main-->


       <!--start overlay-->
        <div class="overlay nav-toggle-icon"></div>
       <!--end overlay-->

        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->

        <!--start switcher-->
        @include('admin.layouts.partials.switcher')
       <!--end switcher-->

  </div>
  <!--end wrapper-->

  @include('admin.layouts.partials.script')

</body>

</html>
