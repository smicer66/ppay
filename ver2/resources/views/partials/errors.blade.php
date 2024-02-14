
@if(Session::has('message'))
    <div>&nbsp;</div>
    <div class="alert alert-dismissible alert-success" style="padding:5px !important;">
        <button type="button" class="close" data-dismiss="alert">X</button>
        <?php echo Session::get('message'); ?>
    </div>
@endif
@if(Session::has('error'))
    <div>&nbsp;</div>
    <div class="alert alert-dismissible alert-danger" style="padding:5px !important;">
        <button type="button" class="close" data-dismiss="alert">X</button>
        <?php echo Session::get('error'); ?>
    </div>
@endif
@if($errors->any())
    <div>&nbsp;</div>
    <div class="alert alert-dismissible alert-danger" style="padding:5px !important;">
        <ul class="alert alert-danger" style="list-style-type: none">
            @foreach($errors->all() as $error)
                <li> <small>-</small> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
