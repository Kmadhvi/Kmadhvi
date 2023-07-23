<?php 



use JasonGrimes\Paginator;

require AD_PLUGIN_DIR .'/vendor/autoload.php';?>


<?php 

 
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

 if (!empty($attributes->data->data)):
     $agentMapInfo = array();
     foreach($attributes->data->data as $idx=>$agentInfo) :
        $wpAuthorslug = false;
        $wpUserInfo = get_user_by('email',$agentInfo->wp_author_slug);
        if($wpUserInfo){
            $wpAuthorslug = $wpUserInfo->data->user_login .'/'. $agentInfo->id;
        }

        if($agentInfo->id == 251){
           $agentInfo->subscription = 'Platinum';
           $agentInfo->calendly = 'https://calendly.com/jigar-senghani/15min';
        }
        if($agentInfo->late != NULL &&  $agentInfo->late != 'null' && $agentInfo->long != 'null' && $agentInfo->long != NULL){

          /*  $agentMapInfo[$idx]['description'] = $agentInfo->address;*/
            $agentMapInfo[$idx]['lat']  =  $agentInfo->late;
            $agentMapInfo[$idx]['lng'] = $agentInfo->long;
            $agentMapInfo[$idx]['title'] = $agentInfo->first_name .' ' . $agentInfo->last_name;    
            $agentMapInfo[$idx]['cdkid'] = bin2hex($agentInfo->id);    
            $agentMapInfo[$idx]['wpAuthorslug'] = site_url('/agent-detail/'.$wpAuthorslug);    
            $agentMapInfo[$idx]['profile_pic'] = $agentInfo->profile_pic;    
           // $agentMapInfo[$idx]['address '] =  $agentInfo->city .' , '. $agentInfo->state;
            $agentMapInfo[$idx]['certifications'] =  $agentInfo->certifications;
            
        }

        $value = !empty($agentInfo->rating)?$agentInfo->rating:0; 
        ?>
        <div id="agnetbox-<?php echo bin2hex($agentInfo->id)?>" data-id="<?php echo bin2hex($agentInfo->id)?>" class="professional_details_inner demo">

            <div class="professional_details_above">

                 <div class="user_image">
                
                  <figure>
                      <a href="<?php echo $wpAuthorslug ? site_url('/agent-detail/'.$wpAuthorslug) : 'javascript:void(0);'?>">
                         <img src="<?php if(!empty($agentInfo->profile_pic)) : echo $agentInfo->profile_pic; else : echo get_site_url()."/wp-content/uploads/2021/02/user.jpg" ;endif;?>" alt="<?php echo $agentInfo->first_name." ".$agentInfo->last_name;?>"/>
                    </a>
                </figure>

                </div>

                <div class="user_details">
                    <?php if(!empty($agentInfo->first_name)){ ?>
                    <a href="<?php echo $wpAuthorslug ? site_url('/agent-detail/'.$wpAuthorslug) : 'javascript:void(0);'?>"> <h3><?php echo $agentInfo->first_name." ".$agentInfo->last_name;  if(!empty($agentInfo->certifications) || $agentInfo->certifications != null) : ?>,<?php  endif; ?></h3><span><?php $credintials = $agentInfo->certifications;
                    $credintials_space  = str_replace(",", ", " , $credintials);
                       if(!empty($agentInfo->certifications) || $agentInfo->certifications != null) : echo limit_text($credintials_space,3);
                        endif; ?>
                    </span></a>
                    <?php } ?>
                    <?php if( $agentInfo->subscription != 'Free'){ ?>
                         <ul class="icon-list achivment-list">

                        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/trophy-green.png"/></li>                    

                        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/star-green.png"/></li>                    

                        <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/computer-security-shield-green.png"/></li>                    

                    </ul>
                  <?php  } ?>
                
                    <div class="city_state">
                    <?php if(!empty($agentInfo->city) || !empty($agentInfo->state) || ($agentInfo->city !=null || $agentInfo->state != null) ){ ?>
                        <strong><?php echo $agentInfo->city .' , '. $agentInfo->state;?></strong>
                    <?php } ?>
                    <?php  if(!empty($agentInfo->areas_of_exp) || $agentInfo->areas_of_exp !=null ) { ?>
                        <span>Area of expertises : <?php echo $agentInfo->areas_of_exp?></span>
                    <?php } ?>
                     <?php  if(!empty($agentInfo->licensed_in) || $agentInfo->licensed_in != null ) { ?>
                        <span>Licensed In: <?php echo $agentInfo->licensed_in?></span>
                    <?php } ?>
                    </div>
                    <a class="fap-list-rating" href="<?php echo $wpAuthorslug ? site_url('/agent-detail/'.$wpAuthorslug) : 'javascript:void(0);'?>">
                     <?php if(!empty($agentInfo->rating || $agentInfo->rating !=null)): ?>
                        <ul class="star_icon">
                            <?php
                            $starRating = $agentInfo->rating;
                            showrating($starRating);
                                    ?>
                                <li><span>(<?php echo $agentInfo->rating; ?>)</span></li>

                        </ul>
                    </a>
                          <?php endif; ?>
                        <?php  if(!empty($agentInfo->description)) { ?>
                            <p class="agt-user-content"><?php echo wp_trim_words($agentInfo->description, 30);?></p>
                        <?php } ?>
                        <span class="reviews-prof"><?php echo $agentInfo->review_count;?> Reviews</span>

                    </div>

            </div>

            <div class="popup_group_btn">

                <a class="professional_popup agt-agent-toggle request_information first" data-popup-open="information">Request Information</a>

                <a class="professional_popup agt-agent-toggle request_call" data-popup-open="call">Request a call</a>

                <?php if($agentInfo->subscription == 'Platinum'  && $agentInfo->calendly != '') :?>

                <a class="professional_popup agt-agent-toggle request_book_appointment" data-popup-open="book">Book An Appointment</a>

            <?php endif;?>

            </div>

            <div class="agt-agent-popup" data-popup="information">

                <div class="agt-agent-popup-wrapper">

                    <div class="agt-agent-popup-close" data-popup-close="information"></div>

                    <div class="agt-agent-popup-title">Request Information</div>
                    
                      

                    <div class="agt-agent-popup-inner">
                    

                        <form class="request_information_form" data-agent_id="<?php echo base64_encode($agentInfo->id)?>">
	                  
	              
                            <div class="two-col">

                                <div class="form-field-wrapper half-width ">

                                    <div class="form-field">

                                        <input type="text" id="name-<?php echo uniqid();?>" name="username" placeholder="Name (required)" maxlength="30" class="form-control username" />

                                    </div>

                                </div>

                                <div class="form-field-wrapper half-width ">

                                     <div class="form-field">

                                    <input type="email" id="email-<?php echo uniqid();?>"  name="useremail" placeholder="Email (required)" maxlength="35" class="form-control useremail" />

                                </div>

                                </div>


                            </div>   

                            <label class="tnc-div">

                                    <input checked name="tos" class="tos" type="checkbox" />

                                    <span>Yes , I accept the <a href="/terms-information/" target="_blank">Terms of Use</a></span>

                            </label>  

                           <div class="g-recaptcha request_information_form_gta" id="reCaptcha_request_<?php echo uniqid();?>" ></div>  
                                    

                            <div class="submit-btn">

                                <input type="submit" value="Send" class="btn request_information_submit" />

                                <input type="hidden" name="agent_id" value="<?php echo base64_encode($agentInfo->id)?>"/>

                                <input type="hidden" name="action" value="credkeeper_request_information"/>

                                <div class="response_box"></div>

                                <div class="request_information_msg" style="font-size: 18px;color: limegreen;text-align: center;"></div>
                            </div>
                        </form>

                    </div>

                </div>

            </div>

             <div class="agt-agent-popup" data-popup="call">

                <div class="agt-agent-popup-wrapper">

                    <div class="agt-agent-popup-close" data-popup-close="call"></div>

                    <div class="agt-agent-popup-title">Request A Call</div>
                    
                      

                    <div class="agt-agent-popup-inner">

                        <form class="request_call_form">

                            <div class="two-col">

                                <div class="form-field-wrapper half-width ">

                                    <div class="form-field">

                                        <input type="text" id="name-<?php echo uniqid();?>" name="username"  placeholder="Name (required)" maxlength="25" class="form-control username" />

                                    </div>

                                </div>

                                <div class="form-field-wrapper half-width ">

                                    <div class="form-field">

                                      <input type="tel" id="phone-<?php echo uniqid();?>" name="phone" onkeypress="keyfunction(event)" placeholder="Phone Number (required)" maxlength="14" class="form-control phone request_call_phone" />

                
                                    </div>

                                </div>

                            </div>

                            <div class="form-field-wrapper half-width ">

                                <div class="form-field">

                                    <input type="email" id="email-<?php echo uniqid();?>"  name="useremail"   placeholder="Email (required)" maxlength="35" class="form-control useremail" />

                                </div>

                            </div>
                            
                             <label class="tnc-div">

                                    <input checked class="tos" name="tos" type="checkbox" />

                                    <span>Yes , I accept the <a href="/terms-information/" target="_blank">Terms of Use</a></span>

                            </label>
                            
                             <div class="g-recaptcha form__captcha request_information_form_gta" id="reCaptcha_request_<?php echo uniqid();?>" ></div> 
                           <!--  <p class="recaptcha_error" style="display: none; color:red;"></p> -->


                            <div class="submit-btn">

                                <input type="submit" value="Send" class="btn request_call_form" />    

                                <input type="hidden" name="agent_id" value="<?php echo base64_encode($agentInfo->id)?>"/>

                                <input type="hidden" name="action" value="credkeeper_request_information"/>

                                <div class="response_box"></div>                            

                                <div class="request_call_msg" style="font-size: 18px;color: limegreen;text-align: center;"></div>
                            </div>


                        </form>

                    </div>

                </div>

            </div>

            <?php if($agentInfo->subscription == 'Platinum' && $agentInfo->calendly != '') :?>

            <div class="agt-agent-popup" data-popup="book">

                <div class="agt-agent-popup-wrapper">

                    <div class="agt-agent-popup-close" data-popup-close="book"></div>

                    <div class="agt-agent-popup-title">Book An Appointment</div>

                    <div class="agt-agent-popup-inner row-appointment">

                        <div class="row">

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4 agent-detail-wrap">
                                        <div class="user_image ">
                                            <figure><img src="<?php echo $agentInfo->profile_pic?>" alt="<?php echo $agentInfo->first_name." ".$agentInfo->last_name;?>"/></figure>
                                        </div>
                                        <div class="text">
                                            <h4>Demo Call</h4>
                                            <p> <i class="fa fa-clock-o" aria-hidden="true"></i> 30 Min</p>
                                            <p>A member of our team will walk you through the platform and demonstrate how your solution can help!</p>
                                        </div>
                                    </div>
                                    <div class="col-md-8 agent-search-wrap">
                                        <!-- Calendly inline widget begin -->
                                        <div class="calendly-inline-widget" data-url="<?php if($agentInfo->calendly != ''): echo $agentInfo->calendly; endif; ?>?hide_event_type_details=1&hide_gdpr_banner=1" style="min-width:320px;height:400px;"></div>

                                        <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
                                        <!-- Calendly inline widget end -->
                                    </div>
                                </div>  
                            </div>
                        </div>

                    </div>
                    <label class="tnc-div book-accept">

                        <input checked class="tos" name="tos" type="checkbox" />

                        <span>Yes , I accept the <a href="/terms-information" target="_blank">Terms of Use</a></span>

                    </label>
                </div>
            </div>

        <?php endif; //if($agentInfo->subscription == 'Platinum') :?>

        </div> 

     <?php endforeach;  ?>





<nav aria-label="Page navigation">

  <?php 

  if(empty($agentMapInfo)){

        $agentMapInfo[0]['description'] = 'Aksa Beach is a popular beach and a vacation spot in Aksa village at Malad, Mumbai';

        $agentMapInfo[0]['lat']  =  '19.1759668';

        $agentMapInfo[0]['lng'] =   '72.79504659999998';

        $agentMapInfo[0]['title'] = 'Aksa Beach';    



         $agentMapInfo[1]['description'] = 'A@@@@@@Aksa village at Malad, Mumbai';

        $agentMapInfo[1]['lat']  =  '19.1759668';

        $agentMapInfo[1]['lng'] =   '72.82652380000002';

        $agentMapInfo[1]['title'] = 'Juhu Beach';

  }else{

    $agentMapInfo = array_values($agentMapInfo);



  }



/*[first_page_url] => https://dev2.thebest.directory/public/index.php/api/wp/wp-get-agent?page=1

[from] => 1

[last_page] => 51

[last_page_url] => https://dev2.thebest.directory/public/index.php/api/wp/wp-get-agent?page=51

[next_page_url] => https://dev2.thebest.directory/public/index.php/api/wp/wp-get-agent?page=2

[path] => https://dev2.thebest.directory/public/index.php/api/wp/wp-get-agent

[per_page] => 10

[prev_page_url] =>

[to] => 10

[total] => 506

*/



$totalItems = $attributes->data->total;

$itemsPerPage = 10;

$currentPage = $attributes->data->current_page;

//$currentPage = isset($_REQUEST['page'])?$_REQUEST['page']:1;

$urlPattern = '(:num)';



$paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

$paginator->setMaxPagesToShow(4);

echo $paginator; 



?>

</nav>

    <?php 



    /* echo "<pre>";

     print_r($attributes);

     echo "</pre>";*/

endif;



?>


</style>

<script type="text/javascript">

    var locations = '<?php echo json_encode($agentMapInfo)?>';

    $('.agt-agent-toggle').on('click',function(){ 
    
    
            $this = $(this);
            var ScrollHeight01 = $this.offset().top - $this.offsetParent().offset().top
            //console.log(ScrollHeight01);
           $(this).addClass('active');
           var PopUp = $(this).attr('data-popup-open');        
            $('[data-popup]').hide();
           var OpenPopup = $('[data-popup="' + PopUp + '"]');
           $(this).parents('.professional_details_inner').find(OpenPopup).slideDown(); 
           $('body').addClass('agt-popup-open');                
//            var ScrollHeight =  $(this).parents('.professional_details_inner').find(OpenPopup).offset().top + $(this).parents('.professional_details_inner').find(OpenPopup).innerHeight() - $(window).innerHeight();
//                setTimeout(function(){ 
//                    $("body,html").animate({ scrollTop: ScrollHeight }, 500);
//                }, 100);
 
    });

    $('.agt-agent-popup-close').on('click',function(){
       $('.agt-agent-toggle').removeClass('active');
       var PopUpClose = $(this).attr('data-popup-close');            
       var ClosePopup = $('[data-popup="' + PopUpClose + '"]');        
        $('[data-popup]').slideUp();
       $(this).parents('.professional_details_inner').find(ClosePopup).slideUp();
        $('body').removeClass('agt-popup-open');
         $('.request_information_form').trigger("reset");
         $('.request_call_form').trigger("reset"); 
    });


</script>
