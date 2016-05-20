@extends('vendor.material.layouts.app')

@section('content')
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
