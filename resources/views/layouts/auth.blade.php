<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | Admin Area</title>
    <!-- Main styles for this application-->
    <link href="{{ asset('assets/backend') }}/css/style.css" rel="stylesheet">
    <link href="{{ asset('assets/backend') }}/vendors/@coreui/icons/css/free.min.css" rel="stylesheet">
</head>

<body class="c-app flex-row align-items-center">
    <div id="app" class="container">
        <auth></auth>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('assets/backend') }}/vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <!--[if IE]><!-->
    <script src="{{ asset('assets/backend') }}/vendors/@coreui/icons/js/svgxuse.min.js"></script>
    <!--<![endif]-->
    <script src="{{ mix('js/auth.js') }}"></script>


</body>

</html>
