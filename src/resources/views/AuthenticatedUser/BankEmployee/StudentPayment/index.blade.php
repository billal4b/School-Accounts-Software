@extends('layouts.app')


@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Student Payment Slip Details</strong></div>
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





                <form class="form-horizontal" role="form" method="POST" action="">
                    {{ csrf_field() }}
                    <div class="form-group form-group-sm">

                        <label for="generate_month" class="col-sm-2 control-label">Month <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-2">
                            <select class="form-control" name="generate_month" id="generate_month">
                                <!--<option value="">Select</option>-->
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        
                        <label for="student_id" class="col-sm-2 control-label">Student ID  <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="student_id" id="student_id" placeholder="Student ID">
                        </div>

                        <div class="col-sm-2">

                            <button type="button" class="btn btn-primary btn-sm" id="view_slip_btn">
                                <i class="fa fa-list" aria-hidden="true"></i>
                                View Slip
                            </button>
                        </div>

                        <div class="col-sm-2" id="wait" style="display: none;">

                            <i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>





            </div>
        </div>
    </div>
</div>

<div id="student_info"></div>
@endsection
