@extends('layouts.app')

@section('main_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong> Update Employee Scale Details  </strong></div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url(route('degScale.update', array('id' => $data['desiScaleDetails']->sec_designation_scale_id))) }}">
                    {{ csrf_field() }}
					 {!! method_field('put') !!}
                    <div class="form-group form-group-sm">
                        <label for="name" class="col-sm-4 control-label">Scale <sup> <i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Designation Scale" value="{{ $data['desiScaleDetails']->name }}">
                        </div>

                    </div>
					 <div class="form-group form-group-sm">
                        <label for="desig_name" class="col-sm-4 control-label">Designation Name <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
						 <select id="desig_name" name="desig_name" class="form-control">
                                <option value="">----- Select -----</option>
                                @if(isset($data['design']))
                                   @foreach($data['design'] as $dgn)
                                       <option value="{{ $dgn->DesigID }}">{{ $dgn->Designation }}</option>
                                   @endforeach
                                @endif
                           </select>
						   <script type="text/javascript">
                                document.getElementById('desig_name').value= '{{ $data['desiScaleDetails']->DesigID }}';
                            </script>
                        </div>

                    </div>
					<div class="form-group form-group-sm">
                        <label for="scale_name" class="col-sm-4 control-label">Scale Name <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
						   <select id="scale_name" name="scale_name" class="form-control">
                                <option value="">----- Select -----</option>
                                @if(isset($data['empScale']))
                                   @foreach($data['empScale'] as $ems)
                                       <option value="{{ $ems->employee_scale_id }}">{{ $ems->scale_name }}</option>
                                   @endforeach
                                @endif
                           </select>
						   <script type="text/javascript">
                                document.getElementById('scale_name').value= '{{ $data['desiScaleDetails']->employee_scale_id }}';
                            </script>
                        </div>

                    </div>
					<div class="form-group form-group-sm">
                        <label for="basic_salary" class="col-sm-4 control-label">Basic Salary </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="basic_salary" name="basic_salary" placeholder="Basic Salary" value="{{ $data['desiScaleDetails']->basic_salary }}">
                        </div>

                    </div>
					<div class="form-group form-group-sm">
                        <label for="cut_basic_salary_absent" class="col-sm-4 control-label">Cut Basic Salary for Absent </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="cut_basic_salary_absent" name="cut_basic_salary_absent" placeholder="Cut Basic Salary for Absent ( tk.)" value="{{ $data['desiScaleDetails']->cut_basic_salary_per_day_for_absent_in_tk }}">
                        </div>

                    </div>
					<div class="form-group form-group-sm">
                        <label for="house_rent_percent" class="col-sm-4 control-label">House Rent of Basic Salary ( Percent ) </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="house_rent_percent" name="house_rent_percent" placeholder="house rent of basic salary ( Percent )" value="{{ $data['desiScaleDetails']->house_rent_of_basic_salary_in_percent }}">
                        </div>

                    </div>
					<div class="form-group form-group-sm">
                        <label for="house_rent_tk" class="col-sm-4 control-label">House Rent of Basic Salary ( Tk.) </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="house_rent_tk" name="house_rent_tk" placeholder="house rent of basic salary ( Tk.) " value="{{ $data['desiScaleDetails']->house_rent_of_basic_salary_in_tk }}">
                        </div>

                    </div>
					<div class="form-group form-group-sm">
                        <label for="cut_house_rent_absent" class="col-sm-4 control-label">Cut House Rent for Absent ( Tk.)  </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="cut_house_rent_absent" name="cut_house_rent_absent" placeholder="cut house rent for absent ( Tk.) " value="{{ $data['desiScaleDetails']->cut_house_rent_per_day_for_absent_in_tk }}">
                        </div>

                    </div>
					<div class="form-group form-group-sm">
                        <label for="medical_allowance_percent" class="col-sm-4 control-label">Medical Allowance ( Percent )  </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="medical_allowance_percent" name="medical_allowance_percent" placeholder="Medical Allowance ( Percent )" value="{{ $data['desiScaleDetails']->medical_allowance_of_basic_salary_in_percent }}">
                        </div>

                    </div>
					<div class="form-group form-group-sm">
                        <label for="medical_allowance_tk" class="col-sm-4 control-label">Medical Allowance ( TK. )  </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="medical_allowance_tk" name="medical_allowance_tk" placeholder="Medical Allowance ( TK. )" value="{{ $data['desiScaleDetails']->medical_allowance_of_basic_salary_in_tk }}">
                        </div>

                    </div>
					<div class="form-group form-group-sm">
                        <label for="cut_medical_allowance" class="col-sm-4 control-label">Cut Medical Allowance ( TK. )  </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="cut_medical_allowance" name="cut_medical_allowance" placeholder="Cut Medical Allowance ( TK. )" value="{{ $data['desiScaleDetails']->cut_medical_allowance_per_day_for_absent_in_tk }}">
                        </div>

                    </div>
					<div class="form-group form-group-sm">
                        <label for="transport_cost_percent" class="col-sm-4 control-label">Transport Cost ( Percent ) </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="transport_cost_percent" name="transport_cost_percent" placeholder="transport cost ( Percent ) " value="{{ $data['desiScaleDetails']->transport_cost_of_basic_salary_in_percent }}">
                        </div>

                    </div>
					<div class="form-group form-group-sm">
                        <label for="transport_cost_tk" class="col-sm-4 control-label">Transport Cost ( Tk. )</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="transport_cost_tk" name="transport_cost_tk" placeholder="transport cost ( Tk. ) " value="{{ $data['desiScaleDetails']->transport_cost_of_basic_salary_in_tk }}">
                        </div>

                    </div>
					<div class="form-group form-group-sm">
                        <label for="cut_transport_cost" class="col-sm-4 control-label">Cut Transport Cost ( Tk. )</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="cut_transport_cost" name="cut_transport_cost" placeholder="Cut Transport Cost ( Tk. ) " value="{{ $data['desiScaleDetails']->cut_transport_cost_per_day_for_absent_in_tk}}">
                        </div>

                    </div>
					<div class="form-group form-group-sm">
                        <label for="branch_version" class="col-sm-4 control-label">Branch & Version <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
						    <select id="branch_version" name="branch_version" class="form-control">
                                <option value="">----- Select -----</option>
                                @if(isset($data['secInstitutes']))
                                @foreach($data['secInstitutes'] as $si)
                                   <option value="{{ $si->institute_branch_version_id }}">
								     {{ $si->school_branch_name }}, {{ $si->school_version_name }} Version
								   </option>		
                                @endforeach
                                @endif
                            </select>	
							 <script type="text/javascript">
                                document.getElementById('branch_version').value= '{{ $data['desiScaleDetails']->institute_branch_version_id }}';
                            </script>
                        </div>

                    </div>

                  
                    
                    <div class="form-group form-group-sm">
                        <label for="desi_status" class="col-sm-4 control-label">Status <sup><i class="fa fa-asterisk"></i></sup></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="desi_status" id="desi_status">
                                <option value="">----- Select -----</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            
                            <script type="text/javascript">
                                document.getElementById('desi_status').value = '{{ $data['desiScaleDetails']->is_active }}';
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