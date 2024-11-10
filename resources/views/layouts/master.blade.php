
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') || Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('asset/dist/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('asset/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('asset/dist/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('asset/dist/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        .alert-danger {
            color: #fff;
            background: #dc354596;
            border-color: #d3253573;
        }
        .card-header {
            background: linear-gradient(-120deg, #a98c66, #12191c, #2b3944, #000000);
        }
        .user-panel {
            padding-bottom: 0 !important;
            padding-top: 7px !important;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed" >
<div class="wrapper">


    @include('layouts.partial.admin.header')

    @include('layouts.partial.admin.sidebar')

    <div class="content-wrapper" style="min-height: 1203.6px; " >
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@yield('title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        @yield('content')
    </div>

    @include('layouts.partial.admin.footer')

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
</div>

@include('sweetalert::alert')

<script src="{{asset('asset/dist/jquery/jquery.min.js')}}"></script>
<script src="{{asset('asset/dist/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('asset/dist/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<script src="{{asset('asset/dist/js/adminlte.js')}}"></script>
<script>
    $(document).ready( function () {
        $('.select2').select2();
        $("#showTeam").select2({disabled:'readonly'});
    } );
</script>
@yield('script')
</body>
</html>
