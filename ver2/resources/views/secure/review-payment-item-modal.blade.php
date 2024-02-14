

<div class="pull-right" style="padding-right: 30px; padding-top:5px;">
	<a href="javascript:closeModals()"><i class="fa fa-close"></i></a>
</div>
<div class="reserve-box mt-30">
	<h5>{{$company->companyName}}</h5>
	<div class="container-fluid invoice-container" style="padding-top:20px !important" id="section-to-print">
		
		<div class="panel panel-default">
			<div class="panel-heading" style="padding-left:10px !important">
				<div class="col col-md-7" style="padding:0px !important">
					<h3 class="panel-title"><strong>{{$title}}</strong></h3>
				</div>
				<div class="col col-md-4 text-right pull-right" style="padding:0px !important;">
					<select class="form-control" id="menus" onchange="javascript:handleDashboardFunctions('menus')">
						<option>-Select An Action-</option>
						<option value="0">My Dashboard</option>
						<option value="1">New Menu</option>
						@if($company->restaurant->provideReservation!=null && $company->restaurant->provideReservation==1)
						<option value="101">Table Availability</option>
						@endif
						<option value="2">List Menus</option>
						<option value="3">View Transactions</option>
						<option value="4">View Table Reservations</option>
						<!--<option value="5">Restaurant Settings</option>-->
						<option value="6">New Promotions</option>
						<option value="7">View Promotions</option>
						<option value="8">New Slider</option>
						<option value="9">View Sliders</option>
						<option value="10">New Subscription</option>
						<option value="11">View Subscriptions</option>
					</select>
				</div>
			</div>

			@include('errors.errors-jq')
			<div class="panel-body" style="clear:both">
				<div class="table-responsive">
					<table class="table table-condensed">
						<thead>
							@if($key==RESTAURANT_LIST_MENUS)
							<tr>
								<th width="5%"><strong>S/N</strong></th>
								<th><strong>Menu Name</strong></th>
								<th width="20%" class="text-center"><strong>Meal Theme & Class</strong></th>
								<th width="5%" class="text-center"><strong>Duration</strong></th>
								<th width="20%" class="text-right"><strong>Pricing(K)</strong></th>
								<th width="20%" class="text-right"><strong>Action</strong></th>
							</tr>
							@elseif($key==RESTAURANT_LIST_RESTAURANT_TRANSACTIONS)
							<tr>
								<td width="5%"><strong>S/N</strong></td>
								<td><strong>Order Id/Transaction Ref</strong></td>
								<td width="5%"><strong>Payers Details</strong></td>
								<td width="20%"><strong>Transaction Type</strong></td>
								<td width="20%" class="text-right"><strong>Status</strong></td>
								<td width="20%" class="text-right"><strong>Amount(K)</strong></td>
							</tr>
							@elseif($key==RESTAURANT_LIST_RESTAURANT_RESERVATIONS)
							<tr>
								<td width="5%"><strong>S/N</strong></td>
								<td><strong>Customer Details</strong></td>
								<td width="5%"><strong>Table Type</strong></td>
								<td width="20%"><strong>Reservation Option</strong></td>
								<td width="20%" class="text-right"><strong>Status</strong></td>
								<td width="20%" class="text-right"><strong>Amount(K)</strong></td>
							</tr>
							@elseif($key==RESTAURANT_LIST_RESTAURANT_PROMOTIONS)
							<tr>
								<td width="5%"><strong>S/N</strong></td>
								<td width="15%" class="text-right"><strong>Promotion Code</strong></td>
								<td><strong>Promotion Title</strong></td>
								<td width="15%"><strong>Period</strong></td>
								<td width="15%"><strong>Percentage Off</strong></td>
								<td width="10%" class="text-right"><strong>Status</strong></td>
								<td width="5%" class="text-right"><strong>Action</strong></td>
							</tr>
							@elseif($key==RESTAURANT_LIST_RESTAURANT_SLIDERS)
							<tr>
								<td width="5%"><strong>S/N</strong></td>
								<td width="15%" class="text-left"><strong>Slider Code</strong></td>
								<td><strong>Slider Title</strong></td>
								<td width="15%"><strong>Period</strong></td>
								<td width="10%" class="text-left"><strong>Status</strong></td>
								<td width="5%" class="text-right"><strong>Action</strong></td>
							</tr>
							@elseif($key==LIST_COMPANY_SUBSCRIPTIONS)
							<tr>
								<td width="5%"><strong>S/N</strong></td>
								<td width="15%" class="text-left"><strong>Order Id</strong></td>
								<td><strong>Subscription Plan</strong></td>
								<td width="20%"><strong>Period</strong></td>
								<td width="10%" class="text-right"><strong>Amount</strong></td>
							</tr>
							@endif
						</thead>
						<tbody>
							<?php $x=1; ?>
							@if($key==RESTAURANT_LIST_MENUS)
								@foreach($data as $li)
									<?php
									$pp = str_replace('"', '', $li->servingTimes);
									$pp = str_replace('|||', ' (', $pp);
									$pp = str_replace(',', '), ', $pp);
									?>
								<tr>
									<td>{{$x++}}.</td>
									<td><a href="/restaurants/{{$li->restaurant->company->slug_url}}/restaurant-menu/{{$li->menu_slug_url}}/{{$li->id}}">{{$li->mealName}}</a></td>
									<td class="text-center">{{$li->mealTheme}} / {{$li->mealType}}</td>
									<td class="text-center">{{$li->preparationDuration}} Mins</td>
									<td class="text-right">K{{number_format($li->lowerAmountPerPlate, 2, '.', ',')}} - 
									K{{number_format($li->upperAmountPerPlate, 2, '.', ',')}}</td>
									<td class="text-right">
										<div class="btn-group">
											<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action <span class="fa fa-caret-down"></span></button>
											<ul class="dropdown-menu" style="left: inherit;right:0 !important">
												<li><a href="/admin/restaurants/add-menu/{{$li->menu_slug_url}}">Update Meal</a></li>
												@if($li->status == 'Inactive')
													<li><a href="/admin/restaurants/menu/status/publish/{{$li->menu_slug_url}}">Publish Meal</a></li>
												@elseif($li->status == 'Active')
													<li><a href="/admin/restaurants/menu/status/unpublish/{{$li->menu_slug_url}}">Un-Publish Meal</a></li>
												@endif
											</ul>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="6"><strong style="text-decoration:underline">Serve Times:</strong> <i>{{strtoupper($pp)}}</i></td></td>
								</tr>
								<tr>
									<td colspan="6"></td></td>
								</tr>
								@endforeach
							@elseif($key==RESTAURANT_LIST_RESTAURANT_TRANSACTIONS)
								@foreach($data as $li)
									<tr>
										<td>{{$x++}}.</td>
										<td>{{$li->orderId}}/{{$li->transactionRef}}</td>
										<td width="5%">{{$li->payeeUserFullName}}<br>{{$li->payeeUserMobile}}</td>
										<td width="20%">{{$li->transactionType}}</td>
										@if($li->status=='Success')
											<td width="20%" class="text-right"><span class="text-success">{{$li->status}}</span></td>
										@elseif($li->status=='Fail')
											<td width="20%" class="text-right"><span class="text-danger">{{$li->status}}</span></td>
										@else
											<td width="20%" class="text-right"><span class="text-primary">{{$li->status}}</span></td>
										@endif
										<td width="20%" class="text-right">{{number_format($li->amount, 2, '.', ',')}}</td>
									</tr>
									@if($li->restaurantReservation!=null)
									<tr>
										<td colspan="6">
											
											<?php
											$reservation = json_decode($li->restaurantReservation->menuOrder, TRUE);
											?>
											<strong style="text-decoration:underline">Reservation:</strong> <i>{{($reservation['mealName'])}} x ({{$li->restaurantReservation->orderCount}}) | 
											{{$reservation['mealType']}} | {{$reservation['mealTheme']}} | Preferred Option: {{$li->restaurantReservation->reserveOption}}</i>
											
										</td>
										
									</tr>
									@endif
									<tr>
										<td colspan="6"></td></td>
									</tr>
								@endforeach
							@elseif($key==RESTAURANT_LIST_RESTAURANT_RESERVATIONS)
								@foreach($data as $li)
									<tr>
										<td width="5%"><span>{{$x++}}.</span></td>
										<td><span>{{$li->customerName}}<br>{{$li->mobileNumber}}</span></td>
										<td width="20%"><span>{{$li->tableType}}</span></td>
										<td width="20%"><span>{{$li->reserveOption}}</span></td>
										<td width="10%" class="text-right"><span>{!! $li->paidYes==1 ? '<span class="text-success">Paid</span>' : '<span class="text-danger">Not Paid</span>' !!}</span></td>
										<td width="20%" class="text-right"><span>{{ number_format($li->amountCharged, 2, '.', ',') }}</span></td>
									</tr>
									<tr>
										<td colspan="6">
											
											<?php
											$reservation = json_decode($li->menuOrder, TRUE);
											?>
											<strong style="text-decoration:underline">Reservation:</strong> <i>{{($reservation['mealName'])}} x ({{$li->orderCount}}) | 
											{{$reservation['mealType']}} | {{$reservation['mealTheme']}}</i>
											
										</td>
										
									</tr>
									<tr>
										<td colspan="6"></td></td>
									</tr>
								@endforeach
							@elseif($key==RESTAURANT_LIST_RESTAURANT_PROMOTIONS)
								@foreach($data as $li)
									<tr>
										<td width="5%"><span>{{$x++}}</span></td>
										<td width="15%" class="text-left">{{$li->promotionCode}}</td>
										<td>{{$li->promotionTitle}}</td>
										<td width="15%"><span>{{$li->period}}</span></td>
										<td width="15%"><span>{{$li->percentage}}%</span></td>
										<td width="10%" class="text-right"><span>{{$li->status}}</span></td>
										<td class="text-right">
											<div class="btn-group">
												<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action <span class="fa fa-caret-down"></span></button>
												<ul class="dropdown-menu" style="left: inherit;right:0 !important">
													<li><a href="/admin/restaurants/new-promotions/{{$li->promotionCode}}">Update Promotion</a></li>
													@if($li->status == 'Inactive')
														<li><a href="/admin/restaurants/promotion/status/publish/{{$li->promotionCode}}">Publish Promotion</a></li>
													@elseif($li->status == 'Active')
														<li><a href="/admin/restaurants/promotion/status/unpublish/{{$li->promotionCode}}">Un-Publish Promotion</a></li>
													@endif
												</ul>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="7">
											<i>{{$li->description}}</i>
										</td>
										
									</tr>
									<tr>
										<td colspan="7"></td>
									</tr>
								@endforeach
							@elseif($key==RESTAURANT_LIST_RESTAURANT_SLIDERS)
								@foreach($data as $li)
									<tr>
										<td width="5%"><span>{{$x++}}.</span></td>
										<td width="20%" class="text-left"><span>{{$li->sliderCode}}</span></td>
										<td><span><a href="/restaurants/{{$li->restaurantSlugUrl}}{{$li->restaurantMenuSlugUrl==null ? '' : '/restaurant-menu/'.$li->restaurantMenuSlugUrl.'/'.$li->restaurantMenuId}}">{{$li->title}}</a></span></td>
										<td width="20%"><span>{{$li->startDate}} - {{$li->endDate}}</span></td>
										<td width="10%" class="text-left"><span>{{$li->status==0 ? 'Inactive' : 'Active'}}</span></td>
										<td width="5%" class="text-right">
											<div class="btn-group">
												<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action <span class="fa fa-caret-down"></span></button>
												<ul class="dropdown-menu" style="left: inherit;right:0 !important">
													<li><a href="/admin/restaurants/new-slider/{{$li->sliderCode}}">Update Slider</a></li>
													@if($li->status == '0')
														<li><a href="/admin/restaurants/slider/status/publish/{{$li->sliderCode}}">Publish Slider</a></li>
													@elseif($li->status == '1')
														<li><a href="/admin/restaurants/slider/status/unpublish/{{$li->sliderCode}}">Un-Publish Slider</a></li>
													@endif
												</ul>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="6">
											<i>{{$li->details}}</i>
										</td>
										
									</tr>
									<tr>
										<td colspan="7"></td>
									</tr>
								@endforeach
							@elseif($key==LIST_COMPANY_SUBSCRIPTIONS)
								@foreach($data as $li)
									<tr>
										<td width="5%"><span>{{$x++}}</span></td>
										<td width="15%" class="text-left"><span>{{$li->orderRef}}</span></td>
										<td><span>{{$li->subscriptionPlan}}</span></td>
										<td width="20%"><span>{{$li->startDate}} to {{$li->endDate}}</span></td>
										<td width="10%" class="text-right"><span>{{number_format($li->amount, 2, '.', ',')}}</span></td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="pull-right btn-group btn-group-sm hidden-print">
			<a href="javascript:printDiv('section-to-print')" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
		</div>
	</div>
</div>