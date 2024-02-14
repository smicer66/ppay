@section('title') Pricing @stop
@extends('layouts.guest')
@section('content')
    <br /><br /><br />
    <section class="packages" id="packages">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title st-center">
                        <!--<h3>Our Packages</h3>-->
                        <p>Choose Package</p>
                        @include('partials.errors')
                    </div>
                </div>
            </div>
            <div class="row">
			<!--bronze: #cd7f32
			
			-->
                @if($packages->count() != 0)
                    @foreach($packages->get() as $sub)
                        <div class="col-md-4">
                            <div class="pricing-table">
                                <div class="pricing-header">
									@if($sub->name=='Bronze Package')
                                    <div class="pt-price" style="background-color:#cd7f32"><span class="naira">ZMW</span>{!! $sub->amount_word !!}
									@elseif($sub->name=='Gold Package')
                                    <div class="pt-price" style="background-color:#ffd700"><span class="naira">ZMW</span>{!! $sub->amount_word !!}
									@elseif($sub->name=='Silver Package')
                                    <div class="pt-price" style="background-color:#c0c0c0"><span class="naira">ZMW</span>{!! $sub->amount_word !!}
									@endif
                                        {{--<small>Per Year</small>--}}
                                    </div>

                                    <div class="pt-name">{!! $sub->name !!}</div>
                                </div>
                                <div class="pricing-body">
                                    @if($sub->packageFeatures->count() != 0)
                                        <ul>
                                            @foreach($sub->packageFeatures as $feature)
                                                <li><i class="fa fa-check"></i> {!! $feature->feature->name !!}</li>
                                            @endforeach
											<li style="color: red"><i class="fa fa-check" style="color: red"></i> Maximum {{$sub->maximum_users}} Users</li>
                                        </ul>
                                    @endif
                                </div>
                                <div class="pricing-footer">
                                    <a href="/auth/register/{!! encrypt($sub->id) !!}" class="btn btn-default">Purchase</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4>We currently do not have any package available yet.</h4>
                @endif
            </div>
        </div>
    </section>
@stop