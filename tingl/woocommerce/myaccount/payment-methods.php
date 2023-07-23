<?php

/**
 * Payment methods
 *
 * Shows customer payment methods on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/payment-methods.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

defined('ABSPATH') || exit;
/* 
$saved_methods = wc_get_customer_saved_methods_list( get_current_user_id() );
$has_methods   = (bool) $saved_methods;
$types         = wc_get_account_payment_methods_types(); */
?>

<!-- if no gifted subscription -->
<div class="empty-page">
	<img src="<?php echo get_template_directory_uri() ?>/assets/images/no-order.png" class="img-fluid">
	<div class="">
		<h4>You haven't gifted any subscriptions yet</h4>
		<p>Looks like you haven't made any purchases yet.</p>
		<a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#giftMealplan">Gift subscription</a>
	</div>
</div>

<!-- if gifted subscription  -->
<div class="row justify-content-center pt-5">
	<div class="col-lg-6 col-md-6">
		<div class="dashboard-section-title">
			<h2>manage gifted subscription</h2>
		</div>
	</div>
	<div class="col-lg-3 col-md-4">
		<select class="form-select dashboard-select">
			<option>filter</option>
			<option>Completed</option>
			<option>Pending</option>
		</select>
	</div>
	<div class="col-lg-9 col-md-10">
		<div class="order-list">
			<div class="order-box">
				<div class="order-img">
					<img src="<?php echo get_template_directory_uri() ?>/assets/images/product-details-img.png" class="img-fluid">
				</div>
				<div class="order-details">
					<label class="status">active</label>
					<h3>Max Value</h3>
					<h4>₹ 26,100 </h4>
					<p>staring date : 25th may</p>
					<div class="order-footer">
						<div class="feedback-star">
							<a href="#" class="active"><img src="<?php echo get_template_directory_uri() ?>/assets/images/star.png"></a>
							<a href="#" class="active"><img src="<?php echo get_template_directory_uri() ?>/assets/images/star.png"></a>
							<a href="#" class="active"><img src="<?php echo get_template_directory_uri() ?>/assets/images/star.png"></a>
							<a href="#"><img src="<?php echo get_template_directory_uri() ?>/assets/images/star.png"></a>
							<a href="#"><img src="<?php echo get_template_directory_uri() ?>/assets/images/star.png"></a>
							<span>write review</span>
						</div>
						<div class="subscribe-btn">
							<a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pauseModal">pause</a>
							<a href="#" class="btn btn-primary">renew</a>
						</div>
					</div>
				</div>
			</div>
			<div class="order-box">
				<div class="order-img">
					<img src="<?php echo get_template_directory_uri() ?>/assets/images/product-details-img.png" class="img-fluid">
				</div>
				<div class="order-details">
					<label class="status expire-s">expire</label>
					<h3>Max Value</h3>
					<h4>₹ 26,100 </h4>
					<p>staring date : 24th may</p>
					<div class="order-footer">
						<div class="feedback-star">
							<a href="#" class="active"><img src="<?php echo get_template_directory_uri() ?>/assets/images/star.png"></a>
							<a href="#" class="active"><img src="<?php echo get_template_directory_uri() ?>/assets/images/star.png"></a>
							<a href="#" class="active"><img src="<?php echo get_template_directory_uri() ?>/assets/images/star.png"></a>
							<a href="#"><img src="<?php echo get_template_directory_uri() ?>/assets/images/star.png"></a>
							<a href="#"><img src="<?php echo get_template_directory_uri() ?>/assets/images/star.png"></a>
							<span>write review</span>
						</div>
						<div class="subscribe-btn">

							<a href="#" class="btn btn-primary">renew</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>