<html>
<head>
<title>ProbasePay</title>
</head>
<body>
Do Not Refresh This Page!!!

<body onload="javascript:document.SubmitPayForm.submit()">
<div style="font-size:14px;"><strong>Re-Loading Payment Gateway!!!</strong></div>
<form autocomplete="off" accept-charset="UTF-8" action="/payments/init" method="post" name="SubmitPayForm" id="SubmitRemitaForm" >
	<input name="merchantId" value="{{$params['merchantId']}}" type="hidden">
	<input name="deviceCode" value="{{$params['deviceCode']}}" type="hidden">
	<input name="serviceTypeId" value="{{$params['serviceTypeId']}}" type="hidden">
	<input name="orderId" value="{{$params['orderId']}}" type="hidden">
	<input name="hash" value="{{$params['hash']}}" type="hidden">
	<input name="payerName" value="{{$params['payerName']}}" type="hidden">
	<input name="payerEmail" value="{{$params['payerEmail']}}" type="hidden">
	<input name="payerPhone" value="{{$params['payerPhone']}}" type="hidden">
	<input name="narration" value="{{isset($params['narration']) ? $params['narration'] : ''}}" type="hidden">
@if(isset($params['currency']))
	<input name="currency" value="{{$params['currency']}}" type="hidden">
@endif
@if(isset($params['probasepay_wallet_customer_verification_no']))
	<input name="probasepay_wallet_customer_verification_no" value="{{$params['probasepay_wallet_customer_verification_no']}}" type="hidden">
@endif
@if(isset($params['hashForWallet']))
	<input name="hashForWallet" value="{{$params['hashForWallet']}}" type="hidden">
@endif
@if(isset($params['hashForWalletStr']))
	<input name="hashForWalletStr" value="{{$params['hashForWalletStr']}}" type="hidden">
@endif
	@foreach($params['amount'] as $amt)
		<input name="amount[]" value="{{$amt}}" type="hidden">
	@endforeach
	@foreach($params['paymentItem'] as $paymentItem)
		<input name="paymentItem[]" value="{{$paymentItem}}" type="hidden">
	@endforeach
	<input name="responseurl" value="{{$params['responseurl']}}" type="hidden">
	<input style="display:none" type ="submit" name="submit_btn" value="">
	
	<!--Specifically for school fees payment-->
	<input name="payerId" value="{{$params['payerId']}}" type="hidden"><!--Student Id-->
	<input name="nationalId" value="{{$params['nationalId']}}" type="hidden"><!--national Id-->
	<input name="scope" value="{{$params['scope']}}" type="hidden"><!--Term of school-->
	<input name="description" value="{{$params['description']}}" type="hidden"><!--description-->
	
	<input name="payment_options" value="{{$params['payment_options']}}" type="hidden">
	
	@if(isset($params['merchant_defined_data']))
	    @foreach($params['merchant_defined_data'] as $k)
	        <input name="{{$k['name']}}" value="{{$k['value']}}" type="hidden">
	    @endforeach
	@endif
	
	@if(isset($params['bank_count']))
	    <input name="bank_count" value="{{$params['bank_count']}}" type="hidden">
	    @for($i1=0; $i1<$params['bank_count']; $i1++)
	        <?php
	        $bankKey = 'bank_code_'.($i1+1);
	        ?>
	        <input name="bank_code_{{($i1+1)}}" value="{{$params[$bankKey]}}" type="hidden">
	    @endfor
	@endif
	
	
	
	@if(isset($str_error) && $str_error!=null)
	    <input name="str_error" value="{{$str_error}}" type="hidden">
	@endif
</form>
</body>
</html>