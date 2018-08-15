@extends('layouts.app')

@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Update Account Category Details</strong></div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('accountCategory.update', array('id' => $data['accountCategoryDetails']->account_category_id))) }}">
                    {{ csrf_field() }}
                    
                    {!! method_field('put') !!}

                    <div class="form-group form-group-sm">
                        <label for="account_category_name" class="col-sm-2 control-label">Account Category Name<sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="account_category_name" name="account_category_name" placeholder="Category Name" value="{{ $data['accountCategoryDetails']->account_category_name }}">
                        </div>
                        @if ($errors->has('account_category_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('account_category_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <div class="form-group form-group-sm">
                        <label for="account_category_status" class="col-sm-2 control-label">Status<sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="account_category_status" id="account_category_status">
                                <option value="">----- Select -----</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            
                            <script type="text/javascript">
                                document.getElementById('account_category_status').value = '{{ $data['accountCategoryDetails']->is_active }}';
                            </script>
                        </div>
                        @if ($errors->has('account_category_status'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('account_category_status') }}</strong>
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