<div class="form-group">
    <label for="contract_no" class="col-sm-2 control-label">Contract No</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" id="contract_no" readonly="true" value="{{ $summary->contract->contract_no }}">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="proposal_no" class="col-sm-2 control-label">Proposal No</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="hidden" id="summary_id" value="{{ $summary->summary_id }}">
            <input type="text" class="form-control input-sm" id="proposal_no" readonly="true" value="{{ $summary->contract->proposal->proposal_no }}">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="proposal_name" class="col-sm-2 control-label">Name</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" name="proposal_name" id="proposal_name" placeholder="Proposal Name" required="true" maxlength="200" value="{{ $summary->contract->proposal->proposal_name }}" readonly="true">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="industry_id" class="col-sm-2 control-label">Industry</label>
    <div class="col-sm-10">
        <div class="fg-line">
            @foreach ($summary->contract->proposal->industries as $row)
                <span class="badge">{{ $row->industry_name }}</span>
            @endforeach
        </div>
    </div>
</div>
<div class="form-group">
    <label for="client_id" class="col-sm-2 control-label">Client</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <a href="{{ url('/master/client/' . $summary->contract->proposal->client->client_id) }}" target="_blank"><span class="badge">{{ $summary->contract->proposal->client->client_name }}</span></a>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="client_contact_id" class="col-sm-2 control-label">Contact</label>
    <div class="col-sm-10">
        <div class="fg-line">
            @foreach ($summary->contract->proposal->client_contacts as $row)
                <a href="{{ url('/master/client/' . $summary->contract->proposal->client->client_id) }}" target="_blank"><span class="badge">{{ $row->client_contact_name . ' | ' . $row->client_contact_phone }}</span></a><br/>
            @endforeach
        </div>
    </div>
</div>
<div class="form-group">
    <label for="brand_id" class="col-sm-2 control-label">Brand</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <span class="badge">{{ $summary->contract->proposal->brand->brand_name }}</span>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="media_id" class="col-sm-2 control-label">Media</label>
    <div class="col-sm-10">
        <div class="fg-line">
            @foreach ($summary->contract->proposal->medias as $row)
                <a href="{{ url('/master/media/' . $row->media_id) }}" target="_blank"><span class="badge">{{ $row->media_name }}</span></a>
            @endforeach
        </div>
    </div>
</div>
<div class="form-group">
    <label for="top_type" class="col-sm-2 control-label">Term of Payment</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" id="top_type" readonly="true" value="{{ $summary->top_type }}">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="summary_notes" class="col-sm-2 control-label">Summary Notes</label>
    <div class="col-sm-10">
        <div class="fg-line">
            {!! $summary->summary_notes !!}
        </div>
    </div>
</div>
<div class="form-group">
    <label for="summary_order_no" class="col-sm-2 control-label">Order No</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" id="summary_order_no" readonly="true" value="{{ $summary->summary_order_no }}">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="upload_file" class="col-sm-2 control-label">Upload File(s)</label>
    <div class="col-sm-10">
        <div class="fg-line">
            @foreach ($summary->uploadfiles as $uploadedfile)
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail">
                        @if($uploadedfile->upload_file_type=='jpg' || $uploadedfile->upload_file_type=='png' || $uploadedfile->upload_file_type=='gif' || $uploadedfile->upload_file_type=='jpeg')
                        <img src="{{ url($uploadedfile->upload_file_path . '/' . $uploadedfile->upload_file_name) }}" alt="{{ $uploadedfile->upload_file_name }}">
                        @else
                        <img src="{{ url('img/filetypes/' . $uploadedfile->upload_file_type . '.png') }}" alt="">
                        @endif
                        <div class="caption">
                            <h6>{{ $uploadedfile->upload_file_name }} [Rev {{ $uploadedfile->upload_file_revision }}]</h6>
                            <p>{{ $uploadedfile->upload_file_desc }}</p>
                            <div class="m-b-5">
                                @can('Summary-Download')
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
    <label for="created_by" class="col-sm-2 control-label">Created By</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" placeholder="Created By" readonly="true" maxlength="100" value="{{ $summary->created_by->user_firstname . ' ' . $summary->created_by->user_lastname }}">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="revision_no" class="col-sm-2 control-label">Revision</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" value="{{ $summary->revision_no }}" readonly="true">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="current_user" class="col-sm-2 control-label">Current User</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" placeholder=Current User" readonly="true" maxlength="100" value="{{ $summary->_currentuser->user_firstname . ' ' . $summary->_currentuser->user_lastname }}">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="pic" class="col-sm-2 control-label">PIC</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" placeholder=PIC" readonly="true" maxlength="100" value="{{ ($summary->pic!=null) ? ($summary->_pic->user_firstname . ' ' . $summary->_pic->user_lastname) : '-' }}">
        </div>
    </div>
</div>
<hr/>
<div class="form-group">
    <div class="col-sm-12 table-responsive">
        <table id="details-table" class="table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Media</th>
                    <th>Date Start</th>
                    <th>Date End</th>
                    <th>Rate Name</th>
                    <th>Omzet Type</th>
                    <th>Insertion</th>
                    <th>Gross Rate</th>
                    <th>Disc (%)</th>
                    <th>Nett Rate</th>
                    <th>Internal Omzet</th>
                    <th>Termin</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Halaman/Posisi</th>
                    <th>Kanal</th>
                    <th>Order Digital</th>
                    <th>Materi</th>
                    <th>Status Materi</th>
                    <th>Capture Materi</th>
                    <th>Sales Order</th>
                    <th>PO Perjanjian</th>
                    <th>PPN</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($summary->summaryitems as $row)
                    @if($row->revision_no == $summary->revision_no)
                        @if($row->summary_item_edited=='YES')
                        <tr style="color:red;">
                        @else
                        <tr>
                        @endif
                            <td>{{ $row->summary_item_type }}</td>
                            <td>{{ $row->rate->media->media_name }}</td>
                            <td>{{ $row->summary_item_period_start }}</td>
                            <td>{{ ($row->summary_item_period_end!='0000-00-00') ? $row->summary_item_period_end : '-' }}</td>
                            <td>{{ $row->rate->rate_name }}</td>
                            <td>{{ $row->omzettype->omzet_type_name }}</td>
                            <td>{{ $row->summary_item_insertion }}</td>
                            <td>{{ number_format($row->summary_item_gross) }}</td>
                            <td>{{ $row->summary_item_disc }}</td>
                            <td>{{ number_format($row->summary_item_nett) }}</td>
                            <td>{{ number_format($row->summary_item_internal_omzet) }}</td>
                            <td>{{ $row->summary_item_termin }}</td>
                            <td>{{ $row->summary_item_viewed }}</td>
                            <td>{{ $row->summary_item_remarks }}</td>
                            <td>{{ $row->page_no }}</td>
                            <td>{{ $row->summary_item_canal }}</td>
                            <td>{{ $row->summary_item_order_digital }}</td>
                            <td>{{ $row->summary_item_materi }}</td>
                            <td>{{ $row->summary_item_status_materi }}</td>
                            <td>{{ $row->summary_item_capture_materi }}</td>
                            <td>{{ $row->summary_item_sales_order }}</td>
                            <td>{{ $row->summary_item_po_perjanjian }}</td>
                            <td>{{ number_format($row->summary_item_ppn) }}</td>
                            <td>{{ number_format($row->summary_item_total) }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7">Total</th>
                    <th>{{ number_format($summary->summary_total_gross) }}</th>
                    <th>{{ number_format($summary->summary_total_disc) }}</th>
                    <th>{{ number_format($summary->summary_total_nett) }}</th>
                    <th>{{ number_format($summary->summary_total_internal_omzet) }}</th>
                    <th colspan="3"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="form-group">
    <label for="history" class="col-sm-2 control-label">History</label>
    <div class="col-sm-10">
        <button class="btn btn-primary waves-effect collapsed" type="button" data-toggle="collapse" data-target="#collapseHistory" aria-expanded="false" aria-controls="collapseHistory">Show/Hide History</button>
        <div class="timeline collapse" id="collapseHistory">
        @foreach($summary->summaryhistories as $key => $value)
            <div class="t-view" data-tv-type="text">
                <div class="tv-header media">
                    <a href="#" class="tvh-user pull-left">
                        <img class="img-responsive" src="{{ url('img/avatar/' . $value->created_by->user_avatar) }}" alt="$value->created_by->user_avatar">
                    </a>
                    <div class="media-body p-t-5">
                        <strong class="d-block">{{ $value->created_by->user_firstname . ' ' . $value->created_by->user_lastname }}</strong>
                        <small class="c-gray">{{ $value->created_at }}</small>
                    </div>
                </div>
                <div class="tv-body">
                    <p>
                        {!! $value->summary_history_text !!}
                    </p>
                    <div class="clearfix"></div>
                    <ul class="tvb-stats">
                        <li class="tvbs-likes">{{ $value->approvaltype->approval_type_name }}</li>
                    </ul>                          
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>
<div class="form-group">
    <label for="export" class="col-sm-2 control-label">Export</label>
    <div class="col-sm-10">
        @can('Summary-Download')
            <a href="{{ url('workorder/summary/api/exportXls/' . $summary->summary_id) }}" target="_blank"><button class="btn btn-success waves-effect collapsed" type="button">Export to .xlsx</button></a>
        @endcan
    </div>
</div>