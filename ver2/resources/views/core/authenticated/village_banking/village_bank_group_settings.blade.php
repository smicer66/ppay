
<div aria-hidden="true" class="onboarding-modal modal fade animated" role="dialog" tabindex="-1" id="village_bank_group_settings_modal">
    <div class="modal-dialog modal-centered village_bank_group_settings_modal village_bank_group_settings_modal1" role="document">
        <div class="modal-content text-center village_bank_group_settings_modal1">
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
                    Village Bank Group Settings
                </h2>
                <div class="col col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <small>Provide the cost and details of registration and membership if applicable.</small>
                </div>
                <form method="post" id="vbsettingsform">
                    <input type="hidden" value="" id="vbsettingsgroupId" name="vbsettingsgroupId">
                    <input type="hidden" value="" id="villageBankingGroupSettingsEncInfo" name="villageBankingGroupSettingsEncInfo">

                    <div style="color: #636363; font-size: 14px;">
                        <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Group Name: </label><br>
                            <div class="villageBankingGroupSettingsName" id="villageBankingGroupSettingsNameDiv">
                                &nbsp;
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Group Is Open: </label><br>
                            <div class="villageBankingGroupSettingsName" id="villageBankingGroupSettingsNameDiv">
                                <select class="form-control col col-md-12 col-xs-12 col-sm-12 col-lg-12" name="villageBankingSettingsRegistrationFeesCurrency" id="villageBankingSettingsRegistrationFeesCurrency" required>
                                    <option value="ZMW">To Everyone</option>
                                    <option value="ZMW">Only Invitees</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Rules & Constitution: </label><br>
                            <div class="villageBankingSettingsRules" id="villageBankingSettingsRulesDiv">
                                <textarea class="form-control" name="villageBankingSettingsRules" id="villageBankingSettingsRules"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Registration Fees If Applicable: </label><br>
                            <div class="villageBankingSettingsRegistrationFees col col-md-12 col-xs-12 col-sm-12 col-lg-12" style="padding-left: 0px !important; padding-right: 0px !important" id="villageBankingSettingsRegistrationFeesCurrencyDiv">
                                <div class="col col-md-5 col-xs-5 col-sm-5 col-lg-5" style="float: left !important; padding-left: 0px !important">
                                    <select class="form-control col col-md-12 col-xs-12 col-sm-12 col-lg-12" name="villageBankingSettingsRegistrationFeesCurrency" id="villageBankingSettingsRegistrationFeesCurrency" required>
                                        <option value="ZMW">ZMW</option>
                                    </select>
                                </div>
                                <div class="col col-md-7 col-xs-7 col-sm-7 col-lg-7" style="float: left !important; padding-left: 0px !important; padding-right: 0px !important">
                                    <input class="form-control col col-md-12 col-xs-12 col-sm-12 col-lg-12" name="villageBankingSettingsRegistrationFees" id="villageBankingSettingsRegistrationFees" placeholder="How Much" type="number" value="0"  required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Membership Fees If Applicable: </label><br>
                            <div class="villageBankingSettingsMembershipFees col col-md-12 col-xs-12 col-sm-12 col-lg-12" style="padding-left: 0px !important; padding-right: 0px !important" id="villageBankingSettingsMembershipFeesDiv">
                                <div class="col col-md-5 col-xs-5 col-sm-5 col-lg-5" style="float: left !important; padding-left: 0px !important">
                                    <select class="form-control col col-md-12 col-xs-12 col-sm-12 col-lg-12" name="villageBankingSettingsMembershipFeesCurrency" id="villageBankingSettingsMembershipFeesCurrency" required>
                                        <option value="ZMW">ZMW</option>
                                    </select>
                                </div>
                                <div class="col col-md-7 col-xs-7 col-sm-7 col-lg-7" style="float: left !important; padding-left: 0px !important; padding-right: 0px !important">
                                    <input class="form-control col col-md-12 col-xs-12 col-sm-12 col-lg-12" name="villageBankingSettingsMembershipFees" id="villageBankingSettingsMembershipFees" placeholder="How Much" type="number" value="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Pay Membership Dues: </label><br>
                            <div class="villageBankingSettingsMembershipFeesInterval col col-md-12 col-xs-12 col-sm-12 col-lg-12" style="padding-left: 0px !important; padding-right: 0px !important" id="villageBankingSettingsMembershipFeesIntervalDiv">
                                <select class="form-control col col-md-12 col-xs-12 col-sm-12 col-lg-12" name="villageBankingSettingsMembershipFeesIntervalType" id="villageBankingSettingsMembershipFeesIntervalType" required>
                                    <option value="-1">Not Applicable</option>
                                    <option value="ONCE">Pay Membership Fee Once</option>
                                    <option value="DAY">Pay Membership Fee Daily</option>
                                    <option value="WEEK">Pay Membership Fee Weekly</option>
                                    <option value="MONTH">Pay Membership Fee Monthly</option>
                                    <option value="YEAR">Pay Membership Fee Yearly</option>
                                </select>
                            </div>
                        </div>
                        <!--<div class="col-md-6 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Membership Due Amount: </label><br>
                            <div class="villageBankingSettingsMembershipFeesAmount col col-md-12 col-xs-12 col-sm-12 col-lg-12" style="padding-left: 0px !important; padding-right: 0px !important" id="villageBankingSettingsMembershipFeesAmountDiv">
                                <input class="form-control col col-md-12 col-xs-12 col-sm-12 col-lg-12" name="villageBankingSettingsMembershipFeesAmount" id="villageBankingSettingsMembershipFeesAmount" type="number" placeholder="Provide how much" value="0" required>
                            </div>
                        </div>-->

                        <div class="col-md-6 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Pay dues how many times: </label><br>
                            <div class="villageBankingSettingsMembershipFeesIntervalPeriod col col-md-9 col-xs-9 col-sm-9 col-lg-9" style="padding-left: 0px !important; padding-right: 0px !important; float: left !important" id="villageBankingSettingsMembershipFeesPeriodDiv">
                                <input class="form-control col col-md-12 col-xs-12 col-sm-12 col-lg-12" name="villageBankingSettingsMembershipFeesPeriod" id="villageBankingSettingsMembershipFeesPeriod" type="number" value="7" required>
                            </div>
                            <div class="villageBankingSettingsMembershipFeesIntervalPeriod col col-md-3 col-xs-3 col-sm-3 col-lg-3" style="text-align: right !important; padding-left: 5px !important; padding-top: 10px !important; padding-right: 0px !important; float: left !important" id="villageBankingSettingsMembershipFeesIntervalPeriodDiv">
                                times
                            </div>
                        </div>

                        
                        <!--<div class="col-md-6 col-sm-6 col-xs-6 col-lg-6 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Groups Funds Are: </label><br>
                            <div class="villageBankingGroupSettingsName" id="villageBankingGroupSettingsNameDiv">
                                <select class="form-control col col-md-12 col-xs-12 col-sm-12 col-lg-12" name="villageBankingSettingsRegistrationFeesCurrency" id="villageBankingSettingsRegistrationFeesCurrency" required>
                                    <option value="ZMW">Loaned To Members</option>
                                    <option value="ZMW">Invested with Fund Managers</option>
                                    <option value="ZMW">Loaned to Members and Invested with Fund Managers</option>
                                </select>
                            </div>
                        </div>-->

                        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 " style="padding-right: 0px !important; text-align: center !important; float: left !important; padding-top: 20px !important"><label>&nbsp; </label>
                            <a onclick="handleSaveGroupSettings('{{\Session::get('jwt_token')}}')" style="clear: both !important; padding: 5px 15px; background-color: #4B72FA; color: #fff; font-weight: bolder; font-size: 14px; display: inline-block; margin: 20px 0px; margin-right: 20px; text-decoration: none;">Save Settings</a>
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



