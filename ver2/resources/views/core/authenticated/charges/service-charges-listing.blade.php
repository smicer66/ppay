@extends('core.authenticated.layout.layout1')
@section('title')  ProbasePay | Bank Teller @stop

@section('content')

@include('partials.errors')
<div class="col-md-8 col-sm-12">
<div class="row">
  <div class="col-sm-12">
    <div class="element-wrapper">
      <div class="element-box">
        <form id="formValidate">
          <h5 class="form-header">
            Service Charge List
          </h5>
          <div class="form-desc">
            All service charges with their valuations are listed below
          </div>
          
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
			
                	<div class="table-responsive">
				<div></div>
				
                                
                                <tbody>
					@foreach($serviceChargeList as $componentCharge => $scList)
				<table id="" width="100%" class="table table-striped table-lightfont">
				    <thead>
                                    <tr role="row" style="background-color: #000000; color: #fff; font-size: 12px !important;">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending" width="40%" 
                                            aria-label="Rendering engine: activate to sort column descending"><strong>Charge Component</strong></th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending" width="30%"
                                            aria-label="Rendering engine: activate to sort column descending"><strong>Value Type</strong></th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending" width="15%"
                                            aria-label="Rendering engine: activate to sort column descending"><strong>Value</strong></th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending"><strong>Action</strong></th>
                                    </tr>
                                </thead>
                                    <tr role="row" class="odd">
                                        	<td colspan="3">
                                            <strong>{{$allServiceTypes[$componentCharge]}}</strong>
                                        </td>
						<td><a class="btn btn-sm btn-primary" href="/accountant/service-charges/new-service-charge/{{$componentCharge}}/{{$allServiceTypes[$componentCharge]}}">Add/Edit Charge</a></td>
                                    </tr>
                                    @foreach($scList as $sc)

                                    <tr role="row" class="odd">
                                        	<td class="sorting_1">
							{{$sc->chargeName}}
						</td>
                                        	<td class="sorting_1">
							{{$chargeTypes[$sc->valueType]}}
						</td>
                                        	<td class="sorting_1">
							
							@if($sc->valueType==0)
								{{number_format($sc->valuation, 3, '.', ',')}}%
							@else
								K{{number_format($sc->valuation, 3, '.', ',')}}
							@endif
						</td>
                                        	<td>
							<!--<div class="btn-group mr-1 mb-1">
        							<button aria-expanded="false" aria-haspopup="true" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton2" type="button">Action</button>
        							<div aria-labelledby="dropdownMenuButton2" class="dropdown-menu">
          								<a class="dropdown-item" href="/accountant/service-charges/delete-service-charge/{{$sc->id}}">Delete Service Charge</a>

        							</div>
      							</div>-->
                                        </td>
                                    </tr>
                                    @endforeach

				
                                </tbody>
				</table>
<hr>
<br>
<br>
					@endforeach


				

				
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
@section('section_title') New Service Charge(s) @stop
@section('scripts')

@stop