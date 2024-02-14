
<div aria-hidden="true" class="onboarding-modal modal fade animated" role="dialog" tabindex="-1" id="add_village_bank_group_modal">
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
                    New Village Bank Group
                </h2>
                <form method="post" id="newVillageBankGroupForm">
                    <div style="color: #636363; font-size: 14px;">
                        <div class="col-md-7 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Group Name: </label><br>
                            <div class="villageBankingGroupName" id="villageBankingGroupNameDiv">
                                <input class="form-control" name="villageBankingGroupName" id="villageBankingGroupName" type="text" required>
                            </div>
                        </div>
                        <div class="col-md-5 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Who Can Join Group: </label><br>
                            <div class="villageBankingGroupName" id="villageBankingGroupNameDiv">
                               <select class="form-control col col-md-12 col-xs-12 col-sm-12 col-lg-12" name="isOpen" id="isOpen" required>
                                    <option value="1">Anyone</option>
                                    <option value="0">Only Invited People</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-12 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Physical Contact Address of Group: </label><br>
                            <div class="villageBankingContactAddress" id="villageBankingContactAddressDiv">
                                <input class="form-control" name="villageBankingContactAddress" id="villageBankingContactAddress" type="text" required>
                            </div>
                        </div>
                        <div class="col-md-7 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Contact Mobile Number: </label><br>
                            <div class="villageBankingMobileNumber col col-md-12 col-xs-12 col-sm-12 col-lg-12" style="padding-left: 0px !important; padding-right: 0px !important" id="villageBankingMobileNumberDiv">
                                <div class="col col-md-5 col-xs-5 col-sm-5 col-lg-5" style="float: left !important; padding-left: 0px !important">
                                    <select class="form-control col col-md-12 col-xs-12 col-sm-12 col-lg-12" name="villageBankingMobileNumberCode" id="villageBankingMobileNumberCode" required>
                                        <option value="260">+260</option>
                                    </select>
                                </div>
                                <div class="col col-md-7 col-xs-7 col-sm-7 col-lg-7" style="float: left !important; padding-left: 0px !important; padding-right: 0px !important">
                                    <input class="form-control col col-md-12 col-xs-12 col-sm-12 col-lg-12" name="villageBankingMobileNumber" id="villageBankingMobileNumber" type="number" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Contact Email Address: </label><br>
                            <div class="villageBankingEmail" id="villageBankingEmailDiv">
                                <input class="form-control" name="villageBankingEmail" id="villageBankingEmail" type="email" required>
                            </div>
                        </div>

                        <div class="col-md-12 " style="text-align: center !important; float: left !important; padding-top: 20px !important">
                            <a onclick="createVillageGroup('{{\Session::get('jwt_token')}}')" data-toggle="modal" style="clear: both !important; padding: 5px 15px; background-color: #4B72FA; color: #fff; font-weight: bolder; font-size: 14px; display: inline-block; margin: 20px 0px; margin-right: 20px; text-decoration: none;">Create Village Group</a><!--data-target="#funds_transfer_overview_modal"-->
                        </div>

                        <a href="#village_bank_group_settings_modal" data-toggle="modal" stye="display: block !important" id="grpsettingslink">Test</a>
                        <a href="#village_bank_group_otp_modal" data-toggle="modal" stye="display: block !important" id="grpotplink">Tes2t</a>


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



