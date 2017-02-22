@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Project Task<small>PIC Form</small></h2></div>
        <div class="card-body card-padding">
            <form class="form-horizontal" role="form" method="POST" action="{{ url($url) }}">
                {{ csrf_field() }}
                @include('vendor.material.grid.projecttask.view')
                @include('vendor.material.grid.projecttask.history')
                <div class="form-group">
                    <label for="upload_file" class="col-sm-2 control-label">Upload File(s)</label>
                    <div class="col-sm-10">
                        <div class="fg-line">
                            <div class="dropzone" id="uploadFileArea">
                                
                            </div>
                        </div>
                        <span class="help-block">
                            <strong>Max filesize: 200 MB. Allowed File(s): .doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .rar, .zip</strong>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="comment" class="col-sm-2 control-label">Comment</label>
                    <div class="col-sm-10">
                        <div class="fg-line">
                            <textarea name="comment" id="comment" class="form-control input-sm" placeholder="Comment" required="true">{{ old('comment') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        <a href="{{ url('grid/projecttask') }}" class="btn btn-danger btn-sm">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/dropzone.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/grid/projecttask-create.js') }}"></script>
@endsection