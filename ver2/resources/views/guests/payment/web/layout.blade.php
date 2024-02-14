<html>
    <head>
        <title>Payments | ProbasePay</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="sha384-2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <script type="text/css">
            .font12{
                font-size:12px;
            }
        </script>
    </head>
    <body style="background-color:#fff; padding:10px; font-family: "Source Sans Pro",Helvetica,sans-serif;">

            <div class="container">
                <div class="row">
                    <div class="col col-md-8 offset-md-2" style="background-color:#00a65a;
                display:-moz-box;-moz-box-pack:center;-moz-box-align:center;display:-webkit-box;-webkit-box-pack:center; -webkit-box-align:center; display:box;box-pack:center;
                box-align:center; padding:15px;">
                        <div class="col col-md-12" style="background-color:#fff; padding:0px;">
                            <div style="height:60px; background-color: chartreuse; color:#fff; font-size:28px; padding:12px">
                                Probase<strong>Pay</strong>
                            </div>
                            <div class="col col-md-12" style="padding:12px;">
                                @yield('content')
                            </div>

                        </div>
                    </div>
                </div>
            </div>

    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>
    @yield('scripts')

</html>


