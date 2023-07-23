<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tingl
 */
?>
    <section class="customize-meal" id="customize-meal">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2>customize your meal plan</h2>
                    </div>
                </div>
                <div class="col-lg-9 col-md-10">
                    <div class="custom-plan-box">
                        <div class="custom-left">
                            <div class="meal-selection">
                                <select class="form-select" id="meal_goal_select">
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
                        
                                <select class="form-select" id="meal_preference_select">
                                <?php
                                    if( have_rows('add_preference_field_text') )
                                    {   
                                        while( have_rows('add_preference_field_text') ) 
                                        {   the_row();

                                            $add_preference_option = get_sub_field('add_preference_option');
                                            if($add_preference_option){
                                                echo  '<option value="'.$add_preference_option.'">'.$add_preference_option.'</option>';
                                            }
                                        }
                                    }
                                ?>
                                </select>
                                <input type="number" name=""
                                placeholder="enter days" class="meal_plan_days" id="meal_day">
                                <!-- <select class="form-select">
                                    <option>days</option>
                                </select> -->
                            </div>
                            <div class="custom-group-box mb-2" id="check_2">
                                <div class="form-group">
                                    <input type="checkbox" id="breakfast" checked>
                                    <label for="breakfast">breakfast</label>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" id="lunch" checked>
                                    <label for="lunch">lunch</label>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" id="snacks" checked>
                                    <label for="snacks">snacks</label>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" id="dinner" checked>
                                    <label for="dinner">dinner</label>
                                </div>
                            </div>
                            <div class="custom-plan-desc">
                                <div class="custom-plan-desc-left">
                                    <div>₹227<span class="sma">/meal</span></div>
                                    <div class="days-meal">
                                        <span id="meal_days">10 days</span>
                                        <p>₹ 9,085 for 40 meals</p>
                                    </div>
                                </div>
                                <div class="custom-plan-desc-right">
                                    <a href="http://localhost/tinglmeals/subscribe/" class="btn btn-secondary w-100">subscribe</a>
                                </div>

                            </div>
                            <div class="all-free-feature">
                                <h5>you get</h5>
                                <ul>
                                <?php
                                    if( have_rows('add_other_checkbox_text') )
                                    {   
                                        while( have_rows('add_other_checkbox_text') ) 
                                        {   the_row();
                                            $add_other_checkbox_option = get_sub_field('add_other_checkbox_option');
                                            if($add_preference_option){
                                                echo ' <li><img src="'.get_template_directory_uri().'/assets/images/checkmark.png">'.$add_other_checkbox_option.'</li>';
                                            }
                                        }
                                    }
                                ?>
                                </ul>
                            </div>
                        </div>
                        <div class="custom-right">
                            <img src="<?php echo get_template_directory_uri()?>/assets/images/plan-bg.png" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="meal-plan-list">
                                <div class="meal-plan-box">
                                    <span class="recomend">recommended</span>
                                    <div class="meal-plan-img">
                                        <img src="<?php echo get_template_directory_uri()?>/assets/images/recepiimg.png">
                                    </div>
                                    <div class="meal-plan-details">
                                        <span class="days">30 days</span>
                                        <h3>most popular</h3>
                                        <div class="daymeal-price">
                                            ₹217<span>/meal <img src="<?php echo get_template_directory_uri()?>/assets/images/veg.svg"class="img-fluid"></span>
                                        </div>
                                        <p class="meal-pr">₹ 26,100 for 120 meals</p>
                                        <div class="plan-feature">
                                            <span>Personal nutritionist</span>
                                            <span>free home delivery</span>
                                            <span>eco packaging</span>
                                            <span>quality ingredients</span>
                                            <span>weight loss</span>
                                            <span>Vegetarian</span>
                                        </div>
                                        <a href="#" class="btn btn-secondary w-100">subscribe</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="meal-plan-list">

                                <div class="meal-plan-box">
                                    <div class="meal-plan-img">
                                        <img src="<?php echo get_template_directory_uri()?>/assets/images/recepiimg.png">
                                    </div>
                                    <div class="meal-plan-details">
                                        <span class="days">45 days</span>
                                        <h3>max value</h3>
                                        <div class="daymeal-price">
                                            ₹197<span>/meal <img src="<?php echo get_template_directory_uri()?>/assets/images/nonveg.svg"
                                                    class="img-fluid"></span>
                                        </div>
                                        <p class="meal-pr">₹ 35,550 for 180 meals</p>
                                        <div class="plan-feature">
                                            <span>Personal nutritionist</span>
                                            <span>free home delivery</span>
                                            <span>eco packaging</span>
                                            <span>quality ingredients</span>
                                            <span>weight loss</span>
                                            <span>Vegetarian</span>
                                        </div>
                                        <a href="#" class="btn btn-secondary w-100">subscribe</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="menu-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-7">
                    <div class="section-title">
                        <h2 class="text-start">menu</h2>
                    </div>
                    <div class="menu-filter">
                        <div class="menu-select">
                            <div class="row">
                                <div class="col-lg-4 col-md-5">
                                    <label>select goal</label>
                                    <select class="form-select" id="menu_goal_select">
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
                                <div class="col-lg-5 col-md-7">
                                    <label>select preference</label>
                                    <select class="form-select" id="menu_preference_select">
                                    <?php
                                        if( have_rows('add_preference_field_text') )
                                        {   
                                            while( have_rows('add_preference_field_text') ) 
                                            {   the_row();

                                                $add_preference_option = get_sub_field('add_preference_option');
                                                if($add_preference_option){
                                                    echo  '<option value ="'.$add_preference_option.'">'.$add_preference_option.'</option>';
                                                }
                                            }
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="date-slider">
                            <label>august</label>
                            <div id="slider-date" class="owl-carousel owl-theme plan-carousel mt-5 slider-date">
                                <div class="item">
                                    <div class="slide-date">
                                        <span>mon</span>
                                        5
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="slide-date">
                                        <span>tue</span>
                                        6
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="slide-date">
                                        <span>wed</span>
                                        7
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="slide-date">
                                        <span>thu</span>
                                        8
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="slide-date">
                                        <span>fri</span>
                                        9
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="slide-date">
                                        <span>sat</span>
                                        10
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="slide-date">
                                        <span>sun</span>
                                        11
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="slide-date">
                                        <span>mon</span>
                                        12
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="slide-date">
                                        <span>tue</span>
                                        13
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="slide-date">
                                        <span>wed</span>
                                        14
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="slide-date">
                                        <span>thu</span>
                                        15
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="slide-date">
                                        <span>fri</span>
                                        16
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="slide-date">
                                        <span>sat</span>
                                        17
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="slide-date">
                                        <span>sun</span>
                                        18
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="menu-type">
                            <div class="select-money">
                                <div class="text-radio">
                                    <input id="dollar1" name="money" type="radio" checked="" class="carfilter">
                                    <label for="dollar1">
                                        breakfast
                                    </label>
                                </div>
                                <div class="text-radio">
                                    <input id="dollar2" name="money" type="radio" class="carfilter">
                                    <label for="dollar2">
                                        lunch
                                    </label>
                                </div>
                                <div class="text-radio">
                                    <input id="dollar3" name="money" type="radio" class="carfilter">
                                    <label for="dollar3">
                                        snacks
                                    </label>
                                </div>
                                <div class="text-radio">
                                    <input id="dollar4" name="money" type="radio" class="carfilter">
                                    <label for="dollar4">
                                        dinner
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-5">
                    <div class="menu-images">
                        <img src="<?php echo get_template_directory_uri()?>/assets/images/r1menu.png" class="img-fluid" name="formula" id="formula">
                        <div class="menu-radio">
                            <p>
                                <input type="radio" id="test1" value="fish" name="radio-group" checked>
                                <label for="test1">fish & vegetables</label>
                            </p>
                            <p>
                                <input type="radio" value="veg" id="test2" name="radio-group">
                                <label for="test2">chicken with pesto</label>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>