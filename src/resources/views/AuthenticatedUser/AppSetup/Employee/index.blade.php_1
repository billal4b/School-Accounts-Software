@extends('layouts.app')


@section('main_content')


<div class="row">
    <div class="col-sm-12">

        <div class="panel panel-default">
            <div class="panel-heading"><strong>Employee </strong></div>
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

            </div>

            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Scale</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($data['employeeList']))
                    @foreach($data['employeeList'] as $egl)
                    <tr>
                        <td>{{ $egl->EmpID }}</td>
                        <td>{{ $egl->EmpName }}</td>
                        <td>{{ $egl->DesigID }}</td>
                        <td>{{ $egl->name }}</td>
                        <td>{{ $egl->Mob1 }}</td>
                        <td><span class="label label-{{ $egl->TeacherType == 1 ? 'success' : 'danger' }}">{{ $egl->TeacherType == 1 ? 'Active' : 'Inactive' }}</span></td>
                        <td><a class="btn btn-primary btn-sm" href="{{ url(route('employee.edit', array('id' => $egl->EmpID))) }}"><i class="fa fa-pencil-square-o"></i>&nbsp;Update</a></td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
