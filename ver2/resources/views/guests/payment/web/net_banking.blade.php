<html>
<head>
    <title>ProbasePay</title>
</head>

<body onLoad="document.SubmitProbasePayForm.submit()">
Be patient while we redirect you to your preferred banking platform....
<form action="{{$response['redirectUrl']}}" method="{{isset($response['typeMethod']) && $response['typeMethod']!=null ? $response['typeMethod'] : 'POST'}}" name="SubmitProbasePayForm" >
    @foreach($response as $key => $value)
        @if(is_array($response[$key]))
            @foreach($response[$key] as $k1 => $v1)
            <input name="{{$key}}[]" value="{{$v1}}" type="hidden">
            @endforeach
        @else
        <input name="{{$key}}" value="{{$value}}" type="hidden">
        @endif
    @endforeach
</form>
</body>
</html>