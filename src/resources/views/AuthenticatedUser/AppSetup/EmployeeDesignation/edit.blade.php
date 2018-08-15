@extends('layouts.app')

@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Employee Designation Details</strong></div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('empDesignation.update', array('id' => $data['empDesignationDetails']->designation_id))) }}">
                    {{ csrf_field() }}
                    
                    {!! method_field('put') !!}

                    <div class="form-group form-group-sm">
                        <label for="designationgrade_name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="designation_name" name="designation_name" placeholder="Designation Name" value="{{ $data['empDesignationDetails']->designation_name }}">
                        </div>
                        @if ($errors->has('designation_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('designation_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <div class="form-group form-group-sm">
                        <label for="grade_status" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="designation_status" id="designation_status">
                                <option value="">----- Select -----</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            
                            <script type="text/javascript">
                                document.getElementById('designation_status').value = '{{ $data['empDesignationDetails']->is_active }}';
                            </script>
                        </div>
                        @if ($errors->has('designation_status'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('designation_status') }}</strong>
                        </span>
                        @endif
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