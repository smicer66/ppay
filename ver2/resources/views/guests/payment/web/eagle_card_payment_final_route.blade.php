<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>ProbasePay</title>
</head>

<body>

<div class="col-md-12" style="text-align: center; padding:10px !important;">
    @if(isset($response['statusmessage']))
    <span style="background-color: red; color: #fff">{{$response['statusmessage']}}</span>

    @else
    Be patient while we redirect you to your preferred banking platform ...
    @endif
    <form action="{{isset($response['redirectUrl']) ? $response['redirectUrl'] : ''}}" method="{{isset($response['typeMethod']) && $response['typeMethod']!=null ? $response['typeMethod'] : 'POST'}}" id="submitProbasePayForm" name="SubmitProbasePayForm" >
        @foreach($response as $key => $value)
            @if(is_array($response[$key]))
                @foreach($response[$key] as $k1 => $v1)
                <input name="{{$key}}[]" value="{{$v1}}" type="hidden">
                @endforeach
            @else
            <input name="{{$key}}" value="{{$value}}" type="hidden">
            @endif
        @endforeach

        @if(isset($response['statusmessage']))
        <input type="submit" name="submit" id="watchButton" style="display:none" value="Return Back To Merchant Site" class="btn btn-success">
        @endif
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
<script>

$(function() {
    $('#watchButton').click();
});
</script>
</body>

</html>
