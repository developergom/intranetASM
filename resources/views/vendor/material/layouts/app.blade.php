<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    
<!-- Mirrored from byrushan.com/projects/ma/1-5-2/jquery/index.html by HTTrack Website Copier/3.x [XR&CO'2013], Wed, 11 May 2016 10:14:19 GMT -->
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{!! Cache::get('setting_headtitle') !!}</title>

        <link rel="icon" type="image/ico" href="{{ url('img/favicon.png')}}" />

        <!-- Vendor CSS -->
        <link href="{{ url('css/fullcalendar.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/animate.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/sweet-alert.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/jquery.bootgrid.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/material-design-iconic-font.min.css') }}" rel="stylesheet">
        @yield('vendorcss')

            
        <!-- CSS -->
        <link href="{{ url('css/app.min.1.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.min.2.css') }}" rel="stylesheet">
        @yield('customcss')
        
    </head>
    <body>
        <header id="header" class="clearfix" data-current-skin="blue">
            <ul class="header-inner">
                <li id="menu-trigger" data-trigger="#sidebar">
                    <div class="line-wrap">
                        <div class="line top"></div>
                        <div class="line center"></div>
                        <div class="line bottom"></div>
                    </div>
                </li>

                <li class="logo hidden-xs">
                    <!-- <a href="#">Intranet<b>ASM</b></a> -->
                    <a href="#">{!! Cache::get('setting_app_name') !!}</a>
                </li>

                <li class="pull-right">
                    <ul class="top-menu">
                        <li id="toggle-width">
                            <div class="toggle-switch">
                                <input id="tw-switch" type="checkbox" hidden="hidden">
                                <label for="tw-switch" class="ts-helper"></label>
                            </div>
                        </li>

                        <li id="top-search">
                            <a href="#"><i class="tm-icon zmdi zmdi-search"></i></a>
                        </li>

                        <li class="dropdown">
                            <a data-toggle="dropdown" href="#">
                                <i class="tm-icon zmdi zmdi-email"></i>
                                <i class="tmn-counts">0</i>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a data-toggle="dropdown" href="#">
                                <i class="tm-icon zmdi zmdi-notifications"></i>
                                <i class="tmn-counts" id="notification_count">0</i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg pull-right">
                                <div class="listview" id="notifications">
                                    <div class="lv-header">
                                        Notification

                                        <ul class="actions">
                                        </ul>
                                    </div>
                                    <div class="lv-body" id="notification_lists">
                                        
                                    </div>

                                    <!-- <a class="lv-footer" href="#">View Previous</a> -->
                                </div>

                            </div>
                        </li>
                        <li class="dropdown">
                            <a data-toggle="dropdown" href="#"><i class="tm-icon zmdi zmdi-more-vert"></i></a>
                            <ul class="dropdown-menu dm-icon pull-right">
                                <li class="skin-switch hidden-xs">
                                    <span class="ss-skin bgm-lightblue" data-skin="lightblue"></span>
                                    <span class="ss-skin bgm-bluegray" data-skin="bluegray"></span>
                                    <span class="ss-skin bgm-cyan" data-skin="cyan"></span>
                                    <span class="ss-skin bgm-teal" data-skin="teal"></span>
                                    <span class="ss-skin bgm-orange" data-skin="orange"></span>
                                    <span class="ss-skin bgm-blue" data-skin="blue"></span>
                                </li>
                                <li class="divider hidden-xs"></li>
                                <li class="hidden-xs">
                                    <a data-action="fullscreen" href="#"><i class="zmdi zmdi-fullscreen"></i> Toggle Fullscreen</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>


            <!-- Top Search Content -->
            <div id="top-search-wrap">
                <div class="tsw-inner">
                    <i id="top-search-close" class="zmdi zmdi-arrow-left"></i>
                    <input type="text">
                </div>
            </div>
        </header>
        
        <section id="main" data-layout="layout-1">
            <aside id="sidebar" class="sidebar c-overflow">
                <div class="profile-menu">
                    <a href="#">
                        <div class="profile-pic">
                            <img src="{{ url('/') }}/img/avatar/{{ Auth::user()->user_avatar }}" alt="">
                        </div>

                        <div class="profile-info">
                            {{ Auth::user()->user_firstname . ' ' . Auth::user()->user_lastname }}

                            <i class="zmdi zmdi-caret-down"></i>
                        </div>
                    </a>

                    <ul class="main-menu">
                        <li>
                            <a href="{{ url('profile') }}"><i class="zmdi zmdi-account"></i> View Profile</a>
                        </li>
                        <li>
                            <a href="{{ url('change-password') }}"><i class="zmdi zmdi-key"></i> Change Password</a>
                        </li>
                        <li>
                            <a href="{{ url('logout') }}"><i class="zmdi zmdi-time-restore"></i> Logout</a>
                        </li>
                    </ul>
                </div>

                {!! $menucomposer !!}
            </aside>
            
            <aside id="chat" class="sidebar c-overflow">
            
                <div class="chat-search">
                    <div class="fg-line">
                        <input type="text" class="form-control" placeholder="Search People">
                    </div>
                </div>

                <div class="listview">
                    <a class="lv-item" href="#">
                        <div class="media">
                            <div class="pull-left p-relative">
                                <img class="lv-img-sm" src="#" alt="">
                                <i class="chat-status-busy"></i>
                            </div>
                            <div class="media-body">
                                <div class="lv-title">Jonathan Morris</div>
                                <small class="lv-small">Available</small>
                            </div>
                        </div>
                    </a>
                </div>
            </aside>
            
            
            <section id="content">
                <div class="container">

                    @yield('content')

                </div>
            </section>
        </section>
        
        <footer id="footer">
            Copyright &copy; 2016 Gramedia Majalah IT
        </footer>

        <!-- Page Loader -->
        <div class="page-loader">
            <div class="preloader pls-blue">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20" />
                </svg>

                <p>Please wait...</p>
            </div>
        </div>
        
        <!-- Older IE warning message -->
        <!--[if lt IE 9]>
            <div class="ie-warning">
                <h1 class="c-white">Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li>
                            <a href="http://www.google.com/chrome/">
                                <img src="img/browsers/chrome.png" alt="">
                                <div>Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.mozilla.org/en-US/firefox/new/">
                                <img src="img/browsers/firefox.png" alt="">
                                <div>Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com">
                                <img src="img/browsers/opera.png" alt="">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.apple.com/safari/">
                                <img src="img/browsers/safari.png" alt="">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                                <img src="img/browsers/ie.png" alt="">
                                <div>IE (New)</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>   
        <![endif]-->
        <script type="text/javascript">
        var base_url = '{{ url('/') }}/';
        </script>

        
        <!-- Javascript Libraries -->
        <script src="{{ url('js/jquery.min.js') }}"></script>
        <script src="{{ url('js/bootstrap.min.js') }}"></script>

        <script src="{{ url('js/jquery.flot.js') }}"></script>
        <script src="{{ url('js/jquery.flot.resize.js') }}"></script>
        <script src="{{ url('js/curvedlines.js') }}"></script>
        <script src="{{ url('js/moment.min.js') }}"></script>
        <script src="{{ url('js/fullcalendar.min.js') }}"></script>
        <script src="{{ url('js/jquery.simpleWeather.min.js') }}"></script>
        <script src="{{ url('js/waves.min.js') }}"></script>
        <script src="{{ url('js/bootstrap-notify.min.js') }}"></script>
        <script src="{{ url('js/jquery.bootstrap-growl.js') }}"></script>
        <script src="{{ url('js/sweet-alert.min.js') }}"></script>
        <script src="{{ url('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
        <script src="{{ url('js/jquery.bootgrid.min.js') }}"></script>
        <script src="{{ url('js/tinymce/tinymce.min.js') }}"></script>
        @yield('vendorjs')
        
        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->
        
        <script src="{{ url('js/curved-line-chart.js') }}"></script>
        <script src="{{ url('js/line-chart.js') }}"></script>
        <script src="{{ url('js/charts.js') }}"></script>
        <script src="{{ url('js/functions.js') }}"></script>
        <script src="{{ url('js/demo.js') }}"></script>

        <!-- for notification -->
        @if(Session::has('status'))
        <script type="text/javascript">
        $(window).load(function(){
            //swal("{{ Session::get('status') }}");
            swal("Success", "{{ Session::get('status') }}", "success");
        });
        </script>
        @endif

        <script src="{{ url('js/app/notification.js') }}"></script>
        <script src="{{ url('js/app/global.js') }}"></script>

        @yield('customjs')
    </body>
  
<!-- Mirrored from byrushan.com/projects/ma/1-5-2/jquery/index.html by HTTrack Website Copier/3.x [XR&CO'2013], Wed, 11 May 2016 10:14:19 GMT -->
</html>