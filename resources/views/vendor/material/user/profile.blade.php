@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

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
                
                <a href="#" class="pmop-edit" id="command-upload-avatar">
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
                                <a href="javascript:void(0)" id="command-edit-profile">Edit</a>
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
                        <input type="hidden" name="old_birthdate" value="{{ $birthdate }}">
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>Religion</dt>
                        <dd>{{ $user->religion->religion_name }}</dd>
                        <input type="hidden" name="old_religion_id" value="{{ $user->religion_id }}">
                    </dl>
                </div>
            </div>
        </div>
   
    
        <div class="pmb-block">
            <div class="pmbb-header">
                <h2><i class="zmdi zmdi-phone m-r-5"></i> Contact Information</h2>
                
                <!-- <ul class="actions">
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
                </ul> -->
            </div>
            <div class="pmbb-body p-l-30">
                <div class="pmbb-view">
                    <dl class="dl-horizontal">
                        <dt>Mobile Phone</dt>
                        <dd>{{ $user->user_phone }}</dd>
                        <input type="hidden" name="old_phone" value="{{ $user->user_phone }}">
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>Email Address</dt>
                        <dd>{{ $user->user_email }}</dd>
                        <input type="hidden" name="old_email" value="{{ $user->user_email }}">
                    </dl>
                </div>
            </div>
        </div>


        <div class="pmb-block">
            <div class="pmbb-header">
                <h2><i class="zmdi zmdi-assignment-account m-r-5"></i> Role Information</h2>
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
                        <dt>Media Group(s)</dt>
                        <dd>
                            @foreach ($mediagroups as $row)
                                @foreach ($user->mediagroups as $mediagroup)
                                    @if($mediagroup->media_group_id==$row->media_group_id)
                                        <span class="badge">{{ $row->media_group_name }}</span>
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

<div class="modal fade" id="modalEditProfile" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Profile Data</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="user_birthdate" class="col-sm-2 control-label">Birthdate</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask" name="user_birthdate" id="user_birthdate" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="" autocomplete="off" data-mask="00/00/0000">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="religion_id" class="col-sm-2 control-label">Religion</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <select name="religion_id" id="religion_id" class="selectpicker" data-live-search="true" required="true">
                                    <!-- <option value=""></option> -->
                                    @foreach ($religion as $row)
                                        <option value="{{ $row->religion_id }}" >{{ $row->religion_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm" name="user_email" id="user_email" placeholder="Email" required="true" maxlength="100" value="">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_phone" class="col-sm-2 control-label">Phone No</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-mask" name="user_phone" id="user_phone" placeholder="Phone No" maxlength="14" value="" autocomplete="off" data-mask="000000000000">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect btn-edit-profile">Save</button>
                <button type="button" class="btn btn-danger waves-effect btn-cancel-edit-profile" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUploadAvatar" data-backdrop="static" data-keyboard="false" tabindex="-2" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Profile Picture</h4>
            </div>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('uploadAvatar') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_birthdate" class="col-sm-4 control-label">Upload Profile Picture</label>
                        <div class="col-sm-8">
                            <div class="fg-line">
                                <input type="file" name="upload_file" id="upload_file" class="form-control input-sm" required="true">
                            </div>
                            <small class="help-block">Max File 2 MB (.jpg, .gif, .png)</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect btn-upload-avatar">Save</button>
                    <button type="button" class="btn btn-danger waves-effect btn-cancel-upload-avatar" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
<script type="text/javascript">
$(document).ready(function(){
    $('#command-edit-profile').click(function(){
        clearEditForm();
        $('#user_birthdate').val($('input[name=old_birthdate]').val());
        $('#religion_id').val($('input[name=old_religion_id]').val());
        $('#user_phone').val($('input[name=old_phone]').val());
        $('#user_email').val($('input[name=old_email]').val());
        $('#religion_id').selectpicker('refresh');

        $('#modalEditProfile').modal();
    });

    $('.btn-edit-profile').click(function() {
        saveEditForm();
    });

    $('.btn-cancel-edit-profile').click(function() {
        clearEditForm();
    });

    function clearEditForm()
    {
        $('#user_birthdate').val('');
        $('#religion_id').val('');
        $('#user_phone').val('');
        $('#user_email').val('');
    }

    function saveEditForm()
    {
        var isValid = false;

        if($('#user_birthdate').val()=='')
        {
            $('#user_birthdate').parents('.form-group').addClass('has-error').find('.help-block').html('User Birth Date Must Be Filled In.');
            $('#user_birthdate').focus();
            isValid = false;
        }else if($('#religion_id').val()=='')
        {
            $('#religion_id').parents('.form-group').addClass('has-error').find('.help-block').html('Religion Must Be Choosed On.');
            $('#religion_id').focus();
            isValid = false;
        }else if($('#user_email').val()=='')
        {
            $('#user_email').parents('.form-group').addClass('has-error').find('.help-block').html('Email Must Be Filled In.');
            $('#user_email').focus();
            isValid = false;
        }else if($('#user_phone').val()=='')
        {
            $('#user_phone').parents('.form-group').addClass('has-error').find('.help-block').html('Phone Must Be Filled In.');
            $('#user_phone').focus();
            isValid = false;
        }else{
            $('#user_birthdate').parents('.form-group').removeClass('has-error').find('.help-block').html('');
            $('#religion_id').parents('.form-group').removeClass('has-error').find('.help-block').html('');
            $('#user_phone').parents('.form-group').removeClass('has-error').find('.help-block').html('');
            $('#user_email').parents('.form-group').removeClass('has-error').find('.help-block').html('');
            isValid = true;
        }

        if(isValid)
        {
            $.ajax({
                url: base_url + 'editProfile',
                type: 'POST',
                data: {
                    'user_birthdate' : $('#user_birthdate').val(),
                    'religion_id' : $('#religion_id').val(),
                    'user_email' : $('#user_email').val(),
                    'user_phone' : $('#user_phone').val(),
                    '_token' : $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                statusCode: {
                    422: function(e) {
                      if('user_email' in e.responseJSON)
                      {
                        var messages = e.responseJSON.user_email;
                        $.each(messages, function(key, value){
                            $('#user_email').parents('.form-group').addClass('has-error').find('.help-block').html(value + '</br>');
                        });
                      }

                      if('user_phone' in e.responseJSON)
                      {
                        var messages = e.responseJSON.user_phone;
                        $.each(messages, function(key, value){
                            $('#user_phone').parents('.form-group').addClass('has-error').find('.help-block').html(value + '</br>');
                        });
                      }
                    }
                },
                error: function() {
                    swal("Failed!", "Saving data failed.", "error");
                },
                success: function(data) {
                    if(data==100) 
                    {
                        swal("Success!", "Your data has been saved.", "success");
                        $('.btn-cancel-edit-profile').click();
                        location.reload();
                    }else{
                        console.log(data);
                        swal("Failed!", "Saving data failed.", "error");
                    }
                }
            });
        }
    }

    $('#command-upload-avatar').click(function(){
        $('#modalUploadAvatar').modal();
    });
});
</script>
@endsection