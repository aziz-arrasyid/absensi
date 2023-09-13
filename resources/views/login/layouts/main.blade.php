<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>{{ $title }}</title>

      <!-- Favicon -->
      <link rel="shortcut icon" href="{{ asset('/assets/images/favicon.ico') }}" />
      <link rel="stylesheet" href="{{ asset('/assets/css/backend-plugin.min.css') }}">
      <link rel="stylesheet" href="{{ asset('/assets/css/backend.css?v=1.0.0') }}">
      <link rel="stylesheet" href="{{ asset('/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
      <link rel="stylesheet" href="{{ asset('/assets/vendor/remixicon/fonts/remixicon.css') }}">

      <link rel="stylesheet" href="{{ asset('/assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css') }}">
      <link rel="stylesheet" href="{{ asset('/assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css') }}">
      <link rel="stylesheet" href="{{ asset('/assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css') }}">  </head>
  <body class=" ">
    <!-- loader Start -->
    <div id="loading">
          <div id="loading-center">
          </div>
    </div>
    <!-- loader END -->

      <div class="wrapper">
        @yield('content')
      </div>

    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('/assets/js/backend-bundle.min.js') }}"></script>

    <!-- Table Treeview JavaScript -->
    <script src="{{ asset('/assets/js/table-treeview.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('/assets/js/customizer.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('/assets/js/chart-custom.js') }}"></script>
    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('/assets/js/slider.js') }}"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('/assets/js/app.js') }}"></script>

    <script src="{{ asset('/assets/vendor/moment.min.js') }}"></script>
  </body>
</html>
