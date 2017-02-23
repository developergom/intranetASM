<!DOCTYPE html>
    <!--[if IE 9 ]><html class="ie9"><![endif]-->
    
<!-- Mirrored from byrushan.com/projects/ma/1-5-2/jquery/login.html by HTTrack Website Copier/3.x [XR&CO'2013], Wed, 11 May 2016 10:20:14 GMT -->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Intranet ASM</title>
            
        <!-- CSS -->
        <style type="text/css">
        body{
            background-color: #eee;
            color:auto;
            margin: 0;
            top: 0;
            left: 0;
            padding: 10px;
            font-family: 'sans-serif';
        }

        a.btn{
            text-decoration: none;
        }

        hr{
            color: #666666;
        }

        .container{
            margin: 0;
            padding: 5px;
        }

        .block-header{
            margin: 0;
        }

        .card{
            background-color: #ffffff;
            color: #000000;
            padding: 15px;
        }

        .btn {
            padding: 10px;
            padding-left: 30px;
            padding-right: 30px;
            text-align: center;
            font-weight: bold;
            border-radius: 3px;
            border: 0px;
        }

        .btn-primary {
            background-color: #3385ff;
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: #66a3ff;
            color: #ffffff;
        }

        .btn-success {
            background-color: #00cc66;
            color: #ffffff;
        }

        .btn-success:hover {
            background-color: #00e673;
            color: #ffffff;
        }

        .btn-danger {
            background-color: #e60000;
            color: #ffffff;
        }

        .btn-danger:hover {
            background-color: #ff1a1a;
            color: #ffffff;
        }

        p.center{
            padding: 10px;
            text-align: center;
        }
        </style>
    </head>
    
    <body style="color:auto;margin: 0;top: 0;left: 0;padding: 10px;font-family: 'sans-serif';">
        <section id="main">
            <section id="content">
                <div class="container">
                    <div class="card">
                        <div class="card-body card-padding">
                            <p>
                                Hello, {{ $item['to_fullname'] }}, <br/><br/>
                                You have a new notification for "{{ $item['subject'] }}" from {{ $item['from_fullname'] }}, please click button below:
                            </p>

                            <p class="center">
                                <a href="{{ url($item['url']) }}" class="btn btn-primary">Open Notification</a>
                            </p>

                            <p>
                                Thank you for using our application.
                            </p>

                            <p>
                                Regards,<br/>
                                <b>{!! Cache::get('setting_app_name') !!}</b>
                            </p>

                            <hr/>

                            <p>
                                If you're having trouble clicking the "Open Notification" button, copy and paste URL below into your browser:
                            </p>
                            <p>
                                <a href="{{ url($item['url']) }}">{{ url($item['url']) }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </section>
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
        
        
        
    </body>
</html>