@extends('layouts.guest')
@section('title') Login @endsection

@section('content')
    <section class="signup">
        <div class="container">
            <div class="row">
                <?php
                $redirect = "";
                $redirect = \Input::get('redirect');
                if (isset($redirect) and strlen($redirect) != 0) {
                    $redirect = \Input::get('redirect');
                }
                ?>
                <div class="col-md-12">
                    <div class="section-title">
                        <p>Login</p>

                        <h3>Please enter your login details</h3>
                    </div>
                    <div class="block">
                        @include('partials.errors')
                        <div class="col-md-8 col-md-offset-2">
                            {!! Form::open(['url' => 'auth/login', 'method' => 'post', 'class' => 'form']) !!}
                            
                            <div class="form-group col-md-12">
                                <label for="username">Email</label>
                                <input type="text" class="form-control" name="username" placeholder="Your username">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Your password">
                            </div>
                            <div class="form-group col-md-7">
                                <div class="checkbox checkbox-success">
                                    <label><input type="checkbox" class="styled">Remember me </label>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            {!! Form::submit("Login",array('class' => 'btn btn-main btn-lg pull-right')) !!}
                            <div class="clearfix"></div>
                            {!! Form::hidden('redirect',$redirect)!!}
                            {!! Form::close() !!}
                            <hr/>
                            <p>
                                Can't sign in? <br> <a href="/auth/recover-password">Recover your password </a> | <a
                                        href="/auth/register">Create an account</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection