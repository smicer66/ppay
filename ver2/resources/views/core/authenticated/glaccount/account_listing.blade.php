@extends('core.authenticated.layout.layout1')
@section('title')  ProbasePay | Charge Component(s) @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="col-md-8 col-sm-12">
<div class="row">
  <div class="col-sm-12">
    <div class="element-wrapper">
      <div class="element-box">

          <h5 class="form-header">
            List of GL Accounts
          </h5>
          <div class="form-desc">
            All GL accounts on the system are displayed here
          </div>
          
	
          <div class="row">
                    		<table id="" width="100%" class="table table-striped table-lightfont">
				    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">GL Account Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">GL Account Code</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending">GL Type</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending">Status</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $x=1;
                                ?>
                                <tbody>
                                    @foreach($glAccountList as $glAccount)
                                   <tr role="row" class="odd">
                                        <td class="sorting_1">{{$glAccount->glAccountName}}</td>
                                        <td>{{$glAccount->glAccountCode}}</td>
                                        <td>{{$glAccountTypes[$glAccount->glAccountType]}}</td>
                                        <td>{{isset($glAccount->isLive) && $glAccount->isLive!=null && $glAccount->isLive==1 ? 'Live' : 'UAT'}}</td>
                                        <td>

							<div class="btn-group mr-1 mb-1">
        							<button aria-expanded="false" aria-haspopup="true" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton2" type="button">Action</button>
        							<div aria-labelledby="dropdownMenuButton2" class="dropdown-menu">
          								<a class="dropdown-item" href="/accountant/gl-accounts/new-gl-account/{{($glAccount->id)}}"> Update GL Account</a>
          								<a class="dropdown-item" href="/accountant/gl-accounts/all-journal-entries?glaccountid={{($glAccount->id)}}&glaccountname={{$glAccount->glAccountName}}&glaccountcode={{$glAccount->glAccountCode}}"> View Journal Entries</a>
        							</div>
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
</div>
</div>
@stop
@section('section_title') New Charge Component(s) @stop
@section('scripts')

@stop










