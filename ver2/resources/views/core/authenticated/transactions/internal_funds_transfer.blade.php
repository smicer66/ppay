
<div aria-hidden="true" class="onboarding-modal modal fade animated" role="dialog" tabindex="-1" id="internal_funds_transfer_overview_modal">
    <div class="modal-dialog modal-centered" role="document">
        <div class="modal-content text-center">
            <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span class="os-icon os-icon-close"></span></button>
            <table style="width: 100%;">
                <tr>
                    <td style="background-color: #fff; text-align: left !important; padding-left: 20px !important">
                        <img alt="" src="img/logo.png" style="width: 70px; padding: 20px; padding-left: 0px !important;">
                    </td>
                    <td style="padding-left: 50px; text-align: right; padding-right: 20px;">
                        <a href="#" style="color: #261D1D; text-decoration: underline; font-size: 14px; letter-spacing: 1px;"></a><a href="#" style="color: #7C2121; text-decoration: underline; font-size: 14px; margin-left: 20px; letter-spacing: 1px;"></a>
                    </td>
                </tr>
            </table><img alt="" src="img/email-header-img.jpg" style="max-width: 100%; height: auto;">
            <div style="padding: 30px 30px;">

                <h2 style="margin-top: 0px;">
                    Transfer Money
                </h2>
                <div style="color: #636363; font-size: 14px;">
                    <form id="transferFundsForm" data-toggle="validator" autocomplete="off" method="post" enctype="application/x-www-form-urlencoded">
                        <div class="col-md-12 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Transfer Type: <span style="color:red">*</span></label><br>
                            <div class="" id="transferTypeDiv">
                                <select class="form-control" name="internalFundsTransferTransferType" id="internalFundsTransferTransferType" required>
                                    <option value=>--Select Option--</option>
                                    <option value="WALLET_TO_WALLET">From My Wallet To Another Wallet</option>
                                    <option value="WALLET_TO_CARD">From My Wallet To A Card</option>
                                    <option value="CARD_TO_WALLET">From My Card To Another Wallet</option>
                                    <option value="CARD_TO_CARD">From My Card To Another Card</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 internalFundsTransferTransferReceipientTypeComponent" id="sourceCardTransferFromCardDiv"
                             style="display: none !important; text-align: left !important; float: left !important; padding-top: 20px !important"><label>Transfer From: <span style="color:red">*</span></label><br>
                            <div class="" id="transferFromDiv">
                                <select class="form-control" name="internalFundsTransferTransferTypeundsTransferTransferFromCard" id="internalFundsTransferTransferTypendsTransferTransferFromCard">
                                    @foreach($cards as $card)
                                        <option value="{{$card->trackingNumber}}|||{{$card->serialNo}}">{{$card->nameOnCard}} - {{$card->pan}} ({{$currencyList[$card->currency]}} {{number_format($card->cardBalance, 2, '.', ',')}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 internalFundsTransferTransferReceipientTypeComponent" id="transferAmount"
                             style="display: none !important; text-align: left !important; float: left !important; padding-top: 20px !important"><label>Amount: <span style="color:red">*</span></label><br>
                            <div class="singleTransfer" id="internalTransferAmountDiv">
                                <input class="form-control" required name="internalFundsTransferTransferAmount" id="internalFundsTransferTransferAmount" type="number" required>
                            </div>
                        </div>

                        <div class="col-md-6 internalFundsTransferTransferReceipientTypeComponent receipientCardDiv" id="recCardNumberDiv"
                             style="display: none !Important; text-align: left !important; float: left !important; padding-top: 20px !important"><label>Receipient Card Number: <span style="color:red">*</span></label><br>
                            <div class="singleTransfer " id="internalReceipientCardDiv">
                                <input class="form-control" name="internalFundsTransferTransferCardTrackingId" id="internalFundsTransferTransferCardTrackingId" type="number">
                            </div>
                        </div>

                        <div class="col-md-6 internalFundsTransferTransferReceipientTypeComponent receipientCardDiv" id="recWalletNumberDiv"
                             style="display: none !Important; text-align: left !important; float: left !important; padding-top: 20px !important"><label>Receipient Wallet Number: <span style="color:red">*</span></label><br>
                            <div class="singleTransfer " id="internalReceipientWalletDiv">
                                <input class="form-control" name="internalFundsTransferTransferWalletNumber" id="internalFundsTransferTransferWalletNumber" type="number">
                            </div>
                        </div>


                        <div class="col-md-12 internalFundsTransferTransferReceipientTypeComponent" id="transferDetailsDiv" style="display: none !important; text-align: left !important; float: left !important; padding-top: 20px !important"><label>Details: </label><br>
                            <div class="singleTransfer" id="internalInternalDetailsDiv">
                                <input class="form-control" name="internalFundsTransferTransferDetails" id="internalFundsTransferTransferDetails" type="text">
                            </div>
                        </div>



                        <div class="col-md-12 " style="text-align: center !important; float: left !important; padding-top: 20px !important">
                            <a onclick="doFundsTransferToSingleReceipient('{{\Session::get('jwt_token')}}')" style="clear: both !important; padding: 5px 15px; background-color: #4B72FA; color: #fff; font-weight: bolder; font-size: 14px; display: inline-block; margin: 20px 0px; margin-right: 20px; text-decoration: none;">Confirm Transfer</a>
                        </div>
                    </form>
                </div>




            </div>

            @if(isset($wallet) && $wallet!=null)
                <div style="background-color: #F5F5F5; padding: 40px; text-align: center;">
                    <div style="margin-bottom: 20px;">
                        <a href="#" style="display: inline-block; margin: 0px 10px;"><img alt="" src="img/social-icons/twitter.png" style="width: 28px;"></a><a href="#" style="display: inline-block; margin: 0px 10px;"><img alt="" src="img/social-icons/facebook.png" style="width: 28px;"></a><a href="#" style="display: inline-block; margin: 0px 10px;"><img alt="" src="img/social-icons/linkedin.png" style="width: 28px;"></a><a href="#" style="display: inline-block; margin: 0px 10px;"><img alt="" src="img/social-icons/instagram.png" style="width: 28px;"></a>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <a href="#" style="text-decoration: underline; font-size: 14px; letter-spacing: 1px; margin: 0px 15px; color: #261D1D;">Contact Us</a><a href="#" style="text-decoration: underline; font-size: 14px; letter-spacing: 1px; margin: 0px 15px; color: #261D1D;">Privacy Policy</a><a href="#" style="text-decoration: underline; font-size: 14px; letter-spacing: 1px; margin: 0px 15px; color: #261D1D;">Unsubscribe</a>
                    </div>
                    <div style="color: #A5A5A5; font-size: 12px; margin-bottom: 20px; padding: 0px 50px;">
                        You are receiving this email because you signed up for Light Admin. We use Light Admin to send our emails
                    </div>
                    <div style="margin-bottom: 20px;">
                        <a href="#" style="display: inline-block; margin: 0px 10px;"><img alt="" src="img/market-google-play.png" style="height: 33px;"></a><a href="#" style="display: inline-block; margin: 0px 10px;"><img alt="" src="img/market-ios.png" style="height: 33px;"></a>
                    </div>
                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(0,0,0,0.05);">
                        <div style="color: #A5A5A5; font-size: 10px; margin-bottom: 5px;">
                            1073 Madison Ave, suite 649, New York, NY 10001
                        </div>
                        <div style="color: #A5A5A5; font-size: 10px;">
                            Copyright 2018 Light Admin template. All rights reserved.
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>



