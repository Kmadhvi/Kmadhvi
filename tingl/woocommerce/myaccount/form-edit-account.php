<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */


defined( 'ABSPATH' ) || exit;

	/* Class object defined */
	$objapi = new adAPI();
	$value = WC()->session->get('token');

	 if (isset($_SESSION['token']) && $_SESSION['token'] !== '') {
		$encryptedtoken = $_SESSION['token'];
	} 
	$postapiData = $objapi->fetchProfile($encryptedtoken);
	$decrypt_value = openssl_decrypt($postapiData, ENCRYPTIONMETHOD, SECRET_KEY, 0,IV);
	$json_decoded = json_decode($decrypt_value);
/* 	echo "<pre>";
	print_r($json_decoded);
	echo "</pre>"; */

	$firstname = $json_decoded->details->firstname;
	$lastname = $json_decoded->details->lastname;
	$mobilenumber = $json_decoded->details->mobilenumber;
	$age = $json_decoded->details->age;
	$gender = $json_decoded->details->gender;
	$weight = $json_decoded->details->weight;
	$height = $json_decoded->details->height;
	$birthdate = $json_decoded->details->birth_date;
	$email = $json_decoded->details->email;
	$allergies = $json_decoded->details->allergies;


?>
<form  action="" method="post">
	<div class="row justify-content-center pt-5 ">
		<div class="col-lg-6 col-md-6 pb-3">
			<div class="dashboard-section-title">
				<h2><?php esc_html_e( 'edit profile', 'woocommerce' ); ?></h2>                                   
			</div>
		</div>
		<div class="col-lg-3 col-md-4">
		</div>
		<div class="col-lg-9 col-md-10 edit-form mb-3">
			<div class="row align-items-center">
				<div class="col-lg-3 mb-4">
					<div class="form-group mb-3">
						<label class="profile-img edit-profile-img">
							<img src="<?php echo get_template_directory_uri()?>/assets/images/placeholder.png">
							<input type="file" name="">
							<span><img src="<?php echo get_template_directory_uri()?>/assets/images/fi-rr-edit.svg"></span>
						</label>
					</div>
				</div>
				<div class="col-lg-9 mb-4">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group mb-3">
								<label><?php esc_html_e( 'first name', 'woocommerce' ); ?></label>
								<input type="text" name="" id="firstname" class="form-control" placeholder="Enter your first name" value="<?php echo $firstname ;?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group mb-3">
								<label><?php esc_html_e( 'last name', 'woocommerce' ); ?></label>
								<input type="text" name="" id="lastname" class="form-control" placeholder="Enter your first name" value="<?php echo $lastname ;?>">
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="form-group mb-3">
						<label><?php esc_html_e( 'birth date (optional)', 'woocommerce' ); ?></label>
						<input type="text" name="birthday" value="<?php echo $birthdate; ?>" id="birthdate" class="form-control" placeholder="Select date">
						<span class="form-icon"><img src="<?php echo get_template_directory_uri()?>/assets/images/fi-rr-calendar.png" class=""></span>
					</div>
				</div>
				<div class="col-lg-9">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group mb-3">
								<label><?php esc_html_e( 'email', 'woocommerce' ); ?></label>
								<input type="text" name="" value="<?php echo $email; ?>" id="email" class="form-control" placeholder="Enter your email id">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group mb-3">
								<label><?php esc_html_e( 'gender', 'woocommerce' ); ?></label>
								<select class="form-select" id="Gender">
								<option value="" <?php if (!$gender) echo 'selected'; ?>>select gender</option>
								<option value="Male" <?php if ($gender === 'Male') echo 'selected'; ?>>Male</option>
								<option value="Female" <?php if ($gender === 'Female') echo 'selected'; ?>>Female</option>
								<option value="Other" <?php if ($gender === 'Other') echo 'selected'; ?>>Other</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="form-group mb-3">
						<label><?php esc_html_e( 'Weight (kg.)', 'woocommerce' ); ?></label>
						<input type="text" id="weight" value="<?php echo $weight; ?>" class="form-control" placeholder="Enter weight (kg.)">
					</div>
				</div>
				<div class="col-lg-9">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group mb-3">
								<label><?php esc_html_e( 'Age(yr)', 'woocommerce' ); ?></label>
								<input type="text" id="age" value="<?php echo $age; ?>" class="form-control" placeholder="Enter your age">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group mb-3">
								<label><?php esc_html_e( 'Height (ft-in)', 'woocommerce' ); ?></label>
								<select class="form-select" id="height">
								<option value="" <?php if (!$height) echo 'selected'; ?>>select height</option>
								<option value="4.5" <?php if ($height === '4.5') echo 'selected'; ?>>4.5</option>
								<option value="4.6" <?php if ($height === '4.6') echo 'selected'; ?>>4.6</option>
								<option value="4.7" <?php if ($height === '4.7') echo 'selected'; ?> > 4.7 </option>
								<option value="4.8" <?php if ($height === '4.8') echo 'selected'; ?> > 4.8 </option>
								<option value="4.9" <?php if ($height === '4.9') echo 'selected'; ?> > 4.9 </option>
								<option value="4.10" <?php if ($height === '4.10') echo 'selected'; ?> >4.10</option>
								<option value="4.11" <?php if ($height === '4.11') echo 'selected'; ?> >4.11</option>
								<option value="5.0" <?php if ($height === '5.0') echo 'selected'; ?>> 5.0 </option>
								<option value="5.1" <?php if ($height === '5.1') echo 'selected'; ?>> 5.1 </option>
								<option value="5.2" <?php if ($height === '5.2') echo 'selected'; ?>> 5.2 </option>
								<option value="5.3" <?php if ($height === '5.3') echo 'selected'; ?>> 5.3 </option>
								<option value="5.4" <?php if ($height === '5.4') echo 'selected'; ?>> 5.4 </option>
								<option value="5.5" <?php if ($height === '5.5') echo 'selected'; ?>> 5.5 </option>
								<option value="5.6" <?php if ($height === '5.6') echo 'selected'; ?>> 5.6 </option>
								<option value="5.7" <?php if ($height === '5.7') echo 'selected'; ?>> 5.7 </option>
								<option value="5.8" <?php if ($height === '5.8') echo 'selected'; ?>> 5.8 </option>
								<option value="5.9" <?php if ($height === '5.9') echo 'selected'; ?>> 5.9 </option>
								<option value="5.10" <?php if ($height === '5.10') echo 'selected'; ?>>5.10</option>
								<option value="5.11" <?php if ($height === '5.11') echo 'selected'; ?>>5.11 </option>
								<option value="6.0" <?php if ($height === '6.0') echo 'selected'; ?>> 6.0 </option>
								<option value="6.1" <?php if ($height === '6.1') echo 'selected'; ?>> 6.1 </option>
								<option value="6.2" <?php if ($height === '6.2') echo 'selected'; ?>> 6.2 </option>
								<option value="6.3" <?php if ($height === '6.3') echo 'selected'; ?>> 6.3 </option>
								<option value="6.4" <?php if ($height === '6.4') echo 'selected'; ?>> 6.4 </option>
								<option value="6.5" <?php if ($height === '6.5') echo 'selected'; ?>> 6.5 </option>
								<option value="6.6" <?php if ($height === '6.6') echo 'selected'; ?>> 6.6 </option>
								<option value="6.7" <?php if ($height === '6.7') echo 'selected'; ?>> 6.7 </option>
								<option value="6.8" <?php if ($height === '6.8') echo 'selected'; ?>> 6.8 </option>
								<option value="6.9" <?php if ($height === '6.9') echo 'selected'; ?>> 6.9 </option>
								<option value="6.10" <?php if ($height === '6.10') echo 'selected'; ?>>6.10</option>
								<option value="6.11" <?php if ($height === '6.11') echo 'selected'; ?>>6.11 </option>
								<option value="7.0" <?php if ($height === '7.0') echo 'selected'; ?>> 7.0 </option>
								<option value="7.1" <?php if ($height === '7.1') echo 'selected'; ?>> 7.1 </option>
								<option value="7.2" <?php if ($height === '7.2') echo 'selected'; ?>> 7.2 </option>
								<option value="7.3" <?php if ($height === '7.3') echo 'selected'; ?>> 7.3 </option>
								<option value="7.4" <?php if ($height === '7.4') echo 'selected'; ?>> 7.4 </option>
								<option value="7.5" <?php if ($height === '7.5') echo 'selected'; ?>> 7.5 </option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 pb-3">
			<div class="dashboard-section-title">
				<h2><?php esc_html_e( 'edit allergies', 'woocommerce' ); ?></h2>                                   
			</div>
		</div>
		<div class="col-lg-3 col-md-4">
			<div class="text-end">
				<a href="#" class="add-allergies" data-bs-toggle="modal" data-bs-target="#allergiesModal"><img src="<?php echo get_template_directory_uri()?>/assets/images/fi-rr-add.svg"><?php esc_html_e( 'add allergies', 'woocommerce' ); ?></a>
			</div>
		</div>
		<div class="col-lg-9">
			<?php if($allergies) : ?>
			<div class="allergies-edit">
				<?php foreach($allergies as $allergy){ ?>
					<span><?php echo $allergy ; ?> <img src="<?php echo get_template_directory_uri()?>/assets/images/delet.png"></span>
				<?php } ?>
				
			</div>
			<?php endif; ?>
			
			<div class="save-btn text-center">
				<a href="#" class="btn btn-primary w-50 edit_profile_btn"><?php esc_html_e( 'save', 'woocommerce' ); ?></a>
			</div>
		</div>
	</div>
</form>


<!-- Allergy model -->
<div class="modal fade" id="allergiesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-allergie border-radius-modal">
    <div class="modal-content">
      <!-- <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div> -->
      <div class="modal-body p-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="auth-details feedback-modal">
                     <div class="shape-1">
                         <img src="<?php echo get_template_directory_uri()?>assets/images/leaf.png">
                     </div>
                     <div class="shape-2">
                         <img src="<?php echo get_template_directory_uri()?>assets/images/leaf-1.png">
                     </div>
                     <div class="close" data-bs-dismiss="modal" aria-label="Close">
                         <img src="<?php echo get_template_directory_uri()?>assets/images/fi-rr-cross.png">
                     </div>
                     <div class="w-100 text-start">
                         <h3 class="text-start"><?php esc_html_e( 'Add allergies', 'woocommerce' ); ?></h3>
                         <div class="allergies-list mt-3">
                             <div class="select-money">
                            <div class="text-checkbox">
                              <input id="dollar1" name="money" type="checkbox" class="carfilter">
                              <label for="dollar1">
                                chicken
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar2" name="money" type="checkbox" checked="" class="carfilter">
                              <label for="dollar2">
                                egg
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar3" name="money" type="checkbox" class="carfilter">
                              <label for="dollar3">
                                fish
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar4" name="money" type="checkbox" class="carfilter">
                              <label for="dollar4">
                                shelfish
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar5" name="money" type="checkbox" class="carfilter">
                              <label for="dollar5">
                                Nuts
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar6" name="money" type="checkbox" checked="" class="carfilter">
                              <label for="dollar6">
                                Peanuts
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar7" name="money" type="checkbox" class="carfilter">
                              <label for="dollar7">
                                Sauce
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar8" name="money" type="checkbox" class="carfilter">
                              <label for="dollar8">
                                Milk
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar9" name="money" type="checkbox" class="carfilter">
                              <label for="dollar9">
                                Seeds
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar10" name="money" type="checkbox" checked="" class="carfilter">
                              <label for="dollar10">
                                Gluten
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar11" name="money" type="checkbox" class="carfilter">
                              <label for="dollar11">
                                Other
                              </label>
                            </div>
                            
                          </div>
                         </div>
                         <div class="form-group col-6 mb-3">
                            <label>other allergies</label>
                             <input type="text" name="" class="form-control" placeholder="Enter allergies">
                         </div>
                        <div class="form-group text-center">
                            <a href="#" class="btn btn-primary w-100">Save</a>
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