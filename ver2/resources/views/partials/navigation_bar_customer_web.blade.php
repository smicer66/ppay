
<ul class="main-menu">
    <li class="sub-header">
        <span>Layouts</span>
    </li>
    <li class="selected">
        <a href="index.html">
            <div class="icon-w">
                <div class="os-icon os-icon-layout"></div>
            </div>
            <span>Dashboard</span></a>
    </li>
    <li class="sub-header">
        <span>Your Business</span>
    </li>
    <li class="">
        <a style="cursor: pointer" data-target="#wallet_overview_modal" data-toggle="modal" class="" onclick="javascript:handleWalletOverview('{{\Session::get('jwt_token')}}')">
            <div class="icon-w">
                <div class="os-icon os-icon-layers"></div>
            </div>
            <span>Wallet Overview</span></a>
    </li>
    <li class="">

        @if(isset(\Auth::user()->cards_exist) && \Auth::user()->cards_exist===true)
            <a href="layouts_menu_top_image.html">
        @else
            <a style="cursor: pointer" data-target="#cards_overview_modal" data-toggle="modal" class="" onclick="javascript:handleWalletOverview('{{\Session::get('jwt_token')}}')">
        @endif
            <div class="icon-w">
                <div class="os-icon os-icon-layers"></div>
            </div>
            <span>Cards</span></a>
    </li>
    <li class="">
        <a href="/fund-transfers">
            <div class="icon-w">
                <div class="os-icon os-icon-layers"></div>
            </div>
            <span>Transfers</span></a>
    </li>
    <li class="">
        <a href="/transaction-adjustments">
            <div class="icon-w">
                <div class="os-icon os-icon-layers"></div>
            </div>
            <span>Adjustments</span></a>
    </li>
    <li class="">
        <a href="/transactions">
            <div class="icon-w">
                <div class="os-icon os-icon-layers"></div>
            </div>
            <span>Transactions</span></a>
    </li>
    <li class="sub-header">
        <span>Utilities & Bills</span>
    </li>
    <li class="">
        <a style="cursor: pointer" data-target="#pay_utility_modal" data-toggle="modal" class="">
            <div class="icon-w">
                <div class="os-icon os-icon-layers"></div>
            </div>
            <span>Pay Utility</span></a>
    </li>
    <li class="">
        <a href="/utilities-paid">
            <div class="icon-w">
                <div class="os-icon os-icon-layers"></div>
            </div>
            <span>Bills Paid</span></a>
    </li>
    <li class="sub-header">
        <span>Accept Payments</span>
    </li>
    <li class="">
        <a href="/new-merchant">
            <div class="icon-w">
                <div class="os-icon os-icon-layers"></div>
            </div>
            <span>Add Merchant Account</span></a>
    </li>
    <li class="">
        <a href="/view-merchant">
            <div class="icon-w">
                <div class="os-icon os-icon-layers"></div>
            </div>
            <span>View Merchant Account</span></a>
    </li>
    <li class="">
        <a href="/payments-received">
            <div class="icon-w">
                <div class="os-icon os-icon-layers"></div>
            </div>
            <span>Payments Received</span></a>
    </li>
    <li class="">
        <a href="layouts_menu_top_image.html">
            <div class="icon-w">
                <div class="os-icon os-icon-layers"></div>
            </div>
            <span>Switch to Live</span></a>
    </li>
    <li class="sub-header">
        <span>Village Banking</span>
    </li>
    <li class="">
        <a href="/my-groups">
            <div class="icon-w">
                <div class="os-icon os-icon-layers"></div>
            </div>
            <span>My Groups</span></a>
    </li>
    <li class="">
        <a href="/my-group-transactions">
            <div class="icon-w">
                <div class="os-icon os-icon-layers"></div>
            </div>
            <span>VB Transactions</span></a>
    </li>
</ul>
