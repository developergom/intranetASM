@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Announcement Management<small>View Announcement</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
	            <div class="form-group">
	                <label for="announcement_title" class="col-sm-2 control-label">Title</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="announcement_title" id="announcement_title" placeholder="Announcement Title" required="true" maxlength="255" value="{{ $announcement->announcement_title }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="announcement_detail" class="col-sm-2 control-label">Detail</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="announcement_detail" id="announcement_detail" class="form-control input-sm" required placeholder="Detail" disabled="true">{{ $announcement->announcement_detail }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="announcement_startdate" class="col-sm-2 control-label">Start Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="announcement_startdate" id="announcement_startdate" placeholder="Start Date e.g dd/mm/yyyy" required="true" maxlength="10" value="{{ $announcement_startdate }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="announcement_enddate" class="col-sm-2 control-label">End Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="announcement_enddate" id="announcement_enddate" placeholder="End Date e.g dd/mm/yyyy" required="true" maxlength="10" value="{{ $announcement_enddate }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('config/announcement') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection