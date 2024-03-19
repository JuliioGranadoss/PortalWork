<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
       @include('includes.head')
    </head>
    @guest
        <body id="wrapper" class="bg-gradient-dark d-flex dlex-column" style="height: 100vh;">
            @yield('content')
        </body>
    @else
        <body id="page-top">

            <!-- Page Wrapper -->
            <div id="wrapper">

                @if (Auth::user()->hasRole(['admin', 'manager']))
                    <!-- Sidebar -->
                        @include('includes.sidebar')
                    <!-- End of Sidebar -->
                @endif

                <!-- Content Wrapper -->
                <div id="content-wrapper" class="d-flex flex-column">

                    <!-- Topbar -->
                        @include('includes.header')
                    <!-- End of Topbar -->

                    @section('breadcrumbs')@show

                    <!-- Main Content -->
                    <div id="app" class="mt-4">
                        @yield('content')
                    </div>
                    <!-- End of Main Content -->

                    <footer class="sticky-footer bg-white mt-auto">
                        @include('includes.footer')
                    </footer>

                </div>
                <!-- End of Content Wrapper -->

            </div>
            <!-- End of Page Wrapper -->
            @include('includes.profile')
            @include('includes.logout')
            @include('includes.scroll')
        </body>
    @endguest

</html>
