@extends('layouts.app')


@section('main_content')
<div class="row">
    <div class="col-sm-12">

        <div class="panel panel-default">
            <div class="panel-heading"><strong> Free Payment Details </strong></div>
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

                <a class="btn btn-sm btn-primary" href="{{ url(route('freePaymentDetails.create')) }}"><i class="fa fa-plus"></i>&nbsp;New</a>
            </div>

            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                      
                        <th>Class</th>
                        <th>Group</th>
						  <th>Branch</th>
                        <th>Head</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($data['FreePaymentList']))
                    @foreach($data['FreePaymentList'] as $egl)
                    <tr>
                        <td>{{ $egl->free_payment_view_id }} </td>
                       
                        <td>{{ $egl->ClassName }}</td>
                        <td>{{ $egl->GroupName }}</td>
						 <td>
                                                 
                                                 <?php
                                                 $query = 'select tsb.school_branch_name, tsv.school_version_name from tbl_sec_institute_branch_version tsibv inner join tbl_school_branches tsb on  tsibv.school_branch_id = tsb.school_branch_id inner join tbl_school_versions tsv on tsibv.school_version_id = tsv.school_version_id where tsibv.institute_branch_version_id = ' . $egl->brn_version_id;
                                                 $result = DB::select($query);
                                                 //echo '<pre>';print_r($result);exit();
                                                 echo $result[0]->school_branch_name . ', ' . $result[0]->school_version_name;
                                                 ?>
                                                 </td>
                        <td>{{ $egl->student_payment_name }}</td>
                        <td>{{ $egl->free_catagory }}</td>
                        <td>{{ $egl->amount }}</td>
                        <td><span class="label label-{{ $egl->is_active == 1 ? 'success' : 'danger' }}">{{ $egl->is_active == 1 ? 'Active' : 'Inactive' }}</span></td>
                        <td><a class="btn btn-primary btn-sm" href="{{ url(route('freePaymentDetails.edit', array('id' => $egl->free_payment_view_id))) }}"><i class="fa fa-pencil-square-o"></i>&nbsp;Update</a></td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
