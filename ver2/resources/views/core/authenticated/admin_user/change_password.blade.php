@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Staff @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="row">
    <!-- right column -->
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Change Password</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/user/password-change" method="post" enctype="multipart/form-data">
                <div class="box-body">


                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Current Password</label>

                        <div class="col-sm-9">
                            <input type="password" class="form-control col col-sm-4" id="password"  required  name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">New Password</label>

                        <div class="col-sm-9">
                            <input type="password" class="form-control col col-sm-4" id="newpassword"  required  name="newpassword">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Confirm New Password</label>

                        <div class="col-sm-9">
                            <input type="password" class="form-control col col-sm-4" id="confirmnewpassword"  required  name="confirmnewpassword">
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Change My Password</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') New Admin Staff Account @stop
@section('scripts')
<script>

    function displayBankDetail()
    {
        var role_type = document.getElementById('role_type').value;
        console.log("role_type == " + role_type);
        document.getElementById('bankSection').style.display = 'none';
        if(role_type=='BANK_STAFF'){
            document.getElementById('bankSection').style.display = 'block';
        }

    }


    jQuery(function () {
        $("#province").on('change', function () {
            alert("We testify");
            var $this = $(this);
            var district = $("#district");
            var provinceId = $(this).val();
            //lga.html('loading...');
            $.ajax({
                url: '/utility/services/pull-district/' + provinceId,
                dataType: 'json',
                success: function (resp) {
                    if (resp.status === 1) {
                        $.each(resp.data, function (k, v) {
                            district.append($('<option>', {
                                value: k,
                                text: v
                            }));
                        });
                        district.prepend($('<option>', {
                            text: 'Select District',
                            value: null
                        }));
                    }
                },
                complete: function () {
                    $this.removeClass('disabled');
                    $("#district").removeClass('disabled');
                }
            });
        });
    });
</script>
@stop