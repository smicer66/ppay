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
                        <p>Forgot Your Password?</p>

                        <h3>Please enter your login Username</h3>
                    </div>
                    <div class="block">
                        @include('partials.errors')
                        <div class="col-md-8 col-md-offset-2">
                            {!! Form::open(['url' => 'auth/forgot-my-password', 'method' => 'post', 'class' => 'form']) !!}
                            <div class="form-group col-md-12">
                                <label for="username">Email</label>
                                <input type="text" class="form-control" name="username" placeholder="Your username">
                            </div>
                            <div class="clearfix"></div>
                            {!! Form::submit("Retrieve Password",array('class' => 'btn btn-main btn-lg pull-right')) !!}
                            <div class="clearfix"></div>
                            {!! Form::close() !!}
                            <hr/>
                            <p>
                                Already Have An Account? <br> <a href="/auth/login">Login </a> | <a
                                        href="/auth/register">Create an account</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection