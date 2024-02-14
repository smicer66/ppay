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
            List of Charge Components
          </h5>
          <div class="form-desc">
            All charge components on the system are displayed here
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
                                            aria-label="Rendering engine: activate to sort column descending">Charge Component Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $x=1;
                                ?>
                                <tbody>
                                    @foreach($chargecomponentlist as $chargecomponent)
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">{{$chargecomponent->chargeName}}</td>
                                        <td>
                                            	<div class="btn-group mr-1 mb-1">
        							<button aria-expanded="false" aria-haspopup="true" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton3" type="button">Action</button>
        							<div aria-labelledby="dropdownMenuButton3" class="dropdown-menu">
          								<a class="dropdown-item" href="/accountant/service-charges/new-service-charge/{{$chargecomponent->id}}"> Create A Service Charge</a>
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
          
        </form>
      </div>
    </div>
  </div>
</div>
</div>

@stop