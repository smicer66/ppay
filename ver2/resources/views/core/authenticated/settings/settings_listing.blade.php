@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Application Settings @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="element-wrapper col-md-12">
    <h6 class="element-header">
        Settings
    </h6>
    <div class="element-box">
        <h5 class="form-header">
            All Settings
        </h5>
        <div class="form-desc">
            List of all settings
        </div>
        <div class="table-responsive">
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
                        <td class="sorting_1">Max Transaction Allowed on Web</td>
                        <td id="maximumTransactionAmountWeb"></td>
                    </tr>
                    <tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                        <td class="sorting_1">Min. Transaction Allowed on Web</td>
                        <td id="minimumTransactionAmountWeb"></td>
                    </tr>
                    <tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                        <td class="sorting_1">CyberSource Profile Id</td>
                        <td id="cyberSourceProfileId"></td>
                    </tr>
                    <tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                        <td class="sorting_1">CyberSource Locale</td>
                        <td id="cyberSourceLocale"></td>
                    </tr>
                    <tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                        <td class="sorting_1">CyberSource Access Key</td>
                        <td id="cyberSourceAccessKey">{</td>
                    </tr>
                    <tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                        <td class="sorting_1">CyberSource Secret Key</td>
                        <td><div style="white-space: pre-wrap !important; word-break: break-word !important;" id="cyberSourceSecretKey"></div>
                        </td>

                    <tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                        <td class="sorting_1">CyberSource Profile Id (Demo)</td>
                        <td id="cyberSourceDemoProfileId"></td>
                    </tr>
                    <tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                        <td class="sorting_1">CyberSource Locale (Demo)</td>
                        <td id="cyberSourceDemoLocale"></td>
                    </tr>
                    <tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                        <td class="sorting_1">CyberSource Access Key (Demo)</td>
                        <td id="cyberSourceDemoAccessKey"></td>
                    </tr>
                    <tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                        <td class="sorting_1">CyberSource Secret Key (Demo)</td>
                        <td><div id="cyberSourceDemoSecretKey" style="white-space: pre-wrap !important; word-break: break-word !important;"></div>
                        </td>
                    </tr>
                    <tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                        <td class="sorting_1">Card Support Active</td>
                        <td><div id="cardsupport" style="white-space: pre-wrap !important; word-break: break-word !important;"></div>
                        </td>
                    </tr>
                    <tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                        <td class="sorting_1">ZESCO Transit Account</td>
                        <td><div id="zescoTransientAccountId" style="white-space: pre-wrap !important; word-break: break-word !important;"></div>
                        </td>
                    </tr>
                    <tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                        <td class="sorting_1">Merchant Payments Transit Account</td>
                        <td><div id="payMerchantTransientAccountId" style="white-space: pre-wrap !important; word-break: break-word !important;"></div>
                        </td>
                    </tr>
                    <tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                        <td class="sorting_1">Funds Transfer Transit Account</td>
                        <td><div id="fundsTransferTransientAccountId" style="white-space: pre-wrap !important; word-break: break-word !important;"></div>
                        </td>
                    </tr>
                    <tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                        <td class="sorting_1">Cable TV Payments Transit Account</td>
                        <td><div id="cableTvTransientAccountId" style="white-space: pre-wrap !important; word-break: break-word !important;"></div>
                        </td>
                    </tr>
                    <tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                        <td class="sorting_1">Wallet Funding Transit Account</td>
                        <td><div id="walletFundingTransientAccountId" style="white-space: pre-wrap !important; word-break: break-word !important;"></div>
                        </td>
                    </tr>

                </tbody>
            </table>

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
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
    <script type="text/javascript" src="/js/action.js"></script>

    <script>
        $(document).ready(function()
        {
            var jwtToken = '{{\Session::get('jwt_token')}}';
            readApplicationSettings(jwtToken, 1);
        });
    </script>
@stop
