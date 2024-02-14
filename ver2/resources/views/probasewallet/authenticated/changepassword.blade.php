@extends('probasewallet.authenticated.layout.layout')
@section('title')  ProbaseWallet | Change Password @stop

@section('content')


    <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <form action="/user/password-change" method="POST" name="PayWalletForm" >
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
                                <h4 class="title">Change Password</h4>
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
                                                <label for="exampleInputEmail1">Current Password</label>
                                                <div><input name="password" type="password" placeholder="Current Password" class="form-control border-input"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <div><input name="newpassword" type="password" placeholder="Your New Password" class="form-control border-input"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Confirm Name</label>
                                                <div><input name="confirmnewpassword" type="password" placeholder="Confirm Your New Password" class="form-control border-input"></div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="clearfix"></div>
                                    <div class="text-right">
                                        <button id="paycustomer" type="submit" class="btn btn-success btn-fill btn-wd" onclick="javascript:handleSubmit();">Change Password</button>
                                    </div>
                                    <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
        </div>

@stop


@section('scripts')
    <script type="text/javascript">
        function handleSubmit()
        {
            this.document.getElementById('paycustomer').disabled = 'disabled';
            this.document.PayWalletForm.submit();
        }

    </script>
@stop