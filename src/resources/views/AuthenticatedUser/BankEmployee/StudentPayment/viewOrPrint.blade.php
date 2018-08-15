<?php
$monthArray = array(
    'Unknown', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
);
//=ig{g{[VJ_Bm
?>

<div class="table-responsive">
    <table class="table table-condensed table-bordered text-uppercase">
        <tbody>
            @if(isset($data['studentDetails']))
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
                        <thead>
                            <tr>
                                <th>SL. NO</th>
                                <th>DETAILS</th>
                                <th>AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($data['paymentDetails'])) {
                                $slNo = 0;
                                $grandTotal = 0;
                                foreach ($data['paymentDetails'] as $pd) {
                                    ?>
                            <tr class="info">
                                        <td>{{ ++$slNo }}</td>
                                        <td>{{ $pd->student_payment_name }}</td>
                                        <td class="text-right">{{ $pd->payment_amount }}</td>
                                    </tr>
                                    <?php
                                    $grandTotal += $pd->payment_amount;
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="2"><strong>TOTAL</strong></td>
                                <td class="text-right"><strong>{{ number_format((float)$grandTotal, 2, '.', '') }}</strong></td>
                            </tr>
                            
                            @if(Auth::user()->role_id == 9){
                            <tr>
                                <td class="text-right" colspan="2"><strong>Received Amount</strong></td>
                                <td class="text-right"><input type="text" id="received_amount" name="received_amount" class="form-control input-sm"></td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="2"><strong>Due</strong></td>
                                <td class="text-right"><strong id="due_amount">{{ number_format((float)$grandTotal, 2, '.', '') }}</strong></td>
                            </tr>
                            @endif
                        </tfoot>
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