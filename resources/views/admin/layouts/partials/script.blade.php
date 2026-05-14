
  {{-- <script src="{{ assetUrl() }}/js/jquery.min.js"></script> --}}
  <script src="{{ assetUrl() }}/js/jquery-3.5.1.min.js"></script>
  <script src="{{ assetUrl() }}/js/jquery-ui.min.js"></script>
  <!-- Bootstrap bundle JS -->
  <script src="{{ assetUrl() }}/js/bootstrap.bundle.min.js"></script>
  <script src="{{ assetUrl() }}/plugins/simplebar/js/simplebar.min.js"></script>
  <script src="{{ assetUrl() }}/plugins/metismenu/js/metisMenu.min.js"></script>
  <script src="{{ assetUrl() }}/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
  <script src="{{ assetUrl() }}/js/pace.min.js"></script>
  <!--app-->
  <script src="{{ assetUrl() }}/js/app.js"></script>
  <script src="{{ asset('assets/backend/layout-settings.js') }}"></script>
  <script>
    $(document).ready(function(){
      $.ajaxSetup({
        async:false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    });
  </script>
  @stack('print')

  @stack('scripts')

  @stack('modal')
