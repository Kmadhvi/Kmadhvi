<?php

/**
 * Template part for displaying login model
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tingl
 */
?>
<!--------------Login-Modal-------------------->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered auth-modal">
        <div class="modal-content">
            <!-- <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div> -->
            <div class="modal-body p-0">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="swiper auth-swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/auth-img-slider.png" class="img-fluid">
                                </div>
                                <div class="swiper-slide">
                                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/auth-img-slider1.png" class="img-fluid">
                                </div>
                                <div class="swiper-slide">
                                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/auth-slider-img-3.png" class="img-fluid">
                                </div>
                                <div class="swiper-slide">
                                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/auth-slider-img-4.png" class="img-fluid">
                                </div>
                                <div class="swiper-slide">
                                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/auth-slider-img-5.png" class="img-fluid">
                                </div>
                            </div>

                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="auth-details">
                            <div class="shape-1">
                                <img src="<?php echo get_template_directory_uri() ?>/assets/images/leaf.png">
                            </div>
                            <div class="shape-2">
                                <img src="<?php echo get_template_directory_uri() ?>/assets/images/leaf-1.png">
                            </div>
                            <div class="close" data-bs-dismiss="modal" aria-label="Close">
                                <img src="<?php echo get_template_directory_uri() ?>/assets/images/fi-rr-cross.png">
                            </div>
                            <div class="login-details active first">
                                <h2>Welcome</h2>
                                <div class="form-group mb-2">
                                    <label>Enter your mobile number</label>
                                    <input type="number" name="mobileNumber" id="mobileNumber" placeholder="Enter your mobile number" value="" class="form-control">
                                </div>
                               
                                <div class="form-group">
                                    <p>by continuing you agree to the <a href="#">terms of services</a> and <a href="">privacy policy</a>.</p>
                                </div>
                                <span class="mobile_errormsg"></span>
                                <div class="mt-5">
                                    <a href="#" class="btn btn-primary btn-login w-100">continue</a>
                                </div>
                            </div>
                            <div class="login-details varification">
                                <h2>verification</h2>
                                <div class="form-group mb-2">
                                    <p>Enter the 4-digit code sent to your mobile number <a href="#">+91 99*** ***00</a></p>
                                    <div class="otp">
                                        <input type="text" name="" class="opt_1">
                                        <input type="text" name="" class="opt_1">
                                        <input type="text" name="" class="opt_1">
                                        <input type="text" name="" class="opt_1">
                                    </div>
                                    <span class="otp_errormsg"></span>
                                </div>
                                <div class="form-group">
                                    <p class="countdown"> <a href="">resend OTP</a></p>
                                </div>
                                <div class="mt-4">
                                    <a href="#" class="btn btn-primary btn-login1 w-100">verify</a>
                                </div>
                            </div>
                            <div class="login-details name-pro">
                                <h2>your name</h2>
                                <div class="form-group mb-2">
                                    <label>enter first name</label>
                                    <input type="text" id="firstName" name="" placeholder="enter first name" class="form-control">
                                    <label>enter last name</label>
                                    <input type="text" name="" id="lastName" placeholder="enter last name" class="form-control">
                                </div>
                                <span class="name_errormsg"></span>

                                <div class="mt-5">
                                    <a href="#" class="btn btn-primary btn-login2 w-100">continue</a>
                                </div>
                            </div>
                            <div class="login-details gender-selection">
                                <h2>your gender</h2>
                                <div class="form-group mb-2">
                                    <label>select your gender</label>
                                    <select class="form-select" id="gender">
                                        <option>select</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                        <option>Other</option>
                                    </select>
                                    <span class="gender_errormsg"></span>
                                </div>

                                <div class="mt-5">
                                    <a href="#" class="btn btn-primary btn-login3 w-100">next</a>
                                </div>
                            </div>
                            <div class="login-details birth-date">
                                <h2>Enter your age</h2>
                                <div class="form-group mb-2">
                                    <label>age</label>
                                    <input type="text" name="age" id="age" placeholder="enter your age" class="form-control login_age">
                                </div>
                                <span class="age_erromsg"></span>


                                <div class="mt-5">
                                     <a href="#" class="btn btn-primary btn-login4 w-100">next</a>
                                </div>
                            </div>

                            <div class="login-details pin-code">
                                <h2>Enter pincode</h2>
                                <div class="form-group mb-2">
                                    <label>pincode</label>
                                    <input type="text" name="pincode" id="pincode" placeholder="enter pin code" class="form-control login_pincode">
                                </div>
                                <span class="pin_errormsg"></span>                        
                                <div class="mt-5">
                                    <a href="#" class="btn btn-primary btn-login5 w-100">done</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
        </div>
    </div>
</div>