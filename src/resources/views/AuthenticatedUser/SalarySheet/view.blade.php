@if(isset($data['salary_sheets']))

<!--<div class="table-responsive">-->
    <table class="table table-bordered table-condenesed" style="font-size: 10px;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Designation</th>
                <th>Monthly Basic Salary</th>
                <th>Period</th>
                <th>Salary for the month</th>
                <th>House Rent</th>
                <th>Medical Allowance</th>
                <th>Transport</th>
                <th>ECPF 10% of Basic</th>
                <th>Gross Total</th>
                <th>Tax</th>
                <th>CPF Loan Adj</th>
                <th>CPF 20%</th>
                <th>Net Payment</th>
                <th>Remarks</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['salary_sheets'] as $ss)
            <?php
            $absent_in_month = $ss->absent_in_month;
            $salary_for_the_month = $house_rent = $ma = $transport = $tax = $cpf_load_adj = $ecpf = $gross_total = $net_payment = 0;
            ?>
            <tr>
                <td>{{ $ss->full_name }}</td>
                <td>{{ $ss->Designation }}</td>
                <td>{{ $ss->basic_salary }}</td>
                <td>
                    <?php
                    if($absent_in_month == 0){
                        echo 'F.M.';
                    }else if($absent_in_month == 1){
                        echo '1day';
                    }else{
                        echo $absent_in_month . 'days';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    
                    $salary_for_the_month = $ss->basic_salary - ($absent_in_month * $ss->cut_basic_salary_per_day_for_absent_in_tk);
                    echo $salary_for_the_month;
                    ?>
                </td>
                <td>
                    <?php
                    $house_rent_in_percent = $ss->house_rent_of_basic_salary_in_percent > 0 ? 1 : 0;
                    if($house_rent_in_percent == 1){
                        $house_rent = (($ss->house_rent_of_basic_salary_in_percent * $ss->basic_salary) / 100) - ($absent_in_month * $ss->cut_house_rent_per_day_for_absent_in_tk);
                    }else{
                        $house_rent = $ss->house_rent_of_basic_salary_in_percent - ($absent_in_month * $ss->cut_house_rent_per_day_for_absent_in_tk);
                    }
                    echo $house_rent;
                    ?>
                </td>
                <td>
                    <?php
                    $ma_in_percent = $ss->medical_allowance_of_basic_salary_in_percent > 0 ? 1 : 0;
                    if($ma_in_percent == 1){
                        $ma = (($ss->medical_allowance_of_basic_salary_in_percent * $ss->basic_salary) / 100) - ($absent_in_month * $ss->cut_medical_allowance_per_day_for_absent_in_tk);
                    }else{
                        $ma = $ss->medical_allowance_of_basic_salary_in_tk - ($absent_in_month * $ss->cut_medical_allowance_per_day_for_absent_in_tk);
                    }
                    echo $ma;
                    ?>
                </td>
                <td>
                    <?php
                    $transport_in_percent = $ss->transport_cost_of_basic_salary_in_percent > 0 ? 1 : 0;
                    if($transport_in_percent == 1){
                        $transport = (($ss->transport_cost_of_basic_salary_in_percent * $ss->basic_salary) / 100) - ($absent_in_month * $ss->cut_transport_cost_per_day_for_absent_in_tk);
                    }else{
                        $transport = $ss->transport_cost_of_basic_salary_in_tk - ($absent_in_month * $ss->cut_transport_cost_per_day_for_absent_in_tk);
                    }
                    echo $transport;
                    ?>
                </td>
                <td>
                    <?php
                    $ecpf = ($salary_for_the_month * 10) / 100;
                    echo $ecpf;
                    ?>
                </td>
                <td>
                <?php
                $gross_total = $salary_for_the_month + $house_rent + $ma + $transport;
                echo $gross_total;
                ?>
                </td>
                <td>
                    <?php
                    $tax = $ss->tax;
                    echo $tax;
                    ?>
                </td>
                <td>
                    <?php
                    $cpf_load_adj = $ss->cpf_loan_adj;
                    echo $cpf_load_adj;
                    ?>
                </td>
                <td>
                    <?php
                    $cpf = ($ss->cpf * 20) / 100;
                    echo $cpf;
                    ?>
                </td>
                <td>
                    <?php
                    $net_payment = $gross_total - ($tax + $cpf + $cpf_load_adj);
                    echo $net_payment;
                    ?>
                </td>
                <td>{{ $ss->remarks }}</td>
                <td><a target="_blank" href="{{ url(route('salarySheet::edit', array('salary_sheet_id' => $ss->salary_sheet_id ))) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Update</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
<!--</div>-->

@endif
