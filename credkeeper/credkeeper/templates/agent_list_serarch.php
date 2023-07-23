
<div class="">
<!--      <div class="container container-sm">  -->
		<div class="wrapper">
           <!-- <div class="text-center">
               <label class="agent-title ng-binding">
                    We found
                    <?php  echo $attributes->data->total; ?> agent near your area:
                </label>
            </div>  -->            
<!--              <div class="searchAgent container"> -->
			<div class="searchAgent">	
                    <?php  
						 function createStart($end1,$end2){
								$output = '';
								for($i=1;$i<=$end1;$i++){
									$output .= '<span class="fa fa-star checked"></span>';
								}

								if($end2 != 0){
									for($i=1;$i<=$end2;$i++){
									$output .= '<span class="fa fa-star-o"></span>';
									}    
								}
								echo $output;
							}
                    //echo "<pre>";print_r($attributes->data->data);
                    if (!empty($attributes->data->data)) 
                    {
                        foreach($attributes->data->data as $d)
                        {
							 $value = !empty($d->point_cnt)?$d->point_cnt:0;

                            //$star_icon=!empty($three) || !empty($four) || !empty($five)?'fa fa-star':'fa fa-star-o';
                        ?>
                            <div class="agentDetail">
                                <?php $gold_class=$d->membership_id==3?'agentbox':'agentbox1'; 
                                     $popupbuttonclass=$d->membership_id==3 || $d->membership_id==2 ?'agent-listing':''; 
                                ?>
                                <div class="<?php echo $gold_class; ?>">
                                    <div class="agent_info">
                                        <button class="btn agent-lead-btn <?php echo $popupbuttonclass; ?>" data-id="<?php echo $d->id; ?>"  type="button"><?php echo $d->first_name." ".$d->last_name;?></button>
                                        <p><?php echo $d->firm; ?></p>
                                        <p><?php echo $d->address;?></p>
                                    </div>
                                    <?php  if($d->membership_id==3){?>
                                    <div class="agentLogo">
                                        <?php 
                                            $url = !empty($d->logo)?$d->img_path.$d->logo: AD_BASE_URL_PLUGIN .'/images/Placeholder.jpg';
                                         ?>
                                           <img src="<?php echo $url; ?>" width="200px;">
                                    </div>
                                    <?php }?>
                                    <div class="agentForm">
                                        <form id="agentleadadd">
                                            <div class="formField halfField">
                                                <input  placeholder="First Name" class="form-control" id="name" name="first_name" type="text" required>
                                            </div>
                                            <div class="formField halfField">
                                                <input placeholder="Last Name" class="form-control" id="name" name="last_name" type="text">
                                            </div>
                                            <div class="formField">
                                                <input  class="form-control" id="email" name="email" type="email" placeholder="Email" required>
                                            </div>
                                            <div class="formField">
                                                <input class="form-control" id="phone" name="phone" type="tel" placeholder="Mobile Number">
                                            </div>
											 
											 <div class="formField prefer_to_contact">
												 <lable>How do you prefer to be contacted?</lable>
												 <div class="conectedChbox">
													<label class="cont">Email
													 <input type="radio" checked="checked" name="prefer_to_contact" value="Email" required>
													 <span class="checkmark"></span>
												 	</label>
													 <label class="cont">Text
													 <input type="radio"  name="prefer_to_contact" value="Text" required>
													 <span class="checkmark"></span>
												 	</label>
													 <label class="cont">Phone
													 <input type="radio" name="prefer_to_contact" value="Phone" required>
													 <span class="checkmark"></span>
												 	</label>
												 </div>
												 
                                            </div>
											<div class="formField opinion_inst">
                                            <!--<label class="opinion">"Click Send to receive a free expert's opinion"</label>-->
                                            </div>
                                            <!--<div class="formField">
                                                <input class="form-control" id="city" name="city" type="text" placeholder="City" required>
                                            </div>-->
                                            <div class="agent_info_footer">
                                                <div class="modal-footer">
                                                    <input type="submit" class="submit btn btn-primary" name="savepostlead" value="Send">
                                                    <input type="hidden" name="action" value="savepostlead">
                                                    <?php echo wp_nonce_field('savepostlead' ); ?>
                                                    <input type="hidden" id="popupagentid" name="agentid" value="<?php echo $d->id;?>">
                                                    

                                                    <?php if($d->membership_id==3 || $d->membership_id==2) { ?>
                                                    
<!--                                                     <button class="btn agent-lead-btn agent-listing learnMore" data-id="<?php echo $d->id; ?>"  type="button">Learn More</button> -->
													<input type="button" data-id="<?php echo $d->id; ?>" class="btn agent-lead-btn agent-listing learnMore"  value="Learn More">

                                                    <?php } ?>
													<div class="agent-lead-response-msg"></div>
                                                </div>
                                            </div>
                                            <div id="popup-with-form">
                                                  <!-- <button class="btn agent-lead-btn agent-listing" data-id="<?php echo $d->id; ?>"  type="button">Contact</button> -->
                                                  <!-- <a href="<?php echo site_url(); ?>/agent-details/?id=<?php echo $d->id; ?>" class="btn-info btn">View Agent</a> -->
                                            </div>
                                        </form>
                                    </div>
									<div class="ratingStar">
                                           <!--  <img src='<?php echo AD_BASE_URL_PLUGIN ?>/images/stara.png' width="200px"> -->
                                            <?php 
                                                if($value == 0 || $value<200){
                                                     createStart(0,5);
                                                }elseif($value <300){
                                                    createStart(3,2);
                                                }elseif($value >=300 && $value <= 399){
                                                    createStart(4,1);
                                                }
                                                else{
                                                    createStart(5,0);
                                                }
                                            ?>
                                        </div>
                                </div>
                            </div>
                            <?php 
                        }
                    }   
                    else
                    {
                        echo "<p><b>Zip code is Wrong.</b></p>";
                    }
                    ?>
            </div>
            <div class="agent-form-style modal-content mfp-hide white-popup-block">
                <div class="mfp-title projectname">
                    agent<span>directory</span>
                </div>
                    <div id="pip" style="background: #fff;color: transparent;">
                    </div>
                    
                </div>

                 <?php
            // echo "<pre>";
            // print_r($attributes);

            $current_page=$attributes->data->current_page;
            $next_page_url=$attributes->data->next_page_url;
            $first_page_url=$attributes->data->first_page_url;
            $last_page_url=$attributes->data->last_page_url;
            $per_page=$attributes->data->per_page;
            $total=$attributes->data->total;
            
            $attributes->metadata->currentpage;
            $attributes->metadata->totalcount;
            
            $options = get_option('agentdir_options');
            $limit =  $options['agentdirlimit'];
          
            if($limit > 0 )
            {
                    echo "<br>";
                    $Totalpages = ceil($attributes->data->total/$limit);

            ?>
                    <!-- <ul class="pagination text-center-custom">
                        <?php           
                          $i=1;
                         ?>
                            <li>
                                <a href="<?php echo  $first_page_url; ?>" class="page-click" data-page_id="<?php $i; ?>">First</a>
                            </li>
                            <?php           
                            for($i;$i<=$Totalpages;$i++)
                            {
                            ?>               
                                 <li>
                                    <a href="http://bedrockfs.demo1.bytestechnolab.com/agentdirectoryback/public/api/wp/wp-get-agent?page=<?php echo $i;?>" class="page-click" data-page_id="<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php         
                            }
                                $last_id = $i - 1;
                            ?>
                            <li>
                                <a href="<?php echo  $last_page_url;?>" class="page-click" data-page_id="<?php echo $last_id; ?>">Last</a>
                            </li>
                    </ul>-->
                <?php
                }
            ?>
    </div>
</div>
