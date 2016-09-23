@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Clients Management<small>View Client</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
	            <div class="form-group">
	                <label for="client_type_id" class="col-sm-2 control-label">Client Type</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="hidden" name="_client_id" value="{{ $client->client_id }}">
	                    	<input name="client_type_id" id="client_type_id" class="form-control input-sm" placeholder="Client Type" value="{{ $client->clienttype->client_type_name }}" disabled="true"> 
	                    </div> 
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="_client_name" id="_client_name" placeholder="Client Name" required="true" maxlength="255" value="{{ $client->client_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_formal_name" class="col-sm-2 control-label">Formal Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client_formal_name" id="client_formal_name" placeholder="Client Formal Name" required="true" maxlength="255" value="{{ $client->client_formal_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_mail_address" class="col-sm-2 control-label">Mail Address</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="client_mail_address" id="client_mail_address" class="form-control input-sm" placeholder="Mail Address" disabled="true">{{ $client->client_mail_address }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_mail_postcode" class="col-sm-2 control-label">Mail Post Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client_mail_postcode" id="client_mail_postcode" placeholder="Post Code" required="true" maxlength="10" value="{{ $client->client_mail_postcode }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_npwp" class="col-sm-2 control-label">N P W P</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client_npwp" id="client_npwp" placeholder="N P W P" required="true" maxlength="25" value="{{ $client->client_npwp }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_npwp_address" class="col-sm-2 control-label">NPWP Address</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="client_npwp_address" id="client_npwp_address" class="form-control input-sm" placeholder="N P W P Address" disabled="true">{{ $client->client_npwp_address }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_npwp_postcode" class="col-sm-2 control-label">NPWP Post Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client_npwp_postcode" id="client_npwp_postcode" placeholder="Post Code" required="true" maxlength="10" value="{{ $client->client_npwp_postcode }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_invoice_address" class="col-sm-2 control-label">Invoice Address</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="client_invoice_address" id="client_invoice_address" class="form-control input-sm" placeholder="Invoice Address" disabled="true">{{ $client->client_invoice_address }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_invoice_postcode" class="col-sm-2 control-label">Invoice Post Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client_invoice_postcode" id="client_invoice_postcode" placeholder="Post Code" required="true" maxlength="10" value="{{ $client->client_invoice_postcode }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_phone" class="col-sm-2 control-label">Phone No</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client_phone" id="client_phone" placeholder="Phone No" required="true" maxlength="15" value="{{ $client->client_phone }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_fax" class="col-sm-2 control-label">Fax No</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client_fax" id="client_fax" placeholder="Fax No" maxlength="15" value="{{ $client->client_fax }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_email" class="col-sm-2 control-label">Email</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client_email" id="client_email" placeholder="Email" required="true" maxlength="255" value="{{ $client->client_email }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_avatar" class="col-sm-2 control-label">Logo</label>
	                <div class="col-sm-10">
	                    <div class="fileinput fileinput-new" data-provides="fileinput">
	                    	<div class="thumbnail">
	                    		<img src="{{ url('/img/client/logo/' . $client->client_avatar) }}" width="200" title="Current Logo">
	                    	</div>
                        </div>
	                </div>
	            </div>
	            <div class="form-group">
	            	<div class="col-sm-12">
	            		<div class="table-responsive">
					        <table id="grid-data" class="table table-hover">
					            <thead>
					                <tr>
					                    <th data-column-id="client_contact_name" data-order="asc">Name</th>
					                    <th data-column-id="client_contact_position" data-order="asc">Position Date</th>
					                    <th data-column-id="client_contact_email" data-order="asc">Email</th>
					                    <th data-column-id="client_contact_phone" data-order="asc">Phone</th>
					                    @can('Clients Management-Update')
					                        @can('Clients Management-Delete')
					                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
					                        @else
					                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
					                        @endcan
					                    @else
					                        @can('Clients Management-Delete')
					                            <th data-column-id="link" data-formatter="link-rd" data-sortable="false">Action</th>
					                        @else
					                            <th data-column-id="link" data-formatter="link-r" data-sortable="false">Action</th>
					                        @endcan
					                    @endcan
					                </tr>
					            </thead>
					            <tbody>
					            </tbody>
					        </table>
					    </div>
	            	</div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                	@can('Clients Management-Create')
	                	<a href="javascript:void(0)" class="btn btn-primary btn-sm waves-effect command-add-contact" data-row-client="{{ $client->client_name }}" data-row-id="{{ $client->client_id }}">Add Contact</a>
	                	@endcan
	                    <a href="{{ url('master/client') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>

    @include('vendor.material.master.client.modal')
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/master/clientcontact-list.js') }}"></script>
<script src="{{ url('js/master/clientcontact.js') }}"></script>
@endsection