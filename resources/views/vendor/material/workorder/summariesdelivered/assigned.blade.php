@extends('vendor.material.layouts.app')


@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Summary<small>View Summary</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="">
        		{{ csrf_field() }}
        		@include('vendor.material.workorder.summariesdelivered.view')
                <div class="form-group">
                    <label for="pic" class="col-sm-2 control-label">PIC</label>
                    <div class="col-sm-10">
                        <div class="fg-line">
                            <select name="pic" id="pic" class="selectpicker" data-live-search="true" required="true">
                                @foreach($pic as $row)
                                    {!! $selected = '' !!}
                                    @if(old('pic')==$row->user_id)
                                        {!! $selected = 'selected' !!}
                                    @endif
                                    <option value="{{ $row->user_id }}" {{ $selected }}>{{ $row->user_firstname . ' ' . $row->user_lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if ($errors->has('pic'))
                        <span class="help-block">
                            <strong>{{ $errors->first('pic') }}</strong>
                        </span>
                    @endif
                </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Submit</button>
	                    <a href="{{ url('workorder/summariesdelivered') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection


@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/ajax-bootstrap-select.min.js') }}"></script>
@endsection