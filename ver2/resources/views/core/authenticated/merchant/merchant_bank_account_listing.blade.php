@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant Bank Accounts @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes --><div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Merchant Bank Account List</h3>
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
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Merchant Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending">Merchant Code</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Account Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Engine version: activate to sort column ascending">Bank</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Bank Account No</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Branch Code</th>
                                    </tr>
                                </thead>
                                <?php
                                    $x=0;
                                    //dd($merchantList);
                                ?>
                                <tbody>
                                @foreach($merchantBankAccountList as $merchantBankAccount)
                                    <tr role="row" class="{{$x%2==0 ? 'odd' : 'even'}}">
                                        <td class="sorting_1">{{$merchantBankAccount->merchant->merchantName}}</td>
                                        <td>{{$merchantBankAccount->merchant->merchantCode}}</td>
                                        <td>{{$merchantBankAccount->bankAccountName}}</td>
                                        <td>{{$merchantBankAccount->merchantBank->bankName}}</td>
                                        <td>{{$merchantBankAccount->bankAccountNumber}}</td>
                                        <td>{{$merchantBankAccount->merchantBank->bankCode}}</td>
                                    </tr>
                                @endforeach
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
@section('section_title') Merchant Bank Accounts Listing @stop
@section('scripts')

@stop