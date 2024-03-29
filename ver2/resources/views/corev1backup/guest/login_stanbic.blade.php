<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Stanbic | Promo </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css?aks=23">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css?as=23">

    <link rel="stylesheet" href="/css/bootstrap.min.css?f=333">
    <link href="/bootstraptour/css/bootstrap-tour-standalone.min.css?kss=2212" rel="stylesheet">

    <link rel="stylesheet" href="/css/login.css?f=333">
    <script src="/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/bootstraptour/js/bootstrap-tour-standalone.min.js?kal=211"></script>

</head>
<body></body>
<section class="login-form-wrap">
    <h1><strong>Stanbic Promo Draw</strong></h1>
    @include('partials.errors')
    <form class="login-form" method="post" action="/login-stanbix-promo">
        <label style="margin-bottom:0px !important; display:block !important;">
            <input type="text" name="username" required placeholder="Username" value="super_admin">
        </label>
        <label style="margin-bottom:0px !important; display:block !important;">
            <input type="password" name="password" required placeholder="Password" value="password">
        </label>
        <input type="submit" value="Login">
    </form>
    <h5><a href="/forgot-password">Forgot password</a></h5>
</section>