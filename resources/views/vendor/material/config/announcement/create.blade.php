@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Announcement Management<small>Create New Announcement</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('config/announcement') }}">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="announcement_title" class="col-sm-2 control-label">Title</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="announcement_title" id="announcement_title" placeholder="Announcement Title" required="true" maxlength="255" value="{{ old('announcement_title') }}">
	                    </div>
	                    @if ($errors->has('announcement_title'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('announcement_title') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="announcement_detail" class="col-sm-2 control-label">Detail</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="announcement_detail" id="announcement_detail" class="form-control input-sm" required placeholder="Detail">{{ old('announcement_detail') }}</textarea>
	                    </div>
	                    @if ($errors->has('announcement_detail'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('announcement_detail') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="announcement_startdate" class="col-sm-2 control-label">Start Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="announcement_startdate" id="announcement_startdate" placeholder="Start Date e.g dd/mm/yyyy" required="true" maxlength="10" value="{{ old('announcement_startdate') }}" autocomplete="off" data-mask="00/00/0000">
	                    </div>
	                    @if ($errors->has('announcement_startdate'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('announcement_startdate') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="announcement_enddate" class="col-sm-2 control-label">End Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="announcement_enddate" id="announcement_enddate" placeholder="End Date e.g dd/mm/yyyy" required="true" maxlength="10" value="{{ old('announcement_enddate') }}" autocomplete="off" data-mask="00/00/0000">
	                    </div>
	                    @if ($errors->has('announcement_enddate'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('announcement_enddate') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('config/announcement') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection