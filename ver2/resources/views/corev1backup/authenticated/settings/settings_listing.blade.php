@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Application Settings @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes --><div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Application Settings</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" style="font-size:12px" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc col-md-3" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Settings Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Setting Value</th>
                                        
                                    </tr>
                                </thead>
								<?php $x = 0; ?>
                                <tbody>

                                    <tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                                        <td class="sorting_1">Payment Vendor Code</td>
                                        <td>{{$result->paymentVendorCode}}</td>
                                    </tr>
									<tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                                        <td class="sorting_1">Vendor Code</td>
                                        <td>{{$result->vendorCode}}</td>
                                    </tr>
									<tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                                        <td class="sorting_1">Data Source</td>
                                        <td>{{$result->dataSource}}</td>
                                    </tr>
									<tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                                        <td class="sorting_1">Currency Code</td>
                                        <td>{{$result->currencyCode}}</td>
                                    </tr>
									<tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                                        <td class="sorting_1">Minimum Balance</td>
                                        <td>{{$result->minimumBalance}}</td>
                                    </tr>
									<tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                                        <td class="sorting_1">Max Transaction Allowed on Web</td>
                                        <td>{{$result->maximumTransactionAmountWeb}}</td>
                                    </tr>
									<tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                                        <td class="sorting_1">Min. Transaction Allowed on Web</td>
                                        <td>{{$result->minimumTransactionAmountWeb}}</td>
                                    </tr>
									<tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                                        <td class="sorting_1">CyberSource Profile Id</td>
                                        <td>{{$result->cyberSourceProfileId}}</td>
                                    </tr>
									<tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                                        <td class="sorting_1">CyberSource Locale</td>
                                        <td>{{$result->cyberSourceLocale}}</td>
                                    </tr>
									<tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                                        <td class="sorting_1">CyberSource Access Key</td>
                                        <td>{{$result->cyberSourceAccessKey}}</td>
                                    </tr>
									<tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                                        <td class="sorting_1">CyberSource Secret Key</td>
                                        <td><div style="white-space: pre-wrap !important; word-break: break-word !important;">{{$result->cyberSourceSecretKey}}</div>
										</td>
                                    </tr>
									<tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                                        <td class="sorting_1">DSTV Business Unit</td>
                                        <td>{{$result->businessUnit}}</td>
                                    </tr>
									<tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                                        <td class="sorting_1">DSTV Method of Payment</td>
                                        <td>{{$result->methodOfPayment}}</td>
                                    </tr>
									<tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                                        <td class="sorting_1">DSTV Language</td>
                                        <td>{{$result->language}}</td>
                                    </tr>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>



@stop
@section('section_title') <i class="fa fa-arrows-alt" style="color:#00a65a"></i>&nbsp;&nbsp;Application Settings Listing @stop

@section('quick_buttons')
    <div class="pull-right" style="padding-left:10px;"><a class="btn btn-sm btn-danger pull-right" onclick="javascript:history.back(-1)" style="color:#fff">Go Back</a></div>
    <div  class="pull-right"><a class="btn btn-sm btn-primary pull-right" href="/potzr-staff/update-settings" style="color:#fff">Update Application Settings</a></div>
@stop
@section('scripts')

@stop