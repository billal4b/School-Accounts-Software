@extends('layouts.app')

@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Student Free Payment Details </strong></div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('freePayment.update', array('id' => $data['freePaymentDetails']->stu_free_payment_id))) }}">
                    {{ csrf_field() }}
                    
                    {!! method_field('put') !!}

                    <div class="form-group form-group-sm">
                        <label for="free_catagory" class="col-sm-2 control-label"> Free Catagory <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="free_catagory" name="free_catagory" value="{{ $data['freePaymentDetails']->free_catagory }}">
                        </div>
                    
                    </div>
                     <div class="form-group form-group-sm">
                        <label for="free_type" class="col-sm-2 control-label"> Free Type <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="free_type" name="free_type" value="{{ $data['freePaymentDetails']->free_type }}">
                        </div>
                    
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="status" class="col-sm-2 control-label"> Status <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="status" id="status">
                                <option value="">----- Select -----</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            
                            <script type="text/javascript">
                                document.getElementById('status').value = '{{ $data['freePaymentDetails']->is_active }}';
                            </script>
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