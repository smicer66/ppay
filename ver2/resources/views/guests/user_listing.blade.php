

@include('partials.errors')
        <!-- Info boxes --><div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">User List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">


                    <div class="box-header">
                        <h3 class="box-title">User Listing</h3>
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
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">OTP</th>
                                    </tr>
                                </thead>
                                <?php
                                $x=1;
                                ?>
                                <tbody>
                                    @foreach($userListing as $user)
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><?php echo $x++; ?></td>
                                        <td class="sorting_1">{{isset($user->lastName) ? $user->lastName : ""}}
                                            {{isset($user->firstName) ? $user->firstName : ""}} {{isset($user->otherName) ? $user->otherName : ""}}</td>
                                        <td>{{isset($user->username) ? $user->username : ''}}</td>
                                        <td>{{isset($user->otp) ? $user->otp : ''}}</td>
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





@section('section_title') <i class="fa fa-server" style="color:#00a65a"></i>&nbsp;&nbsp;User Listing @stop
@section('scripts')

@stop

@section('extraviews')

@stop