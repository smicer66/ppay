@extends('probasewallet.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Recent Transactions</h4>
                                <p class="category">Transaction Listing Across Your Accounts</p>
                            </div>
                            <?php
                              $x = 1;
                            ?>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-striped">
                                    <thead>
                                        <th>ID</th>
                                        <th>Transaction Type</th>
                                        <th>Transaction Date</th>
                                    	<th>Bank</th>
                                    	<th>Account No</th>
                                    	<th>Transaction Ref</th>
                                    	<th>Amount(ZMW)</th>
                                    </thead>
                                    <tbody>
                                        @foreach($transactionList as $transaction)
                                            <?php

                                                    $account=$transaction->account;
                                                    $cr = $transaction->creditWalletTrue == true ? "Credit" : "Debit"
                                            ?>
                                        <tr>
                                        	<td>{{$x++}}</td>
                                            <td>{{$cr}}</td>
                                        	<td>{{$transaction->transactionDate}}</td>
                                            <td>{{$account->bank->bankName}}</td>
                                        	<td>{{$account->accountIdentifier}}</td>
                                        	<td>{{$transaction->transactionRef}}</td>
                                        	<td>{{number_format($transaction->amount, 2, '.', ',')}}</td>
                                        </tr>
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


