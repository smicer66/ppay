@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Staff Privileges @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="row">
    <!-- right column -->
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Bank Staff Privileges</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/potzr-staff/banks/new-bank-staff" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Staff Full Name</label>

                        <div class="col-sm-9">
                            James Peter
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Bank</label>

                        <div class="col-sm-9">
                            Stanbic Bank
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Priviledges for the User</label>

                        <div class="col-sm-9">
                            <select class="form-control" multiple="multiple" size="20" name="privileges">
                                @foreach(getAllPrivileges() as $key => $priviledgeGroup)
                                    <optgroup label="{{$key}}">
                                        @foreach($priviledgeGroup as $key1 => $value)
                                            <option value="{{$key1}}">{{$value}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-success pull-right">Save Privileges</button>
                    </div>
                    <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') New Bank Staff Account @stop
@section('scripts')

@stop