<div class="holder" style="border: 0px solid #000">
    <div class="reserve-box mt-30" style="position: relative !important; border: 0px double #EBE9E8; margin-bottom: 0px !important">
        <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="text-transform: uppercase;
            background: #DB3944;
            color: #FFF;
            line-height: 1;
            margin: 0;
            margin-top: -3px;
            padding: 15px 23px; ">
            <div style="float: left !important; " class="col col-md-5 col-sm-5 col-lg-5 col-xs-5"><h5 style="padding: 0px !Important; margin-top: 0px !important; float: left !important">ProbasePay</h5></div>
            <div style="float: right !important; text-align:right !Important; font-size: 11px !important" class="col col-md-7 col-sm-7 col-lg-7 col-xs-7"><small>{{strtoupper($orderId)}}<br>Order Ref</small></div>

        </div>
        <div style="clear: both !important; padding-left: 0px !important; padding-right: 0px !important" class="container-fluid invoice-container" id="section-to-print" style="margin-left:0px !important; margin-right: 0px !important;">


           


            <form  name="SubmitCyberSourceForm" id="SubmitCyberSourceForm"  action="/api/confirm-cybersource-data" method="post">
                <input type="hidden" name="access_key" value="{{$params['access_key']}}">
                <input type="hidden" name="profile_id" value="{{$params['profile_id']}}">
                <input type="hidden" name="transaction_uuid" value="{{$params['transaction_uuid']}}">
                <input type="hidden" name="signed_field_names" value="access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency">
                <input type="hidden" name="unsigned_field_names">
                <input type="hidden" name="signed_date_time" value="{{$params['signed_date_time']}}">
                <input type="hidden" name="locale" value="{{$params['locale']}}">
                <input type="hidden" value="{{$params['transaction_type']}}" name="transaction_type" size="25"><br/>
                <input type="hidden" value="{{$params['reference_number']}}" name="reference_number" size="25"><br/>
                <input type="hidden" value="{{$params['amount']}}" name="amount" size="25"><br/>
                <input type="hidden" value="{{$params['currency']}}" name="currency" size="25"><br/>
            </form>

        </div>
    </div>
</div>

<script type="text/javascript" src="/v2/js/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="/js/payment_form.js?x={{mt_rand(10, 100)}}"></script>
