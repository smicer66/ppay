@extends('core.authenticated.layout.layout1')
@section('title')  ProbasePay | Bank Teller @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="col-md-10 col-sm-12">
<div class="row">
  <div class="col-sm-12">
    <div class="element-wrapper">
      <div class="element-box">
        <form id="formValidate">
          <h5 class="form-header">
            External Settlement Accounts
          </h5>
          <div class="form-desc">
            Provide the account numbers for the services where settlement is applicable
          </div>
          
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                	<div class="table-responsive">
				<table id="" width="100%" class="table table-striped table-lightfont">
				    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Service Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Bank</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Account Number</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Branch Code</th>
                                    </tr>
                                </thead>
                                <?php
                                $x=1;
                                ?>
                                <tbody>
                                    @foreach($serviceList as $key => $service)
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">{{$service}}</td>
                                        <td>
							<select class="form-control" required="required" name="bank" data-error="Select the bank this pool account belongs to">
								<option value>-Select A Bank-</option>
                     					@foreach($allBanks as $bank)
                     					<option value="{{$bank->id}}">{{$bank->bankName}}</option>
                     					@endforeach
               					</select></td>
                                        <td><input class="form-control" data-minlength="1" placeholder="Enter Account Number" name="account_number[]" required="required" step="0.0001" type="number" data-error="Specify the account number to credit"></td>
                                        <td><input class="form-control" data-minlength="1" placeholder="Enter Value" name="account_number[]" required="required" step="0.0001" type="number" data-error="Specify the branch code to credit"></td>

                                    </tr>
                                    @endforeach
                                </tbody>
				</table>
                  </div>
              </div>
            </div>
            
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>
</div>




@stop