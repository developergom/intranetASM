@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Inventory Planner<small>View Inventory Planner</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
        		<div class="form-group">
        			<label for="inventory_type_id" class="col-sm-2 control-label">Type</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
        					<input class="form-control input-sm" placeholder="Type" disabled="true" value="{{ $inventoryplanner->inventorytype->inventory_type_name }}">
	        			</div>
        			</div>
        		</div>
	            <div class="form-group">
	                <label for="inventory_planner_title" class="col-sm-2 control-label">Title</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input class="form-control input-sm" placeholder="Title" disabled="true" value="{{ $inventoryplanner->inventory_planner_title }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="inventory_planner_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea class="form-control input-sm" placeholder="Description" disabled="true">{{ $inventoryplanner->inventory_planner_desc }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="implementation_id" class="col-sm-2 control-label">Implementation</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        @foreach($inventoryplanner->implementations as $row)
	                        	<span class="badge">{{ $row->implementation_month_name }}</span>
	                        @endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="inventory_planner_year" class="col-sm-2 control-label">Year</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input class="form-control input-sm" placeholder="Year" disabled="true" value="{{ $inventoryplanner->inventory_planner_year }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="inventory_planner_deadline" class="col-sm-2 control-label">Deadline</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input class="form-control input-sm" placeholder="Deadline" disabled="true" value="{{ Carbon\Carbon::createFromFormat('Y-m-d', $inventoryplanner->inventory_planner_deadline)->format('d/m/Y') }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_id" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        @foreach($inventoryplanner->medias as $row)
	                        	<span class="badge">{{ $row->media_name }}</span>
	                        @endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="action_plan_id" class="col-sm-2 control-label">Action Plan</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        @foreach($inventoryplanner->actionplans as $row)
	                        	<span class="badge">{{ $row->action_plan_title }}</span>
	                        @endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="event_plan_id" class="col-sm-2 control-label">Event Plan</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        @foreach($inventoryplanner->eventplans as $row)
	                        	<span class="badge">{{ $row->event_plan_title }}</span>
	                        @endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="upload_file" class="col-sm-2 control-label">Upload File(s)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        @foreach ($inventoryplanner->uploadfiles as $uploadedfile)
                        	<div class="col-sm-6 col-md-3">
                        		<div class="thumbnail">
                        			@if($uploadedfile->upload_file_type=='jpg' || $uploadedfile->upload_file_type=='png' || $uploadedfile->upload_file_type=='gif' || $uploadedfile->upload_file_type=='jpeg')
                        			<img src="{{ url($uploadedfile->upload_file_path . '/' . $uploadedfile->upload_file_name) }}" alt="{{ $uploadedfile->upload_file_name }}">
                        			@else
                        			<img src="{{ url('img/filetypes/' . $uploadedfile->upload_file_type . '.png') }}" alt="">
                        			@endif
                        			<div class="caption">
                        				<h4>{{ $uploadedfile->upload_file_name }}</h4>
                        				<p>{{ $uploadedfile->upload_file_desc }}</p>
                        				<div class="m-b-5">
                        					@can('Inventory Planner-Download')
                        					<a class="btn btn-sm btn-primary waves-effect" href="{{ url('download/file/' . $uploadedfile->upload_file_id) }}" role="button">Download File</a>
                        					@endcan
                        				</div>
                        			</div>
                        		</div>
                        	</div>
                        	@endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	            	<div class="col-sm-12">
	            		<div role="tabpanel">
				            <ul class="tab-nav" role="tablist">
				                <li class="active"><a href="#listprint" aria-controls="listprint" role="tab" data-toggle="tab">Print</a></li>
				                <li><a href="#listdigital" aria-controls="listdigital" role="tab" data-toggle="tab">Digital</a></li>
				                <li><a href="#listevent" aria-controls="listevent" role="tab" data-toggle="tab">Event</a></li>
				                <li><a href="#listcreative" aria-controls="listcreative" role="tab" data-toggle="tab">Creative</a></li>
				                <li><a href="#listother" aria-controls="listother" role="tab" data-toggle="tab">Others</a></li>
				            </ul>
				            <div class="tab-content">
				                <div role="tabpanel" class="tab-pane active" id="listprint">
				                   <div class="table-responsive">
				                        <table id="grid-data-listprint" class="table table-hover">
				                            <thead>
				                                <tr>
				                                    <th data-column-id="print_media_name" data-order="asc">Media</th>
				                                    <th data-column-id="print_advertise_position_name" data-order="asc">Position</th>
				                                    <th data-column-id="print_advertise_size_name" data-order="asc">Size</th>
				                                    <th data-column-id="print_paper_name" data-order="asc">Paper</th>
				                                    <th data-column-id="print_advertise_rate_normal" data-order="asc">Rate</th>
				                                    <th data-column-id="print_gross_rate" data-order="asc">Gross Rate</th>
				                                    <th data-column-id="print_surcharge" data-order="asc">Surcharge (%)</th>
				                                    <th data-column-id="print_total_gross_rate" data-order="asc">Total Gross Rate</th>
				                                    <th data-column-id="print_discount" data-order="asc">Discount (%)</th>
				                                    <th data-column-id="print_nett_rate" data-order="asc">Nett Rate</th>
				                                    <th data-column-id="print_remarks" data-order="asc">Remarks</th>
				                                </tr>
				                            </thead>
				                            <tbody>
				                            @foreach($inventoryplanner->inventoryplannerprintprices as $row)
				                            	<tr>
				                            		<td>{{ $row->media->media_name }}</td>
				                            		<td>{{ $row->advertiserate->advertiseposition->advertise_position_name }}</td>
				                            		<td>{{ $row->advertiserate->advertisesize->advertise_size_name }}</td>
				                            		<td>{{ $row->advertiserate->paper->paper_name }}</td>
				                            		<td>{{ number_format($row->advertiserate->advertise_rate_normal) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_print_price_gross_rate) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_print_price_surcharge) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_print_price_total_gross_rate) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_print_price_discount) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_print_price_nett_rate) }}</td>
				                            		<td>{{ $row->inventory_planner_print_price_remarks }}</td>
				                            	</tr>
				                            @endforeach
				                            </tbody>
				                        </table>
				                    </div>                 
				                </div>
				                <div role="tabpanel" class="tab-pane" id="listdigital">
				                   <div class="table-responsive">
				                        <table id="grid-data-listdigital" class="table table-hover">
				                            <thead>
				                                <tr>
				                                    <th data-column-id="digital_media_name" data-order="asc">Media</th>
				                                    <th data-column-id="digital_advertise_position_name" data-order="asc">Position</th>
				                                    <th data-column-id="digital_advertise_size_name" data-order="asc">Size</th>
				                                    <th data-column-id="digital_paper_name" data-order="asc">Paper</th>
				                                    <th data-column-id="digital_advertise_rate_normal" data-order="asc">Rate</th>
				                                    <th data-column-id="digital_startdate" data-order="asc">Start Date</th>
				                                    <th data-column-id="digital_enddate" data-order="asc">End Date</th>
				                                    <th data-column-id="digital_deadline" data-order="asc">Deadline</th>
				                                    <th data-column-id="digital_gross_rate" data-order="asc">Gross Rate</th>
				                                    <th data-column-id="digital_surcharge" data-order="asc">Surcharge (%)</th>
				                                    <th data-column-id="digital_total_gross_rate" data-order="asc">Total Gross Rate</th>
				                                    <th data-column-id="digital_discount" data-order="asc">Discount (%)</th>
				                                    <th data-column-id="digital_nett_rate" data-order="asc">Nett Rate</th>
				                                    <th data-column-id="digital_remarks" data-order="asc">Remarks</th>
				                                </tr>
				                            </thead>
				                            <tbody>
				                            @foreach($inventoryplanner->inventoryplannerdigitalprices as $row)
				                            	<tr>
				                            		<td>{{ $row->media->media_name }}</td>
				                            		<td>{{ $row->advertiserate->advertiseposition->advertise_position_name }}</td>
				                            		<td>{{ $row->advertiserate->advertisesize->advertise_size_name }}</td>
				                            		<td>{{ $row->advertiserate->paper->paper_name }}</td>
				                            		<td>{{ number_format($row->advertiserate->advertise_rate_normal) }}</td>
				                            		<td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $row->inventory_planner_digital_price_startdate)->format('d/m/Y') }}</td>
				                            		<td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $row->inventory_planner_digital_price_enddate)->format('d/m/Y') }}</td>
				                            		<td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $row->inventory_planner_digital_price_deadline)->format('d/m/Y') }}</td>
				                            		<td>{{ number_format($row->inventory_planner_digital_price_gross_rate) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_digital_price_surcharge) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_digital_price_total_gross_rate) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_digital_price_discount) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_digital_price_nett_rate) }}</td>
				                            		<td>{{ $row->inventory_planner_digital_price_remarks }}</td>
				                            	</tr>
				                            @endforeach
				                            </tbody>
				                        </table>
				                    </div>                 
				                </div>
				                <div role="tabpanel" class="tab-pane" id="listevent">
				                   <div class="table-responsive">
				                        <table id="grid-data-listevent" class="table table-hover">
				                            <thead>
				                                <tr>
				                                    <th data-column-id="event_media_name" data-order="asc">Media</th>
				                                    <th data-column-id="event_gross_rate" data-order="asc">Gross Rate</th>
				                                    <th data-column-id="event_surcharge" data-order="asc">Surcharge (%)</th>
				                                    <th data-column-id="event_total_gross_rate" data-order="asc">Total Gross Rate</th>
				                                    <th data-column-id="event_discount" data-order="asc">Discount (%)</th>
				                                    <th data-column-id="event_nett_rate" data-order="asc">Nett Rate</th>
				                                    <th data-column-id="event_remarks" data-order="asc">Remarks</th>
				                                </tr>
				                            </thead>
				                            <tbody>
				                            @foreach($inventoryplanner->inventoryplannereventprices as $row)
				                            	<tr>
				                            		<td>{{ $row->media->media_name }}</td>
				                            		<td>{{ number_format($row->inventory_planner_event_price_gross_rate) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_event_price_surcharge) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_event_price_total_gross_rate) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_event_price_discount) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_event_price_nett_rate) }}</td>
				                            		<td>{{ $row->inventory_planner_event_price_remarks }}</td>
				                            	</tr>
				                            @endforeach
				                            </tbody>
				                        </table>
				                    </div>                 
				                </div>
				                <div role="tabpanel" class="tab-pane" id="listcreative">
				                   <div class="table-responsive">
				                        <table id="grid-data-listcreative" class="table table-hover">
				                            <thead>
				                                <tr>
				                                    <th data-column-id="creative_media_name" data-order="asc">Media</th>
				                                    <th data-column-id="creative_advertise_position_name" data-order="asc">Position</th>
				                                    <th data-column-id="creative_advertise_size_name" data-order="asc">Size</th>
				                                    <th data-column-id="creative_paper_name" data-order="asc">Paper</th>
				                                    <th data-column-id="creative_advertise_rate_normal" data-order="asc">Rate</th>
				                                    <th data-column-id="creative_gross_rate" data-order="asc">Gross Rate</th>
				                                    <th data-column-id="creative_surcharge" data-order="asc">Surcharge (%)</th>
				                                    <th data-column-id="creative_total_gross_rate" data-order="asc">Total Gross Rate</th>
				                                    <th data-column-id="creative_discount" data-order="asc">Discount (%)</th>
				                                    <th data-column-id="creative_nett_rate" data-order="asc">Nett Rate</th>
				                                    <th data-column-id="creative_remarks" data-order="asc">Remarks</th>
				                                </tr>
				                            </thead>
				                            <tbody>
				                            @foreach($inventoryplanner->inventoryplannercreativeprices as $row)
				                            	<tr>
				                            		<td>{{ $row->media->media_name }}</td>
				                            		<td>{{ $row->advertiserate->advertiseposition->advertise_position_name }}</td>
				                            		<td>{{ $row->advertiserate->advertisesize->advertise_size_name }}</td>
				                            		<td>{{ $row->advertiserate->paper->paper_name }}</td>
				                            		<td>{{ number_format($row->advertiserate->advertise_rate_normal) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_creative_price_gross_rate) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_creative_price_surcharge) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_creative_price_total_gross_rate) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_creative_price_discount) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_creative_price_nett_rate) }}</td>
				                            		<td>{{ $row->inventory_planner_creative_price_remarks }}</td>
				                            	</tr>
				                            @endforeach
				                            </tbody>
				                        </table>
				                    </div>                 
				                </div>
				                <div role="tabpanel" class="tab-pane" id="listother">
				                   <div class="table-responsive">
				                        <table id="grid-data-listother" class="table table-hover">
				                            <thead>
				                                <tr>
				                                    <th data-column-id="other_media_name" data-order="asc">Media</th>
				                                    <th data-column-id="other_gross_rate" data-order="asc">Gross Rate</th>
				                                    <th data-column-id="other_surcharge" data-order="asc">Surcharge (%)</th>
				                                    <th data-column-id="other_total_gross_rate" data-order="asc">Total Gross Rate</th>
				                                    <th data-column-id="other_discount" data-order="asc">Discount (%)</th>
				                                    <th data-column-id="other_nett_rate" data-order="asc">Nett Rate</th>
				                                    <th data-column-id="other_remarks" data-order="asc">Remarks</th>
				                                </tr>
				                            </thead>
				                            <tbody>
				                            @foreach($inventoryplanner->inventoryplannerotherprices as $row)
				                            	<tr>
				                            		<td>{{ $row->media->media_name }}</td>
				                            		<td>{{ number_format($row->inventory_planner_other_price_gross_rate) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_other_price_surcharge) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_other_price_total_gross_rate) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_other_price_discount) }}</td>
				                            		<td>{{ number_format($row->inventory_planner_other_price_nett_rate) }}</td>
				                            		<td>{{ $row->inventory_planner_event_other_remarks }}</td>
				                            	</tr>
				                            @endforeach
				                            </tbody>
				                        </table>
				                    </div>                 
				                </div>
				            </div>
				        </div>
	            	</div>
	            </div>
	            <div class="form-group">
	                <label for="total_value" class="col-sm-2 control-label">Total Value</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="total_value" id="total_value" placeholder="Total Value" maxlength="20" value="{{ number_format($total_value) }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="total_nett" class="col-sm-2 control-label">Total Nett</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="total_nett" id="total_nett" placeholder="Total Nett" maxlength="20" value="{{ number_format($total_nett) }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="saving_value" class="col-sm-2 control-label">Saving Value</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="saving_value" id="saving_value" placeholder="Saving Value" maxlength="20" value="{{ number_format($saving_value) }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('inventory/inventoryplanner') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('customjs')

@endsection