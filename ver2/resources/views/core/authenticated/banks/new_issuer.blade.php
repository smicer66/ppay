@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | New Bank @stop

@section('content')

    @include('partials.errors')


    <div class="content-box">
        <div class="element-wrapper">
            <div class="element-box">
                <div>
                    <div class="steps-w">
                        <div class="step-triggers">
                            <a class="step-trigger active" href="#stepContent1">Issuer Details</a>
                            <!--<a class="step-trigger" href="#stepContent4">Notifications</a>-->
                        </div>
                        <div class="step-contents">
                            <div class="step-content active" id="stepContent1">
                                <form action id="newIssuerForm" data-toggle="validator">
                                    <input type="hidden" name="issuerId" value="" class="issuerId">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Issuer Name<span style="color:red !important">*</span></label>
                                                <input name="issuerName" value="{{$request->old('issuerName') ? $request->old('issuerName') : ''}}" type="text" class="form-control" id="issuerName" placeholder="Provide Name Of Issuer" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Issuer Code<span style="color:red !important">*</span></label>
                                                <input name="issuerCode" value="{{$request->old('issuerCode') ? $request->old('issuerCode') : ''}}" type="text" class="form-control" id="issuerCode" placeholder="Provide Issuer Code" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-buttons-w text-right">
                                        <a class="btn btn-primary step-trigger-btn" onclick="newIssuerGoToStep('{{\Session::get('jwt_token')}}', 'stepContent2', event)" style="cursor: pointer !important;"> Continue</a>
                                        <a class="btn btn-primary step-trigger-btn" id="btn1" style="display: none !important" href="#stepContent2"> Continue</a>
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
@section('section_title') New Bank @stop
@section('scripts')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript" src="/js/action.js"></script>

    <script>
        var goToId_ = null;



        function logoutUser(message, redirect)
        {
            toastr.success(message);
            window.location = '/logout?redirect=' + redirect;
        }









    </script>
@stop
