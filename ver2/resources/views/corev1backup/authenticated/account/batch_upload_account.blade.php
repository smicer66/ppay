@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Teller @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes --><div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Customer Profile</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    @if(isset($customer) && $customer!=NULL)
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="inputEmail3" class="col-sm-2 control-label">First Name</label>

                            <div class="col-sm-10">
                                {{$customer->lastName}}, {{$customer->firstName}} {{$customer->otherName}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="inputEmail3" class="col-sm-2 control-label">Verification Number</label>

                            <div class="col-sm-10">
                                {{$customer->verificationNumber}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="inputEmail3" class="col-sm-2 control-label">Account Number</label>

                            <div class="col-sm-10">
                                {{$account->accountIdentifier}}
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="box-header">
                        &nbsp;
                    </div>


                    <div class="box-header">
                        <h3 class="box-title" style="text-decoration: underline">Upload Batch Accounts</h3>
                    </div>


                    <div class="row">
                        <div class="col-sm-12" style="padding-left:30px !important">
                            @if($primaryAccountId!=NULL)
                                <form enctype="multipart/form-data" action="/bank-teller/accounts/upload-batch-accounts-template/{{$primaryAccountId}}" method="post" style="font-size:11px;">
                            @else
                                <form enctype="multipart/form-data" action="/bank-teller/accounts/upload-batch-accounts-template" method="post" style="font-size:11px;">
                            @endif
                                <fieldset>
                                    <div class="col col-sm-3">
                                        <select class="form-control" required id="cardScheme" name="cardScheme">
                                            <option>-Select Card Scheme-</option>
                                            @foreach($all_card_schemes as $key => $cardScheme )
                                                <option value="{{$cardScheme->id}}">{{$cardScheme->schemeName}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col col-sm-3">
                                        <input type="file" name="template"  style="font-size:11px;">
                                        <input type="submit" value="Upload Batch Template"  style="font-size:11px;" class="btn btn-sm btn-success">
                                        <input type="hidden" name="parentCustomerId" value="{{$customer->id}}">
                                    </div>

                                </fieldset>
                            </form>
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
@section('section_title') <i class="fa fa-arrows-alt" style="color:#00a65a"></i>&nbsp;&nbsp;Batch Upload - Customer Accounts @stop
@section('scripts')
    <script>

    </script>
@stop

