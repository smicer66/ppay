@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Card Batch Upload @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="row">
    <!-- right column -->
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><strong>Step 1:</strong> Card Batch Template Download</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start
            <form class="form-horizontal" autocomplete="off" action="/potzr-staff/ecards/batch-card-upload" method="post" enctype="multipart/form-data"> -->
                <div class="box-body">
					<div class="col col-md-12">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-12 control-label">Download Template</label>
							<label for="inputEmail3" class="col-sm-12 control-label">
								<a href="/potzr-staff/ecards/download-batch-card-template" class="btn btn-sm btn-success pull-left"><i class="fa fa-download"></i> Download</a>
							</label>
						</div>
						
					</div>
                </div>
                
                <!-- /.box-body -->
                <div class="box-footer">
                    
                </div>
                <!-- /.box-footer
            </form> -->
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>



<div class="row">
    <!-- right column -->
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><strong>Step 2:</strong> Card Batch Upload</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/potzr-staff/ecards/batch-card-upload" method="post" enctype="multipart/form-data">
                <div class="box-body">
					
					
					<div class="col col-md-12">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-12 control-label">Upload Filled Template</label>
							<label for="inputEmail3" class="col-sm-12 control-label">
								<div class="col col-md-4">
									<select name="acquirer" class="form-control">
										<option value>-Select Acquirer-</option>
										<option value="TUTUKA">Tutuka</option>
									</select>
								</div>
								<div class="col col-md-12" style="padding-top: 20px !important">
									<input type="file" name="template">&nbsp;
								</div>
								<div class="col col-md-12">
									<button type="submit" class="btn btn-sm btn-success pull-left"><i class="fa fa-upload"></i> Upload</a>
								</div>
							</label>
						</div>
					</div>
                </div>
                
                <!-- /.box-body -->
                <div class="box-footer">
                    
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') Batch Upload @stop
@section('scripts')

@stop