<div class="agent-content">
<nav class="navbar navbar-expand-md navMenu">
    <div class="wrapper"> 
        <a class="navbar-brand logo" href="#">agent<span>directory</span></a>
    </div>      
</nav>
<div class="moduleSection">
    <img src="<?php echo AD_BASE_URL_PLUGIN;?>/images/search_bg.jpg">
    <div class="ad-list-main widget-main" style="color: transparent;"></div>
    <div class="searchform moduleContent">
        <p>Find an agent near you <br> And right for you.</p>
        <form id="user-search" method="post">
                <input type="text" class="form-control postalCode" name="zipcode" placeholder="Postal Code" value>
			<div class="text"></div>
                <input class="searchbyzipcode btn sitebtn search-agent-btn" required="required" type="submit" name="Search" value="Search">
                <input value="searchbyzipcode" type="hidden" name="action">
                <?php echo wp_nonce_field('searchbyzipcode' );?>
         </form>
    </div>
    <div class="fegli_logo">
       <!-- <img src='<?php echo AD_BASE_URL_PLUGIN ?>/images/fegli-logo.png' width="200px">-->
    </div>
</div>
<nav class="navbar navbar-expand-md navMenu">
    <div class="wrapper"> 
        <a class="navbar-brand logo text-right" href="#">agent<span>directory</span></a>
    </div>      
</nav>
</div>
<?php 
//echo "<pre>";print_r($attributes);
?>
<!--
<div class="ad-list-main" style="color: transparent;">
    <div class="widget-main">
        <div class="container container-sm">
            <div class="row">
                <div class="text-center">
                   
                </div>
                
                <div class="agent-form-style modal-content mfp-hide white-popup-block">
                    <form id="agentleadadd" class=" ">
                        <div class="modal-header">
                            <h4 class="modal-title ng-binding">Lead Agent From</h4>
                        </div>
                        <div class="form-horizontal">
                            <ul>
                                <li class="form-group">
                                    <div class="col-sm-3 text-right">
                                        <label class="control-label" for="name">First Name :</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control" id="name" name="first_name" type="text" placeholder="Name" required>
                                    </div>
                                </li>
                                <li class="form-group">
                                    <div class="col-sm-3 text-right">
                                        <label class="control-label" for="name">Last Name :</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control" id="name" name="last_name" type="text" placeholder="Name" required>
                                    </div>
                                </li>
                                <li class="form-group">
                                    <div class="col-sm-3 text-right">
                                        <label class="control-label" for="email">Email :</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control" id="email" name="email" type="email" placeholder="Email" required>
                                    </div>
                                </li>
    							<li class="form-group">
                                    <div class="col-sm-3 text-right">
                                        <label class="control-label" for="phone">Phone :</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control" id="phone" name="phone" type="tel" placeholder="Mobile Number" required>
                                    </div>
                                </li>
                                <li class="form-group">
                                    <div class="col-sm-3 text-right">
                                        <label class="control-label" for="city">City :</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control" id="city" name="city" type="text" placeholder="City" required>
                                    </div>
                                </li>
                              
                            </ul>
                        </div>

                        <div class="modal-footer">
                            <input type="submit" class="submit btn btn-primary" name="savepostlead" value="Save Lead">
                            <input type="hidden" name="action" value="savepostlead">
                            <?php echo wp_nonce_field('savepostlead' ); ?>
                                <input type="hidden" id="popupagentid" name="agentid" value="">
                        </div>
                       
                    </form>
                    <div id="agent-lead-response-msg"></div>
                </div>
            </div>
        </div>
    </div>
</div>
-->
