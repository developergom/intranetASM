@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Rates Management<small>Create New Rate</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" id="form_add_rate" role="form" method="POST" action="{{ url('master/rate') }}">
        		{{ csrf_field() }}
        		<div class="form-group" id="parent_id_container">
	                <label for="parent_id" class="col-sm-2 control-label">Package Rate</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="parent_id" id="parent_id" class="selectpicker" data-live-search="true" required="true">
	                        	<option value="0">NOT BELONG TO ANY PACKAGES</option>
                                @foreach ($parents as $row)
                                	{!! $selected = '' !!}
                                	@if($row->rate_id==old('parent_id'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->rate_id }}" {{ $selected }}>{{ $row->rate_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('parent_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('parent_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
        		<div class="form-group" id="advertise_rate_type_id_container">
	                <label for="advertise_rate_type_id" class="col-sm-2 control-label">Rate Type</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="advertise_rate_type_id" id="advertise_rate_type_id" class="selectpicker" data-live-search="true" required="true">
	                        	<option value=""></option>
                                @foreach ($advertiseratetypes as $row)
                                	{!! $selected = '' !!}
                                	@if($row->advertise_rate_type_id==old('advertise_rate_type_id'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->advertise_rate_type_id }}" {{ $selected }}>{{ $row->advertise_rate_type_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('advertise_rate_type_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_rate_type_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
        		<div class="form-group" id="media_id_container">
	                <label for="media_id" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="media_id" id="media_id" class="selectpicker" data-live-search="true">
	                        	<option value=""></option>
                                @foreach ($medias as $row)
                                	{!! $selected = '' !!}
                                	@if($row->media_id==old('media_id'))
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
	            <div class="form-group" id="rate_name_container">
	            	<label for="rate_name" class="col-sm-2 control-label">Rate Name</label>
	            	<div class="col-sm-10">
	            		<div class="fg-line">
	            			<input type="text" name="rate_name" id="rate_name" class="form-control input-sm" placeholder="Rate Name" autocomplete="off" value="{{ old('rate_name') }}">
	            		</div>
	            		@if($errors->has('rate_name'))
	            			<span class="help-block">
	            				<strong>{{ $errors->first('rate_name') }}</strong>
	            			</span>
	            		@endif
	            	</div>
	            </div>
	            <div class="form-group" id="width_container">
	            	<label for="width" class="col-sm-2 control-label">Width</label>
	            	<div class="col-sm-10">
	            		<div class="fg-line">
	            			<input type="text" name="width" id="width" class="form-control input-sm" placeholder="Width (numeric only)" autocomplete="off" value="{{ old('width') }}">
	            		</div>
	            		@if($errors->has('width'))
	            			<span class="help-block">
	            				<strong>{{ $errors->first('width') }}</strong>
	            			</span>
	            		@endif
	            	</div>
	            </div>
	            <div class="form-group" id="length_container">
	            	<label for="length" class="col-sm-2 control-label">Length</label>
	            	<div class="col-sm-10">
	            		<div class="fg-line">
	            			<input type="text" name="length" id="length" class="form-control input-sm" placeholder="Length (numeric only)" autocomplete="off" value="{{ old('length') }}">
	            		</div>
	            		@if($errors->has('length'))
	            			<span class="help-block">
	            				<strong>{{ $errors->first('length') }}</strong>
	            			</span>
	            		@endif
	            	</div>
	            </div>
	            <div class="form-group" id="unit_id_container">
	                <label for="unit_id" class="col-sm-2 control-label">Unit</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="unit_id" id="unit_id" class="selectpicker" data-live-search="true">
	                        	<option value=""></option>
                                @foreach($units as $row)
                                	{!! $selected = '' !!}
                                	@if($row->unit_id==old('unit_id'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->unit_id }}" {{ $selected }}>{{ $row->unit_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('unit_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('unit_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group" id="studio_id_container">
	                <label for="studio_id" class="col-sm-2 control-label">Studio</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="studio_id" id="studio_id" class="selectpicker" data-live-search="true">
	                        	<option value=""></option>
                                @foreach($studios as $row)
                                	{!! $selected = '' !!}
                                	@if($row->studio_id==old('studio_id'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->studio_id }}" {{ $selected }}>{{ $row->studio_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('studio_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('studio_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group" id="duration_container">
	            	<label for="duration" class="col-sm-2 control-label">Duration</label>
	            	<div class="col-sm-10">
	            		<div class="fg-line">
	            			<input type="text" name="duration" id="duration" class="form-control input-sm" placeholder="Duration (numeric only)" autocomplete="off" value="{{ old('duration') }}">
	            		</div>
	            		@if($errors->has('duration'))
	            			<span class="help-block">
	            				<strong>{{ $errors->first('duration') }}</strong>
	            			</span>
	            		@endif
	            	</div>
	            </div>
	            <div class="form-group" id="duration_type_container">
	                <label for="duration_type" class="col-sm-2 control-label">Duration Type</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="duration_type" id="duration_type" class="selectpicker" data-live-search="true">
	                        	<option value=""></option>
                                @foreach($durationtypes as $row)
                                	{!! $selected = '' !!}
                                	@if($row==old('duration_type'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row }}" {{ $selected }}>{{ $row }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('duration_type'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('duration_type') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group" id="spot_type_container">
	                <label for="spot_type_id" class="col-sm-2 control-label">Spot Type</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="spot_type_id" id="spot_type_id" class="selectpicker" data-live-search="true" >
	                        	<option value=""></option>
                                @foreach($spottypes as $row)
                                	{!! $selected = '' !!}
                                	@if($row->spot_type_id==old('spot_type_id'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->spot_type_id }}" {{ $selected }}>{{ $row->spot_type_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('spot_type_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('spot_type_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group" id="gross_rate_container">
	                <label for="gross_rate" class="col-sm-2 control-label">Gross Rate</label>
	                <div class="col-sm-3">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="gross_rate" id="gross_rate" placeholder="Gross Rate"  maxlength="15" value="{{ old('gross_rate') }}">
	                    </div>
	                    @if ($errors->has('gross_rate'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('gross_rate') }}</strong>
			                </span>
			            @endif
	                </div>
	                <div class="col-sm-7">
	                	<span class="badge" id="result_gross_rate"></span>
	                </div>
	            </div>
	            <div class="form-group" id="discount_container">
	                <label for="discount" class="col-sm-2 control-label">Discount</label>
	                <div class="col-sm-3">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="discount" id="discount" placeholder="Discount" maxlength="15" value="{{ old('discount') }}">
	                    </div>
	                    @if ($errors->has('discount'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('discount') }}</strong>
			                </span>
			            @endif
	                </div>
	                <div class="col-sm-7">
	                	<span class="badge" id="result_discount"></span>
	                </div>
	            </div>
	            <div class="form-group" id="nett_rate_container">
	                <label for="nett_rate" class="col-sm-2 control-label">Nett Rate</label>
	                <div class="col-sm-3">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="nett_rate" id="nett_rate" placeholder="Nett Rate"  maxlength="15" value="{{ old('nett_rate') }}">
	                    </div>
	                    @if ($errors->has('nett_rate'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('nett_rate') }}</strong>
			                </span>
			            @endif
	                </div>	                
	                <div class="col-sm-7">
	                	<span class="badge" id="result_nett_rate"></span>
	                </div>
	            </div>
	            <div class="form-group" id="start_valid_date_container">
	                <label for="start_valid_date" class="col-sm-2 control-label">Start Valid Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="start_valid_date" id="start_valid_date" placeholder="e.g 17/08/1945"  maxlength="10" value="{{ old('start_valid_date') }}" autocomplete="off" data-mask="00/00/0000">
	                    </div>
	                    @if ($errors->has('start_valid_date'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('start_valid_date') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group" id="end_valid_date_container">
	                <label for="end_valid_date" class="col-sm-2 control-label">End Valid Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="end_valid_date" id="end_valid_date" placeholder="e.g 17/08/1945"  maxlength="10" value="{{ old('end_valid_date') }}" autocomplete="off" data-mask="00/00/0000">
	                    </div>
	                    @if ($errors->has('end_valid_date'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('end_valid_date') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group" id="cinema_tax_container">
	                <label for="cinema_tax" class="col-sm-2 control-label">Cinema Tax</label>
	                <div class="col-sm-3">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="cinema_tax" id="cinema_tax" placeholder="Cinema Tax"  maxlength="15" value="{{ old('cinema_tax') }}">
	                    </div>
	                    @if ($errors->has('cinema_tax'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('cinema_tax') }}</strong>
			                </span>
			            @endif
	                </div>
	                <div class="col-sm-7">
	                	<span class="badge" id="result_cinema_tax"></span>
	                </div>
	            </div>
	            <div class="form-group" id="paper_id_container">
	                <label for="paper_id" class="col-sm-2 control-label">Paper</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="paper_id" id="paper_id" class="selectpicker" data-live-search="true" >
	                        	<option value=""></option>
                                @foreach($papers as $row)
                                	{!! $selected = '' !!}
                                	@if($row->paper_id==old('paper_id'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->paper_id }}" {{ $selected }}>{{ $row->paper_name }}</option>
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
	            <div class="form-group" id="color_id_container">
	                <label for="color_id" class="col-sm-2 control-label">Color</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="color_id" id="color_id" class="selectpicker" data-live-search="true" >
	                        	<option value=""></option>
                                @foreach($colors as $row)
                                	{!! $selected = '' !!}
                                	@if($row->color_id==old('color_id'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->color_id }}" {{ $selected }}>{{ $row->color_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('color_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('color_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/rate') }}" class="btn btn-danger btn-sm">Back</a>
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
<script src="{{ url('js/master/rate-create.js') }}"></script>
@endsection