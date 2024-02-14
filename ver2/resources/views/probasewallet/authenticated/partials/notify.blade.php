<?php
$message = "";
$i=0;
$msgType="";
if(Session::has('message')){
    $message = Session::get('message');
    $i=1;
    $msgType="success";
}

if(Session::has('error')){
    $message = Session::get('error');
    $i=2;
    $msgType="error";
}

if($errors->any())
{
    $message = "";
    foreach($errors->all() as $error)
    {
        $message = $message."<li> <small>-</small> ".$error."</li>";
        $i=3;
        $msgType="error";
    }
}

?>

<script type="text/javascript">
    @if($i>0)
        $(document).ready(function(){

            /*$.notify({
                icon: 'ti-gift',
                message: '<?php echo $message; ?>'

            },{
                type: '<?php echo $msgType; ?>',
                timer: 4000
            });*/
            var msg = '<?php echo $message; ?>';
            @if($msgType=='success')
                toastr.success(msg);
            @elseif($msgType=='error')
                toastr.error(msg);
            @endif

        });
    @endif
</script>