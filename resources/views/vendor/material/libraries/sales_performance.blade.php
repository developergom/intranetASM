<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    
<!-- Mirrored from byrushan.com/projects/ma/1-5-2/jquery/index.html by HTTrack Website Copier/3.x [XR&CO'2013], Wed, 11 May 2016 10:14:19 GMT -->
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Sales Performance</title>

        <link rel="icon" type="image/ico" href="{{ url('img/favicon.png')}}" />

        <!-- Vendor CSS -->
        <link href="{{ url('css/material-design-iconic-font.min.css') }}" rel="stylesheet">

            
        <!-- CSS -->
        <link href="{{ url('css/app.min.1.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.min.2.css') }}" rel="stylesheet">
        
    </head>
    <body>
    	<div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Sales Performance Monthly Report</h2>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-12">
                    <h5>NIK : {{ $user->user_name }}</h5><br/>
                    <h5>Name : {{ $user->user_firstname . ' ' . $user->user_lastname }} </h5><br/>
                </div>
            </div>
        </div>
    </body>
</html>