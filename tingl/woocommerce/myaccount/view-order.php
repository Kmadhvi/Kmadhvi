<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;
/* ================================================feedback================================================ */
?>

<div class="row justify-content-center pt-5">
    <div class="col-lg-6 col-md-6">
        <div class="dashboard-section-title mb-3">
            <h2><?php echo esc_html__('Leave feedback'); ?></h2>

        </div>
    </div>
    <div class="col-lg-3 col-md-4 text-end">

    </div>
    <div class="col-lg-9 col-md-10">
        <div class="form-group mb-4">
            <textarea class="form-control" rows="5" placeholder="description"></textarea>
        </div>
        <div class="form-group text-center">
            <a href="#" class="btn btn-primary"><?php echo esc_html__('submit'); ?></a>
        </div>
    </div>
</div>