@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Clients Management<small>Create New Client</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/client') }}" enctype="multipart/form-data">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="client_type_id" class="col-sm-2 control-label">Client Type</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<select name="client_type_id" id="client_type_id" class="selectpicker" data-live-search="true" required="true">
	                        	<option value=""></option>
                                @foreach ($clienttype as $row)
                                	{!! $selected = '' !!}
                                	@if($row->client_type_id==old('client_type_id'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->client_type_id }}" {{ $selected }}>{{ $row->client_type_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('client_type_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_type_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client_name" id="client_name" placeholder="Client Name" required="true" maxlength="255" value="{{ old('client_name') }}">
	                    </div>
	                    @if ($errors->has('client_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_formal_name" class="col-sm-2 control-label">Formal Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client_formal_name" id="client_formal_name" placeholder="Client Formal Name" required="true" maxlength="255" value="{{ old('client_formal_name') }}">
	                    </div>
	                    @if ($errors->has('client_formal_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_formal_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_mail_address" class="col-sm-2 control-label">Mail Address</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="client_mail_address" id="client_mail_address" class="form-control input-sm" placeholder="Mail Address">{{ old('client_mail_address') }}</textarea>
	                    </div>
	                    @if ($errors->has('client_mail_address'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_mail_address') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_mail_postcode" class="col-sm-2 control-label">Mail Post Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client_mail_postcode" id="client_mail_postcode" placeholder="Post Code" required="true" maxlength="10" value="{{ old('client_mail_postcode') }}">
	                    </div>
	                    @if ($errors->has('client_mail_postcode'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_mail_postcode') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_npwp" class="col-sm-2 control-label">N P W P</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client_npwp" id="client_npwp" placeholder="N P W P" required="true" maxlength="25" value="{{ old('client_npwp') }}">
	                    </div>
	                    @if ($errors->has('client_npwp'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_npwp') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_npwp_address" class="col-sm-2 control-label">NPWP Address</label>
	                <div class="col-sm-8">
	                    <div class="fg-line">
	                        <textarea name="client_npwp_address" id="client_npwp_address" class="form-control input-sm" placeholder="N P W P Address">{{ old('client_npwp_address') }}</textarea>
	                    </div>
	                    @if ($errors->has('client_npwp_address'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_npwp_address') }}</strong>
			                </span>
			            @endif
	                </div>
	                <div class="col-sm-1">
	                	<a href="javascript:void(0)" class="btn btn-info" id="copy_address">Copy Address</a>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_npwp_postcode" class="col-sm-2 control-label">NPWP Post Code</label>
	                <div class="col-sm-8">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client_npwp_postcode" id="client_npwp_postcode" placeholder="Post Code" required="true" maxlength="10" value="{{ old('client_npwp_postcode') }}">
	                    </div>
	                    @if ($errors->has('client_npwp_postcode'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_npwp_postcode') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_invoice_address" class="col-sm-2 control-label">Invoice Address</label>
	                <div class="col-sm-8">
	                    <div class="fg-line">
	                        <textarea name="client_invoice_address" id="client_invoice_address" class="form-control input-sm" placeholder="Invoice Address">{{ old('client_invoice_address') }}</textarea>
	                    </div>
	                    @if ($errors->has('client_invoice_address'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_invoice_address') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_invoice_postcode" class="col-sm-2 control-label">Invoice Post Code</label>
	                <div class="col-sm-8">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client_invoice_postcode" id="client_invoice_postcode" placeholder="Post Code" required="true" maxlength="10" value="{{ old('client_invoice_postcode') }}">
	                    </div>
	                    @if ($errors->has('client_invoice_postcode'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_invoice_postcode') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_phone" class="col-sm-2 control-label">Phone No</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client_phone" id="client_phone" placeholder="Phone No" required="true" maxlength="15" value="{{ old('client_phone') }}">
	                    </div>
	                    @if ($errors->has('client_phone'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_phone') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_fax" class="col-sm-2 control-label">Fax No</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client_fax" id="client_fax" placeholder="Fax No" maxlength="15" value="{{ old('client_fax') }}">
	                    </div>
	                    @if ($errors->has('client_fax'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_fax') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_email" class="col-sm-2 control-label">Email</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client_email" id="client_email" placeholder="Email" required="true" maxlength="255" value="{{ old('client_email') }}">
	                    </div>
	                    @if ($errors->has('client_email'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_email') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_avatar" class="col-sm-2 control-label">Logo</label>
	                <div class="col-sm-10">
	                    <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
                            <div>
                                <span class="btn btn-info btn-file">
                                    <span class="fileinput-new">Select image</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="client_avatar">
                                </span>
                                <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                        <span class="help-block">
		                    Allowed File Types: *.jpg, *.jpeg, *.gif, *.png , Max Size: 2 MB
		                </span>
		                @if ($errors->has('client_avatar'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_avatar') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/client') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/fileinput.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/master/client-create.js') }}"></script>
@endsection