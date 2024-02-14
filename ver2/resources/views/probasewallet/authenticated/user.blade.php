@extends('probasewallet.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')


    <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-md-5">
                        <div class="card card-user">
                            <div class="image">
                                <img src="/assets/img/background.jpg" alt="..."/>
                            </div>
                            <div class="content">
                                <div class="author">
                                  <img class="avatar border-white"
                                       src="{{(isset(\Auth::user()->profile_pix) && \Auth::user()->profile_pix!=NULL) ? \Auth::user()->profile_pix : "/assets/img/faces/face-2.jpg" }}" alt="..."/>
                                  <h4 class="title">{{\Auth::user()->firstName}} {{\Auth::user()->lastName}}<br />
                                     <a href="#"><small>{{\Auth::user()->username}}</small></a>
                                  </h4>
                                </div>
                            </div>
                            <hr>
                        </div>

                    </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Edit Profile</h4>
                            </div>
                            <div class="content">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <div>{{\Auth::user()->username}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <div>{{\Auth::user()->userEmail}}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <div>{{\Auth::user()->firstName}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <div>{{\Auth::user()->lastName}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Other Name</label>
                                                <div>{{\Auth::user()->otherName}}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Wallet Code</label>
                                                <div>{{\Auth::user()->wallet_code}}</div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

@stop