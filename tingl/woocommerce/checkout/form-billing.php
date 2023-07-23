<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;

echo die;
?>
<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
	<div class="delivery-address">
                                    <span class="icon-images"><img src="assets/images/delivery.png"></span>
                                    <div class="account-box">
                                        
                                        <div class="account-left">
                                            <h3>delivery address</h3>
                                            <p>choose address or add new address</p>
                                        </div>
                                        <div class="account-right">
                                            <a href="#" class="btn btn-primary">add new address</a>
                                        </div>
                                    </div>
                                    <div class="home-box">                                        
                                        <div class="home-ico">
                                            <img src="assets/images/fi-rr-home.png">
                                        </div>
                                        <div class="home-details">
                                            <div class="float-end delivery-control-link">
                                                <a href="#" class="me-2"><img src="assets/images/fi-rr-edit.svg"></a>
                                                <a href="#"><img src="assets/images/fi-rr-trash.svg"></a>
                                            </div>
                                            <h4>Home</h4>
                                            <p>F-83, vrundavan, waghodia, vadodara, gujarat 390019, india</p>
                                        </div>
                                    </div>
                                    <div class="home-box">                                        
                                        <div class="home-ico">
                                            <img src="assets/images/fi-rr-shopping-bag.png">
                                        </div>
                                        <div class="home-details">
                                            <div class="float-end delivery-control-link">
                                                <a href="#" class="me-2"><img src="assets/images/fi-rr-edit.svg"></a>
                                                <a href="#"><img src="assets/images/fi-rr-trash.svg"></a>
                                            </div>
                                            <h4>Office</h4>
                                            <p>F-83, vrundavan, waghodia, vadodara, gujarat 390019, india</p>
                                        </div>
                                    </div>
                                    <div class="home-box">                                        
                                        <div class="home-ico">
                                            <img src="assets/images/fi-rr-marker-black.png">
                                        </div>
                                        <div class="home-details">
                                            <div class="float-end delivery-control-link">
                                                <a href="#" class="me-2"><img src="assets/images/fi-rr-edit.svg"></a>
                                                <a href="#"><img src="assets/images/fi-rr-trash.svg"></a>
                                            </div>
                                            <h4>Other</h4>
                                            <p>F-83, vrundavan, waghodia, vadodara, gujarat 390019, india</p>
                                        </div>
                                    </div>
                                </div>
<?php endif; ?>
