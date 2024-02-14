@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Application Settings @stop

@section('content')

    @include('partials.errors')

<div class="content-box">
    <div class="element-wrapper">
        <div class="element-box">
            <div>
                <div class="steps-w">
                    <div class="step-triggers">
                        <a class="step-trigger active" href="#stepContent1">Settings</a>
                    </div>
                    <div class="step-contents">
                        <div class="step-content active" id="stepContent1">
                            <form action id="newSettingsForm" data-toggle="validator">
                                <div class="row" style="padding-top: 20px !Important">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for=""><h3><u>Transaction Settings</u></h3></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Min. Transaction Allowed On Web<span style="color:red !important">*</span></label>
                                            <input value="{{isset($result->minimumTransactionAmountWeb) ? $result->minimumTransactionAmountWeb : ''}}" type="number" name="minimumtransactionamountweb" class="form-control" id="minimumTransactionAmountWeb" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Max. Transaction Allowed On Web<span style="color:red !important">*</span></label>
                                            <input value="{{isset($result->maximumTransactionAmountWeb) ? $result->maximumTransactionAmountWeb : ''}}" type="number" name="maximumtransactionamountweb" class="form-control" id="maximumTransactionAmountWeb" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 20px !Important">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <hr>
                                            <label for=""><h3><u>Probase Cybersource Live Details</u></h3></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Cybersource Access Key<span style="color:red !important">*</span></label>
                                            <input value="{{isset($result->cyberSourceAccessKey) ? $result->cyberSourceAccessKey : ''}}" type="text" name="cybersourceaccesskey" class="form-control" id="cyberSourceAccessKey" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Cybersource Profile Id<span style="color:red !important">*</span></label>
                                            <input value="{{isset($result->cyberSourceProfileId) ? $result->cyberSourceProfileId : ''}}" type="text" name="cybersourceprofileid" class="form-control" id="cyberSourceProfileId" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Cybersource Secret Key<span style="color:red !important">*</span></label>
                                            <input value="{{isset($result->cyberSourceSecretKey) ? $result->cyberSourceSecretKey : ''}}" type="text" name="cybersourcesecretkey" class="form-control" id="cyberSourceSecretKey" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Cybersource Locale<span style="color:red !important">*</span></label>
                                            <input value="{{isset($result->cyberSourceLocale) ? $result->cyberSourceLocale : ''}}" type="text" name="cybersourcelocale" class="form-control" id="cyberSourceLocale" required>
                                        </div>
                                    </div>
                                </div>



                                <div class="row" style="padding-top: 20px !Important">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <hr>
                                            <label for=""><h3><u>Probase Cybersource Demo Details</u></h3></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Cybersource Demo Access Key</label>
                                            <input value="{{isset($result->cyberSourceDemoAccessKey) ? $result->cyberSourceDemoAccessKey : ''}}" type="text" name="cybersourcedemoaccesskey" class="form-control" id="cyberSourceDemoAccessKey">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Cybersource Demo Profile Id</label>
                                            <input value="{{isset($result->cyberSourceDemoProfileId) ? $result->cyberSourceDemoProfileId : ''}}" type="text" name="cybersourcedemoprofileid" class="form-control" id="cyberSourceDemoProfileId">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Cybersource Demo Secret Key</label>
                                            <input value="{{isset($result->cyberSourceDemoSecretKey) ? $result->cyberSourceDemoSecretKey : ''}}" type="text" name="cybersourcedemosecretkey" class="form-control" id="cyberSourceDemoSecretKey">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Cybersource Demo Locale</label>
                                            <input value="{{isset($result->cyberSourceDemoLocale) ? $result->cyberSourceDemoLocale : ''}}" type="text" name="cybersourcedemolocale" class="form-control" id="cyberSourceDemoLocale">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-buttons-w text-right">
                                    <a class="btn btn-primary step-trigger-btn" onclick="updateSettingsGoToStep('{{\Session::get('jwt_token')}}', 'stepContent2', event)" style="cursor: pointer !important;"> Save</a>
                                    <a style="cursor: pointer !important; display: none !important" data-target="#new_card_modal" id="add_new_card_btn" data-toggle="modal" class="dropdown-item">View Device</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('section_title') User List @stop
@section('scripts')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
    <script type="text/javascript" src="/js/action.js"></script>

    <script>
        $(document).ready(function()
        {
            var jwtToken = '{{\Session::get('jwt_token')}}';
            getApplicationSettings(jwtToken);
        });
    </script>
@stop
