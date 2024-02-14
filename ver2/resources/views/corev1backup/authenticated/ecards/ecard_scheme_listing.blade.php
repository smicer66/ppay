@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Card Scheme @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes --><div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Card Scheme Listing</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">&nbsp;</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Card Scheme Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Scheme Code</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending">Fixed Charge</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Transaction Fee(%)</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $x="";
                                $y = 1;
                                ?>
                                <tbody>
                                @foreach($cardSchemeList as $scheme)
                                    <?php $x = \Crypt::encrypt($scheme->id); ?>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">{{$y++}}</td>
                                        <td class="sorting_1">{{$scheme->schemeName}}</td>
                                        <td>{{$scheme->schemeCode}}</td>
                                        <td>{{isset($scheme->overrideFixedFee) ? $scheme->overrideFixedFee : "N/A"}}</td>
                                        <td>{{isset($scheme->overrideTransactionFee) ? $scheme->overrideTransactionFee : "N/A"}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-primary" type="button">Action</button>
                                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul role="menu" class="dropdown-menu">
                                                    @if(\Auth::user()->role_code == \App\Models\Roles::$POTZR_STAFF)
                                                        <li><a href="/potzr-staff/ecards/card-scheme-status/deactivate">Deactivate Scheme</a></li>
                                                        <li><a href="/potzr-staff/ecards/new-scheme/{{$x}}">Update Scheme</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
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
@section('section_title') Card Scheme List @stop
@section('scripts')

@stop