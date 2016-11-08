@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Advertise Rates Management<small>Edit Advertise Rate</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/advertiserate/' . $advertiserate->advertise_rate_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
        		<div class="form-group">
	                <label for="media_id" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="media_id" id="media_id" class="selectpicker" data-live-search="true" required="true">
	                        	<!-- <option value=""></option> -->
                                @foreach ($media as $row)
                                	{!! $selected = '' !!}
                                	@if($row->media_id==$advertiserate->media_id)
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->media_id }}" {{ $selected }}>{{ $row->media_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('media_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('media_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_position_id" class="col-sm-2 control-label">Position</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="advertise_position_id" id="advertise_position_id" class="selectpicker" data-live-search="true" required="true">
	                        	<!-- <option value=""></option> -->
                                @foreach ($advertiseposition as $row)
                                	{!! $selected = '' !!}
                                	@if($row->advertise_position_id==$advertiserate->advertise_position_id)
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->advertise_position_id }}" {{ $selected }}>{{ $row->advertise_position_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('advertise_position_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_position_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_size_id" class="col-sm-2 control-label">Size</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="advertise_size_id" id="advertise_size_id" class="selectpicker" data-live-search="true" required="true">
	                        	<!-- <option value=""></option> -->
                                @foreach ($advertisesize as $row)
                                	{!! $selected = '' !!}
                                	@if($row->advertise_size_id==$advertiserate->advertise_size_id)
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->advertise_size_id }}" {{ $selected }}>{{ $row->advertise_size_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('advertise_size_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_size_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="paper_id" class="col-sm-2 control-label">Paper</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="paper_id" id="paper_id" class="selectpicker" data-live-search="true" required="true">
	                        	<!-- <option value=""></option> -->
                                @foreach ($paper as $row)
                                	{!! $selected = '' !!}
                                	@if($row->paper_id==$advertiserate->paper_id)
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->paper_id }}" {{ $selected }}>{{ $row->paper_name . ' ( ' . $row->paper_width . ' x ' . $row->paper_length . ' ' . $row->unit->unit_code . ' )' }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('paper_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('paper_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_rate_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="advertise_rate_code" id="advertise_rate_code" placeholder="Advertise Rate Code" required="true" maxlength="15" value="{{ $advertiserate->advertise_rate_code }}">
	                    </div>
	                    @if ($errors->has('advertise_rate_code'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_rate_code') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_rate_startdate" class="col-sm-2 control-label">Start Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="advertise_rate_startdate" id="advertise_rate_startdate" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ $advertise_rate_startdate }}" autocomplete="off" data-mask="00/00/0000">
	                    </div>
	                    @if ($errors->has('advertise_rate_startdate'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_rate_startdate') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_rate_enddate" class="col-sm-2 control-label">End Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="advertise_rate_enddate" id="advertise_rate_enddate" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ $advertise_rate_enddate }}" autocomplete="off" data-mask="00/00/0000">
	                    </div>
	                    @if ($errors->has('advertise_rate_enddate'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_rate_enddate') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_rate_normal" class="col-sm-2 control-label">Normal Rate</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="advertise_rate_normal_tmp" id="advertise_rate_normal_tmp" placeholder="Normal Rate" required="true" maxlength="15" value="{{ $advertiserate->advertise_rate_normal }}">
	                        <input type="hidden" name="advertise_rate_normal" value="{{ $advertiserate->advertise_rate_normal }}">
	                    </div>
	                    @if ($errors->has('advertise_rate_normal'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_rate_normal') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_rate_discount" class="col-sm-2 control-label">Discount Rate</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="advertise_rate_discount_tmp" id="advertise_rate_discount_tmp" placeholder="Discount Rate" maxlength="15" value="{{ $advertiserate->advertise_rate_discount }}">
	                        <input type="hidden" name="advertise_rate_discount" value="{{ $advertiserate->advertise_rate_discount }}">
	                    </div>
	                    @if ($errors->has('advertise_rate_discount'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_rate_discount') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/advertiserate') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/jquery.price_format.min.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/master/advertiserate-create.js') }}"></script>
@endsection