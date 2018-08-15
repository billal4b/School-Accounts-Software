@extends('layouts.app')


@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Salary Sheet</strong></div>
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





                <form class="form-horizontal" role="form" action="{{ url(route('salarySheet::update', array('salary_sheet_id' => $data['salary_sheet_details']->salary_sheet_id ))) }}" method="post">

                    {{ csrf_field() }}
                    <div class="form-group form-group-sm">

                        <label for="absent_in_month" class="col-sm-2 control-label">Absent(in month) <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" id="absent_in_month" name="absent_in_month" value="{{ $data['salary_sheet_details']->absent_in_month }}">
                        </select>
                    </div>
                    <label for="tax" class="col-sm-2 control-label">Tax <sup><i class="fa fa-asterisk"></i></sup></label>
                               <div class="col-sm-2">
                            <input type="text" class="form-control" id="tax" name="tax" value="{{ $data['salary_sheet_details']->tax }}">
                                 </select>
                             </div>
                             <label for="cpf_loan_adj" class="col-sm-2 control-label">CPF Loan Adj <sup><i class="fa fa-asterisk"></i></sup></label>
                             <div class="col-sm-2">
                                 <input type="text" class="form-control" id="cpf_loan_adj" name="cpf_loan_adj" value="{{ $data['salary_sheet_details']->cpf_loan_adj }}">
                                 </select>
                             </div>
                        </div>
                        <div class="form-group form-group-sm">

                            <label for="remarks" class="col-sm-2 control-label">Remarks <sup><i class="fa fa-asterisk"></i></sup></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" id="remarks" name="remarks">{{ $data['salary_sheet_details']->remarks }}</textarea>
                                </select>
                            </div>

                        </div>

                        <div class="form-group form-group-sm">
                            <div class="col-sm-12">
                                <input type="submit" value="Save" class="btn btn-success btn-block btn-sm">
                            </div>
                        </div>

                </form>

            </div>
        </div>
    </div>
</div>


@endsection