@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Project<small>PIC Form</small></h2></div>
        <div class="card-body card-padding">
            <form class="form-horizontal" role="form" method="POST" action="{{ url($url) }}">
                {{ csrf_field() }}
                @include('vendor.material.grid.project.view')
                @include('vendor.material.grid.project.history')
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
                        <a href="{{ url('grid/project') }}" class="btn btn-danger btn-sm">Back</a>
                        @can('Project Task-Create')
                        <a href="{{ url('grid/projecttask/create') }}" class="btn btn-info btn-sm" target="_blank">Create Task</a>
                        @endcan
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection