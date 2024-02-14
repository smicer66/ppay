<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="description" content="Page Titile">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="msapplication-tap-highlight" content="no">
            
        <title>USSD Emulator</title>
        <!-- base css -->
        <!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/d676b0cfd1.js"></script>
        <style>
            .displayOutput{
              scrollbar-color: black white;
            }

		.aQli{

    			border: 2px solid rgb(0, 0, 0);
    			border-radius: 50% !important;
    			width: 50px !important;
    			height: 50px !important;
    			background-color: white;
    			font-size: 17px !important;
			padding-top: 10px;

		}

		.aQli1{

    			border: 2px solid rgb(0, 0, 0);
    			border-radius: 50% !important;
    			width: 50px !important;
    			height: 50px !important;
    			font-size: 17px !important;
			padding-top: 10px;

		}

		.coderun{
			padding: 10px !important;
			border: 2px solid !important;
			border-radius: 20px !important;
			bottom: 190px;
			width: 300px;
			margin: 0 auto !important;
			background-color: #878787;
			display: none !important;
		}
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col col-md-6 col-xs-6 col-lg-6 col-sm-6" style="background-color: #dedede !important; padding: 5px !important;">
                    <div class="col col-md-12 col-xs-12 col-lg-12 col-sm-12" style="background-color: #dedede !important; padding-bottom: 10px !Important">
                        <button class="btn btn-primary col col-md-12 col-sm-12 col-xs-12 xol-lg-12" onclick="startAfresh()" id="startAfreshButton">Start Test</button>
                    </div>

                    <div class=" col col-md-2 col-xs-2 col-lg-2 col-sm-2 svnum" style="float: left !important; text-align: right !important; padding-top: 5px !important; padding-right: 2px !Important">
                        +260
                    </div>
                    <div class=" col col-md-5 col-xs-5 col-lg-5 col-sm-5 svnum" style="float: left !important;">
                        <input type="number" name="phonenumber" id="phonenumber" class="form-control">
                    </div>
                    <div class="col col-md-5 col-xs-5 col-lg-5 col-sm-5 svnum" style="float: right !important;">
                        <button class="btn btn-primary col col-md-12 col-sm-12 col-xs-12 xol-lg-12" onclick="saveNumber()">Save Number</button>
                    </div>
                </div>
		</div>
            <div class="row">
				<div class="col col-md-12 col-xs-12 col-lg-12 col-sm-12" style="padding-top: 10px !important; display: none !Important" id="emulatorDiv">
					<div class="col col-md-6 col-xs-6 col-lg-6 col-sm-6" style="background-color: #000 !important; border-radius: 30px !important; padding: 20px !important;">
						<!--<div class="col col-md-12 col-xs-12 col-lg-12 col-sm-12" style="background-color: #000 !important; height: 30px !important">

						</div>-->
						<div class="col col-md-12 col-xs-12 col-lg-12 col-sm-12" style="background-color: #000 !important; height: 330px !important; padding: 20px !important;">
							<div class="col col-md-12 col-xs-12 col-lg-12 col-sm-12" style="background-color: #fff !important; height: 300px !important;" id="display">
								<div class="col col-md-12 col-xs-12 col-lg-12 col-sm-12 displayOutput" style="background-color: #fff !important; height: 260px !important; padding:5px !important; overflow-y: scroll" id="displayOutput">
									<div class="col col-md-12 col-xs-12 col-lg-12 col-sm-12 displayOutput" style="background-color: #fff !important; font-size: 30px; text-align: center; margin-top: 100px !important">
										Dial *778#
									</div>
								</div>
								<div class="">
									<div class="col col-md-10 col-xs-10 col-lg-10 col-sm-10" style="background-color: #ffcc00 !important; height: 40px !important; font-size: 30px; text-align: right !important; overflow: hidden !important; float: left !important" id="displayInput">
								
									</div>
									<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2" style="background-color: #ffcc00 !important; height: 40px !important; font-size: 30px; text-align: right !important; float: left !important" id="">
										<i class="fa fa-arrow-left" style="color: #fff !important; font-size: 25px !important;padding-right: 10px; cursor: pointer !important" onclick="backspace()"></i>
									</div>
								</div>

							</div>
						</div>
						<div class="col col-md-12 col-xs-12 col-lg-12 col-sm-12" style="background-color: #000 !important; height: 400px !important; padding: 20px !important;">
							<div class="col col-md-12 col-xs-12 col-lg-12 col-sm-12" style="background-color: #fff !important; height: 370px !important; border-radius: 20px">
								<div class="col col-md-12 col-xs-12 col-lg-12 col-sm-12" style="text-align: center !important; background-color: #fff !important; border: 0px solid #000; border-bottom: 0px solid #000 !important; font-size: 12px !important; padding-left: 15px; padding-top: 15px; padding-bottom: 15px; cursor: pointer;" id="switchMode" onclick="switchMode()">
									<center><strong style="background-color: #dedede !important; padding: 3px !important;">ABC</strong></center>
								</div>

								<div class="col col-md-4 col-xs-4 col-lg-4 col-sm-4 numbers" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen(1)">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important ">1</div></center>
								</div>
								<div class="col col-md-4 col-xs-4 col-lg-4 col-sm-4 numbers" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen(2)">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">2</div></center>
								</div>
								<div class="col col-md-4 col-xs-4 col-lg-4 col-sm-4 numbers" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen(3)">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: left !important ">3</div></center>
								</div>
								<div class="col col-md-4 col-xs-4 col-lg-4 col-sm-4 numbers" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen(4)">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">4</div></center>
								</div>
								<div class="col col-md-4 col-xs-4 col-lg-4 col-sm-4 numbers" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen(5)">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">5</div></center>
								</div>
								<div class="col col-md-4 col-xs-4 col-lg-4 col-sm-4 numbers" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen(6)">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: left !important ">6</div></center>
								</div>
								<div class="col col-md-4 col-xs-4 col-lg-4 col-sm-4 numbers" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen(7)">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important ">7</div></center>
								</div>
								<div class="col col-md-4 col-xs-4 col-lg-4 col-sm-4 numbers" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen(8)">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">8</div></center>
								</div>
								<div class="col col-md-4 col-xs-4 col-lg-4 col-sm-4 numbers" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen(9)">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: left !important ">9</div></center>
								</div>
								<div class="col col-md-4 col-xs-4 col-lg-4 col-sm-4 numbers" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('*')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important ">*</div></center>
								</div>
								<div class="col col-md-4 col-xs-4 col-lg-4 col-sm-4 numbers" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen(0)">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">0</div></center>
								</div>
								<div class="col col-md-4 col-xs-4 col-lg-4 col-sm-4 numbers" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('#')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: left !important ">#</div></center>
								</div>



								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('A')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">A</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('B')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">B</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('C')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">C</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('D')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">D</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('E')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">E</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('F')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">F</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('G')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">G</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('H')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">H</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('I')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">I</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('J')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">J</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('K')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">K</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('L')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">L</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('M')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">M</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('N')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">N</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('O')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">O</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('P')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">P</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('Q')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">Q</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('R')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">R</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('S')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">S</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('T')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">T</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('U')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">U</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('V')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">V</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('W')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">W</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('X')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">X</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('Y')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">Y</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('Z')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">Z</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('/')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">/</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('+')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">+</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('-')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">-</div></center>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 text" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('#')">
									<center><div class="aQli" style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">#</div></center>
								</div>





								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('a')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">a</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('b')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">b</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('c')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">c</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('d')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">d</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('e')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">e</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('f')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">f</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('g')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">g</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('h')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">h</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('i')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">i</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('j')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">j</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('k')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">k</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('l')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">l</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('m')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">m</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('n')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">n</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('o')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">o</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('p')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">p</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('q')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">q</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('r')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">r</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('s')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">s</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('t')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">t</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('u')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">u</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('v')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">v</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('w')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">w</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('x')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">x</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('y')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">y</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('z')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">z</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('_')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">_</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('+')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">+</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('-')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">-</div>
								</div>
								<div class="col col-md-2 col-xs-2 col-lg-2 col-sm-2 textLower" style="background-color: #fff !important; border: 0px solid #000; float: left !important; font-size: 25px !important; text-align: center; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="addToScreen('#')">
									<div style="border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; float: right !important">#</div>
								</div>



								<div class="col col-md-12 col-xs-12 col-lg-12 col-sm-12" style="background-color: #fff !important; border: 0px solid #000; font-size: 25px !important; text-align: center; padding-right: 0px; padding-top: 5px; padding-bottom: 5px; cursor: pointer;">
									<!--<div style="float: right !important; " class="btn btn-success col col-md-8 col-sm-8 col-xs-8 xol-lg-8" id="mtn_zambia" onclick="callUssdService()">OK</div>-->
									<center id="okclicker"><div id="mtn_zambia" onclick="callUssdService()" class="aQli1 btn btn-success" style="background-color: #1ca800 !important; border: 2px solid #000; border-radius: 50% !important; width: 50px !important; height: 50px !important; ">OK</div></center>
									<div style="padding: 15px !important; border: 2px solid !important; border-radius: 20px !important; bottom: 200px; width: 300px; margin: 0 auto" class="coderun">USSD Code Running</div>
								</div>

								<input type="hidden" id="val" name="val">


							</div>
						</div>
					<div>
				</div>
            </div>
            
        <div>

    <body>

    <script>
    myStorage = window.localStorage;
    var textInputSummary = '';
    var service_code = '';
	
	
	$( document ).ready(function() {
		$(".aQli").on('mouseover', function(){  //using "on" for optimization
			this.style.backgroundColor = '#dedede';       //native JS application
		}).on('mouseout', function(){           //chain to avoid second selector call
			this.style.backgroundColor = 'white';     //native JS application
		})
	});


    function switchMode()
    {
        console.log(">>>" + myStorage.getItem('switchMode'));
        if(myStorage.getItem('switchMode')=='123')
        {
            $('#switchMode').html('abc');
            myStorage.setItem('switchMode', 'ABC');
            $('.text').show();
            $('.numbers').hide();
            $('.textLower').hide();
        }
        else if(myStorage.getItem('switchMode')==='ABC')
        {
            $('#switchMode').html('123');
            myStorage.setItem('switchMode', 'abc');
            $('.numbers').hide();
            $('.text').hide();
            $('.textLower').show();
        }
        else if(myStorage.getItem('switchMode')==='abc')
        {
            $('#switchMode').html('ABC');
            myStorage.setItem('switchMode', '123');
            $('.numbers').show();
            $('.text').hide();
            $('.textLower').hide();
        }
        else
        {
            $('#switchMode').html('abc');
            myStorage.setItem('switchMode', 'ABC');
            $('.text').show();
            $('.numbers').hide();
            $('.textLower').hide();
        }
    }


    function addToScreen(x)
    {
        var currentVal = $('#displayInput').html();
        textInputSummary = textInputSummary + '' + x;
        $('#val').val(textInputSummary);
        $('#displayInput').html(currentVal + x);
        $('#mtn_zambia').addClass("btn-success");
        $('#mtn_zambia').removeClass("btn-danger");
    }


    function backspace()
    {
		var currentVal = $('#val').val();
		console.log("currentVal..." + currentVal);
		console.log("currentVal.length  ..." + currentVal.length );
        	if(currentVal.length >0)
        	{

			console.log("12 currentVal..." + currentVal);

            		currentVal = currentVal.substring(0, (currentVal.length-1));
			console.log("new currentVal..." + currentVal);
            		$('#displayInput').html(currentVal);



		
        	}
        	else
        	{
           		$('#mtn_zambia').removeClass("btn-success");
            		$('#mtn_zambia').addClass("btn-danger");
        	}

            	$('#val').val(currentVal);
            	currentVal = $('#val').val();
            	if(currentVal.length ==0)
            	{
                	$('#mtn_zambia').removeClass("btn-success");
                	$('#mtn_zambia').addClass("btn-danger");
            	}

		textInputSummary = currentVal;
		myStorage.setItem('text', currentVal);
		myStorage.setItem('text', currentVal);
		myStorage.setItem('text', currentVal);
    }


    function saveNumber()
    {
        if (typeof(Storage) !== "undefined") {
            myStorage.setItem('mobile_number', '260' + $('#phonenumber').val());
            myStorage.setItem('session_id', makeid(16));
            $('#phonenumber').attr('readOnly', true);
            $('#emulatorDiv').show();
        } else {
          alert('Invalid storage')
        }
    }


    function callUssdService()
    {
        //myStorage.removeItem('text');

	 $('#okclicker').hide();
	 $('.coderun').show();
        if(myStorage.getItem('mobile_number') ==undefined)
        {
            alert('Error');
        }
        else
        {
            textInputSummary = '';
            var textValue = myStorage.getItem('text');
            var service_code = myStorage.getItem('service_code');
            var currentValue = $('#val').val();
            if(textValue!=undefined)
            {
                //textValue = textValue + '*' + currentValue;
                textValue = currentValue;
            }
            else
            {
                textValue = currentValue;
            }

            if(service_code==undefined)
            {
                service_code = currentValue;
                myStorage.setItem('service_code', service_code);
            }



            console.log("service_code..." + service_code);
            console.log(textValue);
            console.log(currentValue);
            //var service_code = textValue.substring(0, 5);
            console.log('service_code...' + service_code);


            myStorage.setItem('text', textValue);
            //if(service_code=='*778#')
            //{
            $.ajax({
                url: "/ussd",
                type: "get", //send it through get method
                data: {
                    MOBILE_NUMBER: myStorage.getItem('mobile_number'),
                    SESSION_ID: myStorage.getItem('session_id'),
                    USSD_BODY: textValue,
                    SERVICE_KEY: service_code
                },
                success: function(response) {

		      $('#okclicker').show();
		      $('.coderun').hide();
                    console.log(response);
                    var data = response;
                    var message = data.Message;
                    var first3letters = data.key;
                    message = message;
                    console.log(message);
                    message = (message + '').replace(/(?:\r\n|\r|\n)/g, '<br>');
                    console.log(message);
                    $('#displayOutput').html(message);



                    console.log("first3letters..." + first3letters);
                    if(first3letters.startsWith("CON"))
                    {
                        $('#displayOutput').html(message);
                    }
                    else
                    {
                        if(first3letters.startsWith("BA"))
                        {
                            var keyIndex = first3letters.substring(2);
                            console.log(keyIndex);
                            keyIndex = parseInt(keyIndex);
                            var text_ = myStorage.getItem('text');
                            console.log(text_);
                            text_ = text_.split('*');
                            console.log(text_.length);
                            console.log(text_);
                            var newText = [];
                            for(var k1=1; k1<(text_.length - (keyIndex-1)); k1++)
                            {
                                console.log(text_[k1]);
                                newText.push(text_[k1]);
                            }
                            console.log(newText);
                            newText = newText.join('*');
                            //newText = '*' + newText + '*';
                            //myStorage.setItem('text', newText);
                            myStorage.setItem('text', textValue);
                        }
                    }
					
					$('#displayInput').html("");
                },
                error: function(xhr) {
                    //Do Something to handle error
                    console.log(333);
                }
            });
            //}
        }
    }


    function makeid(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result.toLowerCase();
    }


    function startAfresh()
    {
        myStorage.removeItem('switchMode');
        myStorage.removeItem('mobile_number');
        myStorage.removeItem('session_id');
        myStorage.removeItem('text');
        var checkText = $('#startAfreshButton').html();
        if(checkText=='End Test')
        {
            $('#startAfreshButton').html('Start Test');
            $('#startAfreshButton').removeClass("btn-danger");
            $('#startAfreshButton').addClass("btn-primary");
            $('#phonenumber').val("");
            $('#emulatorDiv').hide();
            $('#phonenumber').attr('readOnly', true);
            $('.svnum').hide();
            window.location = '/ussdEmulator'
        }
        else if(checkText=='Start Test')
        {
            $('#startAfreshButton').html('End Test');
            $('#startAfreshButton').removeClass("btn-primary");
            $('#startAfreshButton').addClass("btn-danger");
            $('#phonenumber').attr('readOnly', false);
            $('.svnum').show();
        }
    }

    $( document ).ready(function() {

        myStorage.removeItem('text');
        $('#emulatorDiv').hide();
        console.log(myStorage.getItem('switchMode'));
        if(myStorage.getItem('mobile_number')!=null && myStorage.getItem('mobile_number').length>0)
            $('#phonenumber').val(myStorage.getItem('mobile_number').substring(3));

        $('.textLower').hide();
        $('.numbers').hide();
        $('.text').show();
        var mobile_number = myStorage.getItem('mobile_number');

        $('.svnum').hide();
        if(mobile_number!=undefined && mobile_number!=null)
        {
            $('#phonenumber').attr('readOnly', true);
            $('#startAfreshButton').html('End Test');
            $('#startAfreshButton').removeClass("btn-primary");
            $('#startAfreshButton').addClass("btn-danger");
            $('#emulatorDiv').show();
            $('.svnum').show();
        }


        if(myStorage.getItem('switchMode')=='123')
        {
            $('#switchMode').html('ABC');
            $('.numbers').show();
            $('.text').hide();
            $('.textLower').hide();
        }
        else if(myStorage.getItem('switchMode')==='ABC')
        {
            $('#switchMode').html('abc');
            $('.numbers').hide();
            $('.text').show();
            $('.textLower').hide();
        }
        else if(myStorage.getItem('switchMode')==='abc')
        {
            $('#switchMode').html('123');
            $('.numbers').hide();
            $('.text').hide();
            $('.textLower').show();
        }
        else
        {
            $('#switchMode').html('ABC');
            $('.numbers').show();
            $('.text').hide();
            $('.textLower').hide();
        }
    });
    </script>
</html>


