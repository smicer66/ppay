<html>
<head>
    <title>ProbaseWallet</title>
</head>
<body onLoad="document.SubmitProbasePayForm.submit()">
Click to continue
<form action="{{$response['redirectUrl']}}" method="POST" name="SubmitProbasePayForm" >
    @foreach($response as $key => $value)
        <input name="{{$key}}" value="{{$value}}" type="hidden">
    @endforeach
</form>
</body>
</html>