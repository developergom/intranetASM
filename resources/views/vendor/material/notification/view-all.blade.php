@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Notifications<small>List of all notifications</small></h2>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="listview">
                    <div class="lv-body" id="notification_all_container">
                    @foreach($notifications as $notification)
                        <a class="lv-item" href="{{ url($notification->notification_type_url) }}" title="{{ $notification->notification_text }}">
                            <div class="media">
                                <div class="pull-left">
                                    <img class="lv-img-sm" src="{{ url('img/avatar/' . $notification->user_avatar) }}">
                                </div>
                                <div class="pull-right">
                                    <button type="button" class="close notification-delete" data-notif-id="{{ $notification->notification_id }}" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="media-body">
                                    <div class="lv-title">{{ $notification->user_firstname . ' ' . $notification->user_lastname }}</div>
                                    <small class="lv-small">{{ $notification->notification_text }}</small>
                                </div>
                                
                            </div>
                        </a>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection