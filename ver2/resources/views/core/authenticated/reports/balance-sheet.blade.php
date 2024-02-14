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
            Balance Sheet
          </h5>
          <div class="form-desc">
            Balance sheet covers the transactions from inception
          </div>
          
	
          <div class="row">
			<h4>Assets</h4>
			<div style="clear: both !important">&nbsp;</div> 
                    		<table id="" width="100%" class="table table-striped table-lightfont">
				    <thead>
                                    <tr role="row" style="background-color: #000 !important; color: #fff !important">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending" width="15%"
                                            aria-label="Rendering engine: activate to sort column descending">GL Account Code</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" width="30%"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Description</th>
                                        
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: right">Balance</th>
                                    </tr>
                                </thead>
                                <?php
                                $x=1;
					$totalIncome = 0.00;
					$totalExpense = 0.00;
					$totalEquity = 0.00;
					$totalAssets = 0.00;
					$totalLiability = 0.00;
                                ?>
                                <tbody>
                                    @foreach($assetsJournalEntryList as $journalEntry)
                                   <tr role="row" class="odd">
                                        <td><span style="color: #000 !important">{{$journalEntry->glAccountCode}}</i></span></td>
                                        <td style="text-align: left"><span style="color: #000 !important">{{$journalEntry->glAccountName}}</span></td>
                                        <td style="text-align: right"><span style="color: #000 !important">{{number_format($journalEntry->amount, 2, '.', ',')}}</span></td>
                                    </tr>
						<?php
						if(isset($journalEntry->amount) && $journalEntry->amount!=null)
						{
							$totalAssets = $totalAssets + $journalEntry->amount;
						}
						?>
                                    @endforeach
                                </tbody>
					<tfooter>
                                    <tr role="row" style="background-color: #000 !important; color: #fff !important; font-weight: bold !important;">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending" width="15%"
                                            aria-label="Rendering engine: activate to sort column descending"><strong>TOTAL ASSETS</strong></th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: right"><strong>&nbsp;</strong></th>
						<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: right"><strong>{{number_format($totalAssets, 2, '.', ',')}}</strong></th>
                                    </tr>
                                </tfooter>
				</table>
            
          </div>


			<div style="clear: both !important">&nbsp;</div> 
			<div style="clear: both !important">&nbsp;</div> 

          <div class="row">
			<h4>Equity</h4>
			<div style="clear: both !important">&nbsp;</div> 
                    		<table id="" width="100%" class="table table-striped table-lightfont">
				    <thead>
                                    <tr role="row" style="background-color: #000 !important; color: #fff !important">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending" width="15%"
                                            aria-label="Rendering engine: activate to sort column descending">GL Account Code</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" width="30%"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Description</th>
                                        
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: right">Balance</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($equityJournalEntryList as $journalEntry)
                                   <tr role="row" class="odd">
                                        <td><span style="color: #000 !important">{{$journalEntry->glAccountCode}}</i></span></td>
                                        <td style="text-align: left"><span style="color: #000 !important">{{$journalEntry->glAccountName}}</span></td>
                                        <td style="text-align: right"><span style="color: #000 !important">{{number_format($journalEntry->amount, 2, '.', ',')}}</span></td>
                                    </tr>
						<?php
						if(isset($journalEntry->amount) && $journalEntry->amount!=null)
						{
							$totalEquity = $totalEquity + $journalEntry->amount;
						}
						?>
                                    @endforeach
                                </tbody>
					<tfooter>
                                    <tr role="row" style="background-color: #000 !important; color: #fff !important; font-weight: bold !important;">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending" width="15%"
                                            aria-label="Rendering engine: activate to sort column descending"><strong>TOTAL EQUITY</strong></th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: right"><strong>&nbsp;</strong></th>
						<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: right"><strong>{{number_format($totalEquity, 2, '.', ',')}}</strong></th>
                                    </tr>
                                </tfooter>

	
						<?php
						foreach($incomeJournalEntryList as $journalEntry)
						{
							if(isset($journalEntry->amount) && $journalEntry->amount!=null)
							{
								$totalIncome = $totalIncome + $journalEntry->amount;
							}
						}
						foreach($expenseJournalEntryList as $journalEntry)
						{
							if(isset($journalEntry->amount) && $journalEntry->amount!=null)
							{
								$totalExpense = $totalExpense + $journalEntry->amount;
							}
						}
						$profits = $totalIncome - $totalExpense;
						?>
                                    
					<tfooter>
                                    	<tr role="row" style="background-color: #000 !important; color: #fff !important; font-weight: bold !important;">
                                        		<th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending" width="15%"
                                            aria-label="Rendering engine: activate to sort column descending"><strong>RETAINED PROFITS</strong></th>
                                        		<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: right"><strong>&nbsp;</strong></th>
							<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: right"><strong>{{number_format($profits, 2, '.', ',')}}</strong></th>
                                    	</tr>
                                </tfooter>
				</table>
      
          </div>


			<div style="clear: both !important">&nbsp;</div> 
			<div style="clear: both !important">&nbsp;</div> 
		<div class="row">
			<h4>Liabilities</h4>
			<div style="clear: both !important">&nbsp;</div> 
                    		<table id="" width="100%" class="table table-striped table-lightfont">
				    <thead>
                                    <tr role="row" style="background-color: #000 !important; color: #fff !important">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending" width="15%"
                                            aria-label="Rendering engine: activate to sort column descending">GL Account Code</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" width="30%"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Description</th>
                                        
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: right">Balance</th>
                                    </tr>
                                </thead>
                                <?php
                                $x=1;
                                ?>
                                <tbody>
                                    @foreach($liabilityJournalEntryList as $journalEntry)
                                   <tr role="row" class="odd">
                                        <td><span style="color: #000 !important">{{$journalEntry->glAccountCode}}</i></span></td>
                                        <td style="text-align: left"><span style="color: #000 !important">{{$journalEntry->glAccountName}}</span></td>
                                        <td style="text-align: right"><span style="color: #000 !important">{{number_format($journalEntry->amount, 2, '.', ',')}}</span></td>
                                    </tr>
						<?php
						if(isset($journalEntry->amount) && $journalEntry->amount!=null)
						{
							$totalLiability = $totalLiability + $journalEntry->amount;
						}
						?>
                                    @endforeach
                                </tbody>
					<tfooter>
                                    <tr role="row" style="background-color: #000 !important; color: #fff !important; font-weight: bold !important;">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending" width="15%"
                                            aria-label="Rendering engine: activate to sort column descending"><strong>TOTAL LIABILITIES</strong></th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: right"><strong>&nbsp;</strong></th>
						<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: right"><strong>{{number_format($totalLiability, 2, '.', ',')}}</strong></th>
                                    </tr>
                                </tfooter>


					<tfooter>
                                    <tr role="row" style="background-color: #000 !important; color: #fff !important; font-weight: bold !important;">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending" width="15%"
                                            aria-label="Rendering engine: activate to sort column descending"><strong>TOTAL LIABILITIES, RETAINED PROFITS & EQUITY</strong></th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: right"><strong>&nbsp;</strong></th>
						<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: right"><strong>{{number_format(($totalIncome - $totalExpense), 2, '.', ',')}}</strong></th>
                                    </tr>
                                </tfooter>
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
<style>

td{
	vertical-align: top !important;
}


</style>
@stop










