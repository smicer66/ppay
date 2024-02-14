<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
{{--{!! HTML::style('css/questionstemplate.css') !!}--}}
<table>
    <tr>
        <td colspan="10" style="font-size:20px; font-weight:bold">Bank Transactions - {{$status_type}}</td>
    </tr>
    <tr class="info">
        <td colspan="1" style="font-weight: bold">Payout Date</td>
        <td colspan="9" style="font-weight: bold">{!! isset($payoutDate) && $payoutDate!=NULL ? $payoutDate : "N/A" !!}</td>
    </tr>
    <tr class="info">
        <td colspan="1" style="font-weight: bold">Bank</td>
        <td colspan="9" style="font-weight: bold">{!! isset($bankName) && $bankName!=NULL ? $bankName : "N/A" !!}</td>
    </tr>


    <tr>
        <td>&nbsp;</td>
        <td colspan="9" style="color:  #ff0084;"><b>Help info: </b>Each Payment Transaction Is Listed One Row after Another</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="9" style="color:  #ff0084;"><b>Help info: </b>Do Not Tamper With The Amount Column For Each of the Line Transactions</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="9" style="color:  #ff0084;"><b>Help info: </b>Indicate Merchants Paid In Using The Last Column</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="9" style="color:  #ff0084;"><b>Help info: </b>Indicate Merchants Paid by Typing YES/NO</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="9" style="color:  #ff0084;"><b>Help info: </b>On Payout, Upload this Spreadsheet to Complete the Payout Process</td>
    </tr>
    <tr>
        <td style="width: 10px;">&nbsp;</td>
    </tr>
    <tr class="info header">
        <td style="width: 10px; background-color: #9BBB59"><b>S/No</b></td>
        <td style="width: 20px; background-color: #9BBB59"><b>Transaction Ref</b></td>
        <td style="width: 30px; background-color: #9BBB59"><b>Transaction Date</b></td>
        <td style="width: 20px; background-color: #9BBB59"><b>Channel</b></td>
        <td style="width: 30px; background-color: #9BBB59"><b>Merchant Name</b></td>
        <td style="width: 20px; background-color: #9BBB59"><b>Merchant Code</b></td>
        <td style="width: 25px; background-color: #9BBB59"><b>Bank</b></td>
        <td style="width: 20px; background-color: #9BBB59"><b>Bank Account No</b></td>
        <td style="width: 20px; background-color: #9BBB59"><b>Amount</b></td>
        <td style="width: 20px; background-color: #9BBB59"><b>Total Amount</b></td>
        <td style="width: 10px; background-color: #9BBB59"><b>Paid Out?</b></td>
    </tr>

    <tbody>
    <?php $i = 1; $total =0; ?>
    @foreach($transactionList as $transaction)
        <?php $total = $total + $transaction->amount; ?>
        @if(isset($transaction->merchantId))
        <tr>
            <td class="text" style="background-color:#{{($i%2==0 ? 'C4DBFD' : '00B0F0')}}; border:#666666 1px solid">{{$i}}</td>
            <td class="text" style="background-color:#{{($i%2==0 ? 'C4DBFD' : '00B0F0')}}">{{"#".$transaction->transactionRef}}</td>
            <td class="text" style="background-color:#{{($i%2==0 ? 'C4DBFD' : '00B0F0')}}">{{$transaction->transactionDate}}</td>
            <td class="text" style="background-color:#{{($i%2==0 ? 'C4DBFD' : '00B0F0')}}">{{$transaction->channel}}</td>
            <td class="text" style="background-color:#{{($i%2==0 ? 'C4DBFD' : '00B0F0')}}">{{isset($transaction->merchantName) ? $transaction->merchantName : ""}}</td>
            <td class="text" style="background-color:#{{($i%2==0 ? 'C4DBFD' : '00B0F0')}}">{{isset($transaction->merchantCode) ? $transaction->merchantCode : ""}}</td>
            <td class="text" style="background-color:#{{($i%2==0 ? 'C4DBFD' : '00B0F0')}}">{{isset($transaction->merchantBank) ? $transaction->merchantBank : ""}}</td>
            <td class="text" style="background-color:#{{($i%2==0 ? 'C4DBFD' : '00B0F0')}}">{{isset($transaction->merchantAccount) ? $transaction->merchantAccount : ""}}</td>
            <td class="text" style="background-color:#{{($i%2==0 ? 'C4DBFD' : '00B0F0')}}">{{$transaction->amount}}</td>
            <td class="text" style="background-color:#{{($i%2==0 ? 'C4DBFD' : '00B0F0')}}">{{$total}}</td>
            <td class="text" style="background-color:#{{($i%2==0 ? 'C4DBFD' : '00B0F0')}}">NO</td>
            <?php $i++; ?>
        </tr>
        @endif
    @endforeach
    </tbody>
</table>
</html>