@extends('layouts.guest')
@section('content')
    <section class="signup">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @include('partials.errors')
                    <h3>Thank you! for signing up.</h3>
                    <h5>Please check your email. Follow the instruction in your email to complete sign-up</h5>
                    {{--<a href="?resend=true" class="text-danger">Resend Email</a>--}}
                </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('title') Complete Sign up @stop