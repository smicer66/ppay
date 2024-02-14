@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Teller @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="row">
    <!-- right column -->
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Step One - Customer Bio-Data</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php $countries = json_decode(\Auth::user()->all_countries);?>

            <form class="form-horizontal" autocomplete="off" action="/bank-teller/customers/new-customer" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="panel panel-info">
                        <div class="panel-body" style="background-color: #d9edf7 !important">
                            <small>All items with a red asterisk are required</small>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Customer Type<span style="color:red !important">*</span></label>

                        <div class="col-sm-4">
                            <select class="form-control" name="province"  id="province" required>
                                <option value>-Select A Customer Type-</option>
                                @foreach($all_customer_types as $key => $customer_type)
                                    <option value="{{$key}}">{{$customer_type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">First Name<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <input type="text" name="firstName" class="form-control" id="inputEmail3" placeholder="Provide Customers First Name"   required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Last Name<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <input type="text" name="lastName" class="form-control" id="inputEmail3" placeholder="Provide Customers Last Name"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Other Name<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <input type="text" name="otherName" class="form-control" id="inputEmail3" placeholder="Provide Customers Other Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Address Line 1<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <input type="text" name="addressLine1" class="form-control" id="inputEmail3" required placeholder="Provide Customers First Line of Address">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Address Line 2<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <input type="text" name="addressLine2" class="form-control" id="inputEmail3" placeholder="Provide Customers Second Line of Address">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Country Located<span style="color:red !important">*</span></label>

                        <div class="col-sm-4">
                            <select name="countrycode" class="form-control" id="country_current" required>
                                <option value>-Select One-</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Province & District<span style="color:red !important">*</span></label>

                        <div class="col-sm-4">
                            <select class="form-control" name="province"  id="province" required>
                                <option value>-Select Your Province-</option>
                                @foreach($all_provinces as $province)
                                    <option value="{{$province->id}}">{{$province->provinceName}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4 pull-right">
                            <select class="form-control" name="district" id="district" required>
								<option value>-Select Your District-</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Gender</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="gender">
                                <option value="MALE">Male</option>
                                <option value="FEMALE">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Date Of Birth</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="dateOfBirth" name="dateOfBirth"  placeholder="Provide Customers Date of Birth (YYYY-MM-DD)">
                        </div>
                    </div>
					<div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Means of Identification<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <div class="col col-md-4" style="padding:0px !important">
                                <select class="form-control" name="meansOfIdentificationType" style="padding-left:0px !important; " required>
                                    @foreach($all_identification_types as $key => $val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col col-md-8" style="padding-right:0px; padding-left:20px !important">
                                <!--<input required value="0903780448" type="text" name="phoneNumber" class="form-control" style="width:none !important;  font-size:11px;" id="exampleInputPassword1" placeholder="">-->
                                <input type="text" class="form-control" id="meansOfIdentificationNumber" name="meansOfIdentificationNumber" required placeholder="Provide Identification Number">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Contact Mobile No<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <div class="col col-md-4" style="padding:0px !important">
                                <select class="form-control" name="country" style="padding-left:0px !important; " required>
                                    <option value="">-Select One-</option>
                                    @foreach($all_countries as $key => $country)
                                        <option value="{{$country->mobileCode}}">+{{$country->mobileCode}} - ({{$country->name}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col col-md-8" style="padding-right:0px; padding-left:20px !important">
                                <!--<input required value="0903780448" type="text" name="phoneNumber" class="form-control" style="width:none !important;  font-size:11px;" id="exampleInputPassword1" placeholder="">-->
                                <input type="text" class="form-control" id="inputEmail3" name="mobileNo" required placeholder="Provide customers mobile number">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Alternative Mobile No</label>

                        <div class="col-sm-9">
                            <div class="col col-md-4" style="padding:0px !important">
                                <select class="form-control" id="countryalt" style="padding-left:0px !important; " name="countryalt">
                                    <option value="">-Select One-</option>
                                    @foreach($all_countries as $key => $country)
                                        <option value="{{$country->mobileCode}}">+{{$country->mobileCode}} - ({{$country->name}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col col-md-8" style="padding-right:0px; padding-left:20px !important">
                                <!--<input required value="0903780448" type="text" name="phoneNumber" class="form-control" style="width:none !important;  font-size:11px;" id="exampleInputPassword1" placeholder="">-->
                                <input type="text" class="form-control" id="inputEmail3" name="altMobileNo" placeholder="Provide customers alternative mobile number">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Contact Email Address<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="inputEmail3" name="email" required placeholder="Provide customers email address">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Alternative Email Address</label>

                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="inputEmail3" name="altEmail" placeholder="Provide customers alternative email address">
                        </div>
                    </div>
                    <!--<div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Verification Number<br>
                        <small style="color:red">If customer has existing accounts</small>
                        </label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="verificationNumber" id="inputEmail3" required>
                        </div>
                    </div>-->


                    <div class="form-group">
                        <label for="passport_image" class="col-sm-3 control-label">Upload Passport Image:</label>

                        <div class="col-sm-9" style="height: 240px;">
							<input class="form-control" type="file" name="passport_file" accept="image/*;capture=camera">
                            <!--<input class="form-control" type="file" name="passport_file" accept="image/*"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="camera_wrapper" style="display:none">
                            <div id="cam1">
                                <div id="camera"></div>
                            </div>
                            <br />
                            <div id="capture_btn" style="display:none" class="btn btn-sm btn-primary">Capture Snapshot</div>
                            <div id="webcam_movie">&nbsp;</div>
                        </div>
                        <div id="show_saved_img" class="col col-md-2" style="width:160px; height:120px; display:none;"><img src="/photos/member1.png" style="width:160px; height:120px;">
                        </div><!---->
						
                    </div>



                    <div class="clearfix"></div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Next</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </form>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') New Customer Profile @stop
@section('scripts')
<!--<script type="text/javascript" src="/js/webcam.js"></script>-->
<script>
    $(function () {

        $('#dateOfBirth').datepicker({
            format: 'yyyy-mm-dd',
            endDate: '-5y'
        });
    });

	$(function () {
		
	});
	
	

    /*Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach( '#my_camera' );



    function preview_snapshot() {
        // freeze camera so user can preview pic
        Webcam.freeze();

        // swap button sets
        document.getElementById('pre_take_buttons').style.display = 'none';
        document.getElementById('post_take_buttons').style.display = '';
    }

    function cancel_preview() {
        // cancel preview freeze and return to live camera feed
        Webcam.unfreeze();

        // swap buttons back
        document.getElementById('pre_take_buttons').style.display = '';
        document.getElementById('post_take_buttons').style.display = 'none';
    }

    function save_photo() {
        // actually snap photo (from preview freeze) and display it
        Webcam.snap( function(data_uri) {
            // display results in page
            document.getElementById('results').innerHTML =
                    '<h2>Here is your image:</h2>' +
                    '<img src="'+data_uri+'"/>';

            // swap buttons back
            document.getElementById('pre_take_buttons').style.display = '';
            document.getElementById('post_take_buttons').style.display = 'none';
        } );
    }


    /*var stream;
    $( "#c1apture" ).click(function() {
        if(!document.getElementById('camera'))
        {
            alert(34);
            $("#cam1").prepend($('<div id="camera"></div>'));
        }
        alert(22);
        //give the php file path
        webcam.set_api_url( '/webcam/saveimage.php' );
        webcam.set_swf_url( '/js/webcam.swf' );
        webcam.set_quality( 100 ); // Image quality (1 - 100)
        webcam.set_shutter_sound( true ); // play shutter click sound

        var camera = $('#camera');
        camera.html(webcam.get_html(160, 120));

        document.getElementById('capture_btn').style = 'block';
        document.getElementById('camera_wrapper').style = 'block';
        document.getElementById('show_saved_img').setAttribute('style', 'width:160px; height:120px; display:block');

        $('#capture_btn').click(function(){
            //take snap
            webcam.snap();
        });

        //after taking snap call show image
        webcam.set_hook( 'onComplete', function(img){
            $('#show_saved_img').html('<img src="/tmp/' + img + '">');
            document.getElementById('snapshotimage').value = img;
            //reset camera for next shot
            webcam.reset();
        });
    });


    $( "#cancelc1apture" ).click(function() {
        $('#camera').remove();
        document.getElementById('capture_btn').setAttribute('style', 'display: none');
        document.getElementById('camera_wrapper').setAttribute('style', 'display: none');
        document.getElementById('show_saved_img').setAttribute('style', 'width:160px; height:120px; display:none');
        console.log(333);
    });*/

    //jQuery(function () {
        $("#country_current").on('change', function () {
            var $this = $(this);
            var province = $("#province");
            var countryId = $(this).val();
            var district = $("#district");
            //lga.html('loading...');
            $.ajax({
                url: '/utility/services/pull-province/' + countryId,
                dataType: 'json',
                success: function (resp) {
                    province.empty();
                    district.empty();
                    if (resp.status === 1) {
                        $.each(resp.data, function (k, v) {
                            province.append($('<option>', {
                                value: k + '_' + v,
                                text: v
                            }));
                        });
                        province.prepend($('<option>', {
                            text: '-Select Province-',
                            value: null
                        }));
                        district.prepend($('<option>', {
                            text: '-Select District-',
                            value: null
                        }));
                    }
                },
                complete: function () {

                }
            });

        });

        $("#province").on('change', function () {

            var $this = $(this);
            var district = $("#district");
            var provinceId = $(this).val();
            //lga.html('loading...');
            $.ajax({
                url: '/utility/services/pull-district/' + provinceId,
                dataType: 'json',
                success: function (resp) {
                    district.empty();
                    if (resp.status === 1) {

                        $.each(resp.data, function (k, v) {
                            district.append($('<option>', {
                                value: k + '_' + v,
                                text: v
                            }));
                        });
                        district.prepend($('<option>', {
                            text: '-Select District-',
                            value: null
                        }));
                    }
                },
                complete: function () {

                }
            });

        });
    //});



</script>
@stop