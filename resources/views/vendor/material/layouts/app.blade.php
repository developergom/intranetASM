<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    
<!-- Mirrored from byrushan.com/projects/ma/1-5-2/jquery/index.html by HTTrack Website Copier/3.x [XR&CO'2013], Wed, 11 May 2016 10:14:19 GMT -->
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Intranet ASM Apps</title>

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
                            <div class="dropdown-menu dropdown-menu-lg pull-right">
                                <div class="listview">
                                    <div class="lv-header">
                                        Messages
                                    </div>
                                    <div class="lv-body">
                                        <a class="lv-item" href="#">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <img class="lv-img-sm" src="#" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lv-title">Jonathan Morris</div>
                                                    <small class="lv-small">Nunc quis diam diamurabitur at dolor elementum, dictum turpis vel</small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <a class="lv-footer" href="#">View All</a>
                                </div>
                            </div>
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
                                            <!-- <li class="dropdown">
                                                <a href="#" data-clear="notification">
                                                    <i class="zmdi zmdi-check-all"></i>
                                                </a>
                                            </li> -->
                                        </ul>
                                    </div>
                                    <div class="lv-body" id="notification_lists">
                                        <a class="lv-item" href="#">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <img class="lv-img-sm" src="#" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lv-title">Bill Phillips</div>
                                                    <small class="lv-small">Proin laoreet commodo eros id faucibus. Donec ligula quam, imperdiet vel ante placerat</small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <a class="lv-footer" href="#">View Previous</a>
                                </div>

                            </div>
                        </li>
                        <!-- <li class="dropdown hidden-xs">
                            <a data-toggle="dropdown" href="#">
                                <i class="tm-icon zmdi zmdi-view-list-alt"></i>
                                <i class="tmn-counts">2</i>
                            </a>
                            <div class="dropdown-menu pull-right dropdown-menu-lg">
                                <div class="listview">
                                    <div class="lv-header">
                                        Tasks
                                    </div>
                                    <div class="lv-body">
                                        <div class="lv-item">
                                            <div class="lv-title m-b-5">HTML5 Validation Report</div>

                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 95%">
                                                    <span class="sr-only">95% Complete (success)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lv-item">
                                            <div class="lv-title m-b-5">Google Chrome Extension</div>

                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                                    <span class="sr-only">80% Complete (success)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lv-item">
                                            <div class="lv-title m-b-5">Social Intranet Projects</div>

                                            <div class="progress">
                                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lv-item">
                                            <div class="lv-title m-b-5">Bootstrap Admin Template</div>

                                            <div class="progress">
                                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                                    <span class="sr-only">60% Complete (warning)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lv-item">
                                            <div class="lv-title m-b-5">Youtube Client App</div>

                                            <div class="progress">
                                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                                    <span class="sr-only">80% Complete (danger)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <a class="lv-footer" href="#">View All</a>
                                </div>
                            </div>
                        </li> -->
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
                        <!-- <li class="hidden-xs" id="chat-trigger" data-trigger="#chat">
                            <a href="#"><i class="tm-icon zmdi zmdi-comment-alt-text"></i></a>
                        </li> -->
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

                <!-- <ul class="main-menu">
                    @can('Home-Read')
                    <li class="{{ (Request::segment(1)=='') ? 'active' : ''  }}">
                        <a href="{{ url('/') }}"><i class="zmdi zmdi-home"></i> Home</a>
                    </li>
                    @endcan
                    @can('Users Management-Read')
                    <li class="{{ (Request::segment(1)=='user') ? 'active' : ''  }}">
                        <a href="{{ url('user') }}"><i class="zmdi zmdi-assignment-account"></i> Users Management</a>
                    </li>
                    @endcan
                    @can('Master Data-Read')
                    <li class="sub-menu {{ (Request::segment(1)=='master') ? 'active toggled' : ''  }}">
                        <a href="#"><i class="zmdi zmdi-view-list"></i> Master Data</a>

                        <ul>
                            @can('Action Controls Management-Read')
                            <li><a class="{{ (Request::segment(2)=='action') ? 'active' : ''  }}" href="{{ url('master/action') }}">Action Controls Management</a></li>
                            @endcan
                            @can('Action Types Management-Read')
                            <li><a class="{{ (Request::segment(2)=='actiontype') ? 'active' : ''  }}" href="{{ url('master/actiontype') }}">Action Types Management</a></li>
                            @endcan
                            @can('Advertise Positions Management-Read')
                            <li><a class="{{ (Request::segment(2)=='advertiseposition') ? 'active' : ''  }}" href="{{ url('master/advertiseposition') }}">Advertise Positions Management</a></li>
                            @endcan
                            @can('Advertise Rates Management-Read')
                            <li><a class="{{ (Request::segment(2)=='advertiserate') ? 'active' : ''  }}" href="{{ url('master/advertiserate') }}">Advertise Rates Management</a></li>
                            @endcan
                            @can('Advertise Sizes Management-Read')
                            <li><a class="{{ (Request::segment(2)=='advertisesize') ? 'active' : ''  }}" href="{{ url('master/advertisesize') }}">Advertise Sizes Management</a></li>
                            @endcan
                            @can('Brands Management-Read')
                            <li><a class="{{ (Request::segment(2)=='brand') ? 'active' : ''  }}" href="{{ url('master/brand') }}">Brands Management</a></li>
                            @endcan
                            @can('Clients Management-Read')
                            <li><a class="{{ (Request::segment(2)=='client') ? 'active' : ''  }}" href="{{ url('master/client') }}">Clients Management</a></li>
                            @endcan
                            @can('Client Types Management-Read')
                            <li><a class="{{ (Request::segment(2)=='clienttype') ? 'active' : ''  }}" href="{{ url('master/clienttype') }}">Client Types Management</a></li>
                            @endcan
                            @can('Groups Management-Read')
                            <li><a class="{{ (Request::segment(2)=='group') ? 'active' : ''  }}" href="{{ url('master/group') }}">Groups Management</a></li>
                            @endcan
                            @can('Holidays Management-Read')
                            <li><a class="{{ (Request::segment(2)=='holiday') ? 'active' : ''  }}" href="{{ url('master/holiday') }}">Holidays Management</a></li>
                            @endcan
                            @can('Industries Management-Read')
                            <li><a class="{{ (Request::segment(2)=='industry') ? 'active' : ''  }}" href="{{ url('master/industry') }}">Industries Management</a></li>
                            @endcan
                            @can('Inventory Types Management-Read')
                            <li><a class="{{ (Request::segment(2)=='inventorytype') ? 'active' : ''  }}" href="{{ url('master/inventorytype') }}">Inventory Types Management</a></li>
                            @endcan
                            @can('Media Management-Read')
                            <li><a class="{{ (Request::segment(2)=='media') ? 'active' : ''  }}" href="{{ url('master/media') }}">Media Management</a></li>
                            @endcan
                            @can('Media Categories Management-Read')
                            <li><a class="{{ (Request::segment(2)=='mediacategory') ? 'active' : ''  }}" href="{{ url('master/mediacategory') }}">Media Categories Management</a></li>
                            @endcan
                            @can('Media Groups Management-Read')
                            <li><a class="{{ (Request::segment(2)=='mediagroup') ? 'active' : ''  }}" href="{{ url('master/mediagroup') }}">Media Groups Management</a></li>
                            @endcan
                            @can('Menus Management-Read')
                            <li><a class="{{ (Request::segment(2)=='menu') ? 'active' : ''  }}" href="{{ url('master/menu') }}">Menus Management</a></li>
                            @endcan
                            @can('Modules Management-Read')
                            <li><a class="{{ (Request::segment(2)=='module') ? 'active' : ''  }}" href="{{ url('master/module') }}">Modules Management</a></li>
                            @endcan
                            @can('Paper Types Management-Read')
                            <li><a class="{{ (Request::segment(2)=='paper') ? 'active' : ''  }}" href="{{ url('master/paper') }}">Paper Types Management</a></li>
                            @endcan
                            @can('Proposal Types Management-Read')
                            <li><a class="{{ (Request::segment(2)=='proposaltype') ? 'active' : ''  }}" href="{{ url('master/proposaltype') }}">Proposal Types Management</a></li>
                            @endcan
                            @can('Religions Management-Read')
                            <li><a class="{{ (Request::segment(2)=='religion') ? 'active' : ''  }}" href="{{ url('master/religion') }}">Religions Management</a></li>
                            @endcan
                            @can('Roles Management-Read')
                            <li><a class="{{ (Request::segment(2)=='role') ? 'active' : ''  }}" href="{{ url('master/role') }}">Roles Management</a></li>
                            @endcan
                            @can('Sub Industries Management-Read')
                            <li><a class="{{ (Request::segment(2)=='subindustry') ? 'active' : ''  }}" href="{{ url('master/subindustry') }}">Sub Industries Management</a></li>
                            @endcan
                            @can('Units Management-Read')
                            <li><a class="{{ (Request::segment(2)=='unit') ? 'active' : ''  }}" href="{{ url('master/unit') }}">Units Management</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                </ul> -->
                <!-- @include('vendor.material.layouts.menu') -->
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
            
            <ul class="f-menu">
                <li><a href="#">Home</a></li>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="#">Support</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
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

        @yield('customjs')
    </body>
  
<!-- Mirrored from byrushan.com/projects/ma/1-5-2/jquery/index.html by HTTrack Website Copier/3.x [XR&CO'2013], Wed, 11 May 2016 10:14:19 GMT -->
</html>