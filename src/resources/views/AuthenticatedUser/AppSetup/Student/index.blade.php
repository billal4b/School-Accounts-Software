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
				
               <form class="navbar-form " id="student_form_search" role="form" onsubmit="return false;" >
                  {{ csrf_field() }}
                <a class="btn btn-sm btn-primary" href="{{ url(route('student.create')) }}"><i class="fa fa-plus"></i>&nbsp;New </a>				
                  <div class="form-group navbar-right">
                      <input type="search"  class="form-control" id='search_value' name="search" size="40px" placeholder="Search"/>
					  <button type="button" id='student_search_submit' class="btn btn-sm btn-success">Search</button>

<div class="col-sm-2 pull-right" id="wait" style="display: none;">



                            <i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>

                            <span class="sr-only">Loading...</span>

                        </div>



                  </div>  

               
              </form>
			  
				
            </div>
             <div id="student_search_view">
            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Group</th>
                        <th>Section</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($data['studentList']))
                    <?php $i=0; ?>
                    @foreach($data['studentList'] as $egl)
                    <tr>
                       
                        <td>{{ $egl->system_generated_student_id }}</td>
                        <td>{{ $egl->student_name }}</td>
                        <td>{{ $egl->ClassName }}</td>
                        <td>{{ $egl->GroupName }}</td>
                        <td>{{ $egl->SectionName }}</td>
                        <td><span class="label label-{{ $egl->status == 1 ? 'success' : 'danger' }}">{{ $egl->status == 1 ? 'Regular' : 'Irregular' }}</span></td>
                        <td><a class="btn btn-primary btn-sm" href="{{ url(route('student.edit', array('id' => $egl->student_id))) }}"><i class="fa fa-pencil-square-o"></i>&nbsp;Update</a></td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
			<hr/><div style="text-align: center">{!! $data['studentList']->render() !!}</div>
        </div>

    </div>
</div>
@endsection
