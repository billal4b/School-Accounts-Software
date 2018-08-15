@extends('layouts.app')


@section('main_content')
<div class="row">
    <div class="col-sm-12">

        <div class="panel panel-default">
            <div class="panel-heading"><strong>Student</strong></div>
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

                <a class="btn btn-sm btn-primary" href="{{ url(route('student.create')) }}"><i class="fa fa-plus"></i>&nbsp;New</a>
            </div>

            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($data['studentList']))
                    @foreach($data['studentList'] as $egl)
                    <tr>
                        <td>{{ $egl->system_generated_student_id }}</td>
                        <td>{{ $egl->student_name }}</td>
                        <td><span class="label label-{{ $egl->status == 1 ? 'success' : 'danger' }}">{{ $egl->status == 1 ? 'Regular' : 'Irregular' }}</span></td>
                        <td><a class="btn btn-primary btn-sm" href="{{ url(route('student.edit', array('id' => $egl->student_id))) }}"><i class="fa fa-pencil-square-o"></i>&nbsp;Update</a></td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
