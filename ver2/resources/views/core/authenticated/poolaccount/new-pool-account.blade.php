@extends('core.authenticated.layout.layout1')
@section('title')  ProbasePay | Pool Account @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="col-md-6 col-sm-12">
<div class="row">
  <div class="col-sm-12">
    <div class="element-wrapper">
      <div class="element-box">
        <form id="formValidate" action="/accountant/pool-accounts/new-pool-account" method="post">
          <h5 class="form-header">
            New Pool Account
          </h5>
          <div class="form-desc">
            This pool account must match one of your pool accounts in any of the banks in the country
          </div>
          <div class="form-group">
            <label for="">Bank</label>
		<select class="form-control" required="required" name="bank" data-error="Select the bank this pool account belongs to">
			<option value>-Select A Bank-</option>
                     @foreach($all_banks as $bank)
                     <option value="{{$bank->id}}">{{$bank->bankName}}</option>
                     @endforeach
               </select>
            <div class="help-block form-text with-errors form-control-feedback"></div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="">Bank Account Number</label><input class="form-control" name="accountNumber" data-minlength="6" data-error="Valid bank account number is needed" placeholder="" required="required" type="number">
                <div class="help-block form-text text-muted form-control-feedback">
                  Enter a valid bank account number for this pool account
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="">Minimum Balance</label><input class="form-control" data-error="Minimum amount not provided" placeholder="" name="minimumBalance" required="required" type="number">
                <div class="help-block form-text text-muted form-control-feedback">
			Enter the minimum amount allowed in this pool account
		  </div>
              </div>
            </div>
          </div>


	   <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="">Branch Code</label><input class="form-control" name="branchCode" data-minlength="3" data-error="Valid bank code is needed" placeholder="" required="required" type="number">
                <div class="help-block form-text text-muted form-control-feedback">
                  Enter a valid branch code for this pool account
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="">Currency</label>
		  <select class="form-control" required="required" name="currency" data-error="Select the currency this pool account operates">
			<option value>-Select A Currency-</option>
                     @foreach(getAllCurrency() as $k => $currency)
                     <option value="{{$k}}">{{$currency}}</option>
                     @endforeach
                </select>
                <div class="help-block form-text text-muted form-control-feedback">
                  Enter a valid branch code for this pool account
                </div>
              </div>
            </div>
          </div>
	   <?php

		$allAcquirers = (json_decode(json_decode(\Session::get('login_1'))->all_acquirers));
	   ?>

	   <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="">Acquirer</label>
		  <select class="form-control" required="required" name="acquirerId" data-error="Select an acquirer for this pool account">
			<option value>-Select An Acquirer-</option>
                     @foreach($allAcquirers as $allAcquirer)
                     <option value="{{$allAcquirer->id}}">{{$allAcquirer->acquirerName}}</option>
                     @endforeach
                </select>
                <div class="help-block form-text text-muted form-control-feedback">
                  Enter an acquirer for this pool account
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="">Is Live/Test Account</label>
		  <select class="form-control" required="required" name="isLive" data-error="Specify live or test environment for this pool account">
			<option value>-Select Test or Live-</option>
                     <option value="0">Its a Test Pool Account</option>
                     <option value="1">Its a Live Pool Account</option>
                </select>
                <div class="help-block form-text text-muted form-control-feedback">
                  Specify if this account is sitting in a test/live environment
                </div>
              </div>
            </div>
          </div>

          
          <div class="form-buttons-w">
            <button class="btn btn-primary" type="submit"> Save Pool Account</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
@stop
@section('section_title') New Pool Account @stop
@section('scripts')

@stop