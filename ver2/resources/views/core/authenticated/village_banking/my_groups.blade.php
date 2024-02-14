@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('style')
    <style>


        .smart_coops_modal {
            max-width: calc(100% - 10%);
            height: calc(100% - 10%) !important;
            margin: 1.75rem auto;
        }

        .smart_coops_modal1 {
            height: calc(100% - 5%) !important;
        }

        #mainFrame{
            height: calc(100%) !important;
        }

    </style>
@stop

@section('content')

    @include('partials.errors')
    <!-- Info boxes -->
    <div class="element-wrapper col-md-12">

            <h6 class="element-header">Village Banking
                <a style="margin-left: 0px !important; cursor: pointer; color: #fff !important;" data-target="#add_village_bank_group_modal" data-toggle="modal" class="btn btn-primary pull-right"><strong>+<strong> Add A Village Banking Group</a>
            </h6>



        <div class="element-box">
            <h5 class="form-header">
                My Village Banking Groups
            </h5>
            <div class="form-desc">
                List of all village banking groups you belong to are listed here. This includes groups you created and those you joined.<br>
                Click on any of the village banking groups to carry out an action on the group.
            </div>
            <!--<div class="table-responsive">
                <table id="allvillagebankinggroupstable" width="100%" class="table table-striped table-lightfont">
                    <thead>
                    <tr>
                        <th>Group Name</th>
                        <th>Members</th>
                        <th>Mutual Funds</th>
                        <th>Loans To Members</th>
                        <th>Created By</th>
                        <th>Status</th>
                        <th>Funds In Vault</th>
                        <th>&nbsp</th>
                    </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>-->
            @foreach($villageBankGroups as $vbg)

            <div class="col col-lg-3 col-md-3 col-xs-12 col-sm-12" style="background-color: #{{$vbg['bgColor']}}; border-radius: 10px !important; padding: 10px !important;
                                float: left !important;">
                <div class="credit-card visa selectable col-lg-12 col-md-12 col-xs-12 col-sm-12" style="">
                    <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="">
                        <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="
                                            padding-top: 10px !important;
                                            padding-left: 20px !important;
                                            float: left !important;
                                            text-align: center !important;

                                        ">
                            <img src="/img/emptylogo.png" style="height: 20px !important;">
                        </div>
                        <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="
                                            padding-top: 10px !important;
                                            float: left !important;
                                            color: #dbdbd9 !important;
                                            font-size: 20px;
                                            color: #000 !important;
                                            text-align: center !important;
                                        ">
                            <strong style="font-weight: bold !important">{{$vbg['group_name']}}</strong>
                        </div>
                        <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="
                                            padding-top: 10px !important;
                                            float: left !important;
                                            color: #dbdbd9 !important;
                                            font-size: 12px;
                                            color: #000 !important;
                                            text-align: left !important;
                                        ">
                            <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="
                                            color: #dbdbd9 !important;
                                            font-size: 15px;
                                            color: #000 !important;
                                            text-align: center !important;
                                        ">
                                <?php
                                $info = [];
                                $info['usercode'] = $groupMemberMap[$vbg['id']];
                                $info['username'] = \Auth::user()->username;
                                $info = json_encode($info);
                                $info = encrypt_msg_rsa($info, ($vbg['group_public_key']));

                                ?>
                                <!---->
                                @if(!in_array($vbg['id'], $groupSettings))
                                    <a id="loadSmartCoopsInterfaceLink" data-backdrop="static" data-keyboard="false" data-target="#smart_coops_modal" data-toggle="modal" onclick="handleLoadSmartCoopsInterface('{{$vbg['cooperative_code']}}', '{{$info}}')" style="cursor: pointer !important" class="btn btn-primary btn-sm">Access Group</a>
                                @else
                                    <div id="accessgroupholder">
                                        <button onclick="handleNotifySettingsReqd()" style="cursor: pointer !important" class="btn btn-info btn-sm">Access Group</button>
                                    </div>
                                @endif
                                <div style="clear: both !important; padding-top:10px !important" class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <i style="clear: both !important; font-size: 25px !important" class="os-icon os-icon-ui-46"></i><br>
                                    <a data-target="#village_bank_group_settings_modal" data-toggle="modal" onclick="loadVillageBankingSettings('{{$vbg['cooperative_code']}}', '{{$info}}', '{{$vbg['group_name']}}')" style="text-decoration: underline !important; cursor: pointer !important" class="">Settings</a>
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="clear: both !important; padding: 0px !important;">&nbsp;</div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="col col-lg-12 col-md-12 col-xs-12 col-sm-12" style="clear: both !important">
        </div>
    </div>

    @include('core.authenticated.village_banking.add_village_bank_group')
    @include('core.authenticated.village_banking.add_village_bank_otp')
    @include('core.authenticated.village_banking.village_bank_group_settings')
    @include('core.authenticated.village_banking.smart_coops_interface')

@stop
@section('section_title') Village Banking @stop
@section('scripts')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
    <script type="text/javascript" src="/js/action.js"></script>
    <script>


    </script>
@stop

