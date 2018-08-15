@extends('layouts.app')

@section('main_content')
<?php
$monthArray = array(
    'Unknown', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Update Bank Details </strong></div>
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

                <form id="student_payment_form" role="form" method="POST" action ="{{url(route('studentReport::updatePaymentAmount', array('received_student_payment_id' => $data['paymentReport'][0]->received_student_payment_id))) }}">

                    {{ csrf_field() }} 
                    <div class="table-responsive">
                        <table class="table table-condensed table-bordered text-uppercase">
                            <tbody>
                                @if(isset($data['paymentReport']) && !empty($data['paymentReport']))
                                <tr>
                                    <td colspan="3">
                                        Receipt No. : <strong><span class="badge">{{ $data['paymentReport'][0]->received_student_payment_id }}</span></strong>
                                    </td>
<!--							<td>
                                            Sl. No. : <strong>{{ $data['paymentReport'][0]->book_sl_no }}</strong>
                                    </td>-->
                                    <td>
                                        DATE : <strong>{{ date('d-m-Y', strtotime($data['paymentReport'][0]->received_time)) }}</strong>
                                    </td>
                                </tr>
<!--						<tr>
                                        <td colspan="4">
                                                A/C No. : <strong>{{ $data['paymentReport'][0]->account_no }} at {{ $data['paymentReport'][0]->bank_name }}, {{ $data['paymentReport'][0]->branch_name }}</strong>
                                        </td>
                                </tr>-->
                                @endif

                                @if(isset($data['paymentReport']))
                            <input type="hidden" name="student_id" value="{{ $data['paymentReport'][0]->student_id }}">
                            <input type="hidden" name="system_generated_student_id" value="{{ $data['paymentReport'][0]->system_generated_student_id }}">
                            <input type="hidden" name="generated_month" value="{{ $data['paymentReport'][0]->generated_month }}">
                            <input type="hidden" name="student_roll" value="{{ $data['paymentReport'][0]->student_roll }}">
                            <input type="hidden" name="class_id" value="{{ $data['paymentReport'][0]->class_id }}">
                            <input type="hidden" name="section_id" value="{{ $data['paymentReport'][0]->section_id }}">
                            <input type="hidden" name="group_id" value="{{ $data['paymentReport'][0]->group_id }}">
                            <tr>
                                <td colspan="3">
                                    NAME : <strong>{{ $data['paymentReport'][0]->student_name }}</strong>
                                </td>
                                <td>
                                    ID : <strong>{{ $data['paymentReport'][0]->system_generated_student_id }}</strong>
                                </td>
<!--						<td>
                                        MONTH : <strong>{{ $monthArray[$data['paymentReport'][0]->generated_month] }}</strong>
                                </td>-->
                            </tr>
                            <tr>
                                <td>
                                    ROLL : <strong>{{ $data['paymentReport'][0]->student_roll }}</strong>
                                </td>
                                <td>
                                    CLASS : <strong>{{ $data['paymentReport'][0]->ClassName }}</strong>
                                </td>
                                <td>
                                    SECTION : <strong></strong>
                                </td>
                                <td>
                                    GROUP : <strong>{{ $data['paymentReport'][0]->GroupName }}</strong>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-right" colspan="3"><strong>Received Amount</strong></td>
                                <td class="text-right">

                                    <input type="text" id="received_amount" name="received_amount" class="form-control input-sm text-right" value="{{ $data['paymentReport'][0]->received_amount_by_bank}}"></td>

                            </tr>
                            <tr>
                                <td class="text-right" colspan="3"><strong>Book Sl. No.</strong></td>
                                <td class="text-right"><input type="text" id="book_sl_no" name="book_sl_no" value="{{ $data['paymentReport'][0]->book_sl_no}}" class="form-control input-sm text-right"></td>
                            </tr>
                            <tr>
                                <td colspan="4"><button type="submit" class="btn btn-success btn-sm btn-block" id="payBtn">Edit</button></td>


                            </tr>
                            </tbody>

                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
