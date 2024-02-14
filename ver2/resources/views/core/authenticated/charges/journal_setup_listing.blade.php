@extends('core.authenticated.layout.layout1')
@section('title')  ProbasePay | Charge Component(s) @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="col-md-12 col-sm-12">
<div class="row">
  <div class="col-sm-12">
    <div class="element-wrapper">
      <div class="element-box">

          <h5 class="form-header">
            Journal Entries Setup
          </h5>
          <div class="form-desc">
            Journal entries are made in the system using the configuration setup here
          </div>
          
	
          <div class="row">
				
                    		<table id="" width="100%" class="table table-striped table-lightfont">
				    <thead style="background-color: #000 !important; color: #fff !important; font-size: 12px !important; font-weight: bold !important;">
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" style="font-size: 12px !important" 
                                            rowspan="1" colspan="1" aria-sort="ascending" width="40%" 
                                            aria-label="Rendering engine: activate to sort column descending">Transaction Component</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" style="font-size: 12px !important; font-weight: bold !important;" 
                                            rowspan="1" colspan="1" aria-sort="ascending" width="30%" 
                                            aria-label="Rendering engine: activate to sort column descending">DR  - GL Account</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" width="30%" style="font-size: 12px !important; font-weight: bold !important;"  
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">CR - GL Account</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" width="30%" style="font-size: 12px !important; font-weight: bold !important;"  
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Collections Account</th>
                                        
                                    </tr>
                                </thead>
                                <?php
                                $x=1;
                                ?>
                                <tbody>
                                    @foreach($journalEntryList as $key => $journalEntries)
						<tr role="row" class="even" style="background-color: #595959 !important; color: #ffffff !important;">
                                        		<td class="sorting_1" colspan="4"><strong>{{$allServiceTypes[intVal($key)]}}</strong></td>
                                        
                                   	</tr>
						@foreach($journalEntries as $journalEntry)
                                   <tr role="row" class="odd">
                                        <td class="sorting_1"><span>{{$journalEntry->chargeName}}</span></td>
                                        <td class="sorting_1"><span>{{$journalEntry->glAccountCodeDR}}</span><br>{{$journalEntry->glAccountNameDR}}</td>
                                        <td><span>{{$journalEntry->glAccountCodeCR}}</span><br>{{$journalEntry->glAccountNameCR}}</td>
                                        <td><span>{{isset($journalEntry->collectionAccountIdentifier) && $journalEntry->collectionAccountIdentifier!=null ? $journalEntry->collectionAccountIdentifier : 'N/A'}}</span><br>{{isset($journalEntry->collectionAccountName) && $journalEntry->collectionAccountName!=null ? $journalEntry->collectionAccountName : ''}}</td>
                                        
                                    </tr>
						@endforeach
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










