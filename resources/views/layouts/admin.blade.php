<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.admin_topscript')
    <style>
        label{
            font-weight: 600;
            margin-top: 10px;
        },
        table td{
            font-weight: 500;
        }
    </style>
    @livewireStyles
</head>

<body id="page-top" class="sidebar-toggled">
    <div id="wrapper">
        @include('components.admin_sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('components.admin_navbar')
                @yield('content')
            </div>
            <!-- End of Main Content -->
            @include('components.admin_bottomscript')
            @livewireScripts
</body>

</html>
