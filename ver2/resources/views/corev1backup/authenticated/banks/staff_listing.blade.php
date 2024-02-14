@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Staff @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes --><div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Bank Staff</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">


                    <div class="box-header">
                        <h3 class="box-title">Bank Staff Listing</h3>
                    </div>


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
                                            aria-label="Rendering engine: activate to sort column descending">Full Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending">Email Address</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Bank</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Status</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $x=1;
                                ?>
                                <tbody>
                                    @foreach($bankStaffList as $bankStaff)
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><input type="checkbox" name="accounts[]"></td>
                                        <td class="sorting_1">{{$bankStaff->lastName}}, {{$bankStaff->firstName}} {{$bankStaff->otherName}}</td>
                                        <td>{{$bankStaff->user->username}}</td>
                                        <td>{{$bankStaff->bank->bankName}}</td>
                                        <td>{{$bankStaff->status}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-primary" type="button">Action</button>
                                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul role="menu" class="dropdown-menu">
                                                    @if($bankStaff->status== 'ACTIVE')
                                                    <li><a href="/potzr-staff/bank-staff/disable-staff">Disable Staff</a></li>
                                                    @elseif($bankStaff->status== 'DISABLED' || $bankStaff->status== 'LOCKED')
                                                        <li><a href="/potzr-staff/bank-staff/disable-staff">Reactivate Staff</a></li>
                                                    @endif
                                                    <li><a href="/potzr-staff/bank-staff/priviledges">Priviledges</a></li>
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
@section('section_title') Bank Staff Listing @stop
@section('scripts')

@stop

@section('extraviews')

@stop