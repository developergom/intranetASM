<!DOCTYPE html>
    <!--[if IE 9 ]><html class="ie9"><![endif]-->
    
<!-- Mirrored from byrushan.com/projects/ma/1-5-2/jquery/login.html by HTTrack Website Copier/3.x [XR&CO'2013], Wed, 11 May 2016 10:20:14 GMT -->
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{!! Cache::get('setting_headtitle') !!}</title>
        
        <!-- Vendor CSS -->
        <link href="{{ url('css/animate.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/material-design-iconic-font.min.css') }}" rel="stylesheet">
            
        <!-- CSS -->
        <link href="{{ url('css/app.min.1.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.min.2.css') }}" rel="stylesheet">

    </head>
    
    <body class="login-content">
        <!-- Login -->
        <div class="lc-block toggled" id="l-login">
            <form method="POST" role="form" action="{{ url('/login') }}" id="form-login">
            {{ csrf_field() }}
            <div>
                <h3>{!! Cache::get('setting_app_name') !!}</h3><br/>
            </div>
            <div class="clearfix"></div>
            <div class="input-group m-b-20 {{ $errors->has('user_name') ? ' has-error' : '' }}">
                <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Username" name="user_name">
                </div>
                @if ($errors->has('user_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('user_name') }}</strong>
                    </span>
                @endif
            </div>
            
            <div class="input-group m-b-20 {{ $errors->has('password') ? ' has-error' : '' }}">
                <span class="input-group-addon"><i class="zmdi zmdi-male"></i></span>
                <div class="fg-line">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                </div>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            
            <div class="clearfix"></div>
            
            <!-- <div class="checkbox">
                <label>
                    <input type="checkbox" value="">
                    <i class="input-helper"></i>
                    Keep me signed in
                </label>
            </div> -->
            
            <button type="submit" class="btn btn-login btn-danger btn-float"><i class="zmdi zmdi-arrow-forward"></i></button>

            </form>
            
            <ul class="login-navigation">
                <!-- <li data-block="#l-register" class="bgm-red">Register</li> -->
                <li data-block="#l-forget-password" class="bgm-orange">Forgot Password?</li>
            </ul>
        </div>
        
        <!-- Forgot Password -->
        <div class="lc-block" id="l-forget-password">
            <p class="text-left">Please call administrator to reset your password.</p>
            
            <!-- <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Email Address">
                </div>
            </div> -->
            
            <a href="#" class="btn btn-login btn-danger btn-float"><i class="zmdi zmdi-arrow-forward"></i></a>
            
            <ul class="login-navigation">
                <li data-block="#l-login" class="bgm-green">Login</li>
                <!-- <li data-block="#l-register" class="bgm-red">Register</li> -->
            </ul>
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
        
        <!-- Javascript Libraries -->
        <script src="{{ url('js/jquery.min.js') }}"></script>
        <script src="{{ url('js/bootstrap.min.js') }}"></script>
        <script src="{{ url('js/waves.min.js') }}"></script>
        
        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->
        
        <script src="{{ url('js/functions.js') }}"></script>

        <script type="text/javascript">
        $(document).ready(function(){
            $('.btn-login').click(function(){
                $('#form-login').submit();
            });

            /*setInterval(function(){
                window.location.reload();
            }, 10000);*/ // 1 hour 

            var time = new Date().getTime();
             $(document.body).bind("mousemove keypress", function(e) {
                 time = new Date().getTime();
             });

             function refresh() {
                 if(new Date().getTime() - time >= 900000) 
                     window.location.reload(true);
                 else 
                     setTimeout(refresh, 10000);
             }

             setTimeout(refresh, 10000);
        });
        </script>
        
    </body>

<!-- Mirrored from byrushan.com/projects/ma/1-5-2/jquery/login.html by HTTrack Website Copier/3.x [XR&CO'2013], Wed, 11 May 2016 10:20:14 GMT -->
</html>