<?php /* Template Name: subscribe page */ ?>


<style>
    #msform input.selectcheckbox {
        padding: 10px 15px 8px 15px;
        border: 1px solid #cccccc5c;
        border-radius: 10px;
        /* margin-bottom: 35px; */
        /* margin-top: 2px; */
        width: auto;
        box-sizing: border-box;
        color: #2C3E50;
        background-color: #000 !important;
        border-color: #000 !important;
        font-size: 16px;
        letter-spacing: 1px;
    }
    .form-group{
        position: relative;
        margin-bottom: 35px !important;
    }
    span.form-icon {
        position: absolute;
        right: 10px;
        top: 13px !important;
    }

    </style>


<?php 
get_header();
?>

    <div class="main-content">
        <section class="plans">
            <div class="container">
                <div class="section-title">
                    <h2>plans</h2>
                </div>
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

                                <?php
                                    $add_email_field_text               = get_field('add_email_field_text');
                                    $add_pin_code_field_text            = get_field('add_pin_code_field_text');
                                    $add_weight_field_text              = get_field('add_weight_field_text');
                                    $add_age_field_text                 = get_field('add_age_field_text'); 
                                    $add_height_field_text              = get_field('add_height_field_text');
                                    $add_personal_details_description   = get_field('add_personal_details_description');
                                ?>

                                <fieldset>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="subscribe-img">
                                                    <img src="<?php echo get_template_directory_uri()?>/assets/images/subscription-img1.png" class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="subscription-form personal_data">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <?php
                                                                    if($add_email_field_text)
                                                                    {
                                                                        echo '<label>'.$add_email_field_text.'</label>';
                                                                    }
                                                                ?>
                                                                <input type="text" name="email" placeholder="enter email id"
                                                                class="form-control" id="email">
                                                                <span id="email_error" class="error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group ">
                                                                <?php
                                                                    if($add_pin_code_field_text)
                                                                    {
                                                                        echo '<label>'.$add_pin_code_field_text.'</label>';
                                                                    }
                                                                ?>
                                                                <input type="number" name="pincode" placeholder="enter pincode"
                                                                class="form-control" id="pincode">
                                                                <span id="pincode_error" class="error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group ">
                                                                <?php
                                                                    if($add_weight_field_text)
                                                                    {
                                                                        echo '<label>'.$add_weight_field_text.'</label>';
                                                                    }
                                                                ?>
                                                                <input type="number" name="weight" placeholder="enter weight"
                                                                class="form-control" id="weight" maxlength="3">
                                                                <span id="weight_error" class="error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group ">
                                                                <?php
                                                                    if($add_age_field_text)
                                                                    {
                                                                        echo '<label>'.$add_age_field_text.'</label>';
                                                                    }
                                                                ?>
                                                                <input type="number" name="age" placeholder="enter age ex:24"
                                                                class="form-control" id="age" maxlength="2" >
                                                                <span id="age_error" class="error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group ">
                                                                <?php
                                                                    if($add_height_field_text)
                                                                    {
                                                                        echo '<label>'.$add_height_field_text.'</label>';
                                                                    }
                                                                ?>
                                                                <select class="form-select subscription" name="height" id="height">
                                                                    <option value="">Select height</option>
                                                                    <option value="4.5"> 4.5 </option>
                                                                    <option value="4.6"> 4.6 </option>
                                                                    <option value="4.7"> 4.7 </option>
                                                                    <option value="4.8"> 4.8 </option>
                                                                    <option value="4.9"> 4.9 </option>
                                                                    <option value="4.10">4.10</option>
                                                                    <option value="4.11">4.11</option>
                                                                    <option value="5.0"> 5.0 </option>
                                                                    <option value="5.1"> 5.1 </option>
                                                                    <option value="5.2"> 5.2 </option>
                                                                    <option value="5.3"> 5.3 </option>
                                                                    <option value="5.4"> 5.4 </option>
                                                                    <option value="5.5"> 5.5 </option>
                                                                    <option value="5.6"> 5.6 </option>
                                                                    <option value="5.7"> 5.7 </option>
                                                                    <option value="5.8"> 5.8 </option>
                                                                    <option value="5.9"> 5.9 </option>
                                                                    <option value="5.10">5.10</option>
                                                                    <option value="5.11">5.11 </option>
                                                                    <option value="6.0"> 6.0 </option>
                                                                    <option value="6.1"> 6.1 </option>
                                                                    <option value="6.2"> 6.2 </option>
                                                                    <option value="6.3"> 6.3 </option>
                                                                    <option value="6.4"> 6.4 </option>
                                                                    <option value="6.5"> 6.5 </option>
                                                                    <option value="6.6"> 6.6 </option>
                                                                    <option value="6.7"> 6.7 </option>
                                                                    <option value="6.8"> 6.8 </option>
                                                                    <option value="6.9"> 6.9 </option>
                                                                    <option value="6.10">6.10</option>
                                                                    <option value="6.11">6.11</option>
                                                                    <option value="7.0"> 7.0</option>
                                                                    <option value="7.1"> 7.1</option>
                                                                    <option value="7.2"> 7.2</option>
                                                                    <option value="7.3"> 7.3</option>
                                                                    <option value="7.4"> 7.4</option>
                                                                    <option value="7.5"> 7.5</option> 
                                                                </select>
                                                                <span id="height_error" class="error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group ">
                                                                <?php 
                                                                    if( $add_personal_details_description)
                                                                    {
                                                                        echo '<p>'.$add_personal_details_description.'</p>';
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <input type="button" name="next" class="next action-button personal_details" value="Next" />
                                </fieldset>

                                <?php
                                 $add_allergies_section_heading   = get_field('add_allergies_section_heading');
                                 $add_other_allergies_field_text  = get_field('add_other_allergies_field_text');
                                ?>      

                                <fieldset>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="subscribe-img">
                                                    <img src="<?php echo get_template_directory_uri()?>/assets/images/subscription-img2.png" class="img-fluid">
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="subscription-form allergies_data">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="form-group ">
                                                                <?php
                                                                    if( $add_allergies_section_heading)
                                                                    {
                                                                        echo '<p>'.$add_allergies_section_heading.'</p>';                              
                                                                    }
                                                                ?>
                                                            </div>
                                                            <div class="alergy-tab">
                                                                <div class="allergies-list mt-3">
                                                                    <div class="select-money">
                                                                    <?php
                                                                        if( have_rows('add_allergies_list') )
                                                                        {
                                                                            $i=1;
                                                                            while( have_rows('add_allergies_list') ) 
                                                                            {   the_row();
                                                                                $add_allergies_option = get_sub_field('add_allergies_option');
                                                                                if( $add_allergies_option ){
                                                                                    echo  '  <div class="text-checkbox">
                                                                                    <input id="dollar'.$i.'" name="money" type="checkbox" class="carfilter">
                                                                                    <label for="dollar'.$i.'">
                                                                                        '.$add_allergies_option.'
                                                                                    </label>
                                                                                    </div>';
                                                                                    $i++;
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <div class="text-checkbox">
                                                                        <input id="dollarother" name="money" type="checkbox" class="carfilter">
                                                                        <label for="dollarother">
                                                                            other
                                                                        </label>
                                                                        </div>
                                                                
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group  mt-4" id="all_add">
                                                                <?php
                                                                    if($add_other_allergies_field_text)
                                                                    {
                                                                        echo '<label>'.$add_other_allergies_field_text.'</label>';
                                                                    }
                                                                ?>
                                                                <input type="text" name="" placeholder="enter allergies"
                                                                class="form-control">
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
                                                    <img src="<?php echo get_template_directory_uri()?>/assets/images/subscription-img1.png" class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="subscription-form">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group ">
                                                                <select class="form-select subscription" id="goal_select">
                                                                <?php
                                                                    if( have_rows('add_goal_field_text') )
                                                                    {   
                                                                        while( have_rows('add_goal_field_text') ) 
                                                                        {   the_row();

                                                                            $add_goal_option = get_sub_field('add_goal_option');
                                                                            if($add_goal_option){
                                                                                echo  '<option value="'.$add_goal_option.'">'.$add_goal_option.'</option>';
                                                                            }
                                                                        }
                                                                    }
                                                                ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group ">
                                                                <select class="form-select subscription"  id="preference_select">
                                                                <?php
                                                                    if( have_rows('add_preference_field_text') )
                                                                    {
                                                                        while( have_rows('add_preference_field_text') ) 
                                                                        {   the_row();
                                                                            $add_preference_option = get_sub_field('add_preference_option');
                                                                            if($add_preference_option ){
                                                                                echo  '<option value="'.$add_preference_option.'">'.$add_preference_option.'</option>';
                                                                            }
                                                                        }
                                                                    }
                                                                ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group ">
                                                                <input type="number" name="" placeholder="type days"
                                                                    class="form-control" id="meal_plan_day">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="meal-tab">
                                                                <a href=""><input type="checkbox" name="myCheckbox"
                                                                        value="aaa" id="myCheckbox_breakfast"
                                                                        class="selectcheckbox" checked>
                                                                    <label for="myCheckbox"
                                                                        class="checkbox-label">breakfast</label></a>
                                                                <a href=""><input type="checkbox" name="myCheckbox"
                                                                        value="aaa" id="myCheckbox_lunch"
                                                                        class="selectcheckbox" checked>
                                                                    <label for="myCheckbox">lunch</label></a>
                                                                <a href=""><input type="checkbox" name="myCheckbox"
                                                                        value="aaa" id="myCheckbox_snacks"
                                                                        class="selectcheckbox" checked>
                                                                    <label for="myCheckbox">snacks</label></a>
                                                                <a href=""><input type="checkbox" name="myCheckbox"
                                                                        value="aaa" id="myCheckbox_dinner"
                                                                        class="selectcheckbox" checked>
                                                                    <label for="myCheckbox">dinner</label></a>
                                                            </div>
                                                        </div>
                                                       <div class="col-md-12">
                                                            <div class="meal-plan">
                                                                <div class="row">
                                                                    <div class="col-lg-4 col-xl-4">
                                                                        <?php
                                                                            $add_meal_title=get_field('add_meal_title');
                                                                            if($add_meal_title)
                                                                            {
                                                                                echo '<h1 class="meal-title">'.$add_meal_title.'</h1>';
                                                                            }
                                                                        ?>
                                                                        <div class="subpay-meal pb-30" id="meal_day">
                                                                            select Days
                                                                        </div>
                                                                        <div class="subpay-meal">₹9,085 for 40 meals
                                                                        </div>
                                                                        <div class="type-meal d-flex justify-content-start">
                                                                            <label for="Breakfast"id="type_meal_breakfast">breakfast</label>
                                                                            <label for="Lunch" id="type_meal_lunch">lunch</label>
                                                                            <label for="Snacks" id="type_meal_snacks">snacks</label>
                                                                            <label for="Dinner" id="type_meal_dinner">dinner</label>
                                                                  
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-xl-4">
                                                                        <?php
                                                                            $add_get_meal_title=get_field('add_get_meal_title');
                                                                            if($add_get_meal_title)
                                                                            {
                                                                                echo '<h3 class="getmeal-title">'.$add_get_meal_title.'</h3>';
                                                                            }
                                                                        ?>
                                                                        <div class="getmeal-submeal">
                                                                            <div><i class="fa fa-check"></i></div>
                                                                            <div id="goal_text">select goal</div>
                                                                        </div>
                                                                        <div class="getmeal-submeal">
                                                                            <div><i class="fa fa-check"></i></div>
                                                                            <div id="preference_text">select preference</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-xl-4">
                                                                        <br>
                                                                        <?php
                                                                            if( have_rows('add_other_checkbox_text') )
                                                                            {   
                                                                                while( have_rows('add_other_checkbox_text') ) 
                                                                                {   the_row();
                                                                                    $add_other_checkbox_option = get_sub_field('add_other_checkbox_option');
                                                                                    if( $add_other_checkbox_option ){
                                                                                        echo '<div class="getmeal-submeal">
                                                                                        <div><i class="fa fa-check"></i></div>
                                                                                        <div>'.$add_other_checkbox_option.'</div>
                                                                                        </div>';
                                                                                    }                                  
                                                                                }
                                                                            }
                                                                        ?>
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
                                    <input type="button" name="back" class="previous action-button-previous"
                                        value="Back" />
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="subscribe-img">
                                                    <img src="<?php echo get_template_directory_uri()?>/assets/images/subscription-img2.png" class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="subscription-form">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <?php
                                                            if( !empty( have_rows('add_other_option')) ){
                                                                if( have_rows('add_other_option') )
                                                                {   
                                                                    while( have_rows('add_other_option') ) 
                                                                    {   the_row();
                                                                        $add_other_text = get_sub_field('add_other_text');
                                                                        if( $add_other_text ){
                                                                            echo '<div class="checkoutbox">';
                                                                                echo '<div>'. $add_other_text.'</div>';
                                                                                echo '<div>';
                                                                                    echo '<a href=""><input type="checkbox"             name="myCheckbox" value="aaa" id="myCheckbox"
                                                                                    class="selectcheckbox" checked></a>';
                                                                                echo '</div>';
                                                                            echo '</div>';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <?php
                                                                    $add_date_field_text=get_field('add_date_field_text');
                                                                    if($add_date_field_text)
                                                                    {
                                                                        echo '<label>'.$add_date_field_text.'</label>';
                                                                    }
                                                                ?>
                                                                <input type="text" name="birthday" value="" class="form-control" placeholder="selectdate" />
                                                                <span class="form-icon"><img src="<?php echo get_template_directory_uri()?>/assets/images/fi-rr-calendar.png"
                                                                class=""></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="meal-plan mb-70">
                                                                <div class="row">
                                                                    <div class="col-lg-4 col-xl-4">
                                                                        <?php
                                                                            $add_meal_plan_title=get_field('add_meal_plan_title');
                                                                            if($add_meal_plan_title)
                                                                            {
                                                                                echo '<h1 class="meal-title">'.$add_meal_plan_title.'</h1>';
                                                                            }
                                                                        ?>
                                                                        <h1 class="meal-title">₹227<span class="submeal-title">/meal</span>
                                                                        </h1>
                                                                        <div class="type-meal d-flex justify-content-start">
                                                                        <label for="Breakfast"id="meal_breakfast">breakfast</label>
                                                                            <label for="Lunch" id="meal_lunch">lunch</label>
                                                                            <label for="Snacks" id="meal_snacks">snacks</label>
                                                                            <label for="Dinner" id="meal_dinner">dinner</label>
                                                                        </div>
                                                                        <div class="pay-meal">₹9,085</div>
                                                                        <span class="subpay-meal">Total savings- ₹ 905</span>
                                                                    </div>
                                                                    <div class="col-lg-4 col-xl-4">
                                                                        <?php
                                                                            $add_get_meal_title=get_field('add_get_meal_title');
                                                                            if($add_get_meal_title)
                                                                            {
                                                                                echo '<h3 class="getmeal-title">'.$add_get_meal_title.'</h3>';
                                                                            }
                                                                        ?>
                                                                        <div class="getmeal-submeal">
                                                                            <div><i class="fa fa-check"></i></div>
                                                                            <div id="goal_final"><strong>goal</strong>-weight loss</div>
                                                                        </div>
                                                                        <div class="getmeal-submeal">
                                                                            <div><i class="fa fa-check"></i></div>
                                                                            <div id="preference_final"><strong>Preference</strong>-vegetarian
                                                                            </div>
                                                                        </div>
                                                                        <div class="getmeal-submeal">
                                                                            <div><i class="fa fa-check"></i></div>
                                                                            <div id="day_final"><strong>Days</strong>-10</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-xl-4">
                                                                        <br>
                                                                        <?php
                                                                            if( have_rows('add_other_checkbox_text') )
                                                                            {   
                                                                                while( have_rows('add_other_checkbox_text') ) 
                                                                                {   the_row();
                                                                                    $add_other_checkbox_option = get_sub_field('add_other_checkbox_option');

                                                                                    if( $add_other_checkbox_option ){
                                                                                        echo '<div class="getmeal-submeal">
                                                                                        <div><i class="fa fa-check"></i></div>
                                                                                        <div>'.$add_other_checkbox_option.'</div>
                                                                                        </div>';
                                                                                    }                                 
                                                                                }
                                                                            }
                                                                        ?>
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
        </section>
     
<?php
    get_template_part('template-parts/content/content-testimonial','page');
?> 
  </div> 
<?php
get_footer();
?>