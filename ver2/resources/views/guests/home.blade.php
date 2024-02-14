@extends('layouts.guest')
@section('title') Welcome @endsection

@section('content')

    <div id="nexus-slideshow" class="nexus-slideshow">
        <div class="container">
            <div id='nexus_slider_wrapper' class='nexus_slider_wrapper fullwidthbanner-container'
                 data-stellar-background-ratio="0.4">
                <div id='nexus-rev-slider' class='rev_slider fullwidthabanner'>
                    <ul>
                        <li data-transition='fade' data-slotamount='7' data-masterspeed='1000'
                            data-thumb='images/slide-img1.jpg'><img src='images/slide-img2.jpg'
                                                                    data-bgposition='left top' data-bgfit='cover'
                                                                    data-bgrepeat='no-repeat' alt="slider-image1"/>

                            <div class="info">
                                <div class='tp-caption ExtraLargeTitle sft  tp-resizeme ' data-x='60' data-y='120'
                                     data-endspeed='500' data-speed='500' data-start='1100'
                                     data-easing='Linear.easeNone' data-splitin='none' data-splitout='none'
                                     data-elementdelay='0.1' data-endelementdelay='0.1'
                                     style='z-index:2;max-width:auto;max-height:auto;white-space:nowrap;'><span>Web Design - Web Development - UX Design</span>
                                </div>
                                <!--<div class='tp-caption LargeTitle sfl  tp-resizeme ' data-x='0'  data-y='195'  data-endspeed='500'  data-speed='500' data-start='1300' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:3;max-width:auto;max-height:auto;white-space:nowrap;'><span>Welcome Nexus</span></div>-->
                                <!--<div class='tp-caption sfb  tp-resizeme ' data-x='0'  data-y='400'  data-endspeed='500'  data-speed='500' data-start='1500' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:4;max-width:auto;max-height:auto;white-space:nowrap;'><a href='#' class="buy-btn">Shop Now</a></div>-->
                                <div class='tp-caption Title sft  tp-resizeme ' data-x='60' data-y='200'
                                     data-endspeed='500' data-speed='500' data-start='1500'
                                     data-easing='Power2.easeInOut' data-splitin='none' data-splitout='none'
                                     data-elementdelay='0.1' data-endelementdelay='0.1'
                                     style='z-index:4;max-width:auto;max-height:auto;white-space:nowrap;'>Lorem ipsum
                                    dolor sit amet, consectetur adipiscing elit.
                                </div>
                            </div>
                        </li>
                        <li data-transition='fade' data-slotamount='7' data-masterspeed='1000'
                            data-thumb='images/slide-img2.jpg'><img src='images/slide-img1.jpg'
                                                                    data-bgposition='left top' data-bgfit='cover'
                                                                    data-bgrepeat='no-repeat' alt="slider-image2"/>

                            <div class="info">
                                <div class='tp-caption ExtraLargeTitle sft  tp-resizeme ' data-x='60' data-y='120'
                                     data-endspeed='500' data-speed='500' data-start='1100'
                                     data-easing='Linear.easeNone' data-splitin='none' data-splitout='none'
                                     data-elementdelay='0.1' data-endelementdelay='0.1'
                                     style='z-index:2;max-width:auto;max-height:auto;white-space:nowrap;'><span>Photography - Portfolio - Advertisement</span>
                                </div>
                                <!--<div class='tp-caption LargeTitle sfl  tp-resizeme ' data-x='0'  data-y='195'  data-endspeed='500'  data-speed='500' data-start='1300' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:3;max-width:auto;max-height:auto;white-space:nowrap;'><span>Creative Design</span></div>-->
                                <!--<div class='tp-caption sfb  tp-resizeme ' data-x='0'  data-y='400'  data-endspeed='500'  data-speed='500' data-start='1500' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:4;max-width:auto;max-height:auto;white-space:nowrap;'><a href='#' class="buy-btn">Shop Now</a></div>-->
                                <div class='tp-caption Title sft tp-resizeme ' data-x='60' data-y='200'
                                     data-endspeed='500' data-speed='500' data-start='1500'
                                     data-easing='Power2.easeInOut' data-splitin='none' data-splitout='none'
                                     data-elementdelay='0.1' data-endelementdelay='0.1'
                                     style='z-index:4;max-width:auto;max-height:auto;white-space:nowrap;'>Farm Fresh
                                    Produce Right to Your Door
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>



    <section class="about" id="about" style="padding-top: 0px !important">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title st-center">
                        <!--<h3>WelCome to Nexus</h3>-->
                        <p>About Shikola </p>
                    </div>
                    <div class="block">
                        <div class="col-md-12 padd25 no-padding-top padding-left-15 padding-bottom-15">
                            <p>Shikola is your College & School Management Solution developed for the Zambian market providing capability to adapt to various
                                school organization structures. Schools on the Shikola platform enjoy an ability to manage their academics,
                                carry out payments, perform accounting & human resource functions. Payments of school fees and salaries through
                                the use of credit, debit cards and online banking are available on Shikola.
                            </p>
                        </div>
                        <div class="padd25 no-padding-top padding-bottom-15" align="center"><img src="images/img2.jpg" align="middle"
                                                                                                  alt=""
                                                                                                  class="img-responsive">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

        <section class="call-us" style="background-color: #ffcc00">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Start With A Package Today By Signing Up</h3>
                        <a href="#pricing" class="btn btn-default-o btn-lg">Signup Now</a>
                    </div>
                </div>
            </div>
        </section>

    <section class="service" id="service">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title st-center">
                        <!--<h3>What we do</h3>-->
                        <p>Shikola Offerings</p>
                    </div>
                    <div class="block">
                        <div class="col-md-3">
                            <div class="st-feature">
                                <div class="st-feature-icon" style="background-color:#00c0ef !important"><i class="fa fa-mobile"></i></div>
                                <strong class="st-feature-title" style="color:#00c0ef !important">Fully Responsive</strong>

                                <p>Adapted for use on any device.</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="st-feature">
                                <div class="st-feature-icon" style="background-color:#ed5565 !important"><i class="fa fa-credit-card"></i></div>
                                <strong class="st-feature-title" style="color:#ed5565 !important">Payments Processing</strong>

                                <p>Pay Fees, Salaries, Vendors electronically.</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="st-feature">
                                <div class="st-feature-icon" style="background-color:#305777 !important"><i class="fa fa-cog"></i></div>
                                <strong class="st-feature-title" style="color:#305777 !important">Customizable</strong>

                                <p>Affords you the opportunity to customize</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="st-feature">
                                <div class="st-feature-icon" style="background-color:#5b9909 !important"><i class="fa fa-database"></i></div>
                                <strong class="st-feature-title" style="color:#5b9909 !important">Data Visibility</strong>

                                <p>See the numbers as the accumulate on your dashboard</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features-desc">
        <div class="container">
            <div class="block">

                <div class="col-md-12 mb40">

                        <div class="section-title st-center">
                            <!--<h3>What we do</h3>-->
                            <p>Our Features</p>
                        </div>

                    <div style="padding-bottom: 15px !important;">
                        <div class="col-md-6">
                            <div class="col padd25" style="background-color: #fff !important; font-weight: 100  !important">
                                <i class="fa fa-bar-chart" style="font-size:50px; color: #ff6600"></i><br>
                                <div style="font-size: 15px; font-weight: bold; padding-top:5px; padding-bottom:5px; color: #000">Visualize your Students Performance</div>
                                <div>Provides access to parents and students to view their academic performances.
                                    Covers psychomotor and academic performance management. Shikola provides adequate
                                    tools to generate term reports for students</div>
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="col padd25" style="background-color: #fff !important; font-weight: 100 !important">
                                <i class="fa fa-university" style="font-size:50px; color: #ed5565"></i><br>
                                <div style="font-size: 15px; font-weight: bold; padding-top:5px; padding-bottom:5px; color: #000">Academic Institution Setup</div>
                                <div>Enjoy the flexibility Shikola provides to schools in setting up their profile
                                    and structure from the scratch. Grading schemes, creation of departments and classes
                                    in addition to managing the assignment of teachers to classes are available on Shikola
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="clearfix"></div>
                    <div style="padding-bottom: 15px !important;">
                        <div class="col-md-6">
                            <div class="col padd25" style="background-color: #fff !important; font-weight: 100  !important">
                                <i class="fa fa-bar-chart" style="font-size:50px; color: #00e765"></i><br>
                                <div style="font-size: 15px; font-weight: bold; padding-top:5px; padding-bottom:5px; color: #000">Multiple Roles access Secure Portal</div>
                                <div>24x7 access to secure portals provided on Shikola. Parents, Teachers, Accountants, Human Resource
                                    personnel within an academic institution can make use of Shikola in carrying out their regular
                                    tasks. Students/Pupils can also access their schools portal to access their performance and results</div>
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="col padd25" style="background-color: #fff !important; font-weight: 100 !important">
                                <i class="fa fa-university" style="font-size:50px; color: #ffcc00"></i><br>
                                <div style="font-size: 15px; font-weight: bold; padding-top:5px; padding-bottom:5px; color: #000">K12, College, University</div>
                                <div>Shikola can be used by schools at the K12 level from Baby classes to Grade 12. Colleges and Universities
                                    can also make use of Shikola to manage their student data in addition to student academics management.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!--<section class="clients" id="clients">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title st-center">
                        <p>Our Clients</p>
                    </div>
                    <ul class="clients-carousel">
                        <li style="float:left"><img src="photos/client.png" class="img-responsive" alt=""></li>
                        <li style="float:left"><img src="photos/client2.png" class="img-responsive" alt=""></li>
                        <li style="float:left"><img src="photos/client3.png" class="img-responsive" alt=""></li>
                        <li style="float:left"><img src="photos/client4.png" class="img-responsive" alt=""></li>
                        <li style="float:left"><img src="photos/client5.png" class="img-responsive" alt=""></li>
                        <li style="float:left"><img src="photos/client6.png" class="img-responsive" alt=""></li>
                        <li style="float:left"><img src="photos/client7.png" class="img-responsive" alt=""></li>
                        <li style="float:left"><img src="photos/client8.png" class="img-responsive" alt=""></li>
                        <li style="float:left"><img src="photos/client9.png" class="img-responsive" alt=""></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials" id="testimonials">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title st-center">
                        
                        <p>Testimonials</p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="testimonials-carousel">
                        <ul>
                            <li>
                                <div class="testimonial">
                                    <div class="testimonial-img">
                                        <img src="photos/member1.png" alt="">
                                    </div>
                                    <blockquote>
                                        <p>Tueri tantis inter variis deterritum facta caret pleniorem, efficiat affert
                                            quiete, commodis comparat facio ponti, adolescens recta iucundius mundi
                                            nostrum viris quae utilitatibus.</p>
                                        <footer>Joseph Thompson, <cite title="Source Title">Example Inc.</cite></footer>
                                    </blockquote>
                                </div>
                            </li>
                            <li>
                                <div class="testimonial">
                                    <div class="testimonial-img">
                                        <img src="photos/member2.png" alt="">
                                    </div>
                                    <blockquote>
                                        <p>Contrariis labore vetuit scaevola, contra percurri adamare efficeret quibus.
                                            Nostram consulatu mediocritatem maiorem, cyrenaicisque, quandam accedit
                                            veniat cognitioque, animadvertat accusantibus temporibus maximeque
                                            litterae.</p>
                                        <footer>Nancy Ford, <cite title="Source Title">Example Inc.</cite></footer>
                                    </blockquote>
                                </div>
                            </li>
                            <li>
                                <div class="testimonial">
                                    <div class="testimonial-img">
                                        <img src="photos/member3.png" alt="">
                                    </div>
                                    <blockquote>
                                        <p>Illas, volumus prosperum. Nostras eoque statua cuius corrumpit praetor aliter
                                            quaeso propter ei, quam inducitur ruant doctiores sanguinem atomum
                                            molestiae, antiqua inculta dicent.</p>
                                        <footer>Arthur Fernandez, <cite title="Source Title">Example Inc.</cite>
                                        </footer>
                                    </blockquote>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>-->

    <section class="packages" id="packages">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title st-center">
                        <p>Product Sales</p>
                        <h3>Choose Package</h3>
                        @include('partials.errors')
                    </div>
                </div>
            </div>
            <div class="row">
                @if($packages->count() != 0)
                    @foreach($packages->get() as $sub)
                        <div class="col-md-4">
                            <div class="pricing-table">
                                <div class="pricing-header">
                                    @if($sub->name=='Bronze Package')
                                    <div class="pt-price" style="background-color:#cd7f32"><span class="naira">{{$sub->amount_word==0 ? "" : "ZMW"}}</span>{!! $sub->amount_word !!}
									@elseif($sub->name=='Gold Package')
                                    <div class="pt-price" style="background-color:#ffd700"><span class="naira">{{$sub->amount_word==0 ? "" : "ZMW"}}</span>{!! $sub->amount_word !!}
									@elseif($sub->name=='Silver Package')
                                    <div class="pt-price" style="background-color:#c0c0c0"><span class="naira">{{$sub->amount_word==0 ? "" : "ZMW"}}</span>{!! $sub->amount_word !!}
									@endif
                                        {{--<small>Per Year</small>--}}
                                    </div>

                                    <div class="pt-name">{!! $sub->name !!}</div>
                                </div>
                                <div class="pricing-body">
                                    @if($sub->packageFeatures->count() != 0)
                                        <ul>
                                            @foreach($sub->packageFeatures as $feature)
                                                <li><i class="fa fa-check"></i> {!! $feature->feature->name !!}</li>
                                            @endforeach
											<li style="color: red"><i class="fa fa-check" style="color: red"></i> Maximum {{$sub->maximum_users}} Users</li>
                                                <li style="color: red"><i class="fa fa-check" style="color: red"></i> Free Sub-Domain on Shikola Domain</li>
                                        </ul>
                                    @endif
                                </div>
                                <div class="pricing-footer">
                                    <a href="/auth/register/{!! encrypt($sub->id) !!}" class="btn btn-primary">Purchase</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4>We currently do not have any package available yet.</h4>
                @endif
            </div>
        </div>
    </section>

    <section class="faq-sec" id="faq">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- <h2 class="tac">frequently asked questions</h2> -->
                    <div class="section-title st-center">
                        <!--<h3>Some questions</h3>-->
                        <p>Frequently Asked Question!</p>
                    </div>
                </div>
            </div>
            <div class="block">
                <div class="col-md-6">
                    <div class="faq">
                        <h3><i class="ion ion-help-buoy"></i> How Do I Sign Up!</h3>

                        <p>Click the <a href="#packages">Product Sales</a> link then proceed to purchase a package
                            from the list of packages. Start off first by creating a Shikola account before completing
                            the sign up process to sign up your school.
                            On sign up, we would activate your account.</p>
                    </div>
                    <div class="faq">
                        <h3><i class="ion ion-help-buoy"></i> How Secure Is Shikola</h3>

                        <p>Shikola employs the use of latest security trends in technology to secure your schools
                            data by making use of HTTPS encryption and Encryption techniques. Backup of your schools data
                            regular performed on our highly secured cloud-hosted servers</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="faq">
                        <h3><i class="ion ion-help-buoy"></i> Can Shikola Run Offline?</h3>

                        <p>Sure! Offline capabilities have been made available for schools having
                            difficulties accessing the internet due to high internet costs. In addition to this,
                            synchronization between offline servers and our cloud hosted servers is available.</p>
                    </div>
                    <div class="faq">
                        <h3><i class="ion ion-help-buoy"></i> What User Groups Can Make Use of Shikola?</h3>

                        <p>School Administrators, Teachers, Accountants, Parents, Students, Human Resource personnel
                        within K12, Colleges, and Universities can make use of Shikola.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="call-us">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3>Start With A Package Today By Signing Up</h3>
                    <a href="#pricing" class="btn btn-default-o btn-lg">Signup Now</a>
                </div>
            </div>
        </div>
    </section>

    <section class="contact" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title st-center">
                        <!--<h3>Contact Us</h3>-->
                        <p>Get in Touch with Us</p>
                    </div>
                </div>
            </div>
            <div class="block">
                <div class="col-md-7">
                    @include('partials.errors')
                    <form class="contact-form" autocomplete="off" accept-charset="UTF-8" action="/submit-contact" method="post">
                        <input type="text" class="form-control" id="fname" name="fname" placeholder="Your Full Name" required>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Your E-mail" required>
                        <input type="text" class="form-control" id="subj" name="subj" placeholder="Your Subject" required>
                        <textarea id="mssg" name="mssg" placeholder="Your Message" class="form-control"
                                  rows="10" required></textarea>
                        <div class="form-group col-md-7">
                            <div class="form-group">{!! Recaptcha::render() !!}</div>
                        </div>
                        <button class="btn btn-main btn-lg" type="submit" id="send"
                                data-loading-text="<i class='fa fa-spinner fa-spin'></i> Sending..."> Send
                        </button>
                    </form>
                    <div id="result-message" role="alert"></div>
                </div>
                <div class="col-md-5">
                    <p>Contact Us By Sending Us a message. Messages will be responded to within 24hours.
                    </p>

                    <div class="mb20">
                        <iframe width="500" height="400" frameborder="0" style="border:0"
                                src="https://www.google.com/maps/embed/v1/place?q=Shopify, Ottawa 150 Elgin Street, 8th Floor Ottawa, ON, Canada&key=AIzaSyAVk-o-EKPBOgtHwdNY1zJvcqKWM-g1drI"></iframe>
                    </div>
                    <address>
                        <strong>Probase Group</strong><br>
                        Paseli Road, Zambia<br>
                        <abbr title="Phone">Phone:</abbr> (260)97 4365365
                    </address>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')

@stop