<?php
$monthArray = array(
    'Unknown', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
);
?>

<form id="student_payment_form">
    {{ csrf_field() }}
    <div class="table-responsive">
        <table class="table table-condensed table-bordered text-uppercase">
            <tbody>
                @if(isset($data['checkIsReceivedByBank']) && !empty($data['checkIsReceivedByBank']))
                <tr>
                    <td colspan="2">
                        Receipt No. : <strong><span class="badge">{{ $data['checkIsReceivedByBank'][0]->received_student_payment_id }}</span></strong>
                    </td>
                    <td>
                        Sl. No. : <strong>{{ $data['checkIsReceivedByBank'][0]->book_sl_no }}</strong>
                    </td>
                    <td>
                        DATE : <strong>{{ date('d-m-Y', strtotime($data['checkIsReceivedByBank'][0]->received_time)) }}</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        A/C No. : <strong>{{ $data['checkIsReceivedByBank'][0]->account_no }} at {{ $data['checkIsReceivedByBank'][0]->bank_name }}, {{ $data['checkIsReceivedByBank'][0]->branch_name }}</strong>
                    </td>
                </tr>
                @endif
                @if(Auth::user()->role_id == 8)
                @if(isset($data['checkIsReceivedByBank']))
            <input type="hidden" name="student_id" value="{{ $data['checkIsReceivedByBank'][0]->student_id }}">
            <input type="hidden" name="system_generated_student_id" value="{{ $data['checkIsReceivedByBank'][0]->system_generated_student_id }}">
            <input type="hidden" name="generated_month" value="{{ $data['checkIsReceivedByBank'][0]->generated_month }}">
            <input type="hidden" name="student_roll" value="{{ $data['checkIsReceivedByBank'][0]->student_roll }}">
            <input type="hidden" name="class_id" value="{{ $data['checkIsReceivedByBank'][0]->class_id }}">
            <input type="hidden" name="section_id" value="{{ $data['checkIsReceivedByBank'][0]->section_id }}">
            <input type="hidden" name="group_id" value="{{ $data['checkIsReceivedByBank'][0]->group_id }}">
            <tr>
                <td colspan="2">
                    NAME : <strong>{{ $data['checkIsReceivedByBank'][0]->student_name }}</strong>
                </td>
                <td>
                    ID : <strong>{{ $data['checkIsReceivedByBank'][0]->system_generated_student_id }}</strong>
                </td>
                <td>
                    MONTH : <strong>{{ $monthArray[$data['checkIsReceivedByBank'][0]->generated_month] }}</strong>
                </td>
            </tr>
            <tr>
                <td>
                    ROLL : <strong>{{ $data['checkIsReceivedByBank'][0]->student_roll }}</strong>
                </td>
                <td>
                    CLASS : <strong>{{ $data['checkIsReceivedByBank'][0]->ClassName }}</strong>
                </td>
                <td>
                    SECTION : <strong></strong>
                </td>
                <td>
                    GROUP : <strong>{{ $data['checkIsReceivedByBank'][0]->GroupName }}</strong>
                </td>
            </tr>
            @endif
            @elseif(Auth::user()->role_id == 9)
            @if(isset($data['studentDetails']))
            <input type="hidden" name="student_id" value="{{ $data['studentDetails']->student_id }}">
            <input type="hidden" name="system_generated_student_id" value="{{ $data['studentDetails']->system_generated_student_id }}">
            <input type="hidden" name="generated_month" value="{{ $data['paymentMonth'] }}">
            <input type="hidden" name="student_roll" value="{{ $data['studentDetails']->roll_no }}">
            <input type="hidden" name="class_id" value="{{ $data['studentDetails']->class_id }}">
            <input type="hidden" name="section_id" value="{{ $data['studentDetails']->section_id }}">
            <input type="hidden" name="group_id" value="{{ $data['studentDetails']->group_id }}">
			
			<input type="hidden" name="institute_branch_version_id" value="{{ $data['studentDetails']->institute_branch_version_id }}">
            <tr>
                <td colspan="2">
                    NAME : <strong>{{ $data['studentDetails']->student_name }}</strong>
                </td>
                <td>
                    ID : <strong id="studentId"></strong>
                </td>
                <td>
                    MONTH : <strong>{{ $monthArray[$data['paymentMonth']] }}</strong>
                </td>
            </tr>
            <tr>
                <td>
                    ROLL : <strong>{{ $data['studentDetails']->roll_no }}</strong>
                </td>
                <td>
                    CLASS : <strong>{{ $data['studentDetails']->ClassName }}</strong>
                </td>
                <td>
                    SECTION : <strong></strong>
                </td>
                <td>
                    GROUP : <strong>{{ $data['studentDetails']->GroupName }}</strong>
                </td>
            </tr>
            <script>
                document.getElementById('studentId').innerHTML = (document.getElementById("student_id").value);
            </script>
            @endif
            @else
            <tr>
                <td>MONTH : <strong id="monthName"></strong></td>
                <td>
                    CLASS : <strong id="className"></strong>
                </td>
                <td>
                    SECTION : <strong id="sectionName"></strong>
                </td>
                <td>
                    GROUP : <strong id="groupName"></strong>
                </td>

            </tr>
            <script>
                document.getElementById('monthName').innerHTML = (document.getElementById("generate_month").options[document.getElementById("generate_month").selectedIndex].text);
                document.getElementById('className').innerHTML = (document.getElementById("generate_class").options[document.getElementById("generate_class").selectedIndex].text);
                document.getElementById('sectionName').innerHTML = (document.getElementById("generate_section").options[document.getElementById("generate_section").selectedIndex].text);
                document.getElementById('groupName').innerHTML = (document.getElementById("generate_group").options[document.getElementById("generate_group").selectedIndex].text);
            </script>
            @endif
            <tr>
                <td colspan="4">
                    <div class="table-responsive">
                        <table class="table table-condensed table-bordered">
                            @if(Auth::user()->role_id == 8)
                            <thead  class="thead-inverse">
                                <tr>
                                    <th scope="row">SL. NO</th>
                                    <th scope="row">DETAILS</th>
                                    <th scope="row">AMOUNT</th>
                                </tr>
                            </thead>
                            @endif
                            <tbody>

                                <?php
                                if (isset($data['paymentDetails'])) {

                                    $slNo = 0;
                                    $grandTotal = 0;
                                    foreach ($data['paymentDetails'] as $pd) {
                                        ?>

                                        <tr class="info">
                                            @if(Auth::user()->role_id == 8)
                                            <td>{{ ++$slNo }}</td>											
                                            <td>{{ $pd->student_payment_name }}</td>             						
                                            <td class="text-right">{{ $pd->payment_amount }}</td>  
                                            @elseif(Auth::user()->role_id == 9)


                                            @endif
                                        </tr>
                                    </tbody>
                                    <?php
                                    $grandTotal += (int) $pd->payment_amount;
                                }
                            }

//                            if (isset($data['checkIsReceivedByBank']) && !empty($data['checkIsReceivedByBank'])) {
//
//                                $slNo = 0;
//                                $grandTotal = 0;
//                                foreach ($data['checkIsReceivedByBank'] as $pd) {
//                                    if (Auth::user()->role_id == 8) {
//                                        
                            ?>
<!--                                        <tr class="info">
                                    <td>{{ ++$slNo }}</td>
                                    <td>{{ $pd->student_payment_name }}</td>
                                    <td class="text-right">{{ $pd->payment_amount }}</td>
                                </tr>-->
                            <?php
//                                    }
//                                    $grandTotal += (int) $pd->payment_amount;
//                                }
//                            }
                            ?>
                            <script>
                                var grandTotal = '{{ $grandTotal }}';
                            </script>

<?php //echo '<br/><br/>';  ?>

                            <tr>
                                <td class="text-right" colspan="2"><strong>Total Amount</strong></td>
                                <td class="text-right"><strong>{{ number_format((float)$grandTotal, 2, '.', '') }}</strong></td>
                            </tr>

                            @if(Auth::user()->role_id == 8)

                            <tr>
                                <td class="text-right" colspan="2"><strong>Received Amount</strong></td>
                                <td class="text-right"><strong>
                                        @if(isset($data['checkIsReceivedByBank']) && !empty($data['checkIsReceivedByBank']))
                                        {{ $data['checkIsReceivedByBank'][0]->received_amount_by_bank }}
                                        @else
                                        @endif
                                    </strong></td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="2"><strong>Due</strong></td>
                                <td class="text-right"><strong>
                                        @if(isset($data['checkIsReceivedByBank']) && !empty($data['checkIsReceivedByBank']))
                                        {{ $grandTotal - $data['checkIsReceivedByBank'][0]->received_amount_by_bank }}
                                        @else
                                        @endif
                                    </strong>
                                </td>
                            </tr>
                            @if(isset($data['checkIsReceivedByBank']) && !empty($data['checkIsReceivedByBank']))
                            @if($data['checkIsReceivedByBank'][0]->confirm_by_school_user_id ==  Null && $data['checkIsReceivedByBank'][0]->confirm_time ==  Null)
                            <tr> 
                                <td colspan="3"><button id="confirmBtn" type="button" class="btn btn-success btn-sm btn-block">Confirm</button></td>
                            </tr>
                            @endif
                            @else
                            @endif

                            @elseif(Auth::user()->role_id == 9)
                            <tr>
                                <td class="text-right" colspan="2"><strong>Received Amount</strong></td>
                                <td class="text-right"><strong>
                                        @if(isset($data['checkIsReceivedByBank']) && !empty($data['checkIsReceivedByBank']))
                                        {{ $data['checkIsReceivedByBank'][0]->received_amount_by_bank }}</strong>
                                    @else
                                    <input type="text" id="received_amount" name="received_amount" class="form-control input-sm text-right"></td>
                                @endif

                            </tr>
                            <tr>
                                <td class="text-right" colspan="2"><strong>Due</strong></td>
                                <td class="text-right"><strong id="due_amount">
                                        @if(isset($data['checkIsReceivedByBank']) && !empty($data['checkIsReceivedByBank']))
                                        {{ $grandTotal - $data['checkIsReceivedByBank'][0]->received_amount_by_bank }}
                                        @else
                                        {{ number_format((float)$grandTotal, 2, '.', '') }}
                                        @endif
                                    </strong>
                                </td>
                            </tr>
                            @if(isset($data['checkIsReceivedByBank']) && !empty($data['checkIsReceivedByBank']))

                            @else
                            <tr>
                                <td class="text-right" colspan="2"><strong>Book Sl. No.</strong></td>
                                <td class="text-right"><input type="text" id="book_sl_no" name="book_sl_no" class="form-control input-sm text-right"></td>
                            </tr>
                            @if(Auth::user()->user_id == 444 || Auth::user()->user_id == 445 || Auth::user()->user_id == 446 || Auth::user()->user_id == 447)
                            <?php
                                $startDate = date("Y-m-d", strtotime("10/25/2016"));
                                $endDate = date("Y-m-d", strtotime("12/31/2016"));
                                $todayDate = date("Y-m-d");
                                $todayDate = date("Y-m-d", strtotime($todayDate));
                                if(($todayDate > $startDate) && ($todayDate < $endDate))
                                {
                            ?>
                            <tr>
                                <td class="text-right" colspan="2"><strong>Received Date</strong></td>
                                <td class="text-right"><input type="text" id="received_date" name="received_date" class="form-control input-sm text-right" readonly="readonly" value=""></td>
                            </tr>
                                <?php } ?>
                            @endif
                            <tr>
                                <td colspan="3"><button type="button" class="btn btn-success btn-sm btn-block" id="payBtn">Pay</button></td>
                                @endif

                            </tr>
                            @else



                            @endif

                        </table>
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="4" class="text-uppercase">IN WORDS : <strong>{{ convert_number_to_words($grandTotal) }} only.</strong></td>
            </tr>

            </tbody>

        </table>
    </div>
</form>
<script>

    $(function () {
        $("#received_date").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            maxDate: new Date(<?php echo date("Y,12,d"); ?>)
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


    });
</script>
<?php

function convert_number_to_words($number) {

    $hyphen = '-';
    $conjunction = ' and ';
    $separator = ', ';
    $negative = 'negative ';
    $decimal = ' point ';
    $dictionary = array(
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
        20 => 'twenty',
        30 => 'thirty',
        40 => 'fourty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety',
        100 => 'hundred',
        1000 => 'thousand',
        1000000 => 'million',
        1000000000 => 'billion',
        1000000000000 => 'trillion',
        1000000000000000 => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens = ((int) ($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}
