@extends('layouts.app')


@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Employee Grade Details</strong></div>
            <div class="panel-body">

                @if (session()->has('errorMessage'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Error!</strong> {{ session()->pull('errorMessage') }}
                </div>
                @endif
                @if (session()->has('successMessage'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Success!</strong> {{ session()->pull('successMessage') }}
                </div>
                @endif

                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('empGrade.store')) }}">
                    {{ csrf_field() }}

                    <div class="form-group form-group-sm">
                        <label for="grade_name" class="col-sm-2 control-label">Grade Name <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="grade_name" name="grade_name" placeholder="Grade Name" value="{{ old('grade_name') }}">
                        </div>

                    </div>

                    <div class="form-group form-group-sm">
                        <label for="branch_and_version" class="col-sm-2 control-label">Branch And Version <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            @if(isset($data['secInstitutes']))
                            @foreach($data['secInstitutes'] as $si)
                            <div class="checkbox">
                                <label>
                                    <input name="branch_and_version[]" type="checkbox" value="{{ $si->institute_branch_version_id }}">
                                    {{ $si->school_branch_name }}, {{ $si->school_version_name }} Version
                                </label>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group form-group-sm">

                        <label for="grade_status" class="col-sm-2 control-label">Status <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="grade_status">
                                <option value="">----- Select -----</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                               
                    </div>					
                    <div class="form-group form-group-sm">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                Save
                            </button>
                        </div>
                    </div>          
                </form>
            </div>
        </div>
    </div>
</div>
@endsection