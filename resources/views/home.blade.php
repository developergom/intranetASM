@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/announcement-home.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if(count($announcements) > 0)
    <div id="announcement-container" class="alert alert-info" role="alert">
        <div id="text">
            <!-- 1 Lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="zmdi zmdi-info"></span>&nbsp;&nbsp;&nbsp;&nbsp;
            2 Lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="zmdi zmdi-info"></span>&nbsp;&nbsp;&nbsp;&nbsp;
            3 Lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="zmdi zmdi-info"></span>&nbsp;&nbsp;&nbsp;&nbsp; -->
            @foreach($announcements as $announcement)
                {!! $announcement->announcement_detail . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="zmdi zmdi-info"></span>&nbsp;&nbsp;&nbsp;&nbsp;' !!}
            @endforeach
        </div>
    </div>
    @endif
	<div class="block-header">
        <h2>Dashboard</h2>
        
        <ul class="actions">
            <li>
                <a href="#">
                    <i class="zmdi zmdi-trending-up"></i>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="zmdi zmdi-check-all"></i>
                </a>
            </li>
            <li class="dropdown">
                <a href="#" data-toggle="dropdown">
                    <i class="zmdi zmdi-more-vert"></i>
                </a>
                
                <ul class="dropdown-menu dropdown-menu-right">
                    <li>
                        <a href="#">Refresh</a>
                    </li>
                    <li>
                        <a href="#">Manage Widgets</a>
                    </li>
                    <li>
                        <a href="#">Widgets Settings</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="card">
        <div class="card-header">Dashboard</div>
        <div class="card-body card-padding">
            You are logged in!
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/jquery.marquee.min.js') }}"></script>
@endsection

@section('customjs')
<script type="text/javascript">
$(document).ready(function(){
    $('#text').marquee({
        duration: 60000,
        startVisible: true,
        duplicated: true
      });
});
</script>
@endsection