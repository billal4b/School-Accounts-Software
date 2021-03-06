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





                <form class="form-horizontal" role="form" onsubmit="return false;">
                    
                    {{ csrf_field() }}
                    
                    @if(Auth::user()->role_id == 9)
<!--                    <div class="form-group form-group-sm">

                        <label for="generate_month" class="col-sm-2 control-label">Month <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-2">
                            <select class="form-control" name="generate_month" id="generate_month">
                                <option value="">Select</option>
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


                    </div>-->
                    @endif

                    @if(Auth::user()->role_id == 8)
                    <!--<div class="form-group form-group-sm">
                        <label for="generate_class" class="col-sm-2 control-label">Class <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-2">
                            <select class="form-control" name="generate_class" id="generate_class">
                                <option value="">Select</option>
                                @if(isset($data['studentClasses']))
                                @foreach($data['studentClasses'] as $cl)
                                <option value="{{ $cl->id }}">{{ $cl->ClassName }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <label for="generate_group" class="col-sm-2 control-label">Group <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-2">
                            <select class="form-control" name="generate_group" id="generate_group">
                                <option value="">Select</option>
                                @if(isset($data['studentGroups']))
                                @foreach($data['studentGroups'] as $sg)
                                <option value="{{ $sg->id }}">{{ $sg->GroupName }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <label for="generate_section" class="col-sm-2 control-label">Section <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-2">
                            <select class="form-control" name="generate_section" id="generate_section">
                                <option value="">Select</option>
                                @if(isset($data['studentSections']))
                                @foreach($data['studentSections'] as $sg)
                                <option value="{{ $sg->section_id }}">{{ $sg->SectionName }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>-->
                    @endif

                    <div class="form-group form-group-sm">

                        @if(Auth::user()->role_id == 9)
                        <label for="student_id" class="col-sm-2 control-label">Student ID <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="student_id" id="student_id" placeholder="Student ID">
                        </div>                        
                        @elseif(Auth::user()->role_id == 8)
                        <label for="receipt_no" class="col-sm-2 control-label">Receipt No <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="receipt_no" id="receipt_no" placeholder="Receipt No">
                        </div>
                        @elseif(Auth::user()->role_id == 6 || Auth::user()->role_id == 7)
                        <?php
                        $str = Auth::user()->username;
                        $studentId = explode('s', $str);
                        ?>
                        <input type="hidden" name="student_id" id="student_id" value="{{ $studentId[1] }}">
                        @endif

                        <div class="col-sm-4">

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

                </form>

                <div id="student_info"></div>

            </div>
        </div>
    </div>
</div>


@endsection