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
                            <a class="step-trigger active" href="#stepContent1">Bank Details</a>
                            <!--<a class="step-trigger" href="#stepContent4">Notifications</a>-->
                        </div>
                        <div class="step-contents">
                            <div class="step-content active" id="stepContent1">
                                <form action id="newBankForm" data-toggle="validator">
                                    <input type="hidden" id="bankId" name="bankId" value="{{$bankId!=null ? $bankId : ''}}" class="bankId">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Bank Name<span style="color:red !important">*</span></label>
                                                <input name="bankName" value="{{$request->old('bankName') ? $request->old('bankName') : ($bankName==null ? '' : $bankName)}}" type="text" class="form-control" id="bankName" placeholder="Provide Name Of Bank" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Country of Operation<span style="color:red !important">*</span></label>
                                                <select name="operationCountry" id="operationCountry" class="form-control" required>
                                                    <option value>-Country Code-</option>
                                                    @foreach($countries as $country)
                                                        <option value="{{$country->id}}" {{$request->old('operationCountry') && $request->old('operationCountry')==$country->id ? 'selected' : ($countryOfOperation_id!=null && $countryOfOperation_id==$country->id ? 'selected' : '')}}>{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">UAT Bank Code<span style="color:red !important">*</span></label>
                                                <input name="bankCode" value="{{$request->old('bankCode') ? $request->old('bankCode') : ($bankCode==null ? '' : $bankCode)}}" type="text" class="form-control" id="bankCode" placeholder="Provide UAT Bank Code" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Live  Bank Code<span style="color:red !important">*</span></label>
                                                <input name="liveBankCode" value="{{$request->old('liveBankCode') ? $request->old('liveBankCode') : ($liveBankCode==null ? '' : $liveBankCode)}}" type="text" class="form-control" id="liveBankCode" placeholder="Provide Live Bank Code" required>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">BIC Code<span style="color:red !important">*</span></label>
                                                <input name="bicCode" value="{{$request->old('bicCode') ? $request->old('bicCode') : ($bicCode==null ? '' : $bicCode)}}" type="text" class="form-control" id="bicCode" placeholder="Provide Banks BIC Code" required>
                                            </div>
                                        </div>
					     <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Online Banking URL<span style="color:red !important">*</span></label>
                                                <input name="onlineBankingURL" value="{{$request->old('onlineBankingURL') ? $request->old('onlineBankingURL') : ($onlineBankingURL==null ? '' : $onlineBankingURL)}}" type="text" class="form-control" id="onlineBankingURL" placeholder="Provide URL to Online Banking" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-buttons-w text-right">
                                        <a class="btn btn-primary step-trigger-btn" onclick="newBankGoToStep('{{\Session::get('jwt_token')}}', 'stepContent2', event)" style="cursor: pointer !important;"> Continue</a>
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
