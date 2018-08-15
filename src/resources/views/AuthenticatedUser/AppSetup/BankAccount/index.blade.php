@extends('layouts.app')


@section('main_content')
<div class="row">
    <div class="col-sm-12">

        <div class="panel panel-default">
            <div class="panel-heading"><strong>Bank Account</strong></div>
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

                <a class="btn btn-sm btn-primary" href="{{ url(route('bankAccount.create')) }}"><i class="fa fa-plus"></i>&nbsp;New</a>
            </div>

            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>A/C No</th>
                        <th>Bank</th>					
                        <th>Branch</th>					
                       				
                        <th>Contact</th>					
                        <th>Address</th>	
                        <th>Opening Balence</th>							
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($data['bankAccountList']))
                    @foreach($data['bankAccountList'] as $bnac)
                    <tr>
                        <td>{{ $bnac->account_id }}</td>
                        <td>{{ $bnac->account_no }}</td>
                        <td>{{ $bnac->bank_name }}</td>
                        <td>{{ $bnac->branch_name }}</td>
                       
                        <td>{{ $bnac->contact_no }}</td>
                        <td>{{ $bnac->address }}</td>
                         <td>{{ $bnac->opening_balance }}</td>
                        <td><span class="label label-{{ $bnac->is_active == 1 ? 'success' : 'danger' }}">{{ $bnac->is_active == 1 ? 'Active' : 'Inactive' }}</span></td>
                        <td><a class="btn btn-primary btn-sm" href="{{ url(route('bankAccount.edit', array('id' => $bnac->account_id))) }}"><i class="fa fa-pencil-square-o"></i>&nbsp;Update</a></td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
