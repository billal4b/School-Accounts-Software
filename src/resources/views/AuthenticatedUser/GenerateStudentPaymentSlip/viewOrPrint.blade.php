<?php
$monthArray = array(
    0, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
);
?>


<form id="student_payment_form">
    {{ csrf_field() }}
    <div class="table-responsive">
        <table class="table table-condensed table-bordered text-uppercase">
            <tbody>

                @if(Auth::user()->role_id == 8)

                @if(isset($data['checkIsReceivedByBank']) && !empty($data['checkIsReceivedByBank']))
                <?php
                //echo '<pre>';print_r($data['checkIsReceivedByBank']);echo '</pre>';exit();
                ?>
            <input type="hidden" id="class_id" name="class_id" value="{{ $data['checkIsReceivedByBank'][0]->class_id }}">
            <input type="hidden" id="group_id" name="group_id" value="{{ $data['checkIsReceivedByBank'][0]->group_id }}">
            <input type="hidden" id="section_id" name="section_id" value="{{ $data['checkIsReceivedByBank'][0]->section_id }}">
            <input type="hidden" id="ibv_id" name="ibv_id" value="{{ $data['checkIsReceivedByBank'][0]->institute_branch_version_id }}">
            <input type="hidden" id="student_id" name="system_generated_student_id" value="{{ $data['checkIsReceivedByBank'][0]->system_generated_student_id }}">
            <input type="hidden" id="actual_student_id" name="student_id" value="{{ $data['checkIsReceivedByBank'][0]->student_id }}">
            <input type="hidden" id="" name="receipt_no" value="{{ $data['checkIsReceivedByBank'][0]->received_student_payment_id }}">
			<input type="hidden" id="" name="received_time" value="{{ $data['checkIsReceivedByBank'][0]->received_time }}">
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
                    <td colspan="3">
                        NAME : <strong>{{ $data['checkIsReceivedByBank'][0]->student_name }}</strong>
                    </td>
                    <td>
                        ID : <strong>{{ $data['checkIsReceivedByBank'][0]->system_generated_student_id }}</strong>
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

                <tr class="info">
                    <td colspan="4">CASH IN HANDS : <strong id="cashInHands">{{ $data['checkIsReceivedByBank'][0]->cash_in_hands }} ({{ convert_number_to_words($data['checkIsReceivedByBank'][0]->cash_in_hands) }})</strong></td>
                </tr>

                <tr>
                    <td colspan="3">
                        <div class="form-group">
                            <label for="monthSelect" class="col-sm-2 control-label">Month</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="monthSelect" name="monthSelect">
                                    <option value="" selected="">Select</option>
                                    @foreach($monthArray as $key => $value)
                                    @if($key != 0)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </td>
                <input type="hidden" id="tempCashInHands" value="0">
                    <td id="availableCashInHands"></td>
                </tr>
                <tr>
                    <td colspan="4" id="viewMonthWiseStudentPaymentHeads"></td>
                </tr>
    <!--                <tr>
                        <td colspan="4">
                            A/C No. : <strong>{{ $data['checkIsReceivedByBank'][0]->account_no }} at {{ $data['checkIsReceivedByBank'][0]->bank_name }}, {{ $data['checkIsReceivedByBank'][0]->branch_name }}</strong>
                        </td>
                    </tr>-->
                @endif

                @elseif(Auth::user()->role_id == 9)

                @if(isset($data['checkIsReceivedByBank']) && !empty($data['checkIsReceivedByBank']))
                <tr>
                    <td colspan="2">
                        Receipt No. : <strong><span class="badge">{{ $data['checkIsReceivedByBank'][0]->received_student_payment_id }}</span></strong>
                    </td>
                    <td class="info">
                        Sl. No. : <strong>{{ $data['checkIsReceivedByBank'][0]->book_sl_no }}</strong>
                    </td>
                    <td>
                        DATE : <strong>{{ date('d-m-Y', strtotime($data['checkIsReceivedByBank'][0]->received_time)) }}</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        NAME : <strong>{{ $data['checkIsReceivedByBank'][0]->student_name }}</strong>
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
    <!--                <tr>
                        <td colspan="4">
                            A/C No. : <strong>{{ $data['checkIsReceivedByBank'][0]->account_no }} at {{ $data['checkIsReceivedByBank'][0]->bank_name }}, {{ $data['checkIsReceivedByBank'][0]->branch_name }}</strong>
                        </td>
                    </tr>-->
                @endif

                @if(isset($data['studentDetails']))
            <input type="hidden" name="student_id" value="{{ $data['studentDetails']->student_id }}">
            <input type="hidden" name="system_generated_student_id" value="{{ $data['studentDetails']->system_generated_student_id }}">
            <input type="hidden" name="class_id" value="{{ $data['studentDetails']->class_id }}">
            <input type="hidden" name="group_id" value="{{ $data['studentDetails']->group_id }}">
            <input type="hidden" name="section_id" value="{{ $data['studentDetails']->section_id }}">

            <input type="hidden" name="institute_branch_version_id" value="{{ $data['studentDetails']->institute_branch_version_id }}">
            <tr>
                <td colspan="4">
                    NAME : <strong>{{ $data['studentDetails']->student_name }}</strong>
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
            @endif

            @endif

            @if(Auth::user()->role_id == 9)


            <tr>
                <td class="text-right" colspan="3"><strong>Received Amount</strong> 
                    @if(isset($data['checkIsReceivedByBank']) && !empty($data['checkIsReceivedByBank']))
                    @else
                    <sup><i class="fa fa-asterisk"></i></sup>
                    @endif
                </td>
                <td class="text-right {{ (isset($data['checkIsReceivedByBank']) && !empty($data['checkIsReceivedByBank'])) ? "info" : "" }}">
                    @if(isset($data['checkIsReceivedByBank']) && !empty($data['checkIsReceivedByBank']))
                    <strong>{{ $data['checkIsReceivedByBank'][0]->received_amount_by_bank }}</strong>
                    @else
                    <input type="text" id="received_amount" name="received_amount" class="form-control input-sm text-right">
                    @endif
                </td>

            </tr>

            @if(isset($data['checkIsReceivedByBank']) && !empty($data['checkIsReceivedByBank']))
            @else
            <tr>
                <td class="text-right" colspan="3"><strong>Book Sl. No.</strong> <sup><i class="fa fa-asterisk"></i></sup></td>
                <td class="text-right">
                    <input type="text" id="book_sl_no" name="book_sl_no" class="form-control input-sm text-right">
                </td>
            </tr>
            @endif

            @if(isset($data['checkIsReceivedByBank']) && !empty($data['checkIsReceivedByBank']))
            @else
            @if(Auth::user()->user_id == 444 || Auth::user()->user_id == 445 || Auth::user()->user_id == 446 || Auth::user()->user_id == 447)
                <?php
                $startDate = date("Y-m-d", strtotime("11/04/2016"));
                $endDate = date("Y-m-d", strtotime("12/21/2017"));
                $todayDate = date("Y-m-d");
                $todayDate = date("Y-m-d", strtotime($todayDate));
                if(($todayDate > $startDate) && ($todayDate < $endDate))
                {
                ?>
                <tr>
                    <td class="text-right" colspan="3"><strong>Received Date</strong></td>
                    <td class="text-right"><input type="text" id="received_date" name="received_date" class="form-control input-sm text-right" readonly="readonly" value=""></td>
                </tr>
                <?php } ?>
            @endif
            @endif


            <tr>
                @if(isset($data['checkIsReceivedByBank']) && !empty($data['checkIsReceivedByBank']))
                <td colspan="4" class="text-uppercase">IN WORDS : <strong>{{ convert_number_to_words($data['checkIsReceivedByBank'][0]->received_amount_by_bank) }} only.</strong></td>
                @else
                <td colspan="4"><button type="button" class="btn btn-success btn-sm btn-block" id="payBtn">Pay</button></td>
                @endif
            </tr>


            @endif

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
