
<div aria-hidden="true" class="onboarding-modal modal fade animated" role="dialog" tabindex="-1" id="funds_transfer_overview_modal">
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
                <form method="post" id="ftformToBeneficiary">
                    <div style="color: #636363; font-size: 14px;">
                        <div class="col-md-12 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Single or Multiple Recepients: </label><br>
                            <div class="" id="transferTypeDiv">
                                <select class="form-control" name="fundsTransferTransferType" id="fundsTransferTransferType" required>
                                    <option value="SINGLE_TRANSFER">Single Receipient</option>
                                    <option value="MULTIPLE_TRANSFER">Multiple Receipient</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Transfer From: </label><br>
                            <div class="" id="transferFromDiv">
                                <select class="form-control" name="fundsTransferTransferFromCard" id="fundsTransferTransferFromCard" required>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Amount: </label><br>
                            <div class="singleTransfer" id="transferAmountDiv">
                                <input class="form-control" name="fundsTransferTransferAmount" id="fundsTransferTransferAmount" type="number" required>
                            </div>
                        </div>

                        <div class="col-md-6 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Receipient Type: </label><br>
                            <div class="singleTransfer" id="receipientTypeDiv">
                                <select class="form-control" name="fundsTransferTransferReceipientType" id="fundsTransferTransferReceipientType" required>
                                    <option value="BANK">Transfer to Bank</option>
                                    <option value="MOBILE">Transfer to Mobile Money</option>
                                    <option value="BEVURA WALLET">Transfer to Bevura Wallet</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Details: </label><br>
                            <div class="singleTransfer" id="detailsDiv">
                                <input class="form-control" name="fundsTransferTransferDetails" id="fundsTransferTransferDetails" type="text" required>
                            </div>
                        </div>

                        <div class="col-md-6 fundsTransferTransferReceipientTypeComponent transferToBank" style="display: none !Important; text-align: left !important; float: left !important; padding-top: 20px !important"><label>Receipients Bank: </label><br>
                            <div class="singleTransfer " id="receipientBankDiv">
                                <select class="form-control" name="fundsTransferTransferReceipientsBank" id="fundsTransferTransferReceipientsBank" required>
                                    <option value="BANK">Transfer to Bank</option>
                                    <option value="MOBILE">Transfer to Mobile Money</option>
                                    <option value="BEVURA WALLET">Transfer to Bevura Wallet</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 fundsTransferTransferReceipientTypeComponent transferToMobile" style="display: none !Important; text-align: left !important; float: left !important; padding-top: 20px !important"><label>Receipients Mobile Network: </label><br>
                            <div class="singleTransfer " id="receipientNetworkDiv">
                                <select class="form-control" name="fundsTransferTransferReceipientsNetwork" id="fundsTransferTransferReceipientsNetwork" required>
                                    <option value="MTN">Transfer to MTN Money</option>
                                    <option value="AIRTEL">Transfer to AIRTEL Money</option>
                                    <option value="ZAMTEL">Transfer to ZAMTEL Money</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 fundsTransferTransferReceipientTypeComponent transferToWallet" style="display: none !Important; text-align: left !important; float: left !important; padding-top: 20px !important"><label>Wallet Number: </label><br>
                            <div class="singleTransfer " id="fundsTransferTransferWalletNumberDiv">
                                <input class="form-control" name="fundsTransferTransferWalletNumber" id="fundsTransferTransferWalletNumber" type="number" required>
                            </div>
                        </div>

                        <div class="col-md-6 fundsTransferTransferReceipientTypeComponent transferToMobile" style="display: none !Important; text-align: left !important; float: left !important; padding-top: 20px !important"><label>Receipients Mobile Number: </label><br>
                            <div class="singleTransfer " id="transferMobileNumberDiv">
                                <input class="form-control" name="fundsTransferTransferMobileNumber" id="fundsTransferTransferMobileNumber" type="number" required>
                            </div>
                        </div>

                        <div class="col-md-6 fundsTransferTransferReceipientTypeComponent transferToBank" style="display: none !Important; text-align: left !important; float: left !important; padding-top: 20px !important"><label>Account Number: </label><br>
                            <div class="singleTransfer " id="transferAmountDiv">
                                <input class="form-control" name="fundsTransferTransferAccountNumber" id="fundsTransferTransferAccountNumber" type="text" required>
                            </div>
                        </div>

                        <div class="col-md-6 fundsTransferTransferReceipientTypeComponent transferToMobile" style="display: none !Important; text-align: left !important; float: left !important; padding-top: 20px !important"><label>Receipients Name: </label><br>
                            <div class="singleTransfer " id="transferAmountDiv">
                                <input class="form-control" name="fundsTransferTransferReceipientsName" id="fundsTransferTransferReceipientsName" type="text" required>
                            </div>
                        </div>

                        <div class="col-md-6 fundsTransferTransferReceipientTypeComponent transferToWallet" style="display: none !Important; text-align: left !important; float: left !important; padding-top: 20px !important"><label>Receipients Name: </label><br>
                            <div class="singleTransfer " id="fundsTransferTransferWalletNameDiv">
                                <input class="form-control" name="fundsTransferTransferWalletName" id="fundsTransferTransferWalletName" type="text" required>
                            </div>
                        </div>



                        <div class="col-md-12 " style="text-align: center !important; float: left !important; padding-top: 20px !important">
                            <a onclick="doFundsTransferToMultipleReceipients('{{\Session::get('jwt_token')}}')" style="cursor: pointer: important; clear: both !important; padding: 5px 15px; background-color: #4B72FA; color: #fff; font-weight: bolder; font-size: 14px; display: inline-block; margin: 20px 0px; margin-right: 20px; text-decoration: none;">Confirm Transfer</a>
                        </div>

                    </div>
                </form>



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



