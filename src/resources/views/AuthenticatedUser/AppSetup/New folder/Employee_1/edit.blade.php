@extends('layouts.app')

@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong> Update Employee Details  </strong></div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('employee.update', array('id' => $data['employeeDetails']->EmpID))) }}">
                    {{ csrf_field() }}
                    
                    {!! method_field('put') !!}

                    
					
					<div class="form-group form-group-sm">
					<label for="desig_scale" class="col-sm-4 control-label">Designation Scale <sup><i class="fa fa-asterisk"></i></sup></label>
					<div class="col-sm-6">
						<select id="desig_scale" name="desig_scale" class="form-control">
							<option value="">----- Select -----</option>
							@if(isset($data['desigScale']))
							   @foreach($data['desigScale'] as $dgs)
								   <option value="{{ $dgs->sec_designation_scale_id }}">{{ $dgs->name }}</option>
							   @endforeach
							@endif
					   </select>
					   <script type="text/javascript">
							document.getElementById('desig_scale').value= '{{ $data['employeeDetails']->sec_designation_scale_id }}';
					   </script>
					</div>
                    </div>
					
					

                    <div class="form-group form-group-sm">
                        <div class="col-sm-offset-4 col-sm-8">
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