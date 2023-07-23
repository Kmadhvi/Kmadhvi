<!-- <div class="agent-content"> -->
<div class="profileCont">
	<div class="profileInfo">
		<?php //if($attributes->data->membership_id==3){?>
		<div class="proImg">
			<?php 
			     $url = !empty($attributes->data->logo)?$attributes->data->img_path.$attributes->data->logo: AD_BASE_URL_PLUGIN .'\images\Placeholder.jpg';
			?>
				 <img src="<?php echo $url; ?>" width="200px;">
		</div>
		<?php// } ?>
	</div>
	<div class="profileDesc">
		<h2> <?php echo $attributes->data->callout; ?><span><?php echo $attributes->data->title; ?></span></h2>
		<p><?php 
		
			//echo $attributes->data->about_you;
	    	if(!empty($attributes->data->about_you))
	    	{
	    		echo $attributes->data->about_you; 
	    	}else
	    	{
	    		echo "Agent Description Not Found.";
	    	}
	    	?>
	    	</p>
	</div>
	<div class="profileDetail">
	    	<h2><?php echo $attributes->data->first_name." ".$attributes->data->last_name;?></h2>
	    	<a class="phNo" href="tel:<?php echo $attributes->data->phone;?>"><?php echo $attributes->data->phone; ?></a>
	    	<a class="emailAdd" href="mailto:<?php echo $attributes->data->email; ?>"><?php 
	    	echo $attributes->data->email; ?></a>
	    	<a class="emailAdd" target="_blank" href="<?php echo $attributes->data->website; ?>"><?php 
	    	echo $attributes->data->website; ?></a>
		</div>
</div>
<div class="map_contact_part agentForm">
                       <!-- <div class="map">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3322.750816848469!2d-111.91762566308397!3d33.61176931740141!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x872b744fff250f95%3A0x90e26140bcab2c3e!2s7621+E+Gray+Rd+Suite+D%2C+Scottsdale%2C+AZ+85260%2C+USA!5e0!3m2!1sen!2sin!4v1549256557408" width="400" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div> -->
	<div class="map">
<!-- New York, NY, USA (40.7127837, -74.00594130000002) -->
		<?php $address=isset($attributes->data->address) ? $attributes->data->address : '' ;
			 // $logtitude=isset($attributes->data->late) ? $attributes->data->long : '' ;
		?>
<iframe width="100%" height="350" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=<?php echo $address; ?>&amp;key=AIzaSyDIjhlc88Lfhw-67s6QjCZj7ghHrPn7jOw"></iframe>
	</div>
						
                        <form id="agentleadadd" class="agentleadadd">
                            <div class="agentleadhead">
                                <h4 class="modal-title ng-binding">Let us answer your questions.</h4>
                                <h5>Receive a free expert consultation under no obligation to buy.</h5>
                            </div>
                            <div class="form-horizontal">
                                <ul>
                                    <li class="formField halfField">
                                        <input class="form-control" placeholder="First Name" id="name" name="first_name" type="text" required>
                                        
                                    </li>
                                    <li class="formField halfField">
                                        <input class="form-control" placeholder="Last Name" id="name" name="last_name" type="text" required>
                                    </li>
                                    <li class="formField">
                                        <input class="form-control" id="email" name="email" type="email" placeholder="Email"  required>
                                        
                                    </li>
                                    <li class="formField">
                                        <input class="form-control" placeholder="Mobile Number" id="phone" name="phone" type="tel"  required>
                                    </li> <input type="hidden" name="agentidmain" value="" id="agentidmain">
									 <li class="formField prefer_to_contact">
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
                                            </li>
									<li class="confMsg">
									<label><?php echo $attributes->data->first_name;?> or a qualified <?php echo $attributes->data->firm; ?> representative will get back to within 24 hours.</label>
									</li>
									<!--<li class="formField">
                                        <input class="form-control" placeholder="City" id="city" name="city" type="text"  required>
                                       
                                    </li>-->
                                 </ul>
                            </div>
                            <?php  //print_AgentDetail(); 
                            //do_shortcode('[get_agent_by_id]');?>
                            <div class="modal-footer">
                                <input type="submit" class="submit btn btn-primary" name="savepostlead" value="Send">
                                <input type="hidden" name="action" value="savepostlead">
                                <?php echo wp_nonce_field('savepostlead' ); ?>
                                <input type="hidden" id="popupagentid" name="agentid" value="">
                                <div class="agent-lead-response-msg"></div>
                            </div>
                        </form>
                    </div>
                    <!-- </div> -->