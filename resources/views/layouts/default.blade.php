<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="/assets/image/icon-logo.png">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"  rel="stylesheet"/>
    <!-- MDB -->
    <link  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.1/mdb.min.css"  rel="stylesheet"/>
    <!-- CUSTOM CSS -->
    <link  href="/assets/css/app.css"  rel="stylesheet"/>

    <title>Shop bán điện thoại</title>
</head>
<body>
    @include('includes.header')

    @yield('banner')

    @yield('content')

    @include('includes.footer')

    <script  type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.1/mdb.min.js"></script>
</body>
</html>
