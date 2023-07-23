<?php 

/**
 Template Name: Agent Details
 */

get_header();  



$ayp_options = get_option( 'ayp_setting_options', array() );
global $wp;
$current_slug = add_query_arg( array(), $wp->request );
$page_url= site_url();

function showrating($starRating){
    
    for ($star = 1; $star <= 5; $star++) {
      if($starRating >= $star){
         echo '<li><i class="fa fa-star" aria-hidden="true"></i></li>';        
      } else if($starRating < $star && ($star - $starRating) > 0 && ($star - $starRating) < 1 ) {
        echo '<li><i class="fa fa-star-half" aria-hidden="true"></i></li>';
      } else {
         echo '<li><i class="fa fa-star" style="opacity: 0.3;" aria-hidden="true"></i></li>';
      }
    }
}

if(get_query_var('agentid')){
      $post = ['id'  => get_query_var('agentid')];
    
      $agentInfo = Agent_Call()->getAgentByID($post); 
  }

$agentInfo = $agentInfo->data;
$wpUserInfo = get_user_by('slug',get_query_var('wpusername'));
$value = !empty($agentInfo->rating)?$agentInfo->rating:0;
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="agentInfoanonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/rater-jquery@1.0.0/rater.min.js"></script>


<!-- Twitter Card data -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@publisher_handle">
<meta name="twitter:title" content="Agent Detail - CSM">
<meta name="twitter:description" content="<?php echo $agentInfo->ldesc ?>">
<meta name="twitter:creator" content="@author_handle">
<meta name="twitter:image" content="<?php echo $agentInfo->profile_pic;?>">

<!-- Open Graph data -->
<meta property="og:image" content="<?php echo $agentInfo->profile_pic;?>" />
<meta property="og:title" content="Title Here" />
<meta property="og:type" content="article" />
<meta property="og:url" content="<?php echo $page_url ?>" />
<meta property="og:description" content="$agentInfo->ldesc " />
<style type="text/css">
.tool-slider-wrapper{ max-width: 100% !important; }    

    @media(max-width:767px){
        .pagination{margin-bottom: 0;}      
        .user_image figure img{height: auto;max-height: unset;}
        .experts-near p{font-size: 18px;}
        .agt-note p{font-size: 16px;}
    }

    .addReadMore.showlesscontent .SecSec,.addReadMore.showlesscontent .readLess {display: none;}
    .addReadMore.showmorecontent .readMore {display: none;}
    .addReadMoreWrapTxt.showmorecontent .SecSec,.addReadMoreWrapTxt.showmorecontent .readLess {display: block;}

</style>

<div class="agt-user-cover" style="background-image:url('<?php echo $ayp_options['banner_img']['url']; ?>')"></div>
<!--<a href="javascript:history.go(-1)">Go Back</a>-->
<section class="agt-user-detail usertype-<?php echo $agentInfo->subscription?>">
    <div class="container-fluid">
        <div class="row reviewer-row">
            <div class="col-md-6 pl-0 left-col">
                
                <div class="user-deail-desp">
                    <div class="back-btn"><a href="/agent-search/">Back To Results</a></div>
                    <div class="row">
                        <div class="col-md-2 pd-right0">
                            <ul class="icon-list achivment-list">
                                 <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/trophy-green-large.png"/></li>                    
                                 <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/star-green-large.png"/></li>                    
                                 <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/computer-security-shield-green-large.png"/></li>  
                            </ul>
                        </div>
                        <div class="col-md-4 agt-user_width">
                            <div class="agt-user-info">
                                <div class="agt-rating">
                                    <?php if(!empty($agentInfo->rating || $agentInfo->rating !=null)): ?>
                                      <ul class="star-rating_single">
                                     <?php $agentrating = $agentInfo->rating;
                                      showrating($agentrating);
                                    ?>
                                      </ul>
                                    <span class="rating-count-agt">(<?php echo $agentInfo->rating; ?>)</span>
                                <?php endif; ?>
                                </div>
                                <div class="agt-user-image">
                                  <img alt="<?php echo $agentInfo->first_name .' '. $agentInfo->last_name?>" title="<?php echo $agentInfo->first_name .' '. $agentInfo->last_name?>" data-src="<?php echo $agentInfo->profile_pic;?>" class=" lazyloaded" src="<?php if(!empty($agentInfo->profile_pic)): echo $agentInfo->profile_pic; else : echo  get_site_url()."/wp-content/uploads/2021/02/user.jpg"; endif;?>">
                                </div>
                                <div class="agt-button-popup d-none d-md-block">
                                    <div class="agt-button">
                                      <a class="white-button agt-agent-toggle request_book_appointment" data-popup-open="book"><?php _e('Contact Professional','agentdirectory'); ?></a>
                                      <?php if($agentInfo->subscription == 'Platinum'){ ?>
                                          <a class="white-button agt-agent-toggle request_information first" data-popup-open="information"><?php _e('Request Information','agentdirectory'); ?></a>
                                      <?php } ?>
                                        
                                       <!--   -->
                                    </div>
                                    <!-------------------Popup HTML for Request Information Desktop ------------------------->
                                     <div class="agt-agent-popup" data-popup="information">
                                        <div class="agt-agent-popup-wrapper">
                                            <div class="agt-agent-popup-close" data-popup-close="information"></div>
                                            <div class="agt-agent-popup-title" >Request Information</div>
                                            <div class="agt-agent-popup-inner">
                                                <form class="request_information_form" data-agent_id="<?php echo base64_encode($agentInfo->id)?>">
                                                    <div class="two-col">
                                                        <div class="form-field-wrapper half-width ">
                                                            <div class="form-field">
                                                                <input type="text" maxlength="30" id="name-<?php echo uniqid();?>" name="username" placeholder="Name (required)" class="form-control username" />
                                                            </div>
                                                        </div>
                                                        <div class="form-field-wrapper half-width ">
                                                             <div class="form-field">
                                                            <input type="email" id="email-<?php echo uniqid();?>"  name="useremail" maxlength= "40" placeholder="Email (required)" class="form-control useremail"  />
                                                        </div>
                                                        </div>
                                                    </div>  
                                                      <label class="tnc-div">
                                                            <input checked name="tos" class="tos" type="checkbox" />
                                                            <span><?php _e('Yes , I accept the','agentdirectory'); ?> <a href="/terms-information/"><?php _e('Terms of Use','agentdirectory'); ?></a></span>
                                                    </label>
                                                    <div class="g-recaptcha form__captcha request_information_form_gta" style="padding-top: 15px;" id="reCaptcha_request_<?php echo uniqid();?>" ></div>                         
                                                    <div class="submit-btn">
                                                        <input type="submit" value="Send" class="btn request_information_submit" />
                                                        <input type="hidden" name="agent_id" value="<?php echo base64_encode($agentInfo->id)?>"/>
                                                        <input type="hidden" name="action" value="credkeeper_request_information"/>
                                                        <div class="response_box"></div>
                                                    </div>
                                                  
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                            <!------------------- Popup HTML for Book Appointment Desktop------------------------->
                                     <div class="agt-agent-popup" data-popup="book">
                                      <div class="agt-agent-popup-wrapper">
                                          <div class="agt-agent-popup-close" data-popup-close="book"></div>
                                          <div class="agt-agent-popup-title" >Book Appointment</div>
                                          <div class="agt-agent-popup-inner">
                                               <form class="book_appointment_form" data-agent_id="<?php echo base64_encode($agentInfo->id)?>">
                                                  <div class="two-col">
                                                      <div class="form-field-wrapper half-width ">
                                                          <div class="form-field">
                                                              <input type="text" placeholder="Name (required)" class="form-control username" maxlength= "30"name="username" />
                                                          </div>
                                                      </div>
                                                       <div class="form-field-wrapper half-width ">
                                                          <div class="form-field">
                                                              <input type="tel" id="phone-<?php echo uniqid();?>"  name="phone" placeholder="Phone Number (required)" onkeypress="keyfunction(event)" maxlength= "14" class="form-control phone request_call_phone" />
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <div class="form-field-wrapper half-width ">
                                                      <div class="form-field">
                                                          <input type="email" id="email-<?php echo uniqid();?>"  name="useremail" maxlength= "40" placeholder="Email (required)" class="form-control useremail" />
                                                      </div>
                                                  </div>
                                                  <label class="tnc-div">
                                                        <input checked name="tos" class="tos" type="checkbox" />
                                                        <span><?php _e('Yes , I accept the','agentdirectory'); ?> <a href="/terms-information/"><?php _e('Terms of Use','agentdirectory'); ?></a></span>
                                                  </label>
                                                  <?php //echo Recaptcha_divcallback();?>
                                                     <div class="g-recaptcha form__captcha request_information_form_gta"  style="padding-top: 15px;" id="reCaptcha_request_<?php echo uniqid();?>" ></div>
                                                  <div class="submit-btn">
                                                      <input type="submit" value="Send" class="btn book_appointment_form" />    
                                                      <input type="hidden" name="agent_id" value="<?php echo base64_encode($agentInfo->id)?>"/>
                                                      <input type="hidden" name="action" value="credkeeper_request_information"/>
                                                      <div class="response_box"></div>                            
                                                  </div>
                                              </form>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                            </div>   
                        </div>

                        <div class="col-md-6 agt-about_width">
                            <div class="agt-user-about">
                              <?php if( !empty($agentInfo->first_name) || !empty($agentInfo->title)){ ?>
                                 <h1><?php echo $agentInfo->first_name .' '. $agentInfo->last_name;   if(!empty($agentInfo->certifications) || $agentInfo->certifications != null) : ?>,<?php  endif; ?> </h1>
                                 <span><?php $credintials = $agentInfo->certifications;
                                    $credintials_space  = str_replace(", ",", ",$credintials);
                                       if(!empty($agentInfo->certifications) || $agentInfo->certifications != null) : echo limit_text($credintials_space,2);
                                        endif;  ?>
                                </span>
                                 <?php } ?>
                                <?php if( !empty($agentInfo->firm)){ ?>
                                  <span class="busin_title"><?php echo $agentInfo->firm?></span>
                                <?php } ?>
                                 <!-- <span><?php //echo $agentInfo->address;?>,</span> -->
                                 <?php if( !empty($agentInfo->city) || !empty($agentInfo->state)){ ?>
                                 <span><?php echo $agentInfo->city;?>, <?php echo $agentInfo->state;?> <?php //echo $agentInfo->zipcode;?></span>
                                 <?php } ?>
                                  <?php if($agentInfo->subscription == 'Platinum'){ ?>
                                    <p>
                                      <button class="btn email" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                      <?php _e('Show Email','agentdirectory'); ?>
                                      </button>
                                    </p>
                                    <?php if( !empty($agentInfo->email)){ ?>
                                    <div class="collapse" id="collapseExample">
                                          <span class="email"><?php echo $agentInfo->email?></span> 
                                         <!-- <span class="phone"><?php //echo $agentInfo->phone?></span> -->
                                    </div>
                                    <?php } ?>
                                  <?php } else{ ?>
                                    <?php if( !empty($agentInfo->email)){ ?><span class="email-text"><?php echo $agentInfo->email?></span> <?php } ?>
                                  <?php } ?>
                                   <?php if( !empty($agentInfo->phone)){ ?>
                                   <p>
                                      <button class="btn email" type="button" data-toggle="collapse" data-target="#collapseExample01" aria-expanded="false" aria-controls="collapseExample01">
                                      <?php _e('Show Contact Information','agentdirectory'); ?>
                                      </button>
                                    </p>
                                    <div class="collapse" id="collapseExample01">
                                          <span class="email"><?php echo substr($agentInfo->phone, 0, 3) ."-".substr($agentInfo->phone, 4, 3) ."-". substr($agentInfo->phone, 6, 4);?></span> 
                                    </div> 
                                     <?php } ?>
                              <?php  if(!empty($agentInfo->areas_of_exp) || $agentInfo->areas_of_exp != NULL  ){ ?>
                                 <p class="area-expertise">Areas of expertise: <?php echo $agentInfo->areas_of_exp;?>
                                <?php } ?>
                                  <br>
                                 <?php  if(!empty($agentInfo->licensed_in) || $agentInfo->licensed_in != NULL ){ ?>
                                 Licensed In: <?php echo $agentInfo->licensed_in;?>

                                 </p>
                               <?php }  ?>
                            </div>
                      </div>
                    </div>
                    <div class="agt-button-popup d-block d-md-none">
                                    <div class="agt-button">
                                      <a class="white-button agt-agent-toggle request_book_appointment" data-popup-open="book"><?php _e('Contact Professional','agentdirectory'); ?></a>
                                      <?php if($agentInfo->subscription == 'Platinum'){ ?>
                                          <a class="white-button agt-agent-toggle request_information first" data-popup-open="information"><?php _e('Request Information','agentdirectory'); ?></a>
                                      <?php } ?>
                                        
                                       <!--   -->
                                    </div>
                                     <!------------------- Popup HTML for Request Information Mobile ------------------------->
                                     <div class="agt-agent-popup" data-popup="information">
                                        <div class="agt-agent-popup-wrapper">
                                            <div class="agt-agent-popup-close" data-popup-close="information"></div>
                                            <div class="agt-agent-popup-inner">
                                                <form class="request_information_form" data-agent_id="<?php echo base64_encode($agentInfo->id)?>">
                                                    <div class="two-col">
                                                        <div class="form-field-wrapper half-width ">
                                                            <div class="form-field">
                                                                <input type="text" id="name-<?php echo uniqid();?>" name="username" maxlength= "30"placeholder="Name (required)" class="form-control username" />
                                                            </div>
                                                        </div>
                                                        <div class="form-field-wrapper half-width ">
                                                             <div class="form-field">
                                                            <input type="email" id="email-<?php echo uniqid();?>"  name="useremail" maxlength= "40" placeholder="Email (required)" class="form-control useremail" />
                                                        </div>
                                                        </div>
                                                    </div>   
                                                     <div class="g-recaptcha form__captcha request_information_form_gta" style="padding-top: 15px;" id="reCaptcha_request_<?php echo uniqid();?>" ></div>
                                                     <label class="tnc-div">
                                                            <input checked name="tos" class="tos" type="checkbox" />
                                                            <span><?php _e('Yes , I accept the','agentdirectory'); ?> <a href="/terms-information/"><?php _e('Terms of Use','agentdirectory'); ?></a></span>
                                                    </label>                    
                                                    <div class="submit-btn">
                                                        <input type="submit" value="Send" class="btn request_information_submit" />
                                                        <input type="hidden" name="agent_id" value="<?php echo base64_encode($agentInfo->id)?>"/>
                                                        <input type="hidden" name="action" value="credkeeper_request_information"/>
                                                        <div class="response_box"></div>
                                                    </div>
                                                    
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                            <!------------------- Popup HTML for Book Appointment Mobile------------------------->
                                     <div class="agt-agent-popup" data-popup="book">
                                      <div class="agt-agent-popup-wrapper">
                                          <div class="agt-agent-popup-close" data-popup-close="book"></div>
                                          <div class="agt-agent-popup-inner">
                                               <form class="book_appointment_form" data-agent_id="<?php echo base64_encode($agentInfo->id)?>">
                                                  <div class="two-col">
                                                      <div class="form-field-wrapper half-width ">
                                                          <div class="form-field">
                                                              <input type="text" placeholder="Name (required)" class="form-control username" maxlength= "30" name="username" />
                                                          </div>
                                                      </div>
                                                       <div class="form-field-wrapper half-width ">
                                                          <div class="form-field">
                                                                <input type="tel" id="phone-<?php echo uniqid();?>"  name="phone" placeholder="Phone Number (required)" onkeypress="keyfunction(event)" maxlength= "14" class="form-control phone request_call_phone" />
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <div class="form-field-wrapper half-width ">
                                                      <div class="form-field">
                                                          <input type="email" id="email-<?php echo uniqid();?>"  name="useremail" maxlength= "40" placeholder="Email (required)" class="form-control useremail" />
                                                      </div>
                                                  </div>
                                                  <?php //echo Recaptcha_divcallback();?>
                                                  <div class="g-recaptcha form__captcha request_information_form_gta"  style="padding-top: 15px;" id="reCaptcha_request_<?php echo uniqid();?>" ></div>
                                                   <label class="tnc-div">
                                                        <input checked name="tos" class="tos" type="checkbox" />
                                                        <span><?php _e('Yes , I accept the','agentdirectory'); ?> <a href="/terms-information/"><?php _e('Terms of Use','agentdirectory'); ?></a></span>
                                                  </label>
                                                  <div class="submit-btn">
                                                      <input type="submit" value="Send" class="btn book_appointment_form" />    
                                                      <input type="hidden" name="agent_id" value="<?php echo base64_encode($agentInfo->id)?>"/>
                                                      <input type="hidden" name="action" value="credkeeper_request_information"/>
                                                      <div class="response_box"></div>                            
                                                  </div>
                                                 
                                              </form>
                                          </div>
                                      </div>
                                  </div>
                                </div>

                     <?php 
                     $title= get_bloginfo();
                     $facebook = 'https://www.facebook.com/sharer?u='.$page_url.'/'.$current_slug; 
                     $linkdin = 'http://www.linkedin.com/shareArticle?mini=true&amp;url='.$page_url.'/&amp;title='.$title.'&amp;source=Certified%20SafeMoney%22';
                     ?>
                    <div class="row recent_main">
                        <div class="col-md-2 pd-right0 col-2">
                            <ul class="published-social-icon">
                                <li><a target="_blank" href="<?php  echo $agentInfo->twitter_url?$agentInfo->twitter_url:'http://twitter.com/share?text='.$title.'&amp;url='.$page_url.'/'.$current_slug;?>"><span class="fa fa-twitter"></span></a></li>
                                <li><a href="<?php  echo $agentInfo->linkedin_url?$agentInfo->linkedin_url:$linkdin;?>" target="_blank"><span class="fa fa-linkedin"></span></a></li>

                                <li>
                                  <a href="<?php  echo $agentInfo->facebook_url?$agentInfo->facebook_url: $facebook?>" target="_blank">
                                    <span class="fa fa-facebook"></span></a></li>
                            </ul>
                        </div>
                        <?php if(!empty($agentInfo->ldesc)) { ?>
                        <div class="col-md-10 agent-detail-right-sec col-10">
                            <div class="about_agt agt-user-about">
                                <h3>About <?php echo $agentInfo->first_name .' '. $agentInfo->last_name?></h3>
                                <p> <?php echo str_ireplace(array("\r","\n",'\r','\n', '\"'),'', $agentInfo->ldesc); ?></p>
                            </div>
                        </div>
                      <?php } ?>
                    </div>

                    <?php 
                    if(isset($agentInfo->user_review) && !empty($agentInfo->user_review)) :
                      foreach($agentInfo->user_review as $idx=>$review){ ?>
                          <div class="row recent_main reviews-section <?php echo $idx != 0 ? 'mar_top0':''?>">
                              <div class="col-md-2 pd-right0 rating-col col-2">
                                <?php  
                                
                                $value = !empty($review->reviewer_star) ? $review->reviewer_star: 0;?>
                                  <ul class="star-rating_single">
                             <?php 
                                     $starRating = $value;
                                     showrating($starRating);
                                ?>
                                  </ul> 

                              </div>
                              <div class="col-md-10 review-col col-10">
                                  <div class="about_agt" id="review_description">
                                      <?php echo $idx == 0 ? '<h3>Recent Reviews</h3>':''?>
                                       <p class="addReadMore showlesscontent"><?php echo date('Y-m-d',strtotime($review->review_date));?> „ <?php echo $review->review_description;?>
                                       </p>
                                      <!--   <div class="agt-button">
                                          <a href="#" class="white-button">Read More</a>
                                      </div> -->
                                  </div>
                              </div>
                          </div>
                      <?php }
                    endif;?>
                     <div class="row">
                        <div class="col-md-12">
                            <div class="more_reviews">
                              <div class="agt-button">
                                  <a class="white-button agt-agent-toggle request_call" data-popup-open="leave_review">Leave a Review</a>
                              </div>
                      <!------------------------ Popup html for Leave a Review ---------------------------->
                           <div class="agt-agent-popup leave_review" data-popup="leave_review">
                              <div class="agt-agent-popup-wrapper">
                                  <div class="agt-agent-popup-close" data-popup-close="leave_review"></div>
                                  <div class="agt-agent-popup-title">Leave a Review</div>
                                  <div class="agt-agent-popup-inner">
                                      <form class="leave_review_form" data-agent_id="<?php echo base64_encode($agentInfo->id)?>">
                                          <div class="two-col">
                                              <div class="form-field-wrapper half-width ">
                                                  <div class="form-field">
                                                      <input type="text" id="reviewer_name" name="reviewer_name" maxlength= "30" placeholder="Name (required)" class="form-control reviewer_name" />
                                                  </div>
                                              </div>
                                              <div class="form-field-wrapper half-width ">
                                                <div class="form-field">
                                                    <input type="email"  maxlength= "40" id="reviewer_email"  name="reviewer_email"   placeholder="Email (required)" class="form-control reviewer_email" />
                                                </div>
                                              </div>
                                          </div>
                                          <div class="two-col">
                                                <div class="form-field-wrapper half-width ">
                                                  <div class="form-field">
                                                        <div class="rating"></div> 
                                                       <input type="hidden" id="reviewer_star"  name="reviewer_star" value="3" placeholder="Reviewer Star (required)" class="form-control reviewer_star" /> 
                                                  </div>
                                              </div>
                                          </div>
                                          <textarea rows="2" cols="20" id="review_description" class="form-control review_description" name="review_description" placeholder="Enter Description..."></textarea> 
                                          <?php // echo Recaptcha_divcallback();?>
                                          <div class="g-recaptcha form__captcha request_information_form_gta" style="padding-top: 15px;" id="reCaptcha_request_<?php echo uniqid();?>" ></div>
                                
                                          
                                          <div class="submit-btn">
                                              <input type="submit" value="Send" class="btn leave_review_form" />    
                                              <input type="hidden" name="agent_id" value="<?php echo base64_encode($agentInfo->id)?>"/>
                                              <input type="hidden" name="action" value="credkeeper_request_add_review"/>
                                              <div class="response_box"></div>                            
                                          </div>
                                      </form>
                                  </div>
                              </div>
                          </div>
                            </div>                             
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="col-md-6 right-col">
              <?php if($agentInfo->subscription == 'Platinum'  && $agentInfo->calendly != ''){ ?>
                <div class="book_appointment">
                     <div class="book_appoi">
                        <h2 class="h2">
                            Book An Appointment Via Calendly
                        </h2>
                         <div class="cal-sec"> <!-- style="height:500px" -->
                          <!-- Calendly inline widget begin -->
                          <div class="calendly-inline-widget" data-url="<?php echo $agentInfo->calendly?>" style="min-width:320px;height:630px;"></div>
                          <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
                          <!-- Calendly inline widget end -->
                         </div>
                    </div>
                </div>
              <?php } ?>
             
                <div class="latest_safe_sec">
                    <h3><?php  _e('Latest Safe Money eBooks','agentdirectory'); ?></h3>
                     <div class="tool-slider-wrapper">
                          <?php $loop = new WP_Query( array( 'post_type' => 'valuable', 'posts_per_page' => 2, 'order' => 'DESC' ) ); 
                          if($loop->have_posts()):  ?>      
                            <div class="agt-ebook-slider owl-carousel owl-theme" id="agt-ebook-slider">
                              <?php while($loop->have_posts()): $loop->the_post(); 
                              /*$image = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'valuable-image' );
                                $alt = get_post_meta(get_post_thumbnail_id( $loop->post->ID ), '_wp_attachment_image_alt', true);
                                $title = get_the_title(get_post_thumbnail_id( $loop->post->ID ));*/ ?>
                                <div class="item">
                                  <div class="slide-img">
                                    <?php if ( has_post_thumbnail() ) : the_post_thumbnail('valuable-image'); 
                                      $img_src = get_the_post_thumbnail_url($loop->post->ID,array(120,166)); endif; ?>
                                      <div class="slide-btn text-center mt-3">
                                        <a href="javascript:void(0);" class="green-btn item-popup-toggle" data-src="<?php echo $img_src; ?>">Read eBook</a>
                                      </div>
                                  </div>                       
<!--
                                  <div class="slide-contedatant"> 
                                    <h4><?php //the_title(); ?></h4>
                                  </div>         
-->
                                </div>                
                              <?php endwhile; wp_reset_query(); ?>
                            </div>                      
                          <?php endif; ?>  
                          <div class="tool-item-popup">
                              <div class="tool-item-popup-wrapper">
                                  <div class="tool-item-popup-close"><span>X</span></div>
                                  <div class="item-popup-header">
                                      <div class="item-popup-img">
                                          <?php /*if ( has_post_thumbnail() ) : the_post_thumbnail(array(120,166)); endif;*/ ?>
                                          <img src="" class="tool-item-img">
                                      </div>
                                      <div class="item-popup-header-text">
                                          <h3>Complete the information to Download Your eBook</h3>
                                      </div>       
                                  </div>  
                                  <div class="item-popup-content">
                                       <?php echo do_shortcode('[contact-form-7 id="884" title="Download eBook"]'); ?>
                                  </div>
                              </div>
                          </div> 
                                <?php  include('popup-template/thankyou-ebook.php'); ?>
                            <div class="see-ebook-btn text-center">

                                <a href= "<?php echo $page_url?>/safe-money-ebooks/" class="green-btn">Preview All eBooks</a>
                            </div>                         
                      </div>
                 <!--     <div class="agt-ebook-slider owl-carousel owl-theme">
                         <div class="owl-stage-outer">
                            <div class="owl-stage">                        
                             <div class="item">
                               <div class="article-slide-img">
                                  <a href="javacript:void(0)">
                                     <img alt="Financial Strategies" loading="lazy"   src="https://cdn.shortpixel.ai/client/q_glossy,ret_img,w_224/http://csm.demo1.bytestechnolab.com/wp-content/uploads/2021/01/retirement-strategy.jpg">                                   
                                  </a>
                               </div>
                               <div class="agt-button">
                                  <a href="#" class="white-button">Read More</a>
                               </div>
                            </div>                                         
                       </div>
                      </div>
                   </div> -->
                </div>
            </div>
        </div>
    </div>
</section>

<?php echo Agent_Call()->get_template_html("agentarticlelist",array('wp_info'=>$wpUserInfo,'agentInfo'=>$agentInfo)); ?>     
<?php /*
<section class="certifiedsafemoney-section">
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-1">
                <p>CertifiedSafeMoney.com and <?php echo $agentInfo->first_name .' '. $agentInfo->last_name?> are unrelated entities. Content is the opinion of <br> the Author as of the date of publication. The Sponsor of this content and the Author may not be the same person.</p>
                <p> <?php echo $agentInfo->first_name .' '. $agentInfo->last_name?> Disclosure: <?php echo $agentInfo->disclaimer?></p>
            <div>
        <div>
    <div>
</section> */ ?>
<section class="ask-question">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading">
                    <h3 class="h1">Ask A Question!</h3>
                    <p>Do you have a question about one of our agent/advisors or want to leave feedback?<br/>Please contact us so our team  at Credkeeper can assist you.</p>
                </div>
                <div class="question-form">
                    <?php echo do_shortcode('[contact-form-7 id="1124" title="Ask a Question"]'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php 

//include('tellus-content.php');
get_footer();

?>
<script type="text/javascript">
    jQuery( document ).ready(function() {
        var options = {
        max_value: 5,
        step_size: 0.5,
        initial_value: 0,
        selected_symbol_type: 'utf8_star', // Must be a key from symbols
        cursor: 'default',
        readonly: false,
        change_once: false, // Determines if the rating can only be set once
        additional_data: {} // Additional data to send to the server
    }

   jQuery(".rating").rate(options);
   jQuery("#reviewer_star").val(options.initial_value);
   jQuery(".rating").on("change", function(ev, data){
     // console.log(data.from, data.to);
        jQuery('#reviewer_star').val(data.to);
           jQuery('.rating').hover(function() {
      if(jQuery(this).hasClass('removerating') == true){
        jQuery(this).removeClass('removerating');
      }
    });
    });
});
</script>
