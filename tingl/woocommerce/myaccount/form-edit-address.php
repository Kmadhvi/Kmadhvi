<?php

/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
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

defined('ABSPATH') || exit;

/* ================================================manage-subscription================================================ */

/* Class object defined */
$objapi = new adAPI();
$value = WC()->session->get('token');

if (isset($_SESSION['token']) && $_SESSION['token'] !== '') {
	$encryptedtoken = $_SESSION['token'];
}
$postapiData = $objapi->addressList($encryptedtoken);
$decrypt_value = openssl_decrypt($postapiData, ENCRYPTIONMETHOD, SECRET_KEY, 0, IV);
$json_decoded = json_decode($decrypt_value);
/* echo "<pre>";
print_r($json_decoded);
echo "</pre>";  */
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


if ($json_decoded->code == 401 || $json_decoded->code == 2) { ?>
	<!-- if address is empty -->
	<div class="empty-page">
		<img src="<?php echo get_template_directory_uri() ?>/assets/images/map-empty.png" class="img-fluid">
		<div class="">
			<?php if($json_decoded->message == 'invalid token provided.')?>
			<p><?php echo $json_decoded->message; ?></p>
			<a href="#" data-bs-toggle="modal" data-bs-target="#selectaddressModal" class="btn btn-primary"><?php echo $address ? esc_html__('Add address', 'woocommerce') : esc_html__('Add address', 'woocommerce'); ?></a>
		</div>
	</div>
<?php } else { ?>


	<!-- if address is not empty -->
	<div class="row justify-content-center pt-5">
		<div class="col-lg-6 col-md-6">
			<div class="dashboard-section-title">
				<h2>delivery address</h2>
				<p>choose address or add new address</p>
			</div>
		</div>
		<div class="col-lg-3 col-md-4 text-end">
			<a href="#" data-bs-toggle="modal" data-bs-target="#selectaddressModal" class="btn btn-primary">Add new address</a>
		</div>
		<div class="col-lg-9 col-md-10">
			<div class="address-list">
				<?php foreach ($json_decoded->details as $address) {
					/* echo "<pre>";
					print_r($address);
					echo "</pre>"; */ ?>
					<div class="address-box">
						<div class="address-img">
							<img src="<?php echo get_template_directory_uri() ?>/assets/images/fi-rr-home.png" class="img-fluid">
						</div>
						<div class="address-details">
							<div class="address-edit">
								<a href="#" data-edit-id="<?php echo $address->id; ?>"><img src="<?php echo get_template_directory_uri() ?>/assets/images/fi-rr-edit.svg"></a>
								<a href="#" data-trash-id="<?php echo $address->id; ?>"><img src="<?php echo get_template_directory_uri() ?>/assets/images/fi-rr-trash.svg"></a>
							</div>
							<h3><?php echo $address->address_type ;?></h3>
							<p><?php echo $address->address; ?></p>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>