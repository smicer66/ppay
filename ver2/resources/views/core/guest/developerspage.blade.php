@extends('core.guest.sitelayout')


@section('page_content')
        <div class="tp-wrapper">
            <div class="tp-banner-container">
                <div class="tp-banner" >
                    <div class="col col-md-3">

                    </div>
                    <div class="col-md-9 col-xs-3 col-lg-9 main_content" style="margin-top:50px !important">
                        <div id="section-1" class="docking" style="padding-top:50px">
                            <h4>How ProbasePay Integration work </h4>
                            <p>
                                ProbasePay provides developers a set of SOAP-based we interfaces to enable developers integrate their web applications, POS devices, ATM machines securely and in a simple way into the ProbasePay sytem. To integrate successfully, developers are required to have on hand a set of merchant code and device code.</p>
                            <p>ProbasePay provides a platform through which merchants can start receiving payments through multiple channels from one place.
                            </p>
                        </div>
                        <div id="howtointegrate" class="docking">
                            <h4>Steps towards Integration</h4>
                            <p>
                                To integrate into ProbasePay payment system:.</p>
                            <p>
                            </p><ol>
                                <li>Obtain the merchants ProbasePay merchant code and device code provided to the merchant.</li>
                                <li>Download the sample payment plugin/code provided on this developers section.</li>
                                <li>Using the integration specification, customize the same code to fit your merchants requirements. </li>
                                <li>Test your integration to confirm your integration works. </li>
                                <li>Migrate integration to live. </li>
                            </ol>
                            <p></p>
                        </div>

                        <div id="integration-via-specification" class="docking">
                            <h4>Integration Specification</h4>
                            <p>You are required to create an HTML form which contains payment parameters.</p>
                            <p>On users submitting the HTML form, a ProbasePAY payment page is displayed to users. Users can then choose from a variety of payment options to complete their payment.</p>
                            </p><h4>Fields and Values</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed table-striped">
                                    <thead>
                                        <th>Parameter Name</th>
                                        <th>Description</th>
                                        <th>Type</th>
                                    </thead>
                                    <tbody><tr>
                                        <td>merchantId</td>
                                        <td><b>Required</b><br>This is a unique identifier of merchants</td>
                                        <td>String</td>
                                    </tr>
                                    <tr>
                                        <td>deviceCode</td>
                                        <td><b>Required</b><br>This is a unique identifier for the device of the merchant</td>
                                        <td>String</td>
                                    </tr>
                                    <tr>
                                        <td>serviceTypeId</td>
                                        <td><b>Required</b><br>Indicates the service type the payment belongs.<br>
                                            An example of a service type is a General E-Commerce service type meant for general ecommerce. You can find the different service types and their respective codes at the Service Types section on this page</td>
                                        <td>String</td>
                                    </tr>
                                    <tr>
                                        <td>orderId</td>
                                        <td><b>Required</b><br>This is the unique identification of the transaction.<br>
                                            You are advised not to repeat orderIds even for failed transactions as each transaction is considered to be unique.</td>
                                        <td>String</td>
                                    </tr>
                                    <tr>
                                        <td>hash</td>
                                        <td><b>Required</b><br>hashed value of merchantId+deviceCode+serviceTypeId+orderId+amount+responseurl+api_key</td>
                                        <td>String</td>
                                    </tr>
                                    <tr>
                                        <td>payerName</td>
                                        <td><b>Required</b><br>This is the name of the customer to be displayed on the payment page.</td>
                                        <td>String</td>
                                    </tr>
                                    <tr>
                                        <td>payerEmail</td>
                                        <td><b>Required</b><br>This is the Payer Email Address</td>
                                        <td>String</td>
                                    </tr>
                                    <tr>
                                        <td>payerPhone</td>
                                        <td><b>Optional</b><br>This is the Payer Phone Number</td>
                                        <td>String</td>
                                    </tr>
                                    <tr>
                                        <td>paymentItem[]</td>
                                        <td><b>Required</b><br>A listing of all line items which the payment is for.</td>
                                        <td>String</td>
                                    </tr>
                                    <tr>
                                        <td>amount[]</td>
                                        <td><b>Required</b><br>A listing of all line items costing which the payment is for.</td>
                                        <td>Numeric</td>
                                    </tr>
                                    <tr>
                                        <td>responseurl</td>
                                        <td><b>Required</b><br>The URL to be redirected to on completion of payment.</td>
                                        <td>String</td>
                                    </tr>
                                    <tr>
                                        <td>payerId</td>
                                        <td><b>Optional*Required</b><br>The payer's Identification Number. Used if you want to process a payment as a school fees payment. Must be provided if the serviceTypeId indicates a School Fees Payment Type</td>
                                        <td>String</td>
                                    </tr>
                                    <tr>
                                        <td>nationalId</td>
                                        <td><b>Optional*Required</b><br>The payer's National Identification Number. Used if you want to process a payment as a school fees payment. Must be provided if the serviceTypeId indicates a School Fees Payment Type</td>
                                        <td>String</td>
                                    </tr>
                                    <tr>
                                        <td>scope</td>
                                        <td><b>Optional*Required</b><br>The period the payment covers for example the particular schools' term, academic year, semester, or session. Used if you want to process a payment as a school fees payment. Must be provided is the serviceTypeId indicates a School Fees Payment Type</td>
                                        <td>String</td>
                                    </tr>
                                    <tr>
                                        <td>description</td>
                                        <td><b>Optional*Required</b><br>The description of the payment. Used if you want to process a payment as a school fees payment. Must be provided if the serviceTypeId indicates a School Fees Payment Type</td>
                                        <td>String</td>
                                    </tr>
                                    <tr>
                                        <td>customdata[]</td>
                                        <td><b>Optional</b><br>Extra information can be passed to the ProbasePay system using the customdata fields.</td>
                                        <td>String</td>
                                    </tr>
                                    <tr>
                                        <td>currency</td>
                                        <td><b>Required</b><br>For Zambian Kwacha payments, provide ZMW</td>
                                        <td>String</td>
                                    </tr>
                                    </tbody></table>
                            </div>
                            <p></p>
                            <p>
                                <b><u>Generating Request Hash</u></b><br>
                                For security reasons you are required to hash your payment details with your API Key. Request the API key provided to the merchant during merchant setup. This API key is used to . A valid payment request hash is generated by concatenating the following payment details and hashed using <b>SHA512 algorithm</b> and the assigned API Key:
                                <code>merchantId+deviceCode+serviceTypeId+orderId+amt+responseurl+api_key</code> where amt is the sum total of all the amounts listed in the amount[] field
                            </p>
                            <p>

                            </p><h4>Sample HTML Code</h4>
                            <div class="codetext">

                                &lt;html&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;body&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;form action="http://payments.probasepay.com/payments/init" name="SubmitProbasePayForm" method="POST"&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input name="merchantId" value="7OESIFCUXQ" type="hidden"&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input name="deviceCode" value="QYSH2MM5" type="hidden"&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input name="serviceTypeId" value="1981511018900" type="hidden"&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input name="orderId" value="8192101" type="hidden"&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input name="hash" value="HYUASKCL12910KAS3912" type="hidden"&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input name="payerName" value="Junior Peter" type="hidden"&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input name="payerEmail" value="contactus@juniorpeter.com" type="hidden"&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input name="payerPhone" value="260901111111" type="hidden"&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input name="amount[]" value="100" type="hidden"&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input name="amount[]" value="100" type="hidden"&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input name="amount[]" value="100" type="hidden"&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input name="paymentItem[]" value="Payment Item A" type="hidden"&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input name="paymentItem[]" value="Payment Item B" type="hidden"&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input name="paymentItem[]" value="Payment Item C" type="hidden"&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input name="responseurl" value="http://www.yourdomain.com/payments/response" type="hidden"&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input type ="submit" name="submit_btn" value="Pay Via ProbasePAY"&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;/form&gt;<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;/body&gt;<br>
                                &lt;/html&gt;

                            </div>

                            <p></p>

                        </div>


                        <div id="demo-accounts" class="docking">
                            <h4>For Test: Demo Accounts</h4>
                            <p>
                            </p><h4>Merchant Account Credentials</h4>
                            <table class="table table-bordered table-condensed table-striped">
                                <tbody><tr>
                                    <th>Merchant Code</th>
                                    <th>Device Code</th>
                                    <th>Service Type</th>
                                    <th>Service Type ID</th>
                                    <th>API KEY</th>
                                </tr>
                                <tr>
                                    <td>7OESIFCUXQ</td>
                                    <td>QYSH2MM5</td>
                                    <td>General E-commerce</td>
                                    <td>1981511018900</td>
                                    <td>D3D1D05AFE42AD50818167EAC73C109168A0F108F32645C8<br>
                                        B59E897FA930DA44F9230910DAC9E20641823799A107A020<br>
                                        68F7BC0F4CC41D2952E249552255710F</td>
                                </tr>
                                <tr>
                                    <td>7OESIFCUXQ</td>
                                    <td>QYSH2MM5</td>
                                    <td>School Fee Payment</td>
                                    <td>1981598182741</td>
                                    <td>D3D1D05AFE42AD50818167EAC73C109168A0F108F32645C8B5<br>
                                        9E897FA930DA44F9230910DAC9E20641823799A107A02068F7<br>
                                        BC0F4CC41D2952E249552255710F</td>
                                </tr>
                                </tbody></table>
                            <p></p>
                            <p>
                            </p><h4>Test Card Details</h4>
                            <table class="table table-bordered table-condensed table-striped">
                                <tbody><tr>
                                    <th>Card Type</th>
                                    <th>Name</th>
                                    <th>Number</th>
                                    <th>Expiration</th>
                                    <th>CVV</th>
                                    <th>PIN</th>
                                </tr>
                                <tr>
                                    <td>EagleCard</td>
                                    <td>-</td>
                                    <td>00260350010010116799006</td>
                                    <td>09/2020</td>
                                    <td>316</td>
                                    <td>2159</td>
                                </tr>
                                <tr>
                                    <td>Visa</td>
                                    <td>-</td>
                                    <td>400200000000002</td>
                                    <td>01/2020</td>
                                    <td>400</td>
                                    <td>-</td>
                                </tr>
                                </tbody></table>
                            <p></p>

                            <p>
                            </p><h4>Pay With ProbaseWallet</h4>
                            <table class="table table-bordered table-condensed table-striped">
                                <tbody><tr>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>OTP</th>
                                </tr>
                                <tr>
                                    <td>customer1@gmail.com</td>
                                    <td>password</td>
                                    <td>0000</td>
                                </tr>
                                </tbody></table>
                            <p></p>
                            <p>
                        </div>
                        <div id="trans-status" class="docking">
                            <h4>Transaction Status</h4>
                            <p>
                                Although a status code is sent to the responseurl, a re-query for the status of the transaction is required to confirm the transaction status on ProbasePAY on completion of the transaction.
                            </p><p>
                            </p><p>
                            </p><h4>Status Check Parameter</h4>
                            <table class="table table-bordered table-condensed table-striped">
                                <tbody><tr>
                                    <th>Parameter Names</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                </tr>
                                <tr>
                                    <td>merchantCode</td>
                                    <td><b>Required</b><br>This is a unique identifier of merchants</td>
                                    <td>String</td>
                                </tr>
                                <tr>
                                    <td>deviceCode</td>
                                    <td><b>Required</b><br>This is a unique identifier of the merchant device on which the transaction took place</td>
                                    <td>String</td>
                                </tr>
                                <tr>
                                    <td>transactionRef</td>
                                    <td><b>Required</b><br>The transaction reference of the transaction</td>
                                    <td>String</td>
                                </tr>
                                <tr>
                                    <td>hash</td>
                                    <td><b>Required</b><br>SHA512 (transactionRef+api_key+merchantId)</td>
                                    <td>String</td>
                                </tr>
                                </tbody></table>
                            <p></p>
                            <p>
                            </p><h4>Check Payment Status URL using TransactionRef</h4>
                            <div class="codetext">
                                http://probasepay.com/transaction/check-status/{merchantCode}/{deviceCode}/{transactionRef}/{hash}
                            </div>
                            <p></p>
                            <p>
                            </p>
                            <p>
                            </p><h4>Sample GET Request</h4>
                            <div class="codetext">
                                http://probasepay.com/transaction/check-status/7OESIFCUXQ/QYSH2MM5/83012IOSPSI2S2/<br>
                                781d5689aa52d7f00ff42b169931ec7f863b6c293ba0744bef2e848bab8<br>
                                c8de94061ae5c2a5b8cb2d2d1636418e3aca0295b834c5f4989bf1d073050b9b7ae8f<br>
                            </div>
                            <p></p>
                            <p>
                            </p><h4>Sample JSON Response</h4>
                            <div class="codetext">
                                &nbsp;&nbsp;&nbsp;{ <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"statusmessage": "Transaction Successful", <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"merchantId": "7OESIFCUXQ", <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"merchantId": "QYSH2MM5", <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"status": "00", <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"TransactionRef": "83012IOSPSI2S2", <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"transactiontime": "2016-09-30 11:16:12 PM", <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"orderId": "8192101" <br>
                                &nbsp;&nbsp;&nbsp;}
                            </div>
                            <p></p>
                            <p>
                            </p>
                        </div>
                        <div id="logos" class="docking">
                            <h4>Logos &amp; Graphics</h4>
                            <p>Give your website more credibility and help reassure customers about security by including these logos on your checkout pages.</p>
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <img src="/images/verified.png" class="img-responsive" style="height:50px;">
                                    <br><a target="_blank" href="/images/verified.png">Download</a>
                                </div>
                                <div class="col-md-6 col-lg-8 pull-right">
                                    <img src="/images/visa-mastercard.png" class="img-responsive" style="height:50px;">
                                    <br><a target="_blank" href="/images/visa-mastercard.png">Download</a>
                                </div>
                            </div>
                            <p></p>
                            <p></p>
                            <p></p>
                            <p></p>
                        </div>
                        <div id="sample-codes" class="docking">
                            <h4>Sample Codes</h4>
                            <p>
                                In this section, you will find some SDKs which will allow you to interact with our APIs as well as some sample codes.
                            </p>
                            <p>
                            </p><h4>PHP</h4>
                            <p>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    <i class="fa fa-caret-right"></i> Sample Post to ProbasePay</a>
                            </p><div id="collapseOne" class="panel-collapse collapse" style="height: 0px;">
                                You may use the following sample post as a blueprint for your own custom form post. The script handles the basic form post and verify the transaction by calling the Check Status. You will need to add extra lines of code in order for it to behave as your web application requires.
                                <br><a href="developers/sample-codes/sample_post_to_probasepay.zip" class="download-link">Click to Download Code</a>
                            </div>
                            <hr>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                <i class="fa fa-caret-right"></i> Sample Get Transaction Status</a>
                            <div id="collapseThree" class="panel-collapse collapse" style="height: 0px;">
                                You may use the following sample as a blueprint for your own custom check status query. The script handles the basic check status query. You will need to add extra lines of code in order for it to behave as your web application requires.
                                <br><a href="assets/sample-codes/sample_get_status_to_probasepay.zip" class="download-link">Click to Download Code</a>
                            </div>
                            <hr>
                            <p></p>
                            <p></p>
                            <p>
                            </p>
                            <p></p>
                            <p></p>
                            <p></p>
                            <p></p>
                        </div>
                        <div id="trans-codes" class="docking">
                            <h4>Transaction Codes</h4>
                            <table class="table table-bordered table-condensed table-striped">
                                <tbody><tr>
                                    <th>Status</th>
                                    <th>Description</th>
                                </tr>
                                <tr>
                                    <td>00</td>
                                    <td>Transaction Completed Successfully</td>
                                </tr>
                                <tr>
                                    <td>01</td>
                                    <td>Transaction Timed Out</td>
                                </tr>
                                <tr>
                                    <td>02</td>
                                    <td>Parameters Provided are Incomplete</td>
                                </tr>
                                <tr>
                                    <td>03</td>
                                    <td>Invalid Merchant Code Provided</td>
                                </tr>
                                <tr>
                                    <td>04</td>
                                    <td>Service Type Not Found</td>
                                </tr>
                                <tr>
                                    <td>05</td>
                                    <td>Invalid Hash</td>
                                </tr>
                                <tr>
                                    <td>06</td>
                                    <td>Transaction Failed</td>
                                </tr>
                                <tr>
                                    <td>07</td>
                                    <td>User Aborted Transaction</td>
                                </tr>
                                <tr>
                                    <td>08</td>
                                    <td>Insufficient Balance</td>
                                </tr>
                                <tr>
                                    <td>99</td>
                                    <td>Unknown Error</td>
                                </tr>
                                </tbody></table>
                        </div>
                        <div id="acceptance" class="docking">
                            <h4>ProbasePay Integration User Acceptance Test (UAT)</h4>
                            <p>
                            </p><ol>
                                <li>- You must have the ProbasePay logo on your checkout page</li>
                                <li>- Is the customer aware of the total amount he/she will be debited of before loading the payment page? Always inform the customer duly.</li>
                                <li>- Display customers Order number to them before they make payment so that they will have a reference value in case they have issues with their transactions. You should send a mail, text or you could print these details for them on the website with an eye-catching prompt to notify them.</li>
                                <li>- When the payment page loads up, confirm that the amount displayed is correct.</li>
                                <li>- After a transaction had been processed, certain information needs to be displayed to the customer. They include the following;
                                    <ul><li>&nbsp;&nbsp;&nbsp;&nbsp;- The Order number/Id which you sent to ProbasePay for that transaction.</li>
                                        <li>&nbsp;&nbsp;&nbsp;&nbsp;- The transaction reference number which ProbasePay sends back to you for that transaction.</li>
                                        <li>&nbsp;&nbsp;&nbsp;&nbsp;- The total amount paid by the customer as indicated in the response sent back to you from ProbasePAY.</li>
                                    </ul>
                                </li>
                                <li>- It is expected that you store the response from ProbasePAY for each transaction against that transaction</li>
                                <li>- It is expected that you have a log of all transaction attempts on your website. When transaction IDs are generated, you are to log the transaction on that table and update when the responses returned. That way, you will be able to determine transactions status. For transactions that were described as pending,
                                    it means those transactions have not yet been completed.
                                </li>
                                <li>
                                    - It is expected you have a Payment Notification Listener URL, which will receive Payment Notifications sent by ProbasePay.  The URL will be
                                    configured during your ProbasePay merchant setup.</li>
                            </ol>
                            <p></p>
                            <p>
                                After you have successfully integrated ProbasePay to your website and carried out the tests above successfully, you should send us an email to confirm
                                your integration has been completed. Further tests are carried out by us to ascertain integration has been completed before you can be migrated to our
                                live platform
                            </p>
                        </div>

                    </div>



                </div><!-- /tp-banner -->
            </div><!-- /tp-banner-container -->

        </div><!-- /tp-wrapper -->
@endsection