@extends('vendor.material.layouts.app')

@section('content')
<div class="card" id="profile-main">
    <div class="pm-overview c-overflow">
        <div class="pmo-pic">
            <div class="p-relative">
                <a href="#">
                	<img class="img-responsive" src="{{ url('/') }}/img/avatar/{{ $user->user_avatar }}" alt="">
                </a>
                
                <!-- <div class="dropdown pmop-message">
                    <a data-toggle="dropdown" href="#" class="btn bgm-white btn-float z-depth-1">
                        <i class="zmdi zmdi-comment-text-alt"></i>
                    </a>
                    
                    <div class="dropdown-menu">
                        <textarea placeholder="Write something..."></textarea>
                        
                        <button class="btn bgm-green btn-float"><i class="zmdi zmdi-mail-send"></i></button>
                    </div>
                </div> -->
                
                <a href="#" class="pmop-edit">
                    <i class="zmdi zmdi-camera"></i> <span class="hidden-xs">Update Profile Picture</span>
                </a>
            </div>
            
            
            <!-- <div class="pmo-stat">
                <h2 class="m-0 c-white">1562</h2>
                Total Connections
            </div> -->
        </div>
        
        <div class="pmo-block pmo-contact hidden-xs">
            <h2>Contact</h2>
            
            <ul>
                <li><i class="zmdi zmdi-phone"></i> {{ $user->user_phone }}</li>
                <li><i class="zmdi zmdi-email"></i> {{ $user->user_email }}</li>
            </ul>
        </div>
        
        
    </div>
    
    <div class="pm-body clearfix">
        <ul class="tab-nav tn-justified">
            <li class="waves-effect"><a href="#">{{ $user->user_firstname . ' ' . $user->user_lastname }}</a></li>
        </ul>
        
        
        <div class="pmb-block">
            <div class="pmbb-header">
                <h2><i class="zmdi zmdi-account m-r-5"></i> Basic Information</h2>
                
                <ul class="actions">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a data-pmb-action="edit" href="#">Edit</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="pmbb-body p-l-30">
                <div class="pmbb-view">
                	<dl class="dl-horizontal">
                        <dt>Username / NIK</dt>
                        <dd>{{ $user->user_name }}</dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>Full Name</dt>
                        <dd>{{ $user->user_firstname . ' ' . $user->user_lastname }}</dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>Gender</dt>
                        <dd>{{ ($user->user_gender=='1') ? 'Male' : 'Female' }}</dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>Birthday</dt>
                        <dd>{{ $birthdate }}</dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>Religion</dt>
                        <dd>{{ $user->religion->religion_name }}</dd>
                    </dl>
                </div>
                
                <div class="pmbb-edit">
                    <dl class="dl-horizontal">
                        <dt class="p-t-10">Full Name</dt>
                        <dd>
                            <div class="fg-line">
                                <input type="text" class="form-control" placeholder="eg. Mallinda Hollaway">
                            </div>
                            
                        </dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt class="p-t-10">Gender</dt>
                        <dd>
                            <div class="fg-line">
                                <select class="form-control">
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt class="p-t-10">Birthday</dt>
                        <dd>
                            <div class="dtp-container dropdown fg-line">
                                <input type='text' class="form-control date-picker" data-toggle="dropdown" placeholder="Click here...">
                            </div>
                        </dd>
                    </dl>
                    
                    <div class="m-t-30">
                        <button class="btn btn-primary btn-sm">Save</button>
                        <button data-pmb-action="reset" class="btn btn-link btn-sm">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
   
    
        <div class="pmb-block">
            <div class="pmbb-header">
                <h2><i class="zmdi zmdi-phone m-r-5"></i> Contact Information</h2>
                
                <ul class="actions">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a data-pmb-action="edit" href="#">Edit</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="pmbb-body p-l-30">
                <div class="pmbb-view">
                    <dl class="dl-horizontal">
                        <dt>Mobile Phone</dt>
                        <dd>{{ $user->user_phone }}</dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>Email Address</dt>
                        <dd>{{ $user->user_email }}</dd>
                    </dl>
                </div>
                
                <div class="pmbb-edit">
                    <dl class="dl-horizontal">
                        <dt class="p-t-10">Mobile Phone</dt>
                        <dd>
                            <div class="fg-line">
                                <input type="text" class="form-control" placeholder="eg. 00971 12345678 9">
                            </div>
                        </dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt class="p-t-10">Email Address</dt>
                        <dd>
                            <div class="fg-line">
                                <input type="email" class="form-control" placeholder="eg. malinda.h@gmail.com">
                            </div>
                        </dd>
                    </dl>
                    
                    <div class="m-t-30">
                        <button class="btn btn-primary btn-sm">Save</button>
                        <button data-pmb-action="reset" class="btn btn-link btn-sm">Cancel</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="pmb-block">
            <div class="pmbb-header">
                <h2><i class="zmdi zmdi-assignment-account m-r-5"></i> Role Information</h2>
                
                <ul class="actions">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="pmbb-body p-l-30">
                <div class="pmbb-view">
                    <dl class="dl-horizontal">
                        <dt>Role(s)</dt>
                        <dd>
                        	@foreach ($roles as $row)
                            	@foreach ($user->roles as $role)
                            		@if($role->role_id==$row->role_id)
                            			<span class="badge">{{ $row->role_name }}</span>
                            		@endif
                            	@endforeach
							@endforeach
                        </dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>Group(s)</dt>
                        <dd>
                        	@foreach ($groups as $row)
                            	@foreach ($user->groups as $group)
                            		@if($group->group_id==$row->group_id)
                            			<span class="badge">{{ $row->group_name }}</span>
                            		@endif
                            	@endforeach
							@endforeach
                        </dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>Media(s)</dt>
                        <dd>
                        	@foreach ($medias as $row)
                            	@foreach ($user->medias as $media)
                            		@if($media->media_id==$row->media_id)
                            			<span class="badge">{{ $row->media_name }}</span>
                            		@endif
                            	@endforeach
							@endforeach
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection