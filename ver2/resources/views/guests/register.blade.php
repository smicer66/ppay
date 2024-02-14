@extends('layouts.guest')
@section('content')
    <section class="signup">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="section-title">
                        <p>Create Account</p>
                    </div>
                    @include('partials.errors')
                    <div class="block">
                        {!! Form::open(['url' => 'potzr-staff/register','class' => 'form']) !!}
                        <div class="form-group col-md-7">
                            <label for="email">Email</label>
                            {!! Form::email('username', '', ['class' => 'form-control', 'placeholder' => 'Email address']) !!}
                        </div>
                        <div class="form-group col-md-7">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Your password">
                        </div>
                        <div class="form-group col-md-7">
                            <label for="cmPassword">Confirm Password</label>
                            {!! Form::password('password_confirmation',array('class' => 'form-control', 'placeholder' => 'Confirm Password')) !!}
                        </div>
                        <div class="form-group col-md-7">
                            <div class="form-group">{!! Recaptcha::render() !!}</div>
                            {!! Form::hidden('packageId', $packageId) !!}
                        </div>
                        <div class="clearfix"></div>
                        <hr/>
                        {!! Form::button("Cancel",array('class' => 'btn btn-default btn-lg')) !!}
                        {!! Form::submit("Create Account",array('class' => 'btn btn-main btn-lg pull-right')) !!}<br />
						<a href="/auth/login" class="pull-right">Already Have An Account? Sign In</a>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="col-md-3 side-tips">
                    <h3><i class="fa fa-info-circle"></i> Helpful Tips</h3>
                    <hr/>
                    <ul class="list-unstyled">
                        <li>Creating an account is the first step towards purchasing a package plan on Shikola</li>
                        <li>You can use your new account to purchase new packages for other schools on Shikola</li>
                    </ul>
                </div>
            </div>
        </div>

    </section>
@stop

@section('title') Register @stop