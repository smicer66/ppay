@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Teller @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="row">
    <!-- right column -->
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Confirm Customer Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/bank-teller/customers/new-customer-step-four" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="box-header with-border">
                        <h3 class="box-title">Customer Bio-Data</h3>
                    </div>
                    <div class="col col-md-10" style="padding:0px !important">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">First Name</label>

                            <div class="col-sm-8">
                                {{$data1['firstName']}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Last Name</label>

                            <div class="col-sm-8">
                                {{$data1['lastName']}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Other Name</label>

                            <div class="col-sm-8">
                                {{$data1['otherName']}}
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-2" style="padding:0px !important">
                        <img src="{{(isset($data1['customerImage']) && strlen($data1['customerImage'])>0) ? $data1['customerImage'] : '/photos/member1.png'}}" style="height:120px;">
                    </div>

                    <div class="col col-md-10" style="padding:0px !important">
                        <div class="form-group clear-fix" style="clear:both !important;">
                            <label for="inputEmail3" class="col-sm-4 control-label">Address Line 1</label>

                            <div class="col-sm-8">
                                {{$data1['addressLine1']}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Address Line 2</label>

                            <div class="col-sm-8">
                                {{$data1['addressLine2']}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Province & District</label>

                            <div class="col-sm-8">
                                <?php
                                    //dd($all_provinces);
                                    //dd(explode('_', $data1['district'])[0]);
                                //$prov = ($all_provinces[explode('_', $data1['district'])[0]]);
                                    //dd($prov);, {{($prov->provinceName)}}
                                ?>
                                {{explode('_', $data1['district'])[1]}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Gender</label>

                            <div class="col-sm-8">
                                {{$data1['gender']}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Date Of Birth</label>

                            <div class="col-sm-8">
                                {{$data1['dateOfBirth']}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Contact Mobile No</label>

                            <div class="col-sm-8">
                                +{{$data1['country']."".$data1['mobileNo']}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Alternative Mobile No</label>

                            <div class="col-sm-8">
                                +{{$data1['countryalt']."".$data1['altMobileNo']}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Contact Email Address</label>

                            <div class="col-sm-8">
                                {{$data1['email']}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Alternative Email Address</label>

                            <div class="col-sm-8">
                                {{$data1['altEmail']}}
                            </div>
                        </div>
                        @if(isset($data1['verificationNumber']))
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Verification Number</label>

                            <div class="col-sm-8">
                                {{isset($data1['verificationNumber']) ? $data1['verificationNumber'] : "N/A"}}
                            </div>
                        </div>
                        @endif








                        <div class="box-header with-border">
                            <h3 class="box-title">EagleCard Account Details</h3>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Account Type</label>

                            <div class="col-sm-8">
                                {{$all_account_type[$data1['accountType']]}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Account Currency</label>

                            <div class="col-sm-8">
                                {{$all_currency[$data1['accountCurrency']]}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Opening Balance</label>

                            <div class="col-sm-8">
								{{$all_currency[$data1['accountCurrency']]}}{{number_format(0, 2, '.', ',')}}
                            </div>
                        </div>






                        <div class="box-header with-border">
                            <h3 class="box-title">Credit/Debit Card Details</h3>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Name On Card</label>

                            <div class="col-sm-8">
                                {{$data1['nameOnCard']}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Card Type</label>

                            <div class="col-sm-8">
                                {{$data1['cardType']}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Card Scheme</label>

                            <div class="col-sm-8">
                                <?php
                                $exp = explode('_', $data1['cardScheme']);
                                ?>
                                {{$all_card_schemes[$exp[0]]->schemeName}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Extra Options</label>

                            <div class="col-sm-8">
                                <label class="control-sidebar-subheading">
                                    Add Mobile Money to this card?
                                    @if(isset($data1['addMobileMoney']) && $data1['addMobileMoney']=='on')
                                        <br>&nbsp;&nbsp;&nbsp;&nbsp;Yes
									@else
										<br>&nbsp;&nbsp;&nbsp;&nbsp;No
                                    @endif
                                </label>
                                <label class="control-sidebar-subheading">
                                    Add eWallet to this card
                                    @if(isset($data1['addEWallet']) && $data1['addEWallet']=='on')
                                        <br>&nbsp;&nbsp;&nbsp;&nbsp;Yes
									@else
										<br>&nbsp;&nbsp;&nbsp;&nbsp;No
                                    @endif
                                </label>
                            </div>
                        </div>
                    </div>

                </div>

                <input type="hidden" name="data" value="{{$data}}">
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Create Customer Account</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') New Customer Profile @stop
@section('scripts')

@stop