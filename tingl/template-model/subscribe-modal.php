<?php

/**
 * Template part for displaying subscribe model
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tingl
 */

?>
<div class="modal fade" id="subscribeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered border-radius-modal">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="auth-details feedback-modal">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div>
                                        <form id="msform">
                                            <!-- progressbar -->
                                            <ul id="progressbar">
                                                <li class="active" id="account"><strong>personal details</strong></li>
                                                <li id="personal"><strong>allergies</strong></li>
                                                <li id="payment"><strong>meal plan</strong></li>
                                                <li id="confirm"><strong>checkout</strong></li>
                                            </ul>
                                            <!-- fieldsets -->
                                            <fieldset>
                                                <div class="form-card">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="subscribe-img">
                                                                <img src="assets/images/subscription-img1.png" class="img-fluid">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="subscription-form">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label>First Name</label>
                                                                            <input type="text" name="" placeholder="enter first name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label>Last Name</label>
                                                                            <input type="text" name="" placeholder="enter last name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">
                                                                            <label>Mobile Number</label>
                                                                            <input type="text" name="" placeholder="enter mobile number" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">
                                                                            <label>Email</label>
                                                                            <input type="text" name="" placeholder="enter email id" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">
                                                                            <label>Pincode</label>
                                                                            <input type="text" name="" placeholder="enter pincode" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">
                                                                            <label>Weight (Kg.)</label>
                                                                            <input type="text" name="" placeholder="enter weight" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">
                                                                            <label>Age(yr.)</label>
                                                                            <input type="text" name="" placeholder="enter age ex:24" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">
                                                                            <label>height(ft-in)</label>
                                                                            <select class="form-select subscription">
                                                                                <option>height(ft-in)</option>
                                                                                <option>1</option>
                                                                                <option>2</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group mb-3">
                                                                            <p>**This information is required by our nutritionist to
                                                                                prepare meals tailored for you</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <input type="button" name="next" class="next action-button" value="Next" />
                                            </fieldset>
                                            <fieldset>
                                                <div class="form-card">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="subscribe-img">
                                                                <img src="assets/images/subscription-img2.png" class="img-fluid">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-8">
                                                            <div class="subscription-form">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <div class="form-group mb-3">
                                                                            <p>Select if have any allergies</p>
                                                                        </div>
                                                                        <div class="alergy-tab">
                                                                            <a href="">Chicken</a>
                                                                            <a href="">Egg</a>
                                                                            <a href="">Fish</a>
                                                                            <a href="">Jellyfish</a>
                                                                            <a href="">Nuts</a>
                                                                            <a href="">Penuts</a>
                                                                            <a href="">Sauce</a>
                                                                            <a href="">Milk</a>
                                                                            <a href="">Seeds</a>
                                                                            <a href="">Gluten</a>
                                                                            <a href="">Other</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <div class="form-group mb-3 mt-4">
                                                                            <label>Other allergies</label>
                                                                            <input type="text" name="" placeholder="enter allergies" class="form-control">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="button" name="next" class="next action-button" value="Next" />
                                                <input type="button" name="back" class="previous action-button-previous" value="Back" />
                                            </fieldset>
                                            <fieldset>
                                                <div class="form-card">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="subscribe-img">
                                                                <img src="assets/images/subscription-img1.png" class="img-fluid">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="subscription-form">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">

                                                                            <select class="form-select subscription">
                                                                                <option>Goal</option>
                                                                                <option>1</option>
                                                                                <option>2</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">

                                                                            <select class="form-select subscription">
                                                                                <option>Preference</option>
                                                                                <option>1</option>
                                                                                <option>2</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">
                                                                            <input type="text" name="" placeholder="type days" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-8">

                                                                        <div class="meal-tab">
                                                                            <a href=""><input type="checkbox" name="myCheckbox" value="aaa" id="myCheckbox" class="selectcheckbox" checked>
                                                                                <label for="myCheckbox" class="checkbox-label">Breakfast</label></a>
                                                                            <a href=""><input type="checkbox" name="myCheckbox" value="aaa" id="myCheckbox" class="selectcheckbox" checked>
                                                                                <label for="myCheckbox">Lunch</label></a>
                                                                            <a href=""><input type="checkbox" name="myCheckbox" value="aaa" id="myCheckbox" class="selectcheckbox">
                                                                                <label for="myCheckbox">Snacks</label></a>
                                                                            <a href=""><input type="checkbox" name="myCheckbox" value="aaa" id="myCheckbox" class="selectcheckbox">
                                                                                <label for="myCheckbox">Dinner</label></a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="meal-plan">
                                                                            <div class="row">
                                                                                <div class="col-lg-4 col-xl-4">
                                                                                    <h1 class="meal-title">your plan</h1>
                                                                                    <div class="subpay-meal pb-30">10
                                                                                        Days</div>


                                                                                    <div class="subpay-meal">₹9,085 for 40 meals
                                                                                    </div>
                                                                                    <div class="type-meal">
                                                                                        <a href="">Breakfast</a>
                                                                                        <a href="">Lunch</a>
                                                                                        <a href="">Snacks</a>
                                                                                        <a href="">Dinner</a>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4 col-xl-4">
                                                                                    <h3 class="getmeal-title">you get</h3>
                                                                                    <div class="getmeal-submeal">
                                                                                        <div><i class="fa fa-check"></i></div>
                                                                                        <div>weight loss</div>
                                                                                    </div>
                                                                                    <div class="getmeal-submeal">
                                                                                        <div><i class="fa fa-check"></i></div>
                                                                                        <div>vegetarian
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="col-lg-4 col-xl-4">
                                                                                    <br>
                                                                                    <div class="getmeal-submeal">
                                                                                        <div><i class="fa fa-check"></i></div>
                                                                                        <div>quality ingredients</div>
                                                                                    </div>
                                                                                    <div class="getmeal-submeal">
                                                                                        <div><i class="fa fa-check"></i></div>
                                                                                        <div>eco packaging
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="getmeal-submeal">
                                                                                        <div><i class="fa fa-check"></i></div>
                                                                                        <div>Personal nutritionist</div>
                                                                                    </div>
                                                                                    <div class="getmeal-submeal">
                                                                                        <div><i class="fa fa-check"></i></div>
                                                                                        <div>Free home delivery</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="button" name="next" class="next action-button" value="Next" />
                                                <input type="button" name="back" class="previous action-button-previous" value="Back" />
                                            </fieldset>
                                            <fieldset>
                                                <div class="form-card">

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="subscribe-img">
                                                                <img src="assets/images/subscription-img2.png" class="img-fluid">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="subscription-form">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <div class="checkoutbox">
                                                                            <div>ok with eggs in desserts & breads.</div>
                                                                            <div>
                                                                                <a href=""><input type="checkbox" name="myCheckbox" value="aaa" id="myCheckbox" class="selectcheckbox" checked>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="checkoutbox">
                                                                            <div>Want meals on weekends?</div>
                                                                            <div>
                                                                                <a href=""><input type="checkbox" name="myCheckbox" value="aaa" id="myCheckbox" class="selectcheckbox" checked>
                                                                                </a>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <div class="form-group mb-2">
                                                                            <label>select Start date</label>
                                                                            <input type="text" name="birthday" value="" class="form-control" placeholder="selectdate" />
                                                                            <span class="form-icon"><img src="assets/images/fi-rr-calendar.png" class=""></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="meal-plan mb-70">
                                                                            <div class="row">
                                                                                <div class="col-lg-4 col-xl-4">
                                                                                    <h1 class="meal-title">your meal plan</h1>
                                                                                    <h1 class="meal-title">₹227<span class="submeal-title">/meal</span>
                                                                                    </h1>
                                                                                    <div class="type-meal">
                                                                                        <a href="">Breakfast</a>
                                                                                        <a href="">Lunch</a>
                                                                                        <a href="">Snacks</a>
                                                                                        <a href="">Dinner</a>
                                                                                    </div>
                                                                                    <div class="pay-meal">₹9,085</div>
                                                                                    <span class="subpay-meal">Total savings- ₹
                                                                                        905</span>
                                                                                </div>
                                                                                <div class="col-lg-4 col-xl-4">
                                                                                    <h3 class="getmeal-title">you get</h3>
                                                                                    <div class="getmeal-submeal">
                                                                                        <div><i class="fa fa-check"></i></div>
                                                                                        <div><strong>goal</strong>-weight loss</div>
                                                                                    </div>
                                                                                    <div class="getmeal-submeal">
                                                                                        <div><i class="fa fa-check"></i></div>
                                                                                        <div><strong>Preference</strong>-vegetarian
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="getmeal-submeal">
                                                                                        <div><i class="fa fa-check"></i></div>
                                                                                        <div><strong>Days</strong>-10</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4 col-xl-4">
                                                                                    <br>
                                                                                    <div class="getmeal-submeal">
                                                                                        <div><i class="fa fa-check"></i></div>
                                                                                        <div>quality ingredients</div>
                                                                                    </div>
                                                                                    <div class="getmeal-submeal">
                                                                                        <div><i class="fa fa-check"></i></div>
                                                                                        <div>eco packaging
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="getmeal-submeal">
                                                                                        <div><i class="fa fa-check"></i></div>
                                                                                        <div>Personal nutritionist</div>
                                                                                    </div>
                                                                                    <div class="getmeal-submeal">
                                                                                        <div><i class="fa fa-check"></i></div>
                                                                                        <div>Free home delivery</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="index.php"><input type="button" name="next" class="next action-button" value="Add to cart" /></a>
                                                <input type="button" name="back" class="previous action-button-previous" value="Back" />

                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>