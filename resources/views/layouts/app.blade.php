<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    
    <link rel="stylesheet"
        href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
</head>
<body>
    <div class="main-body">
        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="javascript:void(0);">
                        <b><span style="color:#fff;font-size: 28px;">{{ config('app.name', 'Laravel') }}</span></b>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    @guest
                    @else
                    <ul class="nav navbar-nav">
                        <li class="{{ Auth::user()->Role == 1 ? '' : 'hidden' }} {{ Request::is('maintain/employee') ? 'active' : '' }}"><a href="{{ url('maintain/employee') }}">Maintain Employee</a></li>
                        <li class="{{ Auth::user()->Role == 1 ? '' : 'hidden' }} {{ Request::is('maintain/project') ? 'active' : '' }}"><a href="{{ url('maintain/project') }}">Maintain Project</a></li>
                        <li class="{{ Auth::user()->Role != 3 ? '' : 'hidden' }} {{ Request::is('manage/project') || Request::is('manage/project/*') ? 'active' : '' }}"><a href="{{ url('manage/project') }}">Manage Project</a></li>
                        <li class="{{ Auth::user()->Role != 3 ? '' : 'hidden' }} {{ Request::is('manage/generatesummary') || Request::is('generatereport') ? 'active' : '' }}"><a href="{{ url('manage/generatesummary') }}">Generate Summary</a></li>
                        <li class="{{ Request::is('employee/viewtimesheet') ? 'active' : '' }} {{ Request::is('employee/viewemployeetimesheet') ? 'active' : '' }}">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    View Timesheet <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="{{ Request::is('employee/viewtimesheet') ? 'active' : '' }}">
                                    <a href="{{ url('employee/viewtimesheet') }}">My Timesheet</a>
                                </li>
                                <li class="{{ Auth::user()->Role != 3 ? '' : 'hidden' }} {{ Request::is('employee/viewemployeetimesheet') ? 'active' : '' }}">
                                    <a href="{{ url('employee/viewemployeetimesheet') }}">Employee Timesheet</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    @endguest
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <!-- <li><a href="{{ route('register') }}">Register</a></li> -->
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->FullName }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a>{{ Auth::user()->JobTitle }}</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <span class="text-primary">Logout</span>
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
    <script src="//code.jquery.com/jquery-1.12.3.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/common.js') }}"></script>
</body>
</html>
