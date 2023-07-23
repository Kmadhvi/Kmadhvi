<?php

define('STRIPE_SECRET_KEY', 'sk_test_AxpTFKWmFAEB5vdqQ9kPxn66');

add_filter('woocommerce_package_rates', 'custom_shipping', 12, 2);
function custom_shipping($rates, $package)
{
    global $woocommerce;
    $ship_cost = 0;
    $items = $woocommerce->cart->get_cart();
    foreach ($items as $items_key => $item) {
        $ship_cost += $item['shipping_option'];
    }
    foreach ($rates as $rate_key => $rate) {

        if ('flat_rate' === $rate->method_id) {
            // Set the new cost
            $rates[$rate_key]->cost = $ship_cost;
        }
    }
    return $rates;
}
//Oshin Child Theme

add_action('show_user_profile', 'crf_show_extra_profile_fields');
add_action('edit_user_profile', 'crf_show_extra_profile_fields');

function crf_show_extra_profile_fields($user)
{
    $val = get_option('browse_lender');
    $select = 21;
    foreach ($val as $key => $value) {
        if ($value == $user->ID) {
            $select = $key;
        }
    }
?>
    <h3><?php esc_html_e('Browse Lender', 'crf'); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="browse_lender"><?php esc_html_e('Feature Lender', 'crf'); ?></label></th>
            <td><select name="browse_lender">
                    <option value='21'>Select Lender Position</option>
                    <?php for ($i = 0; $i < 20; $i++) {
                        $j = $i + 1;
                        if ($select == $i) {
                            echo "<option value='" . $i . "' selected>" . $j . "</option>";
                        } else {
                            echo "<option value='" . $i . "'>" . $j . "</option>";
                        }
                    } ?>
            </td>
        </tr>
    </table>
<?php
}
add_action('personal_options_update', 'crf_update_profile_fields');
add_action('edit_user_profile_update', 'crf_update_profile_fields');

function crf_update_profile_fields($user_id)
{

    if ($_POST['browse_lender'] != '') {
        $index_key = $_POST['browse_lender'];
        $val = get_option('browse_lender');
        foreach ($val as $key => $data) {
            if ($data == $user_id && $key != $index_key) {
                $val[$key] = '0';
            }
        }
        if ($index_key != '5') {
            $val[$index_key] = $user_id;
        }

        update_option('browse_lender', $val);
    }
}

add_action('wp_enqueue_scripts', 'load_child_theme_enqueue_scripts');
function load_child_theme_enqueue_scripts()
{

    wp_enqueue_style('child-theme-css', get_stylesheet_uri());
    wp_enqueue_style('daterangepicker-min-css', get_stylesheet_directory_uri() . '/js/daterangepicker.min.css', true);
    wp_enqueue_style('bootstrap-css', get_stylesheet_directory_uri() . '/css/bootstrap.css', true);
    wp_enqueue_style('jQuery-ui-css', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', true);
    //YITH Proteo child theme javascript js file
    //wp_enqueue_script('autocomplete-js', get_stylesheet_directory_uri() . '/js/autocomplete.js', array( 'jquery' ), '1.1.0', true );
    wp_enqueue_script('jQuery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array('jquery'), '1.0', true);
    wp_enqueue_script('child-theme-js', get_stylesheet_directory_uri() . '/script.js', array('jquery'), '1.0', true);
    wp_localize_script('child-theme-js', 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
include 'home_search.php';
add_filter('woocommerce_account_menu_items', 'misha_remove_my_account_dashboard');
function misha_remove_my_account_dashboard($menu_links)
{

    unset($menu_links['orders']);
    unset($menu_links['downloads']);
    unset($menu_links['dashboard']);
    return $menu_links;
}

add_filter('woocommerce_account_menu_items', 'account_details_rename');


function account_details_rename($menu_links)
{

    // $menu_links['TAB ID HERE'] = 'NEW TAB NAME HERE';
    $menu_links['edit-account'] = 'Personal Info';

    return $menu_links;
}

function my_account_menu_order()
{
    $menuOrder = array(
        '' => __('User Settings', 'woocommerce'),
        'edit-account' => __('Personal Info', 'woocommerce'),
        'edit-address' => __('Addresses', 'woocommerce'),
        'orders' => __('Orders', 'woocommerce'),
        'customer-logout' => __('Logout', 'woocommerce'),

    );
    return $menuOrder;
}
add_filter('woocommerce_account_menu_items', 'my_account_menu_order');

/*
 * Step 1. Add Link (Tab) to My Account menu
 */
add_filter('woocommerce_account_menu_items', 'change_password_link', 40);
function change_password_link($menu_links)
{

    $menu_links = array_slice($menu_links, 0, 4, true)
        + array('change-password' => 'Change Password')
        + array_slice($menu_links, 4, null, true);

    return $menu_links;
}
/*
 * Step 2. Register Permalink Endpoint
 */
add_action('init', 'change_password_add_endpoint');
function change_password_add_endpoint()
{

    // WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
    add_rewrite_endpoint('change-password', EP_PAGES);
}
/*
 * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action('woocommerce_account_change-password_endpoint', 'change_password_my_account_endpoint_content');
function change_password_my_account_endpoint_content()
{
    $user_id = get_current_user_id();
    $user = get_userdata($user_id);
?>
    <div class="JT-dashboard">
        <div class="JT-dashboard__uset-container JT-bg-white">
            <form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action('woocommerce_edit_account_form_tag'); ?>>
                <fieldset>
                    <legend><?php esc_html_e('Password change', 'woocommerce'); ?></legend>
                    <input type="hidden" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr($user->first_name); ?>" />
                    <input type="hidden" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr($user->last_name); ?>" />
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="password_current"><?php esc_html_e('Current password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
                        <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
                    <div class="current_pass error"></div>
                    </p>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="password_1"><?php esc_html_e('New password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
                        <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
                    <div class="new_pass error"></div>
                    </p>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="password_2"><?php esc_html_e('Confirm new password', 'woocommerce'); ?></label>
                        <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
                    <div class="confirm_pass error"></div>
                    </p>
                </fieldset>

                <p>
                    <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
                    <button type="submit" class="woocommerce-Button button change_pass_btn" name="save_account_details" value="<?php esc_attr_e('Save changes', 'woocommerce'); ?>"><?php esc_html_e('Save changes', 'woocommerce'); ?></button>
                    <input type="hidden" name="action" value="save_account_details" />
                </p>

            </form>
        </div>
    </div>
<?php

}
/*
 * Step 4
 */
// Go to Settings > Permalinks and just push "Save Changes" button.

add_filter('woocommerce_save_account_details_required_fields', 'wc_save_account_details_required_fields');
function wc_save_account_details_required_fields($required_fields)
{
    unset($required_fields['account_display_name']);
    unset($required_fields['account_email']);
    //unset( $required_fields['account_first_name'] );
    //unset( $required_fields['account_last_name'] );
    return $required_fields;
}

/*
 * Step 1. Add Link (Tab) to My Account menu
 */
add_filter('woocommerce_account_menu_items', 'payout_details_link', 40);
function payout_details_link($menu_links)
{

    $menu_links = array_slice($menu_links, 0, 2, true)
        + array('payout-details' => 'Payout Details')
        + array_slice($menu_links, 2, null, true);

    return $menu_links;
}
/*
 * Step 2. Register Permalink Endpoint
 */
add_action('init', 'payout_details_add_endpoint');
function payout_details_add_endpoint()
{

    // WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
    add_rewrite_endpoint('payout-details', EP_PAGES);
}
/*
 * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action('woocommerce_account_payout-details_endpoint', 'payout_details_my_account_endpoint_content');
function payout_details_my_account_endpoint_content()
{

?>
    <?php
    if ($_POST['submit']) {
        $user_id = get_current_user_id();
        if (empty($_POST['user_account_name'])) {
    ?>
            <div class="woocommerce-notices-wrapper">
                <ul class="woocommerce-error" role="alert">
                    <li>
                        <strong>Error:</strong> Account name is required.
                    </li>
                </ul>
            </div>
        <?php

        } elseif (empty($_POST['user_account_number'])) {
        ?>
            <div class="woocommerce-notices-wrapper">
                <ul class="woocommerce-error" role="alert">
                    <li>
                        <strong>Error:</strong> Account Number is required.
                    </li>
                </ul>
            </div>
        <?php
        } elseif (empty($_POST['user_bsb'])) {
        ?>
            <div class="woocommerce-notices-wrapper">
                <ul class="woocommerce-error" role="alert">
                    <li>
                        <strong>Error:</strong> BSB is required.
                    </li>
                </ul>
            </div>
    <?php
        } else {
            update_user_meta($user_id, 'user_account_name', $_POST['user_account_name']);
            update_user_meta($user_id, 'user_account_number', $_POST['user_account_number']);
            update_user_meta($user_id, 'user_bsb', $_POST['user_bsb']);
            echo "<div class='woocommerce-message'>Your data has been added</div>";
        }
    }
    ?>
    <?php $user_id = get_current_user_id(); ?>
    <div class="JT-dashboard">
        <div class="JT-dashboard__uset-container JT-bg-white JT-dashboard__uset-content ">
            <div class="JT-dashboard__pyout-block JT-dashboard-pymt-common">
                <h4 class="JT-dashboard__uset-head">Payout Details<i class="info-icon" data-original-title="Tell us where to pay you after you Lend a dress" data-placement="bottom" data-toggle="tooltip" title=""></i></h4>
                <div class="JT-payoutdetail-form" id="JT_paypout_edit_form">
                    <form class="edit_user_profile" id="user_payout_edit_form" action="" accept-charset="UTF-8" method="post" novalidate="novalidate">
                        <input name="utf8" type="hidden" value="✓">
                        <div class="form-group">
                            <label class="mandatory">Account name</label>
                            <input id="payout_account_name" class="form-control input-sm" type="text" value="<?php echo get_user_meta($user_id, 'user_account_name', true); ?>" name="user_account_name">
                        </div>
                        <div class="form-group">
                            <label class="mandatory">Account number</label>
                            <input id="payout_account_number" class="form-control input-sm" type="text" value="<?php echo get_user_meta($user_id, 'user_account_number', true); ?>" name="user_account_number">
                        </div>
                        <div class="form-group">
                            <label class="mandatory">BSB</label>
                            <input id="payout_bsb" class="form-control input-sm" type="text" value="<?php echo get_user_meta($user_id, 'user_bsb', true); ?>" name="user_bsb">
                        </div>
                        <div class="JT-dashboard__uset-btnGroup"><input type="submit" name="submit" value="Save" data-disable-with="Saving" class="JT-btn-primary JT-btn-w150"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php

}
/*
 * Step 4
 */
// Go to Settings > Permalinks and just push "Save Changes" button.

/*
 * Step 1. Add Link (Tab) to My Account menu
 */
add_filter('woocommerce_account_menu_items', 'id_verification_link', 40);
function id_verification_link($menu_links)
{

    $menu_links = array_slice($menu_links, 0, 3, true)
        + array('id-verification' => 'ID Verification')
        + array_slice($menu_links, 3, null, true);

    return $menu_links;
}
/*
 * Step 2. Register Permalink Endpoint
 */
add_action('init', 'id_verification_add_endpoint');
function id_verification_add_endpoint()
{

    // WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
    add_rewrite_endpoint('id-verification', EP_PAGES);
}
/*
 * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action('woocommerce_account_id-verification_endpoint', 'id_verification_my_account_endpoint_content');
function id_verification_my_account_endpoint_content()
{
    $user_id = get_current_user_id();
    if (isset($_POST['passport_submit'])) {
        global $wpdb;
        $files = $_FILES['passport_upload'];
        if (empty($files['name'])) {
    ?>
            <div class="woocommerce-notices-wrapper">
                <ul class="woocommerce-error" role="alert">
                    <li>
                        <strong>Error:</strong> Field is required.
                    </li>
                </ul>
            </div>
        <?php
        } else {
            //echo "<pre>"; print_r($files); exit;
            if (!function_exists('wp_handle_upload')) {
                require_once ABSPATH . 'wp-admin/includes/file.php';
            }
            $file = array(
                'name' => $files['name'],
                'type' => $files['type'],
                'tmp_name' => $files['tmp_name'],
                'error' => $files['error'],
                'size' => $files['size'],
            );

            $upload_overrides = array('test_form' => false);
            $movefile = wp_handle_upload($file, $upload_overrides);
            //echo "<pre>"; print_r($movefile);
            if ($movefile && !isset($movefile['error'])) {
                //echo $movefile['url'];
                update_user_meta($user_id, 'user_passport', $movefile['url']);
                echo "<div class='woocommerce-message'>Your data has been saved</div>";
            }
        }
    }
    if (isset($_POST['dl_submit'])) {
        global $wpdb;
        $files = $_FILES['dl_upload'];
        //echo "<pre>"; print_r($files); exit;
        if (empty($files['name'])) {
        ?>
            <div class="woocommerce-notices-wrapper">
                <ul class="woocommerce-error" role="alert">
                    <li>
                        <strong>Error:</strong> Field is required.
                    </li>
                </ul>
            </div>
        <?php
        } else {
            if (!function_exists('wp_handle_upload')) {
                require_once ABSPATH . 'wp-admin/includes/file.php';
            }
            $file = array(
                'name' => $files['name'],
                'type' => $files['type'],
                'tmp_name' => $files['tmp_name'],
                'error' => $files['error'],
                'size' => $files['size'],
            );

            $upload_overrides = array('test_form' => false);
            $movefile = wp_handle_upload($file, $upload_overrides);
            //echo "<pre>"; print_r($movefile);
            if ($movefile && !isset($movefile['error'])) {
                //echo $movefile['url'];
                update_user_meta($user_id, 'user_dl', $movefile['url']);
                echo "<div class='woocommerce-message'>Your data has been saved</div>";
            }
        }
    }
    if (isset($_POST['id_submit'])) {
        global $wpdb;
        $files = $_FILES['identity_upload'];
        if (empty($files['name'])) {
        ?>
            <div class="woocommerce-notices-wrapper">
                <ul class="woocommerce-error" role="alert">
                    <li>
                        <strong>Error:</strong> Field is required.
                    </li>
                </ul>
            </div>
    <?php
        } else {
            if (!function_exists('wp_handle_upload')) {
                require_once ABSPATH . 'wp-admin/includes/file.php';
            }
            $file = array(
                'name' => $files['name'],
                'type' => $files['type'],
                'tmp_name' => $files['tmp_name'],
                'error' => $files['error'],
                'size' => $files['size'],
            );

            $upload_overrides = array('test_form' => false);
            $movefile = wp_handle_upload($file, $upload_overrides);
            //echo "<pre>"; print_r($movefile);
            if ($movefile && !isset($movefile['error'])) {
                //echo $movefile['url'];
                update_user_meta($user_id, 'user_identity', $movefile['url']);
                echo "<div class='woocommerce-message'>Your data has been saved</div>";
            }
        }
    }
    ?>
    <div class="JT-dashboard">
        <div class="JT-dashboard__uset-container JT-bg-white">
            <div class="id-verification-section">
                <h4 class="JT-dashboard__uset-head">Select ID type </h4>

                <p>Use a valid government-issued photo ID.</p>
                <div class="passport_wrp">
                    <div><button type="button" id="passport_btn">Passport</button></div>
                    <div class="passport_form" style="display: none;">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="file" name="passport_upload" />
                            <input type="submit" name="passport_submit" />
                        </form>
                    </div>
                </div>
                <?php
                $userpassport = get_user_meta($user_id, 'user_passport', true);
                if (!empty($userpassport)) {
                    echo "<div class='passpost_css'><img src='" . $userpassport . "' width='20%'>";
                ?>
                    <input type="button" class="btn passport_remove" value="X" data_id="<?php echo $user_id; ?>">
            </div>
        <?php
                }
        ?>
        <div class="dl_wrp">
            <div> <button type="button" id="dl_btn">Driver's license</button></div>
            <div class="dl_form" style="display: none;">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="file" name="dl_upload" />
                    <input type="submit" name="dl_submit" />
                </form>
            </div>
        </div>
        <?php
        $userdl = get_user_meta($user_id, 'user_dl', true);
        if (!empty($userdl)) {
            echo "<div class='userdl'><img src='" . $userdl . "' width='20%'>";
        ?>
            <input type="button" class="btn dl_remove" value="X" data_id="<?php echo $user_id; ?>">
        </div>
    <?php
        }
    ?>
    <div class="id_wrp">
        <div> <button type="button" id="identity_btn">Identity card</button></div>
        <div class="identy_form" style="display: none;">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="file" name="identity_upload" />
                <input type="submit" name="id_submit" />
            </form>
        </div>
    </div>
    <?php
    $useridentity = get_user_meta($user_id, 'user_identity', true);
    if (!empty($useridentity)) {
        echo "<div class='passpost_css'><img src='" . $useridentity . "' width='20%'>";
    ?>
        <input type="button" class="btn identity_remove" value="X" data_id="<?php echo $user_id; ?>">
    </div>
<?php
    }
?>
</div>
</div>
</div>
<?php

}
/*
 * Step 4
 */
// Go to Settings > Permalinks and just push "Save Changes" button.
/**
 * @snippet       Add First & Last Name to My Account Register Form - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WC 3.9
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

///////////////////////////////
// 1. ADD FIELDS

add_action('woocommerce_register_form_start', 'bbloomer_add_name_woo_account_registration');

function bbloomer_add_name_woo_account_registration()
{
?>

    <p class="form-row form-row-first">
        <label for="reg_billing_first_name"><?php _e('First name', 'woocommerce'); ?> <span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if (!empty($_POST['billing_first_name'])) {
                                                                                                                esc_attr_e($_POST['billing_first_name']);
                                                                                                            }
                                                                                                            ?>" />
    </p>

    <p class="form-row form-row-last">
        <label for="reg_billing_last_name"><?php _e('Last name', 'woocommerce'); ?> <span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if (!empty($_POST['billing_last_name'])) {
                                                                                                                esc_attr_e($_POST['billing_last_name']);
                                                                                                            }
                                                                                                            ?>" />
    </p>

    <div class="clear"></div>

<?php
}

///////////////////////////////
// 2. VALIDATE FIELDS

add_filter('woocommerce_registration_errors', 'bbloomer_validate_name_fields', 10, 3);

function bbloomer_validate_name_fields($errors, $username, $email)
{
    if (isset($_POST['billing_first_name']) && empty($_POST['billing_first_name'])) {
        $errors->add('billing_first_name_error', __('<strong>Error</strong>: First name is required!', 'woocommerce'));
    }
    if (isset($_POST['billing_last_name']) && empty($_POST['billing_last_name'])) {
        $errors->add('billing_last_name_error', __('<strong>Error</strong>: Last name is required!.', 'woocommerce'));
    }
    return $errors;
}

///////////////////////////////
// 3. SAVE FIELDS

add_action('woocommerce_created_customer', 'bbloomer_save_name_fields');

function bbloomer_save_name_fields($customer_id)
{
    if (isset($_POST['billing_first_name'])) {
        update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
        update_user_meta($customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']));
    }
    if (isset($_POST['billing_last_name'])) {
        update_user_meta($customer_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
        update_user_meta($customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']));
    }
}
//add_action( 'woocommerce_register_form', 'dob_add_register_form_field' );

function dob_add_register_form_field()
{

    woocommerce_form_field(
        'my_account_dob',
        array(
            'type' => 'text',
            'required' => true, // just adds an "*"
            'label' => 'Date of Birth',
        ),
        (isset($_POST['my_account_dob']) ? $_POST['my_account_dob'] : '')
    );
}
//add_action( 'woocommerce_register_post', 'dob_validate_fields', 10, 3 );

function dob_validate_fields($username, $email, $errors)
{

    if (empty($_POST['my_account_dob'])) {
        $errors->add('my_account_dob_error', 'Date of Birth field is required');
    }
}
add_action('woocommerce_created_customer', 'dob_save_register_fields');

function dob_save_register_fields($customer_id)
{

    if (isset($_POST['my_account_dob'])) {
        update_user_meta($customer_id, 'my_account_dob', wc_clean($_POST['my_account_dob']));
    }
}
add_action('show_user_profile', 'extra_user_profile_fields');
add_action('edit_user_profile', 'extra_user_profile_fields');

function extra_user_profile_fields($user)
{ ?>
    <h3><?php _e("Extra profile information", "blank"); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="my_account_dob"><?php _e("Date Of Birth"); ?></label></th>
            <td>
                <input type="text" name="my_account_dob" id="my_account_dob" value="<?php echo esc_attr(get_the_author_meta('my_account_dob', $user->ID)); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your Date of Birth."); ?></span>
            </td>
        </tr>
        <?php if (!empty(esc_attr(get_the_author_meta('user_passport', $user->ID)))) { ?>
            <tr>
                <th><label for="passport"><?php _e("Passport"); ?></label></th>
                <td>
                    <img src="<?php echo esc_attr(get_the_author_meta('user_passport', $user->ID)); ?>" width="30%">
                </td>
            </tr>
        <?php } ?>
        <?php if (!empty(esc_attr(get_the_author_meta('dl_upload', $user->ID)))) { ?>
            <tr>
                <th><label for="passport"><?php _e("Driver's license"); ?></label></th>
                <td>
                    <img src="<?php echo esc_attr(get_the_author_meta('dl_upload', $user->ID)); ?>" width="30%">
                </td>
            </tr>
        <?php } ?>
        <?php if (!empty(esc_attr(get_the_author_meta('identity_upload', $user->ID)))) { ?>
            <tr>
                <th><label for="passport"><?php _e("Identity card"); ?></label></th>
                <td>
                    <img src="<?php echo esc_attr(get_the_author_meta('identity_upload', $user->ID)); ?>" width="30%">
                </td>
            </tr>
        <?php } ?>
        <?php if (!empty(esc_attr(get_the_author_meta('user_passport', $user->ID))) || !empty(esc_attr(get_the_author_meta('dl_upload', $user->ID))) || !empty(esc_attr(get_the_author_meta('identity_upload', $user->ID)))) {
            $user_verify = get_user_meta($user->ID, 'user_verification', true);
        ?>
            <tr>
                <th><label for="passport"><?php _e("ID Verification"); ?></label></th>
                <td>
                    <select name="user_verification" id="user_verification">
                        <option <?php if ($user_verify == "verified") { ?> selected="selected" <?php } ?> value="verified">Verified</option>
                        <option <?php if ($user_verify == "unverified") { ?> selected="selected" <?php } ?> value="unverified">Unverified</option>
                    </select>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php if (!empty(get_user_meta($user->ID, 'user_account_number', true))) { ?>
        <h3><?php _e("Account information", "blank"); ?></h3>

        <table class="form-table">
            <tr>
                <th><label for="my_account_dob"><?php _e("Account Name"); ?></label></th>
                <td>
                    <?php echo get_user_meta($user->ID, 'user_account_name', true); ?>
                </td>
            </tr>
            <tr>
                <th><label for="my_account_dob"><?php _e("Account Number"); ?></label></th>
                <td>
                    <?php echo get_user_meta($user->ID, 'user_account_number', true); ?>
                </td>
            </tr>
            <tr>
                <th><label for="my_account_dob"><?php _e("BSB"); ?></label></th>
                <td>
                    <?php echo get_user_meta($user->ID, 'user_bsb', true); ?>
                </td>
            </tr>
        </table>
    <?php } ?>
<?php }
add_action('personal_options_update', 'save_extra_user_profile_fields');
add_action('edit_user_profile_update', 'save_extra_user_profile_fields');

function save_extra_user_profile_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    update_user_meta($user_id, 'my_account_dob', $_POST['my_account_dob']);
    update_user_meta($user_id, 'user_verification', $_POST['user_verification']);
}
add_action('woocommerce_save_account_details', 'my_account_saving_dob', 10, 1);
function my_account_saving_dob($user_id)
{
    $my_account_dob = $_POST['my_account_dob'];
    if (!empty($my_account_dob)) {
        update_user_meta($user_id, 'my_account_dob', sanitize_text_field($my_account_dob));
    }
}
// only copy the opening php tag if needed
// Change the shop / product prices if a unit_price is set
function sv_change_product_html($price_html, $product)
{

    $rental_price = get_post_meta($product->id, 'rental_price', true);
    $rrp = get_post_meta($product->id, 'rrp', true);
    if (!empty($rental_price)) {
        $price_html = '<span class="amount">' . wc_price($rental_price) . ' Rent (RRP ' . wc_price($rrp) . ')</span>';
    }

    return $price_html;
}
add_filter('woocommerce_get_price_html', 'sv_change_product_html', 10, 2);

// Change the cart prices if a unit_price is set
function sv_change_product_price_cart($price, $cart_item, $cart_item_key)
{
    //echo "<pre>"; print_r();
    $rental_price = get_post_meta($cart_item['product_id'], 'rental_price', true);
    $num_of_days = $cart_item['num_of_days']['days'];
    $cleaning_options = get_post_meta($cart_item['product_id'], 'cleaning_options', true);
    $shipping_options = get_post_meta($cart_item['product_id'], 'shipping_options', true);
    // $shipping_price = $cart_item['shipping_option'];
    $shipping_price = 0;
    $percentage = 40;
    if (!empty($rental_price)) {
        if (!empty($cleaning_options) || !empty($shipping_options)) {
            if ($cleaning_options == "$25.00 to the rental") {
                $cleaning_price = 20.00;
            } elseif ($cleaning_options == "own cleaning cost") {
                $cleaning_cost = get_post_meta($cart_item['product_id'], 'cleaning_cost', true);
                $cleaning_price = $cleaning_cost;
            } else {
                $cleaning_price = 0;
            }
            // if($shipping_options == "$21.70 to the shipping"){
            //     $shipping_price = 15.00;
            // }elseif ($shipping_options == "own shipping cost") {
            //     $shipping_cost = get_post_meta($cart_item['product_id'], 'shipping_cost', true);
            //     $shipping_price = $shipping_cost;
            // }else{
            //     $shipping_price = 0;
            // }
            if (!empty($cleaning_options) && empty($shipping_options)) {
                if ($num_of_days == "10") {
                    $percent_price = $rental_price + ($percentage / 100) * $rental_price;
                    $price = wc_price($percent_price + $cleaning_price);
                } else {
                    $price = wc_price($rental_price + $cleaning_price);
                }
            }
            if (!empty($shipping_options) && empty($cleaning_options)) {
                if ($num_of_days == "10") {
                    $percent_price = $rental_price + ($percentage / 100) * $rental_price;
                    $price = wc_price($percent_price + $shipping_price);
                } else {
                    $price = wc_price($rental_price + $shipping_price);
                }
            }
            if (!empty($cleaning_options) && !empty($shipping_options)) {
                if ($num_of_days == "10") {
                    $percent_price = $rental_price + ($percentage / 100) * $rental_price;
                    $price = wc_price($percent_price + $cleaning_price + $shipping_price);
                } else {
                    $price = wc_price($rental_price + $cleaning_price + $shipping_price);
                }
            }
        } else {
            if ($num_of_days == "10") {
                $percent_price = $rental_price + ($percentage / 100) * $rental_price;
                $price = wc_price($percent_price);
            } else {
                $price = wc_price($rental_price);
            }
        }
    }

    return $price;
}
add_filter('woocommerce_cart_item_price', 'sv_change_product_price_cart', 10, 3);

add_action('woocommerce_before_calculate_totals', 'add_custom_price', 20, 1);
function add_custom_price($cart)
{

    foreach ($cart->get_cart() as $item) {
        $num_of_days = $item['num_of_days']['days'];
        $rental_price = get_post_meta($item['product_id'], 'rental_price', true);
        $cleaning_options = get_post_meta($item['product_id'], 'cleaning_options', true);
        $shipping_options = get_post_meta($item['product_id'], 'shipping_options', true);
        $percentage = 40;
        // $shipping_price = $item['shipping_option'];
        $shipping_price = 0;
        /********/

        if (!empty($cleaning_options) || !empty($shipping_options)) {
            if ($cleaning_options == "$25.00 to the rental") {
                $cleaning_price = 20.00;
            } elseif ($cleaning_options == "own cleaning cost") {
                $cleaning_cost = get_post_meta($item['product_id'], 'cleaning_cost', true);
                $cleaning_price = $cleaning_cost;
            } else {
                $cleaning_price = 0;
            }
            // if($shipping_options == "$21.70 to the shipping"){
            //     $shipping_price = 15.00;
            // }elseif ($shipping_options == "own shipping cost") {
            //     $shipping_cost = get_post_meta($item['product_id'], 'shipping_cost', true);
            //     $shipping_price = $shipping_cost;
            // }else{
            //     $shipping_price = 0;
            // }
            if (!empty($cleaning_options) && empty($shipping_options)) {
                if ($num_of_days == "10") {
                    $percent_price = $rental_price + ($percentage / 100) * $rental_price;
                    $item['data']->set_price($percent_price + $cleaning_price);
                } else {
                    $item['data']->set_price($rental_price + $cleaning_price);
                }
            }
            if (!empty($shipping_options) && empty($cleaning_options)) {
                if ($num_of_days == "10") {
                    $percent_price = $rental_price + ($percentage / 100) * $rental_price;
                    $item['data']->set_price($percent_price + $shipping_price);
                } else {
                    $item['data']->set_price($rental_price + $shipping_price);
                }
            }
            if (!empty($cleaning_options) && !empty($shipping_options)) {
                if ($num_of_days == "10") {
                    $percent_price = $rental_price + ($percentage / 100) * $rental_price;
                    $item['data']->set_price($percent_price + $shipping_price + $cleaning_price);
                } else {
                    $item['data']->set_price($rental_price + $shipping_price + $cleaning_price);
                }
            }
        } else {
            if ($num_of_days == "10") {
                $percent_price = $rental_price + ($percentage / 100) * $rental_price;
                $item['data']->set_price($percent_price);
            } else {
                $item['data']->set_price($rental_price);
            }
        }

        /******/
    }
}
add_action('init', 'wpse_74054_add_author_woocommerce', 999);

function wpse_74054_add_author_woocommerce()
{
    add_post_type_support('product', 'author');
}
add_action('woocommerce_before_add_to_cart_button', 'single_page_content');
function single_page_content()
{
    global $wpdb, $product;
    $id = $product->id;
    $cleaning_option = get_post_meta($id, 'cleaning_options', true);
    $shipping_option = get_post_meta($id, 'shipping_options', true);
    $local_shipping_options = get_post_meta($id, 'local_shipping_options', true);
    $local_address = get_post_meta($id, 'local_address', true);
    $local_address_suburb = get_post_meta($id, 'local_address_suburb', true);
    $cleaning_cost = get_post_meta($id, 'cleaning_cost', true);
    $shipping_cost = get_post_meta($id, 'shipping_cost', true);
    $dates = get_post_meta($id, 'availability_date', true);
    $order_status = array('wc-processing');
    $results = $wpdb->get_col("
          SELECT order_item_meta.order_item_id
          FROM {$wpdb->prefix}woocommerce_order_items as order_items
          LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
          LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
          WHERE posts.post_type = 'shop_order'
          AND posts.post_status IN ( '" . implode("','", $order_status) . "' )
          AND order_items.order_item_type = 'line_item'
          AND order_item_meta.meta_value = '$id'
      ");
    $stepVal = '+1 day';
    $new_date = '';
    foreach ($results as $result) {
        $date_sql = $wpdb->get_results(
            "
        SELECT order_item_meta.* FROM {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta WHERE (order_item_meta.meta_key='FROM' OR order_item_meta.meta_key='TO') AND order_item_meta.order_item_id = " . $result
        );
        foreach ($date_sql as $data) {
            if ($data->meta_key == 'FROM') {
                $from = strtotime(date("m/d/Y", strtotime($data->meta_value)));
            } else {
                $to = strtotime(date("m/d/Y", strtotime($data->meta_value)));
            }
        }
        while ($from <= $to) {
            $dates .= ',' . date("m/d/Y", $from);
            $from = strtotime($stepVal, $from);
        }
    }
    //$start_date = get_post_meta($id, 'start_date', true);
    //$end_date = get_post_meta($id, 'end_date', true);

?>
    <?php $get_size = $product->get_attribute('pa_size');
    $get_size_str = explode(',', $get_size);

    // shoes size
    $get_shoe_size = $product->get_attribute('pa_shoes-size');
    $get_shoe_size_str = explode(',', $get_shoe_size);

    // bag size
    $get_bag_size = $product->get_attribute('pa_bag-size');
    $get_bag_size_str = explode(',', $get_bag_size);
    //print_r($get_size); exit;
    // pa_accessories size
    $get_accessories_size = $product->get_attribute('pa_accessories-size');
    $get_accessories_size_str = explode(',', $get_accessories_size);
    ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() ?>/js/jquery.daterangepicker.min.js"></script>
    <?php if (isset($get_size) && !empty($get_size)) { ?>
        <div class="form-group" class="product_size">
            <div class="input-label">Select Size</div>
            <select class="sizeselect" name="size">
                <?php foreach ($get_size_str as $size) { ?>
                    <option value="<?php echo $size ?>"><?php echo $size ?></option>
                <?php } ?>
            </select>
        </div>
    <?php } ?>

    <!-- Shoes Size -->
    <?php if (isset($get_shoe_size) && !empty($get_shoe_size)) { ?>
        <div class="form-group" class="product_size">
            <div class="input-label">Select Size</div>
            <select class="sizeselect" name="size">
                <?php foreach ($get_shoe_size_str as $size) { ?>
                    <option value="<?php echo $size ?>"><?php echo $size ?></option>
                <?php } ?>
            </select>
        </div>
    <?php } ?>

    <!-- bag Size -->
    <?php if (isset($get_bag_size) && !empty($get_bag_size)) { ?>
        <div class="form-group" class="product_size">
            <div class="input-label">Select Size</div>
            <select class="sizeselect" name="size">
                <?php foreach ($get_bag_size_str as $size) { ?>
                    <option value="<?php echo $size ?>"><?php echo $size ?></option>
                <?php } ?>
            </select>
        </div>
    <?php } ?>

    <!-- Accessories Size -->
    <?php if (isset($get_accessories_size) && !empty($get_accessories_size)) { ?>
        <div class="form-group" class="product_size">
            <div class="input-label">Select Size</div>
            <select class="sizeselect" name="size">
                <?php foreach ($get_accessories_size_str as $size) { ?>
                    <option value="<?php echo $size ?>"><?php echo $size ?></option>
                <?php } ?>
            </select>
        </div>
    <?php } ?>

    <p class="label_title">RENTAL PERIOD</p>
    <div class="num_of_days">
        <div class="sel_day">
            <label class="radio-inline checked_day"><input type="radio" name="days" value="4" checked>4-days</label>
        </div>
        <div class="sel_day">
            <label class="radio-inline"><input type="radio" name="days" value="10">10-days</label>
        </div>
    </div>
    <p class="label_title">Dates</p>
    <input id="date-range-picker" value="" placeholder="Delivery & Return Dates" autocomplete="off">
    <input type="hidden" name="" class="sel_avil_date" value="">
    <input id="delivery_date" type="hidden" placeholder="DELIVERY/PICK UP DATE">
    <input id="return_date" type="hidden" value="" placeholder="RETURN DATE">
    <!--<input type="hidden" value="<?php echo $start_date; ?>" class="start_date">
        <input type="hidden" value="<?php echo $end_date; ?>" class="end_date">-->
    <?php if (!empty($dates)) {
    ?>
        <input type="hidden" value="<?php echo $dates; ?>" class="availability_date_sel">
    <?php
    } ?>
    <?php if (!empty($cleaning_option) || !empty($shipping_option) || !empty($local_shipping_options)) { ?>
        <div class="JT-dressPreview-additionaldetails__container">
            <div class="JT-dressPreview-additionaldetails__collapsiblelabel">
                <label class="JT-dressPreview-additionaldetails__collapsible JTscript-dressPreview-toggle">
                    <i class="fa fa-minus"></i>Details &amp; Style Notes
                </label>
            </div>
            <div class="JT-dressPreview-additionaldetails__collapsibleblock JT-dressPreview-moreInfo">
                <p class="check-required dressPreview-moreInfoContent">Please Choose Shipping Method</p>
                <?php
                if ($shipping_option == "$21.70 to the shipping") {
                    echo '<p><input class="DshipOpt" type="radio" name="shipping_option" value="15" required>$15.00 Delivery fee</p>';
                } elseif ($shipping_option == "own shipping cost") {
                    echo '<p><input class="CshipOpt" type="radio" name="shipping_option" value="' . $shipping_cost . '" required> $' . $shipping_cost . ' Delivery fee</p>';
                } elseif ($shipping_option == "free cleaning") {
                    echo '<p><input class="CshipOpt" type="radio" name="shipping_option" value="0" required>' . $shipping_option . '</p>';
                }
                ?>
                <?php if ($local_address != "" && $local_address_suburb != "") { ?>
                    <p><input class="PshipOpt" type="radio" name="shipping_option" value="0" required> Free Local Pickup</p>
                    <span><?php echo 'State : ' . $local_address; ?></span><br />
                    <span><?php echo 'Suburb : ' . $local_address_suburb; ?></span>
                <?php } ?>
                </p>
                <?php //if(!empty($cleaning_option)) { 
                ?>
                <!-- <p class="check-required dressPreview-moreInfoContent">Cleaning Included</p> -->
                <?php
                // if($cleaning_option == "$25.00 to the rental"){
                //       echo "<p>$20.00 Cleaning fee</p>";
                //   }elseif ($cleaning_option == "own cleaning cost") {
                //       echo "<p>$".$cleaning_cost." Cleaning fee</p>";
                //   }
                //   else{
                //       echo "<p>".$cleaning_option."</p>";
                //   }
                ?>
                <?php //} 
                ?>
            </div>

        </div>
    <?php } ?>
<?php
}
add_filter('woocommerce_new_customer_data', 'bbloomer_assign_custom_role', 10, 1);

function bbloomer_assign_custom_role($args)
{
    $args['role'] = 'vendor';
    return $args;
}
// define the woocommerce_after_shop_loop_item_title callback
function action_woocommerce_after_shop_loop_item_title()
{
    global $product;
?>
    <?php
    $id = $product->get_id();
    $author_id = get_post_field('post_author', $id);
    $get_author_gravatar = get_avatar_url($author_id, array('size' => 450));
    if (!empty($get_author_gravatar)) {
        echo '<div class="profile_rate"><img src="' . $get_author_gravatar . '" alt="' . get_the_title() . '" class="vendor_pic" width="30px"/>';
        //echo $author_id;
    }
    ?>
    <?php if ($average = $product->get_average_rating()) : ?>
        <?php echo '<div class="star-rating" title="' . sprintf(__('Rated %s out of 5', 'woocommerce'), $average) . '"><span style="width:' . (($average / 5) * 100) . '%"><strong itemprop="ratingValue" class="rating">' . $average . '</strong> ' . __('out of 5', 'woocommerce') . '</span></div></div>'; ?>
    <?php else : ?>
        <?php echo "</div>"; ?>
    <?php endif; ?>
    <?php
    $get_shoe_size = $product->get_attribute('pa_shoes-size');
    $get_dress_size = $product->get_attribute('pa_size');
    $get_bag_size = $product->get_attribute('pa_bag-size');
    $get_accessories_size = $product->get_attribute('pa_accessories-size');
    if (!empty($get_shoe_size)) {
        echo "<div class='shoes_size_f'> Size:" . $get_shoe_size . "</div>";
    }
    if (!empty($get_dress_size)) {
        echo "<div class='shoes_size_f'> Size:" . $get_dress_size . "</div>";
    }
    if (!empty($get_bag_size)) {
        echo "<div class='shoes_size_f'> Size:" . $get_bag_size . "</div>";
    }
    if (!empty($get_accessories_size)) {
        echo "<div class='shoes_size_f'> Size:" . $get_accessories_size . "</div>";
    }
    ?>
<?php
};

// add the action
add_action('woocommerce_after_shop_loop_item_title', 'action_woocommerce_after_shop_loop_item_title', 10, 0);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

add_filter('woocommerce_add_cart_item_data', 'add_cart_item_data', 25, 2);
function add_cart_item_data($cart_item_meta, $product_id)
{

    if (isset($_POST['days'])) {
        $num_of_days = array();
        $size = $_POST['size'];
        $num_of_days['days'] = isset($_POST['days']) ? sanitize_text_field($_POST['days']) : "";

        $cart_item_meta['num_of_days'] = $num_of_days;
        $cart_item_meta['size'] = $size;
    }

    if (isset($_POST['shipping_option'])) {
        $cart_item_meta['shipping_option'] = $_POST['shipping_option'];
    }

    return $cart_item_meta;
}

function myscript()
{
?>
    <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/autocomplete.js?ver=1.0"></script>
<?php
}
add_action('wp_head', 'myscript');
add_action('wp_ajax_nopriv_remove_product_img', 'remove_product_img_ajax');
add_action('wp_ajax_remove_product_img', 'remove_product_img_ajax');

function remove_product_img_ajax()
{
    global $wpdb;
    $attachment_ID = $_POST['img_id'];
    wp_delete_attachment($attachment_ID, true);
    $wpdb->query("DELETE
     {$wpdb->postmeta} WHERE post_id = " . $attachment_ID);
    echo "DELETE FROM {$wpdb->postmeta} WHERE post_id = " . $attachment_ID;
    wp_delete_post($attachment_ID, true);
    echo "success";
    //die();
}

add_filter('woocommerce_gallery_image_size', function ($size) {
    return 'full';
});

function my_widget()
{
    register_sidebar(array(
        'name' => __('Product Sidebar', 'oshin-child-theme'),
        'id' => 'product_sidebar',
        'description' => __('This is description', 'yourtheme'),
        'before_widget' => '<aside>',
        'after_widget' => '</aside>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'my_widget');

add_shortcode('products-counter', 'products_counter');
function products_counter($atts)
{
    $category = $_GET['product_cat'];
    $explode_cat = explode(",", $_GET['product_cat']);
    $atts = shortcode_atts([
        'category' => $explode_cat[0],
    ], $atts);

    $taxonomy = 'product_cat';
    if (is_numeric($atts['category'])) {
        $cat = get_term($atts['category'], $taxonomy);
    } else {
        $cat = get_term_by('slug', $atts['category'], $taxonomy);
    }

    // if($explode_cat[0] == 'dress'){
    //   $cat_count = '( <span class="cat_count">'.$cat->count.'</span> dresses )';
    // }else{
    //   $cat_count = '( <span class="cat_count">'.$cat->count.'</span> '.$explode_cat[0].')';
    // }

    if (empty($cat->term_id)) {
        if (!isset($_GET['durmstring'])) {
            echo '<div class="show_all_count">( showing All <span class="cat_count">' . $cat->count . '</span> )</div>';
        }
    } else if ($cat && $cat->count != 0 && !is_wp_error($cat)) {
        return $cat_count;
    }

    return '';
}
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
add_shortcode('my_purchased_products', 'bbloomer_products_bought_by_curr_user');

function bbloomer_products_bought_by_curr_user()
{

    // GET CURR USER
    $current_user = wp_get_current_user();
    if (0 == $current_user->ID) {
        return;
    }

    // GET USER ORDERS (COMPLETED + PROCESSING)
    $customer_orders = get_posts(array(
        'post_type' => 'product',
    ));
    foreach ($customer_orders as $customer_order) {
        if ($current_user->ID != $customer_order->post_author) {
            $product_ids[] = $customer_order->ID;
        }
    }
    //exit;
    $product_ids = array_unique($product_ids);
    $product_ids_str = implode(",", $product_ids);

    // PASS PRODUCT IDS TO PRODUCTS SHORTCODE
    return do_shortcode("[products ids='$product_ids_str' limit='20' paginate='true']");
}
add_action('wp_ajax_nopriv_remove_passport', 'remove_passport_fun');
add_action('wp_ajax_remove_passport', 'remove_passport_fun');

function remove_passport_fun()
{
    global $wpdb;
    $user_id = $_POST['user_id'];
    update_user_meta($user_id, 'user_passport', "");
    echo "success";
    die();
}
add_action('wp_ajax_nopriv_dl_remove_data', 'dl_remove_data_fun');
add_action('wp_ajax_dl_remove_data', 'dl_remove_data_fun');

function dl_remove_data_fun()
{
    global $wpdb;
    $user_id = $_POST['user_id'];
    update_user_meta($user_id, 'user_dl', "");
    echo "success";
    die();
}
add_action('wp_ajax_nopriv_identity_remove_data', 'identity_remove_data_fun');
add_action('wp_ajax_identity_remove_data', 'identity_remove_data_fun');

function identity_remove_data_fun()
{
    global $wpdb;
    $user_id = $_POST['user_id'];
    update_user_meta($user_id, 'user_identity', "");
    echo "success";
    die();
}
/**
 * @snippet       WooCommerce Show Product Image @ Checkout Page
 * @author        Sandesh Jangam
 * @donate $9     https://www.paypal.me/SandeshJangam/9
 */

add_filter('woocommerce_cart_item_name', 'ts_product_image_on_checkout', 10, 3);

function ts_product_image_on_checkout($name, $cart_item, $cart_item_key)
{

    /* Return if not checkout page */
    if (!is_checkout()) {
        return $name;
    }

    /* Get product object */
    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

    /* Get product thumbnail */
    $thumbnail = $_product->get_image();

    /* Add wrapper to image and add some css */
    $image = '<div class="ts-product-image" style="display: inline-block; padding-right: 7px; vertical-align: middle;">'
        . $thumbnail .
        '</div>';

    /* Prepend image to name and return it */
    return $image . $name;
}

/**
 * Method to delete Woo Product
 *
 * @param int $id the product ID.
 * @param bool $force true to permanently delete product, false to move to trash.
 * @return \WP_Error|boolean
 */
function wh_deleteProduct($id, $force = false)
{
    $product = wc_get_product($id);

    if (empty($product)) {
        return new WP_Error(999, sprintf(__('No %s is associated with #%d', 'woocommerce'), 'product', $id));
    }

    // If we're forcing, then delete permanently.
    if ($force) {
        if ($product->is_type('variable')) {
            foreach ($product->get_children() as $child_id) {
                $child = wc_get_product($child_id);
                $child->delete(true);
            }
        } elseif ($product->is_type('grouped')) {
            foreach ($product->get_children() as $child_id) {
                $child = wc_get_product($child_id);
                $child->set_parent_id(0);
                $child->save();
            }
        }

        $product->delete(true);
        $result = $product->get_id() > 0 ? false : true;
    } else {
        $product->delete();
        $result = 'trash' === $product->get_status();
    }

    if (!$result) {
        return new WP_Error(999, sprintf(__('This %s cannot be deleted', 'woocommerce'), 'product'));
    }

    // Delete parent product transients.
    if ($parent_id = wp_get_post_parent_id($id)) {
        wc_delete_product_transients($parent_id);
    }
    return true;
}

add_action('wp_ajax_nopriv_listing_remove_product', 'listing_remove_product_fun');
add_action('wp_ajax_listing_remove_product', 'listing_remove_product_fun');

function listing_remove_product_fun()
{
    global $wpdb;
    $product_id = $_POST['product_id'];
    $delete_product = wh_deleteProduct($product_id, true);
    echo "success";
    die();
}

/**
 * @snippet       Display All Products Purchased by User via Shortcode - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 3.6.3
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

add_shortcode('vendor_order_product', 'vendor_order_product_fun');

function vendor_order_product_fun()
{
    // GET CURR USER
    $current_user = wp_get_current_user();
    //echo "<pre>"; print_r($current_user); exit;
    $user_display_name = $current_user->display_name;
    if (0 == $current_user->ID) {
        return;
    }

    $orders = wc_get_orders(array(
        //'limit'        => -1, // Query all orders
        //'orderby'      => 'date',
        //'order'        => 'DESC',
        'meta_key' => 'Sold By', // The postmeta key field
        'meta_value' => $user_display_name, // The comparison argument
    ));
    echo "<pre>";
    print_r($orders);
    exit;
    // GET USER ORDERS (COMPLETED + PROCESSING)
    $customer_orders = get_posts(array(
        'numberposts' => -1,
        'meta_key' => 'Sold By',
        'meta_value' => $user_display_name,
        'post_type' => wc_get_order_types(),
        'post_status' => array_keys(wc_get_is_paid_statuses()),
    ));
    echo "<pre>";
    print_r($customer_orders);
    // LOOP THROUGH ORDERS AND GET PRODUCT IDS
    if (!$customer_orders) {
        return;
    }

    $product_ids = array();
    foreach ($customer_orders as $customer_order) {
        $order = wc_get_order($customer_order->ID);
        $items = $order->get_items();
        foreach ($items as $item) {
            $product_id = $item->get_product_id();
            $product_ids[] = $product_id;
        }
    }
    $product_ids = array_unique($product_ids);
    $product_ids_str = implode(",", $product_ids);

    // PASS PRODUCT IDS TO PRODUCTS SHORTCODE
    return do_shortcode("[products ids='$product_ids_str']");
}

/**
 * Update the order meta with field value
 */
add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta');

function my_custom_checkout_field_update_order_meta($order_id)
{
    //if ( ! empty( $_POST['my_field_name'] ) ) {
    $orderstatus = '0';
    update_post_meta($order_id, 'count_order_status', $orderstatus);
    //}
}

add_action('wp_ajax_nopriv_booking_update_count', 'booking_update_count_fun');
add_action('wp_ajax_booking_update_count', 'booking_update_count_fun');

function booking_update_count_fun()
{
    global $wpdb;
    $order_id = $_POST['order_id'];
    foreach ($order_id as $orderid) {
        $orderstatus = '1';
        update_post_meta($orderid, 'count_order_status', $orderstatus);
    }
    die();
}

// Remove some checkout billing fields
function unset_checkout_option_fields($fields)
{
    unset($fields["billing_company"]);
    unset($fields["billing_address_2"]);
    return $fields;
}
add_filter('woocommerce_billing_fields', 'unset_checkout_option_fields');

///Add the File Upload Field in Shipping Fields Group
//add_filter( 'woocommerce_shipping_fields', 'woo_filter_upload_shipping' );

function woo_filter_upload_shipping($address_fields)
{
    //  $address_fields['file_upload']['required'] = true;

    $address_fields['user_id_verify'] = array(
        //'label'     => __('Upload your ID', 'woocommerce'),
        'required' => false,
        'class' => array('form-row-wide'),
        'clear' => true,
    );

    return $address_fields;
}

/**
 * Add the field to the checkout
 */
//add_action( 'woocommerce_after_order_notes', 'my_custom_checkout_field' );

function my_custom_checkout_field($checkout)
{

    echo '<div id="my_custom_checkout_field"><h2>' . __('User ID') . '</h2>';
    echo '</div>';
    $uploadFile = "";
    $uploadFile .= '<div id="upload_user_id">';
    $uploadFile .= '<input id="user_id_verify" name="user_id_verify"
    type="file">';
    $uploadFile .= '<span id="">';
    $uploadFile .= '</span>';
    $uploadFile .= '</div>';
    echo $uploadFile;
}

/**
 * Process the checkout
 */
//add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

function my_custom_checkout_field_process()
{
    // Check if set, if its not set add an error.
    if (!$_POST['user_id_verify']) {
        wc_add_notice(__('Please enter something into this new shiny field.'), 'error');
    }
}

/**
 * Update the order meta with field value
 */
//add_action( 'woocommerce_checkout_update_order_meta', 'field_update_order_meta' );

function field_update_order_meta($order_id)
{
    if (!empty($_POST['user_id_verify'])) {
        $files = $_FILES['user_id_verify'];
        echo "<pre>";
        print_r($files);
        if (!function_exists('wp_handle_upload')) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }
        $file = array(
            'name' => $files['name'],
            'type' => $files['type'],
            'tmp_name' => $files['tmp_name'],
            'error' => $files['error'],
            'size' => $files['size'],
        );

        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($file, $upload_overrides);
        //echo "<pre>"; print_r($movefile);
        if ($movefile && !isset($movefile['error'])) {
            //echo $movefile['url'];
            update_post_meta($order_id, 'user_verify', $movefile['url']);
            //echo "<div class='woocommerce-message'>Your data has been saved</div>";
        }
        //update_post_meta( $order_id, 'User Id', sanitize_text_field( $_POST['user_id_verify'] ) );
    }
}

/**
 * Display field value on the order edit page
 */
//add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order)
{
    echo '<p><strong>' . __('User Id') . ':</strong> ' . get_post_meta($order->id, 'user_verify', true) . '</p>';
}

add_action('woocommerce_after_shop_loop_item_title', 'custom_field_display_below_title', 2);
function custom_field_display_below_title()
{
    global $product;

    // Get the custom field value
    $get_shoe_brand = get_post_meta($product->get_id(), 'shoes_brand', true);
    $get_dress_brand = get_post_meta($product->get_id(), 'dress_brand', true);
    $get_bag_brand = get_post_meta($product->get_id(), 'bag_brand', true);
    $get_accessories_brand = get_post_meta($product->get_id(), 'accessories_brand', true);
    if (!empty($get_shoe_brand)) {
        echo "<div class='brand_name_txt'>Brand: " . $get_shoe_brand . "</div>";
    }
    if (!empty($get_dress_brand)) {
        echo "<div class='brand_name_txt'>Brand: " . $get_dress_brand . "</div>";
    }
    if (!empty($get_bag_brand)) {
        echo "<div class='brand_name_txt'>Brand: " . $get_bag_brand . "</div>";
    }
    if (!empty($get_accessories_brand)) {
        echo "<div class='brand_name_txt'>Brand: " . $get_accessories_brand . "</div>";
    }
}

// SW CHANGES [ nmspace - _intech ]

if (!function_exists('dd')) {
    function dd($data)
    {
        echo "<pre>";
        var_dump($data);
        die();
    }
}

function _intech_wc_add_my_account_orders_column($columns)
{

    $new_columns = array();

    foreach ($columns as $key => $name) {

        $new_columns[$key] = $name;

        // add ship-to after order status column
        if ('order-status' === $key) {
            $new_columns['order-item-name'] = __('Item(s)', 'textdomain');
            $new_columns['order-renter-name'] = __('Renter', 'textdomain');
        }
    }

    return $new_columns;
}
add_filter('woocommerce_my_account_my_orders_columns', '_intech_wc_add_my_account_orders_column');

function _intech_wc_my_orders_item_name_column($order)
{
    $items = '';
    foreach ($order->get_items() as $line_item) {
        $items .= $line_item['name'] . ', ';
    }

    echo rtrim($items, ', ');
}
add_action('woocommerce_my_account_my_orders_column_order-item-name', '_intech_wc_my_orders_item_name_column');

function _intech_wc_my_orders_renter_name_column($order)
{
    $renters = '';
    foreach ($order->get_items() as $line_item) {
        $user_id = WCV_Vendors::get_vendor_from_product($line_item->get_product_id());
        if (!empty($user_id = intval($user_id)) && $user_id > 0) {
            $user = get_userdata($user_id);
            $renters .= $user->data->user_nicename . ', ';
        }
    }

    echo rtrim($renters, ', ');
}
add_action('woocommerce_my_account_my_orders_column_order-renter-name', '_intech_wc_my_orders_renter_name_column');

function _intech_wc_change_shipping_nm($s_b_array)
{
    if (isset($s_b_array['billing'])) {
        $s_b_array['billing'] = __('Shipping info', 'woocommerce');
    }
    return $s_b_array;
}
add_filter('woocommerce_my_account_get_addresses', '_intech_wc_change_shipping_nm');

// add_action('woocommerce_after_shop_loop', '_intech_woo_after_shop_loop');
function _intech_product_query_meta_query($args)
{
    if (!isset($_GET['k_max_price']) && !isset($_GET['k_min_price'])) {
        return $args;
    }

    $current_min_price = isset($_GET['k_min_price']) ? floatval(wp_unslash($_GET['k_min_price'])) : 0.00; // WPCS: input var ok, CSRF ok.
    $current_max_price = isset($_GET['k_max_price']) ? floatval(wp_unslash($_GET['k_max_price'])) : PHP_INT_MAX; // WPCS: input var ok, CSRF ok.

    $args[] = [
        [
            'key' => 'rental_price',
            'value' => [$current_min_price, $current_max_price],
            'type' => 'numeric',
            'compare' => 'BETWEEN',
        ],
    ];

    return $args;
}
add_filter('woocommerce_product_query_meta_query', '_intech_product_query_meta_query', 9, 2);

add_action('wp_head', function () {

?>

    <script type="text/javascript">
        // function to update query params in the url
        function _UpdateQueryString(e, l, n) {
            n || (n = window.location.href);
            var r, i = new RegExp("([?&])" + e + "=.*?(&|#|$)(.*)", "gi");
            if (i.test(n)) return null != l ? n.replace(i, "$1" + e + "=" + l + "$2$3") : (r = n.split("#"), n = r[0].replace(i, "$1$3").replace(/(&|\?)$/, ""), void 0 !== r[1] && null !== r[1] && (n += "#" + r[1]), n);
            if (null != l) {
                var t = -1 !== n.indexOf("?") ? "&" : "?";
                return r = n.split("#"), n = r[0] + t + e + "=" + l, void 0 !== r[1] && null !== r[1] && (n += "#" + r[1]), n
            }
            return n
        }

        function _getParameterByName(e, n = window.location.href) {
            e = e.replace(/[\[\]]/g, "\\$&");
            var r = new RegExp("[?&]" + e + "(=([^&#]*)|&|#|$)").exec(n);
            return r ? r[2] ? decodeURIComponent(r[2].replace(/\+/g, " ")) : "" : null
        }
    </script>

    <?php
});

// price filter on product collection page
add_filter('woof_print_content_before_redraw_zone', function () {
    $class = '';
    if (wp_is_mobile()) {
    ?>
        <button class="toggle_div" style="margin-bottom:0">Filter Search</button>
    <?php
        $class = "ak_side_filter";
    } else {
    ?>
        <p style="margin-bottom:0">Filter Search</p>
    <?php
    }
    ?>
    <style>
        .ak_side_filter {
            display: none;
        }

        @media only screen and (max-width: 600px) {
            .woof_redraw_zone {
                display: none;
            }

            .woof_sid_widget {
                text-align: center;
            }

            #left-sidebar {
                border-top: 0 !important;
                margin-bottom: 0;
            }

            #page-content {
                border-top: 0 !important;
            }
        }
    </style>

    <div class="<?php echo $class ?>">
        <input type="text" id="amount_slider" readonly style="border:0;color:#f6931f;font-size:14px;font-weight:bold;">

        <div id="price-range-slider-range"></div>

        <a id="price-range-btn" href="javascript:void(0)" style="display:none;font-size:14px;font-weight:bold;letter-spacing:1px;text-decoration:underline;">Search</a>
    </div>

    <script type="text/javascript">
        jQuery(document).on('click', '.toggle_div', function() {
            jQuery('.ak_side_filter').toggle();
            jQuery('.woof_redraw_zone').toggle();
        });
        // if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
        //     alert('dfsgsdf');
        // }

        document.addEventListener("DOMContentLoaded", function() {
            var $ = $ || jQuery;

            var price_range_slider = $("#price-range-slider-range");
            var amount_slider = $("#amount_slider");

            var k_min_price = <?php echo isset($_GET['k_min_price']) ? trim($_GET['k_min_price']) : 0 ?>;
            var k_max_price = <?php echo isset($_GET['k_max_price']) ? trim($_GET['k_max_price']) : 1000 ?>;

            var timeout = null;

            function _page_reload_min_max_price() {
                var d = _UpdateQueryString('k_max_price', k_max_price);
                var e = _UpdateQueryString('k_min_price', k_min_price, d);

                window.location.replace(e);
            }


            price_range_slider.slider({
                range: true,
                min: 0,
                max: 1000,
                values: [k_min_price, k_max_price],
                step: 10,
                slide: function(event, ui) {
                    clearTimeout(timeout);

                    k_min_price = ui.values[0];
                    k_max_price = ui.values[1];
                    amount_slider.val("$" + k_min_price + " - $" + k_max_price);

                    timeout = setTimeout(_page_reload_min_max_price, 1000);
                }
            });

            amount_slider.val('$ ' + k_min_price + ' -  $ ' + k_max_price);

            $("#price-range-btn").click(_page_reload_min_max_price);


            // remove left bar and pagination on latest products page
            // browse-wardrobes/?durmstring=1&orderby=date&limit=12
            if (null !== _getParameterByName('durmstring')) {
                $(".search-page-template #page-content")
                    .get(0).style.setProperty('width', '100%', 'important');
                $(".search-page-template #left-sidebar").hide();

                //$(".woocommerce-pagination").hide();
            }

        });
    </script>
<?php
}, 10);

// authorize
add_action('wp', function () {

    // authorization - whether or not this user
    // can list an item on this store
    $auth_urls = ['add_bag_product.php', 'add_shoes_product.php', 'add_accessories_product.php', 'add-frontend-product.php'];

    $template = basename(get_page_template());

    if (in_array($template, $auth_urls)) {

        $user_meta = get_user_meta(get_current_user_id());

        $_isset = function ($key) use ($user_meta) {
            if (isset($user_meta[$key]) && !empty($a = $user_meta[$key])) {
                return is_array($a) ? !empty($a[0]) : true;
            }

            return false;
        };

        $error_msg = '';

        // id proof
        $id_proof = $_isset('user_passport') || $_isset('user_dl') || $_isset('user_identity');

        if (!$id_proof) {
            $error_msg .= 'ID Proof, ';
        }

        // bank details
        $bank =
            $_isset('user_account_name') &&
            $_isset('user_account_number') &&
            $_isset('user_bsb');

        if (!$bank) {
            $error_msg .= 'Bank Ac Details, ';
        }

        $shipping =
            $_isset('shipping_address_1') &&
            $_isset('shipping_city') &&
            $_isset('shipping_state') &&
            $_isset('shipping_postcode');

        // if( !$shipping ) {
        //     $error_msg .= 'Shipping Details';
        // }

        if ($error_msg !== '') {
            $error_msg = rtrim($error_msg, ', ');

            wc_add_notice('Following details are required to list products: ' . $error_msg);
            wp_redirect(wc_get_page_permalink('myaccount'));
            exit;
        }
    }

    // order notfication update
    // when clicked on an notification item
    // page - /my-account-v1/
    if (isset($_GET['karporav_seen_action']) && isset($_GET['odeer'])) {
        $order_id = intval(trim($_GET['odeer']));

        if ($order_id) {
            update_post_meta($order_id, '_intech_show_notification', 1);
            wp_send_json(['status' => 1]);
        } else {
            wp_send_json(['status' => 0]);
        }

        exit;
    }
});

function _intech_custom_fee_based_on_cart_total($cart)
{
    $percent = 10;
    $cart_total = $cart->cart_contents_total;

    if ($cart_total > 0) {
        $cart->add_fee(__("Service Fee", "woocommerce"), $cart_total * $percent / 100, false);
    }
}

add_action('woocommerce_cart_calculate_fees', '_intech_custom_fee_based_on_cart_total', 10, 1);

function _intech_woo_order_status_change_custom($order_id)
{
    update_post_meta($order_id, '_intech_show_notification', 0);
}
add_action('woocommerce_order_status_changed', '_intech_woo_order_status_change_custom', 10, 3);

add_filter('woocommerce_shipping_fields', '_intech_ts_unrequire_wc_phone_field');
function _intech_ts_unrequire_wc_phone_field($fields)
{
    $fields['shipping_first_name']['required'] = false;
    $fields['shipping_last_name']['required'] = false;
    return $fields;
}

add_filter('woocommerce_billing_fields', '_intech_ts_unrequire_wc_billing_field');
function _intech_ts_unrequire_wc_billing_field($fields)
{
    $fields['billing_first_name']['required'] = false;
    $fields['billing_last_name']['required'] = false;
    return $fields;
}

function _intech_wc_billing_field_strings($translated_text, $text, $domain)
{
    switch ($translated_text) {
        case 'Billing details':
            $translated_text = __('Postal details', 'woocommerce');
            break;
    }
    return $translated_text;
}
add_filter('gettext', '_intech_wc_billing_field_strings', 20, 3);

add_action('woocommerce_review_order_before_submit', function () {
?>

    <p style="margin-top:12px;">
        <input type="checkbox" id="intehc_accept_terms">
        <label for="intehc_accept_terms" style="display:inline;">
            By checking out, you agree to <a href="<?php echo get_page_link(4692); ?>" target="_blank">Terms & Conditions and User Conduct</a> of this site.
        </label>
    </p>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var $ = $ || jQuery;

            $('form.checkout').on('checkout_place_order', function() {
                var $payment_method = $('#intehc_accept_terms').is(":checked");
                if (!$payment_method) {
                    // prevent the submit AJAX call
                    alert('Please check Terms & Conditions at the bottom');
                    return false;
                }
                // allow the submit AJAX call
                return true;
            });
        });
    </script>

<?php
}, 10);

// temporarily making administrator a vendor
add_filter('wcvendors_vendor_roles', function ($roles = array()) {
    $roles[] = 'administrator';
    return $roles;
}, 10);

add_filter('wcvendors_orders_date_range', function ($dates) {
    return [];
}, 10);

// BRAND FILTER NOT WORKING ON PRODUCT COLLECTION PAGE --FIX--
//
add_filter('woof_get_tax_query', function ($res) {

    // remove and get extra
    $extras = array();
    foreach ($res as &$val) {
        if (isset($val['taxonomy']) && $val['taxonomy'] == 'product_cat') {
            $l = count($val['terms']);

            if ($l > 2) {
                $first = $val['terms'][0];
                $extras = array_slice($val['terms'], 2, $l);
                array_splice($val['terms'], 2, $l);
            }

            $val['operator'] = 'AND';

            break;
        }
    }

    // if( isset($_GET['test']) ) dd( $res );

    foreach ($extras as $extra) {
        // $res[] = [
        //   'relation' => 'OR'
        // ];
        $res['relation'] = 'OR';

        $res[] = [
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => [$first, $extra],
            'operator' => 'AND',
        ];
    }

    // if( isset($_GET['test']) ) dd( $res );

    // foreach ( $res as &$val ) {
    //     if( isset($val['taxonomy']) && $val['taxonomy'] == 'product_cat' ) {
    //         // if the terms are more than 3 then we need to divide it up
    //         $val['operator'] = 'AND';
    //     }
    // }

    return $res;
});
add_filter('woocommerce_product_query_tax_query', function ($tax_query) {
    return array();
});
// BRAND FILTER NOT WORKING ON PRODUCT COLLECTION PAGE --FIX--
//

// use first and last name as username while creating a new user
add_filter('woocommerce_new_customer_data', function ($new_customer_data) {

    $first_name = isset($_POST['billing_first_name']) ? trim($_POST['billing_first_name']) : '';

    $last_name = isset($_POST['billing_last_name']) ? trim($_POST['billing_last_name']) : '';

    // the customer billing complete name
    $complete_name = trim($first_name . ' ' . $last_name);

    // Replacing ‘user_login' in the user data array, before data is inserted
    if (!empty($complete_name)) {
        $new_customer_data['user_login'] = sanitize_user(str_replace(' ', '_', strtolower($complete_name))) . '_' . random_int(1000, 9999);
    }

    return $new_customer_data;
}, 99, 1);

function _intech_wc_admin_after_order_itemmeta($item_id = 0)
{
    global $wp;

    $order_page_url = admin_url('post.php' . add_query_arg(array($_GET), $wp->request));

    $userData = get_userdata(get_current_user_id());

    if ($item_id > 0) {
        $order = wc_get_order(get_the_ID());

        $html = '<div style="display:flex;justify-content:space-between;align-items:start">';

        foreach ($order->get_items() as $item) {

            if ($item->get_id() === $item_id) {

                if ($product = $item->get_product()) {
                    $html .= '<div>';
                    $html .= '<p><b>Lender Info:</b></p>';

                    $post = get_post($product->get_id());

                    $post_author = $post->post_author;

                    $post = get_user_meta($post_author);

                    // get accpect/reject status
                    $accept_reject_lender =
                        get_user_meta(get_current_user_id(), 'vendor_report_accept_reject_lender_' . $order->get_id() . '_' . $product->get_id(), true);

                    $accept_reject_admin =
                        get_user_meta(get_current_user_id(), 'vendor_report_accept_reject_admin_' . $order->get_id() . '_' . $product->get_id(), true);

                    if (isset($post['user_passport']) && !empty($p = $post['user_passport']) && isset($p[0]) && !empty($p[0])) {
                        $html .= '<p>ID Proof: <b><a href="' . $p[0] . '" target="_blank">User Passport</a></b></p>';
                    } else if (isset($post['user_dl']) && !empty($p = $post['user_dl']) && isset($p[0]) && !empty($p[0])) {
                        $html .= '<p>ID Proof: <b><a href="' . $p[0] . '" target="_blank">User DL</a></b></p>';
                    } else if (isset($post['user_identity']) && !empty($p = $post['user_identity']) && isset($p[0]) && !empty($p[0])) {
                        $html .= '<p>ID Proof: <b><a href="' . $p[0] . '" target="_blank">User ID</a></b></p>';
                    }

                    if (isset($post['user_account_name']) && !empty($p = $post['user_account_name']) && isset($p[0]) && !empty($p[0])) {
                        $html .= '<p>Lender Account Name: <b>' . $p[0] . '</b></p>';
                    }
                    if (isset($post['user_account_number']) && !empty($p = $post['user_account_number']) && isset($p[0]) && !empty($p[0])) {
                        $html .= '<p>Lender Account Number: <b>' . $p[0] . '</b></p>';
                    }
                    if (isset($post['user_bsb']) && !empty($p = $post['user_bsb']) && isset($p[0]) && !empty($p[0])) {
                        $html .= '<p>Lender Account BSB: <b>' . $p[0] . '</b></p>';
                    }

                    $html .= '<p>Lender Name: <b>' . ucwords($userData->first_name . ' ' . $userData->last_name) . '</b></p>';

                    $html .= '<p>Lender Email: <b>' . $userData->user_email . '</b></p>';

                    if (isset($post['billing_phone']) && !empty($p = $post['billing_phone']) && isset($p[0]) && !empty($p[0])) {
                        $html .= '<p>Lender Phone: <b>' . $p[0] . '</b></p>';
                    }

                    if (!empty($accept_reject_lender)) {
                        $html .= '<p><b>Lender <span class="tan_label ' . $accept_reject_lender . '">' . $accept_reject_lender . '</span> this item</b></p>';
                    }

                    if (!empty($accept_reject_admin)) {
                        $html .= '<p><b>You <span class="tan_label ' . $accept_reject_admin . '">' . $accept_reject_admin . '</span> this item</b></p>';
                    } else {
                        $html .= '<div style="margin-top:10px">
                        <a href="'. site_url() .'"/vendor-report?quin=1&order_id=' . $order->get_id() . '&vendor_report_accept_reject=' . $product->get_id() . '&status=accepted&back=' . $order_page_url . '">Accept</a>
                        <a href="https://thedesignerclub.com.au/vendor-report?quin=1&order_id=' . $order->get_id() . '&vendor_report_accept_reject=' . $product->get_id() . '&status=rejected&back=' . $order_page_url . '" style="margin-left:5px">Reject</a>
                      </div>';
                    } 

                    $html .= '</div><div><p><b>Renter Info:</b></p>';

                    $post = get_user_meta($order->get_user_id());

                    if (isset($post['user_passport']) && !empty($p = $post['user_passport']) && isset($p[0]) && !empty($p[0])) {
                        $html .= '<p>ID Proof: <b><a href="' . $p[0] . '" target="_blank">User Passport</a></b></p>';
                    } else if (isset($post['user_dl']) && !empty($p = $post['user_dl']) && isset($p[0]) && !empty($p[0])) {
                        $html .= '<p>ID Proof: <b><a href="' . $p[0] . '" target="_blank">User DL</a></b></p>';
                    } else if (isset($post['user_identity']) && !empty($p = $post['user_identity']) && isset($p[0]) && !empty($p[0])) {
                        $html .= '<p>ID Proof: <b><a href="' . $p[0] . '" target="_blank">User ID</a></b></p>';
                    }

                    if (isset($post['user_account_name']) && !empty($p = $post['user_account_name']) && isset($p[0]) && !empty($p[0])) {
                        $html .= '<p>Renter Account Name: <b>' . $p[0] . '</b></p>';
                    }
                    if (isset($post['user_account_number']) && !empty($p = $post['user_account_number']) && isset($p[0]) && !empty($p[0])) {
                        $html .= '<p>Renter Account Number: <b>' . $p[0] . '</b></p>';
                    }
                    if (isset($post['user_bsb']) && !empty($p = $post['user_bsb']) && isset($p[0]) && !empty($p[0])) {
                        $html .= '<p>Renter Account BSB: <b>' . $p[0] . '</b></p>';
                    }

                    $html .= '</div>';

                    // $html .= '<div style="margin-top:10px"><a onclick="h_tai_user_accpet(event)" data-id="'. $post_author .'" href="javascript:void(0);">Accept</a><a onclick="h_tai_user_reject(event)" data-id="'. $post_author .'" href="#" style="margin-left:5px">Decline</a></div>';
                }
            }
        }

        $html .= '</div>';

        echo $html;
    }
}
// add extra info about lender and render in order detail page
add_action('woocommerce_after_order_itemmeta', '_intech_wc_admin_after_order_itemmeta');

// add phone number at user registration
add_action('woocommerce_register_form_start', function () {
?>
    <p style="margin-bottom: 0px; margin-top: 10px;" class="form-row form-row-wide">
        <label for="reg_billing_phone"><?php _e('Phone', 'woocommerce'); ?> *</label>

        <!--  "You can’t have 2 times the value attribute and you can use "tel" type … (to be removed)" -->
        <input style="width:254px!important;" type="tel" class="woocommerce-Input woocommerce-Input--text input-text placeholder" name="billing_phone" id="reg_billing_phone" value="<?php esc_attr_e($_POST['billing_phone']); ?>" required />
    </p><br>
    <div class="clear"></div>
<?php
});
// verify user phone on registration post
add_action('woocommerce_register_post', function ($username, $email, $validation_errors) {

    if (isset($_POST['billing_phone']) && strlen($_POST['billing_phone']) < 10) {
        $validation_errors->add('billing_phone_error', __('Please type a correct phone number', 'woocommerce'));
    }
    return $validation_errors;
}, 10, 3);
// update user phone into the db on registration post
add_action('woocommerce_created_customer', function ($customer_id) {
    if (isset($_POST['billing_phone'])) {
        update_user_meta($customer_id, 'phone', sanitize_text_field($_POST['billing_phone']));
        update_user_meta($customer_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
        update_user_meta($customer_id, 'shipping_phone', sanitize_text_field($_POST['billing_phone']));
    }
});

// replace rent by with lend by in order detail page
add_action('admin_footer', function () {
?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery("#order_line_items .display_meta").find("th:contains('Rent By:')").text('LEND BY:');
        });
    </script>
<?php
});

// fix: administrator can now see products uploaded by other vendors
add_action('load-edit.php', function () {
    add_action('request', function ($query_vars) {

        if (current_user_can('administrator')) {
            unset($query_vars['author']);
        }

        return $query_vars;
    }, 99);
}, 99);

// define the woocommerce_review_order_before_submit callback
function ak_action_woocommerce_review_order_before_submit()
{
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $userpassport = get_user_meta($user_id, 'user_passport', true);
        $userdl = get_user_meta($user_id, 'user_dl', true);
        $useridentity = get_user_meta($user_id, 'user_identity', true);
        $url = get_permalink(get_option('woocommerce_myaccount_page_id'));
        if (empty($userpassport) && empty($userdl) && empty($useridentity)) {
            echo "<p class='verfy_txt'>Before Payment Please Enter Your Id Verification <a href='" . $url . "id-verification/'>Please Click</a></p>";
        }
    }
};

// add the action
add_action('woocommerce_review_order_before_submit', 'ak_action_woocommerce_review_order_before_submit', 10);

add_action('woocommerce_add_order_item_meta', 'tdc_add_order_item_meta', 10, 3);
function tdc_add_order_item_meta($item_id, $cart_item, $cart_item_key)
{
    if (isset($cart_item['size'])) {
        wc_add_order_item_meta($item_id, 'Size', $cart_item['size']);
    }
}

function keep_me_logged_in_for_1_year($expirein)
{
    return 31556926; // 1 year in seconds
}
add_filter('auth_cookie_expiration', 'keep_me_logged_in_for_1_year');

add_action('woocommerce_register_form', 'bbloomer_add_woo_account_registration_fields');

function bbloomer_add_woo_account_registration_fields()
{

?>
    <p class="form-row validate-required" id="dc_id_type" data-priority=""><label for="dc_id_type" class="">Select ID type <abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper">
            <select name="dc_id_type">
                <option value="user_passport">Passport</option>
                <option value="user_dl">Driver's license</option>
                <option value="user_identity">Identity card</option>
            </select>
        </span></p>
    <p class="form-row validate-required" id="image" data-priority=""><label for="image" class="">Upload Image ID (JPG, PNG, PDF)<abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper"><input type='file' name='dc_image' accept='image/*,.pdf' required></span></p>

    <?php

}

// --------------
// 2. Validate new field

add_filter('woocommerce_registration_errors', 'bbloomer_validate_woo_account_registration_fields', 10, 3);

function bbloomer_validate_woo_account_registration_fields($errors, $username, $email)
{
    if (isset($_POST['image']) && empty($_POST['image'])) {
        $errors->add('image_error', __('Please provide a valid image', 'woocommerce'));
    }
    return $errors;
}

// --------------
// 3. Save new field

add_action('user_register', 'bbloomer_save_woo_account_registration_fields', 1);

function bbloomer_save_woo_account_registration_fields($customer_id)
{
    $key_name = '';
    if (isset($_POST['dc_id_type'])) {
        if (isset($_FILES['dc_image'])) {
            $files = $_FILES['dc_image'];
            if (!function_exists('wp_handle_upload')) {
                require_once ABSPATH . 'wp-admin/includes/file.php';
            }
            $file = array(
                'name' => $files['name'],
                'type' => $files['type'],
                'tmp_name' => $files['tmp_name'],
                'error' => $files['error'],
                'size' => $files['size'],
            );

            $upload_overrides = array('test_form' => false);
            $movefile = wp_handle_upload($file, $upload_overrides);
            //echo "<pre>"; print_r($movefile);
            if ($movefile && !isset($movefile['error'])) {
                //echo $movefile['url'];
                update_user_meta($customer_id, $_POST['dc_id_type'], $movefile['url']);
            }
        }
    }
}

// --------------
// 4. Add enctype to form to allow image upload

add_action('woocommerce_register_form_tag', 'bbloomer_enctype_custom_registration_forms');

function bbloomer_enctype_custom_registration_forms()
{
    echo 'enctype="multipart/form-data"';
}

add_action('woocommerce_after_checkout_billing_form', 'misha_file_upload_field');

function misha_file_upload_field()
{
    $user_id = get_current_user_id();
    $userpassport = get_user_meta($user_id, 'user_passport', true);

    $userdl = get_user_meta($user_id, 'user_dl', true);
    $useridentity = get_user_meta($user_id, 'user_identity', true);
    if (isset($userpassport) && !empty($userpassport)) {
        $img_url = $userpassport;
    } else if (isset($userdl) && !empty($userdl)) {
        $img_url = $userdl;
    } else if (isset($useridentity) && !empty($useridentity)) {
        $img_url = $useridentity;
    }
    if (isset($img_url) && !empty($img_url)) {
    ?>
        <div class="form-row form-row-wide">
            <label for="misha_file">Image ID</label>
            <img src="<?php echo $img_url ?>" width="200" height="200" />
        </div>
    <?php
    } else {
    ?>
        <div class="form-row form-row-wide">
            <label for="misha_file">Upload Image ID</label>
            <input type="file" id="misha_file" name="misha_file" />
            <input type="hidden" name="misha_file_field" />
            <div id="misha_filelist"></div>
        </div>
    <?php
    }
}

add_action('wp_ajax_mishaupload', 'misha_file_upload');
add_action('wp_ajax_nopriv_mishaupload', 'misha_file_upload');

function misha_file_upload()
{

    $upload_dir = wp_upload_dir();

    if (isset($_FILES['misha_file'])) {
        $path = $upload_dir['path'] . '/' . basename($_FILES['misha_file']['name']);

        if (move_uploaded_file($_FILES['misha_file']['tmp_name'], $path)) {
            echo $upload_dir['url'] . '/' . basename($_FILES['misha_file']['name']);
        }
    }
    die;
}

add_action('woocommerce_checkout_update_order_meta', 'misha_save_what_we_added');

function misha_save_what_we_added($order_id)
{

    if (!empty($_POST['misha_file_field'])) {
        update_post_meta($order_id, '_billing_user_id_verification', sanitize_text_field($_POST['misha_file_field']));
    }
}

function dc_billing_field_strings($translated_text, $text, $domain)
{
    switch ($translated_text) {
        case 'Billing &amp; Shipping':
            $translated_text = __('Shipping', 'woocommerce');
            break;
    }
    return $translated_text;
}
add_filter('gettext', 'dc_billing_field_strings', 20, 3);

add_filter('woocommerce_billing_fields', 'dc__override_address_fields', 9999);
function dc__override_address_fields($fields)
{
    $fields['billing_state']['label'] = 'State';
    return $fields;
}

add_filter('woocommerce_default_address_fields', 'override_default_address_fields_dc', 999);
function override_default_address_fields_dc($address_fields)
{
    $address_fields['state']['label'] = 'State';
    return $address_fields;
}

add_filter('wcvendors_commissions_columns', 'wcvendors_commissions_columns_fn');
function wcvendors_commissions_columns_fn($columns)
{
    $columns['total_due'] = 'Payout';
    return $columns;
}

add_filter('ak_commision_change', 'ak_commision_change_callback', 99, 2);
function ak_commision_change_callback($commision, $item)
{
    $order = wc_get_order($item->order_id);
    $shipping_method_total = 0;
    foreach ($order->get_items('shipping') as $item_id => $item) {
        $shipping_method_total = $item->get_total() + $shipping_method_total;
    }
    if ($shipping_method_total > 0) {
        return $commision . ' + ' . wc_price($shipping_method_total);
    }
    return $commision;
}

/**
 * User endpoint API Authonication
 *
 */

// Define plugin url
define('TWILLIO_ACCOUNT_SID', 'ACcc49cabb2222d3d4ff3a1c6e38e2ba41');
define('TWILLIO_ACCOUNT_AUTH', 'f203d4232b15d35adf57f145542f0a09');
define('TWILLIO_SERVICE_SID', 'ISa98ee2c1450e4e4bb9d7beb95ef5f873');
define('TWILLIO_API_KEY', 'SKda2a88011d6aed74dbe4ad2af5dfc793');
define('TWILLIO_API_SECRET', '2ahQf8LxHxo0YwRe0UPacFfEawsXqrpW');

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/stripe/init.php';
\Stripe\Stripe::setApiKey('sk_test_AxpTFKWmFAEB5vdqQ9kPxn66');

use Illuminate\Http\Request;
use JetBrains\PhpStorm\Internal\ReturnTypeContract;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Rest\Client;

function thedesignerclub_user_athontication_api()
{
    register_rest_route(
        'v1',
        '/user_authentication/',
        array(
            'methods' => 'GET',
            'callback' => 'thedesignerclub_user_activate_test_kit',
            'permission_callback' => '__return_true',
        )
    );
}
add_action('rest_api_init', 'thedesignerclub_user_athontication_api');

function thedesignerclub_user_activate_test_kit(WP_REST_Request $request)
{
    $response = [];
    $user_name = $request->get_param('user_name');
    $password = $request->get_param('password');
    $device_token = $request->get_param('device_token');

    if (empty($user_name)) {
        $response['status_code'] = 404;
        $response['message'] = 'Username is missing';
    } elseif (empty($password)) {
        $response['status_code'] = 404;
        $response['message'] = 'Password is missing';
    } else {
        $user_data = wp_authenticate($user_name, $password);
        if (is_wp_error($user_data)) {
            $response['status_code'] = 404;
            $response['message'] = 'We can\'t authenticate with your username and password.';
        } else {
            $userdata = $user_data->data;
            $user_id = $userdata->ID;
            //echo $user_id;
            update_user_meta($user_id, 'device_token', $device_token);

            $response['status_code'] = 200;
            $response['message'] = 'User Data Fetch Successfully.';
            $response['data'] = $user_data->data;
            //$response['return_twilio_userID'] = create_twilio_user_add_in_twilio($user_data->data);
        }
    }
    return $response;
}

function thedesignerclub_login_using_social_media_api()
{
    register_rest_route('wp/v2', 'users/login', array(
        'methods' => 'GET',
        'callback' => 'designerclub_login_using_social_media',
    ));
}
add_action('rest_api_init', 'thedesignerclub_login_using_social_media_api');

function designerclub_login_using_social_media(WP_REST_Request $request)
{
    $response = [];
    global $wpdb;
    $user_name    = $request->get_param('user_name');
    $password     = $request->get_param('password');
    $device_token = $request->get_param('device_token');
    $social_id    = $request->get_param('social_id');

    $get_social_id = $wpdb->get_var("SELECT meta_value FROM wp_usermeta where meta_value = '" . $social_id . "'");

    if ($get_social_id == $social_id && (empty($user_name) && empty($password))) {
        $response['status_code'] = 200;
        $response['message'] = 'user logged in Successfully.';
        $response['data'] = $get_social_id;
    } else {
        if (empty($user_name)) {
            $response['status_code'] = 404;
            $response['message'] = 'Username is missing';
        } elseif (empty($password)) {
            $response['status_code'] = 404;
            $response['message'] = 'Password is missing';
        } else {
            if (is_wp_error($user_data)) {
                $response['status_code'] = 404;
                $response['message'] = 'We can\'t authenticate with your username and password.';
            } else {
                $user_data = wp_authenticate($user_name, $password);
                $userdata = $user_data->data;
                $user_id = $userdata->ID;
                update_user_meta($user_id, 'device_token', $device_token);
                $response['status_code'] = 200;
                $response['message'] = 'User Data Fetch Successfully.';
                $response['data'] = $user_data->data;
            }
        }
    }
    return $response;
}

function create_twilio_user_add_in_twilio($user_identity)
{
    $return_twilio_userID = [];

    $twilio = new Client(TWILLIO_ACCOUNT_SID, TWILLIO_ACCOUNT_AUTH);
    $user = $twilio->conversations->v1->users($user_identity->user_email)->fetch();

    if (isset($user->sid) && !empty($user->sid)) {

        $upduser = $twilio->conversations->v1->users($user->sid)->update(array("friendlyName" => $user_identity->display_name));
        //$this->common_model->common_singleUpdate("tbl_user", array("twilio_user_sid" => $user->sid), array("id" => $user_identity));
        $return_twilio_userID['user_sid'] = $user->sid;
    } else {
        $newuser = $twilio->conversations->v1->users->create(array("identity" => $user_identity->user_email, "friendlyName" => $user_identity->display_name));
        if (isset($newuser->sid) && !empty($newuser->sid)) {
            //$this->common_model->common_singleUpdate("tbl_user", array("twilio_user_sid" => $newuser->sid), array("id" => $user_identity));
            $return_twilio_userID['newuser_sid'] = $newuser->sid;
        } else {
            $return_twilio_userID['newuser_sid_blank'] = "";
        }
    }

    return $return_twilio_userID;
}

/**
 * Register User endpoint API Authonication
 *
 */

function designerclub_custom_userdata_save_fn($user_id, $user_phone_number, $country_code)
{

    global $wpdb;

    $thedesignerclub_user_tablename = $wpdb->prefix . 'designerclub_custom_userdata_save';

    //Save Phone Number With userID in database
    $wpdb->insert($thedesignerclub_user_tablename, array(
        'wp_designerclub_userid' => $user_id,
        'wp_designerclub_userphonenumber' => $user_phone_number,
        'wp_designerclub_user_country_code' => $country_code,
    ));
}

add_action('rest_api_init', 'thedesignerclub_rest_user_endpoints');
function thedesignerclub_rest_user_endpoints($request)
{

    register_rest_route('wp/v2', 'users/register', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_rest_user_endpoint_handler',
    ));
}
function thedesignerclub_rest_user_endpoint_handler(WP_REST_Request $request)
{

    $response = [];
    $username = $request->get_param('username');
    $password = $request->get_param('password');
    $email = $request->get_param('email');
    $firstname = $request->get_param('firstname');
    $lastname = $request->get_param('lastname');
    $phonenumber = $request->get_param('phonenumber');
    $country_code = $request->get_param('country_code');

    $login_type = $request->get_param('login_type');
    $social_id = $request->get_param('social_id');

    if (empty($username)) {
        $response['status_code'] = 404;
        $response['message'] = 'Username is missing';
    } elseif (empty($password)) {
        $response['status_code'] = 404;
        $response['message'] = 'Password is missing';
    } elseif (empty($email)) {
        $response['status_code'] = 404;
        $response['message'] = 'Email is missing';
    } elseif (empty($firstname)) {
        $response['status_code'] = 404;
        $response['message'] = 'First Name is missing';
    } elseif (empty($lastname)) {
        $response['status_code'] = 404;
        $response['message'] = 'Last Name is missing';
    } elseif (empty($country_code)) {
        $response['status_code'] = 404;
        $response['message'] = 'Country code is missing';
    } elseif (empty($phonenumber)) {
        $response['status_code'] = 404;
        $response['message'] = 'Phone Number is missing';
    }/*elseif (empty($login_type)) {
        $response['status_code'] = 404;
        $response['message'] = ' is missing';
    }  */ else {

        $user_id = username_exists($username);
        if (email_exists($email) == false) {

            $user_id = wp_insert_user(array(
                'user_login' => $username,
                'user_email' => $email,
                'first_name' => $firstname,
                'last_name' => $lastname,
                'display_name' => $firstname . ' ' . $lastname,
                'user_pass' => $password,
                'role' => 'vendor',
            ));
            $user_id = get_user_by('id', $user_id);

            update_user_meta($user_id->ID, 'billing_phone', $phonenumber);
            update_user_meta($user_id->ID, 'shipping_phone', $phonenumber);

            designerclub_custom_userdata_save_fn($user_id->ID, $phonenumber, $country_code);

            update_user_meta($user_id->ID, 'login_type', $login_type);
            update_user_meta($user_id->ID, 'social_id', $social_id);

            $response['status_code'] = 200;
            $response['data'] = $user_id;
            $response['message'] = 'User registered successfully!!!';
        } else {
            $response['status_code'] = 406;
            $response['message'] = 'Email already exists, please try Reset Password';
        }
    }

    return $response;
}

/**
 * Forgot Password User endpoint API Authonication
 *
 */
add_action('rest_api_init', function () {

    register_rest_route('wp/v2', 'users/reset-password', array(

        'methods' => 'POST',

        'callback' => function ($data) {

            $response = [];
            $exists = email_exists($data['email']);

            if (empty($data['email']) || $data['email'] === '') {
                $response['status_code'] = 400;
                $response['message'] = 'You must provide an email address.';
            } elseif (!$exists) {
                $response['status_code'] = 404;
                $response['message'] = 'No user found with this email address.';
            } else {

                try {

                    //$rndno=rand(100000, 999999);
                    $user = get_user_by('email', $data['email']);
                    $adt_rp_key = get_password_reset_key($user);
                    $user_login = $user->user_login;
                    $rp_link = '' . network_site_url("wp-login.php?action=rp&key=$adt_rp_key&login=" . rawurlencode($user_login), 'login') . '';
                    $to = $data['email'];
                    $subject = "[The Designer Club] Password Reset";
                    $message = 'To reset your password, visit the following address: ' . $rp_link . '';
                    $headers = 'From: ' . $to . "\r\n" .
                        'Reply-To: ' . $data['email'] . "\r\n";

                    //Here put your Validation and send mail
                    $sent = wp_mail($to, $subject, $message, $headers);

                    if ($sent) {
                        $response['status_code'] = 200;
                        $response['data'] = $rp_link;
                        $response['message'] = 'Email Sent Successfully!!!';
                    } else {
                        $response['status_code'] = 404;
                        $response['message'] = 'Something Went Wrong!!!';
                    }
                } catch (Exception $e) {
                    $response['status_code'] = 500;
                    $response['message'] = 'Bad Request - Invalid Email!!!';
                }
            }

            return $response;
        },

        'permission_callback' => function () {
            return true;
        },

    ));
});

//Our Weekly Favourite Product
add_action('template_redirect', 'thedesignerclub_our_weekly_fav_product_ID');

function thedesignerclub_our_weekly_fav_product_ID()
{

    $current_page_id = 16784;
    $select_our_weekly_favourite_product = get_field('select_our_weekly_favourite_product', $current_page_id);
    $select_our_weekly_favourite_product = implode(",", $select_our_weekly_favourite_product);

    return $select_our_weekly_favourite_product;
}

add_action('rest_api_init', 'thedesignerclub_our_weekly_fav_product');
function thedesignerclub_our_weekly_fav_product($request)
{

    register_rest_route('wp/v2', 'ourweeklyfavproduct', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_our_weekly_fav_product_rest_user_endpoint_handler',
    ));
}
function thedesignerclub_our_weekly_fav_product_rest_user_endpoint_handler(WP_REST_Request $request)
{

    $response = [];

    $thedesignerclub_our_weekly_fav_product_ID = thedesignerclub_our_weekly_fav_product_ID();

    $response['status_code'] = 200;
    $response['data'] = $thedesignerclub_our_weekly_fav_product_ID;
    $response['message'] = 'Successfully Ourweekly Favourite Product data!!!';

    return $response;
}

//End Our Weekly Favourite Product

//High End Designer Product

add_action('template_redirect', 'thedesignerclub_hour_end_designer_product_ID');

function thedesignerclub_hour_end_designer_product_ID()
{

    $current_page_id = 16785;
    $select_high_end_designer_product = get_field('select_high_end_designer_product', $current_page_id);
    $select_high_end_designer_product = implode(",", $select_high_end_designer_product);

    return $select_high_end_designer_product;
}

add_action('rest_api_init', 'thedesignerclub_hour_end_designer_product');
function thedesignerclub_hour_end_designer_product($request)
{

    register_rest_route('wp/v2', 'highenddesignerproduct', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_hour_end_designer_product_rest_user_endpoint_handler',
    ));
}
function thedesignerclub_hour_end_designer_product_rest_user_endpoint_handler(WP_REST_Request $request)
{

    $response = [];

    $thedesignerclub_hour_end_designer_product_ID = thedesignerclub_hour_end_designer_product_ID();

    $response['status_code'] = 200;
    $response['data'] = $thedesignerclub_hour_end_designer_product_ID;
    $response['message'] = 'Successfully High End Designer Product Data!!!';

    return $response;
}

//End High End Designer Product

// User Wise Product API

add_action('woocommerce_before_cart', 'thedesignerclub_user_wise_show_product_ID');

function thedesignerclub_user_wise_show_product_ID()
{

    $allproductID = array();
    $all_ids = get_posts(array(
        'post_type' => 'product',
        'numberposts' => -1,
        'post_status' => 'publish',
        'fields' => 'ids',
    ));
    foreach ($all_ids as $allproductids) {

        $author_id = get_post_field('post_author', $allproductids);
        $get_author_gravatar = get_avatar_url($author_id, array('size' => 450));
        $allproductID[$allproductids] = $get_author_gravatar;
    }

    return $allproductID;
}

add_action('rest_api_init', 'thedesignerclub_user_wise_show_product');
function thedesignerclub_user_wise_show_product($request)
{

    register_rest_route('wp/v2', 'userprofileurlforproduct', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_user_wise_show_product_rest_user_endpoint_handler',
    ));
}
function thedesignerclub_user_wise_show_product_rest_user_endpoint_handler(WP_REST_Request $request)
{

    $thedesignerclub_user_wise_show_product_ID = thedesignerclub_user_wise_show_product_ID();

    return $thedesignerclub_user_wise_show_product_ID;
}

// End User Wise Product API

//Start phone varification api endpoint

function designerclub_designerclub_user_otp_save_fn($user_phonenumber, $twilio_otp_number)
{

    global $wpdb;

    $expiration_timestamp = date("Y-m-d H:i:s", strtotime("+15 minutes"));

    $wp_designerclub_user_otp_save = 'otp_verification';

    //Save Phone Number With userID in database
    $wpdb->insert($wp_designerclub_user_otp_save, array(
        'phone_number' => $user_phonenumber,
        'otp' => $twilio_otp_number,
        'expiration_timestamp' => $expiration_timestamp,
    ));
}

add_action('rest_api_init', 'thedesignerclub_register_phone_varification_api');
function thedesignerclub_register_phone_varification_api($request)
{

    register_rest_route('wp/v2', 'sendotp', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_send_otp',
    ));
}
function thedesignerclub_send_otp(WP_REST_Request $request)
{

    $response = [];
    $country_code = $request->get_param('country_code');
    $phone_number = $request->get_param('phone_number');

    if (empty($phone_number)) {
        $response['status_code'] = 404;
        $response['message'] = 'Please enter your mobile number!!!';
    } else {

        $randomOTP = rand(100000, 999999);

        $account_sid = 'ACcc49cabb2222d3d4ff3a1c6e38e2ba41';
        $auth_token = 'f203d4232b15d35adf57f145542f0a09';

        $twilio_number = "+16089098129";
        $from_number = $country_code . $phone_number;

        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            // Where to send a text message (your cell phone?)
            $from_number,
            array(
                'from' => $twilio_number,
                'body' => 'Dear user, the one time password (OTP) to varify your account at Designerclub is ' . $randomOTP . '. Please do not share this OTP with anyone for security purpose - Designerclub Team',
            )
        );

        designerclub_designerclub_user_otp_save_fn($from_number, $randomOTP);

        $response['status_code'] = 200;
        $response['data'] = $randomOTP;
        $response['message'] = 'OTP sent successfully!!!';
    }

    return $response;
}

//End phone varification api endpoint

//Start phone varification verfiy api endpoint

add_action('rest_api_init', 'thedesignerclub_register_phone_verify_otp_api');
function thedesignerclub_register_phone_verify_otp_api($request)
{

    register_rest_route('wp/v2', 'verifyOtp', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_verify_otp',
    ));
}
function thedesignerclub_verify_otp(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];

    $country_code = $request->get_param('country_code');
    $phone_number = $request->get_param('phone_number');

    $from_number = $country_code . $phone_number;

    $user_inputOTP = $request->get_param('user_inputOTP');

    if (empty($from_number)) {
        $response['status_code'] = 404;
        $response['message'] = 'Phonenumber not found!!!';
    } else {

        $check = $wpdb->get_results("SELECT * FROM otp_verification WHERE expiration_timestamp >= NOW() AND otp = '" . $user_inputOTP . "' AND phone_number = '" . $from_number . "' ");

        if (!empty($check)) {
            $response['status_code'] = 200;
            $response['data'] = $check;
            $response['message'] = 'OTP verify successfully!!!';
        } else {
            $response['status_code'] = 404;
            $response['message'] = 'Invalid OTP!!!';
        }
    }

    return $response;
}

//End phone varification verfiy api endpoint

//Start forgot password phone number api

add_action('rest_api_init', 'thedesignerclub_forgot_password_phone_number_api');
function thedesignerclub_forgot_password_phone_number_api($request)
{

    register_rest_route('wp/v2', 'phoneforgotpassword', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_phone_forgot_password_api',
    ));
}
function thedesignerclub_phone_forgot_password_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $country_code = $request->get_param('country_code');
    $phone_number = $request->get_param('phone_number');
    $res_sendOtp = thedesignerclub_send_otp($request);

    if ($res_sendOtp["status_code"] == 404) {
        // means data not found
        return $res_sendOtp;
    } else {

        $sql = "SELECT * FROM wp_designerclub_custom_userdata_save WHERE wp_designerclub_userphonenumber='" . $phone_number . "' AND wp_designerclub_user_country_code='" . $country_code . "' LIMIT 1;";

        $check = $wpdb->get_results($sql);

        if (empty($check)) {
            $response['status_code'] = 404;
            $response['data'] = $check;
            $response['message'] = 'We can\'t find this mobile number!!!';
        } else {
            //if ( $phone_number == $check[0]->wp_designerclub_userphonenumber ) {
            $response['status_code'] = 200;
            $response['data'] = [
                'user_id' => $check[0]->wp_designerclub_userid,
            ];
            $response['message'] = $res_sendOtp["message"];
            //}
        }
        return $response;
    }
}

//End forgot password phone number api

//Start wp_set_password endpoint api

add_action('rest_api_init', 'thedesignerclub_wp_set_password_apiendpoint');
function thedesignerclub_wp_set_password_apiendpoint($request)
{

    register_rest_route('wp/v2', 'set_password', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_wp_set_password',
    ));
}
function thedesignerclub_wp_set_password(WP_REST_Request $request)
{

    $response = [];
    $user_id = $request->get_param('user_id');
    $password = $request->get_param('password');

    wp_set_password($password, $user_id);

    $response['status_code'] = 200;
    $response['message'] = 'Password changed successfully!!!';

    return $response;
}

//End wp_set_password endpoint api

//Start Completed profile api

add_action('rest_api_init', 'thedesignerclub_completed_profile_apiendpoint');
function thedesignerclub_completed_profile_apiendpoint($request)
{

    register_rest_route('wp/v2', 'completed_profile', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_completed_profile',
    ));
}
function thedesignerclub_completed_profile(WP_REST_Request $request)
{

    $response = [];
    $user_id = $request->get_param('user_id');
    $user_profile_image = $request->get_param('user_profile_image');
    $user_passport = $request->get_param('user_passport');
    $user_identity = $request->get_param('user_identity');
    $user_address = $request->get_param('user_address');

    if (!empty($user_profile_image)) {
        update_user_meta($user_id, 'easy_author_avatar_profile_image', 'https://hlink-bhavinp-s3.s3.amazonaws.com/designerclub/userprofile/' . $user_profile_image);
    }
    if (!empty($user_passport)) {
        update_user_meta($user_id, 'user_passport', 'https://hlink-bhavinp-s3.s3.amazonaws.com/designerclub/documents/' . $user_passport);
    }
    if (!empty($user_identity)) {
        update_user_meta($user_id, 'user_identity', 'https://hlink-bhavinp-s3.s3.amazonaws.com/designerclub/documents/' . $user_identity);
    }
    if (!empty($user_address)) {
        update_user_meta($user_id, 'billing_address_1', $user_address);
    }

    $easy_author_avatar_profile_image = get_user_meta($user_id, 'easy_author_avatar_profile_image', true);
    $user_passport = get_user_meta($user_id, 'user_passport', true);
    $user_identity = get_user_meta($user_id, 'user_identity', true);
    $user_address = get_user_meta($user_id, 'billing_address_1', true);

    $response['status_code'] = 200;
    if (!empty($easy_author_avatar_profile_image)) {
        $response['user_profile_image'] = $easy_author_avatar_profile_image;
    }
    if (!empty($user_passport)) {
        $response['user_passport'] = $user_passport;
    }
    if (!empty($user_identity)) {
        $response['user_identity'] = $user_identity;
    }
    if (!empty($user_address)) {
        $response['user_address'] = $user_address;
    }
    $response['message'] = 'Your profile has been create successfully!!!';

    return $response;
}

add_filter('get_avatar', 'thedesignerclub_get_easy_author_image', 10, 5);
function thedesignerclub_get_easy_author_image($avatar, $id_or_email, $size, $default, $alt)
{

    $user = false;

    if (is_numeric($id_or_email)) {

        $id = (int) $id_or_email;
        $user = get_user_by('id', $id);
    } elseif (is_object($id_or_email)) {

        if (!empty($id_or_email->user_id)) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by('id', $id);
        }
    } else {
        $user = get_user_by('email', $id_or_email);
    }

    if ($user && is_object($user)) {
        $get_avatar = get_user_meta($user->ID, 'easy_author_avatar_profile_image', true);
        if ($get_avatar) {
            $avatar = "<img src='" . $get_avatar . "' class='avatar avatar-50 photo' height='50' width='50' />";
        }
    }

    return $avatar;
}

//End Completed profile api

//Start Random Api Product list filter

add_filter('rest_product_collection_params', function ($params) {
    $params['orderby']['enum'][] = 'rand';
    return $params;
});

//End Random Api Product list filter

//Start Add to cart api endpoint

add_action('rest_api_init', 'thedesignerclub_add_to_cart_apiendpoint');

function thedesignerclub_add_to_cart_apiendpoint($request)
{
    register_rest_route('custom/v1', '/add-to-cart', array(
        'methods' => 'GET',
        'callback' => 'thedesignerclub_add_to_cart',
    ));
}

function thedesignerclub_add_to_cart(WP_REST_Request $request)
{

    global $woocommerce;

    $response = [];
    $product_id = $request->get_param('product_id');
    $quantity = $request->get_param('quantity');
    $booking_start_date = $request->get_param('booking_start_date');
    $booking_end_date = $request->get_param('booking_end_date');

    if (!wc_get_product($product_id)) {

        $response['status_code'] = 400;
        $response['message'] = 'Your cart is currently empty!!!';
    } elseif (empty($booking_start_date)) {
        $response['status_code'] = 400;
        $response['message'] = 'Please select start date!!!';
    } elseif (empty($booking_end_date)) {
        $response['status_code'] = 400;
        $response['message'] = 'Please select end date!!!';
    } else {

        // Load cart functions which are loaded only on the front-end.
        include_once WC_ABSPATH . 'includes/wc-cart-functions.php';
        include_once WC_ABSPATH . 'includes/class-wc-cart.php';

        if (is_null(WC()->cart)) {
            wc_load_cart();
        }

        $item_key = WC()->cart->add_to_cart($product_id, $quantity, 0, array(), array(
            'TO' => $booking_start_date,
            'FROM' => $booking_end_date,
        ));

        // Return response to added item to cart or return error.
        if ($item_key) {

            $data = WC()->cart->get_cart_item($item_key);

            do_action('wc_cart_rest_add_to_cart', $item_key, $data);

            $response['status_code'] = 200;
            $response['data'] = $data;
            $response['message'] = 'Product added to cart successfully!!!';
        } else {
            return new WP_Error('wc_cart_rest_cannot_add_to_cart', sprintf(__('You cannot add "%s" to your cart.', 'cart-rest-api-for-woocommerce'), 'this product'), array('status' => 500));
        }
    }

    return $response;
}

//End Add to cart api endpoint

//Start Contact us, Term&Condition, and privacy policy static content api

add_action('rest_api_init', 'thedesignerclub_term_and_policy_apiendpoint');
function thedesignerclub_term_and_policy_apiendpoint($request)
{

    register_rest_route('wp/v2', 'privacytermapi', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_term_and_policy',
    ));
}
function thedesignerclub_term_and_policy(WP_REST_Request $request)
{

    $response = [];

    $page_name_request = $request->get_param('page_name_request');

    switch ($page_name_request) {
        case 'termcondition':
            $base = get_stylesheet_directory_uri();
            $getfilepath = $base . '/Appfile/termcondition.txt';
            $readfile = file_get_contents($getfilepath);

            $response['title'] = 'TERMS & CONDITIONS';
            $response['status_code'] = 200;
            $response['data'] = $readfile;
            break;

        case 'privacypolicy':

            $base = get_stylesheet_directory_uri();
            $getfilepath = $base . '/Appfile/privacypolicy.txt';
            $readfile = file_get_contents($getfilepath);

            $response['title'] = 'PRIVACY POLICY';
            $response['status_code'] = 200;
            $response['data'] = $readfile;
            break;

        case 'aboutus':
            $base = get_stylesheet_directory_uri();
            $getfilepath = $base . '/Appfile/aboutus.txt';
            $readfile = file_get_contents($getfilepath);

            $response['title'] = 'ABOUT US';
            $response['status_code'] = 200;
            $response['data'] = $readfile;
            break;

        case 'contactus':
            $response['status_code'] = 200;
            $response['data'] =
                [
                    'title' => 'CONTACT THE DESIGNER CLUB',
                    'content1' => 'Need help understanding how our site works, or have a problem regarding any hires?',
                    'content2' => 'feel free to contact us within business hours 9am-5pm, Monday – Sunday.',
                    'email' => 'support@thedesignerclub.com.au',
                    'phonenumber' => '0422454677',
                ];
            break;

        default:
            $response['data'] = 'No found data!!';
            break;
    }

    return $response;
}

//End Contact us, Term&Condition, and privacy policy static content api

//Start FAQ endpoint api

add_action('rest_api_init', 'thedesignerclub_faq_apiendpoint');
function thedesignerclub_faq_apiendpoint($request)
{

    register_rest_route('wp/v2', 'thedesignerclubfaq', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_faq',
    ));
}
function thedesignerclub_faq(WP_REST_Request $request)
{

    $response = [];

    $response['title'] = 'FAQ';
    $response['status_code'] = 200;
    $response['data'] =
        [
            [

                'que' => 'How to send my package?',
                'ans' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of Using Lorem Ipsum is that it has a more-or- less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English',

            ],
            [

                'que' => 'How to Edit Profile?',
                'ans' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of Using Lorem Ipsum is that it has a more-or- less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English',

            ],
            [

                'que' => 'How to Edit Profile?',
                'ans' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of Using Lorem Ipsum is that it has a more-or- less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English',

            ],
            [

                'que' => 'How to Edit Profile?',
                'ans' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of Using Lorem Ipsum is that it has a more-or- less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English',

            ],
            [

                'que' => 'How to Edit Profile?',
                'ans' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of Using Lorem Ipsum is that it has a more-or- less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English',

            ],
        ];

    return $response;
}

//End FAQ endpoint api

//Start Change password api endpoint

add_action('rest_api_init', 'thedesignerclub_profile_changed_password_endpoint');
function thedesignerclub_profile_changed_password_endpoint($request)
{

    register_rest_route('wp/v2', 'profilechangedpassword', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_profile_changed_password',
    ));
}
function thedesignerclub_profile_changed_password(WP_REST_Request $request)
{

    $response = [];
    $user_id = $request->get_param('user_id');
    $current_password = $request->get_param('current_password');
    $new_password = $request->get_param('new_password');

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'You are not logged in Designerclub!!!';
    } elseif (empty($current_password)) {
        $response['status_code'] = 404;
        $response['message'] = 'Please enter a current password!!!';
    } elseif (empty($new_password)) {
        $response['status_code'] = 404;
        $response['message'] = 'Please enter a new password!!!';
    } else {

        $userdata = get_user_by('id', $user_id);
        $wp_check_password = wp_check_password($current_password, $userdata->user_pass, $user_id);

        if ($wp_check_password == $current_password) {
            $response['status_code'] = 200;
            wp_set_password($new_password, $user_id);
            $response['message'] = 'Password changed successfully!!!';
        } else {
            $response['status_code'] = 404;
            $response['message'] = 'Your current password is wrong!!!';
        }
    }

    return $response;
}

//End Change password api endpoint

//Start Update User api endpoint

add_action('rest_api_init', 'thedesignerclub_update_profile_apiendpoint');
function thedesignerclub_update_profile_apiendpoint($request)
{

    register_rest_route('wp/v2', 'update_profile', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_update_profile',
    ));
}
function thedesignerclub_update_profile(WP_REST_Request $request)
{

    $response = [];
    global $wpdb;
    $user_id = $request->get_param('user_id');
    $first_name = $request->get_param('first_name');
    $last_name = $request->get_param('last_name');
    $username = $request->get_param('username');
    $email = $request->get_param('email');
    $phonenumber = $request->get_param('phonenumber');

    $user_profile_image = $request->get_param('user_profile_image');
    $user_passport = $request->get_param('user_passport');
    $user_identity = $request->get_param('user_identity');
    $user_address = $request->get_param('user_address');
    $country_code = $request->get_param('country_code');

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id not found!!!';
    } else {

        $userdata = [
            'ID' => $user_id,
            'user_email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'user_nicename' => $first_name . ' ' . $last_name,
            'display_name' => $first_name . ' ' . $last_name,
            'nickname' => $first_name . ' ' . $last_name,
        ];

        wp_update_user(
            $userdata
        );
        update_user_meta($user_id, 'billing_phone', $phonenumber);
        update_user_meta($user_id, 'shipping_phone', $phonenumber);
        if (!empty($user_profile_image)) {
            update_user_meta($user_id, 'easy_author_avatar_profile_image', 'https://hlink-bhavinp-s3.s3.amazonaws.com/designerclub/userprofile/' . $user_profile_image);
        }
        if (!empty($user_passport)) {
            update_user_meta($user_id, 'user_passport', 'https://hlink-bhavinp-s3.s3.amazonaws.com/designerclub/documents/' . $user_passport);
        }
        if (!empty($user_identity)) {
            update_user_meta($user_id, 'user_identity', 'https://hlink-bhavinp-s3.s3.amazonaws.com/designerclub/documents/' . $user_identity);
        }
        if (!empty($user_address)) {
            update_user_meta($user_id, 'billing_address_1', $user_address);
        }
        if (!empty($country_code)) {
            $table_name = $wpdb->prefix . 'designerclub_custom_userdata_save';
            $data_update = array('wp_designerclub_user_country_code' => $country_code);
            $data_where = array('wp_designerclub_userid' => $user_id);
            $wpdb->update($table_name, $data_update, $data_where);
        }
        $response['status_code'] = 200;
        $response['message'] = 'Your profile has been updated!!!';
    }

    return $response;
}

//End Update User api endpoint

// Start Personal Profile Screen api endpoint

add_action('rest_api_init', 'thedesignerclub_full_personal_profile_api_endpoint');
function thedesignerclub_full_personal_profile_api_endpoint($request)
{

    register_rest_route('wp/v2', 'personal_profile', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_full_personal_profile',
    ));
}
function thedesignerclub_full_personal_profile(WP_REST_Request $request)
{

    $response = [];
    global $wpdb;
    $user_id = $request->get_param('user_id');

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Something went wrong!!!';
    } else {

        $userdata = get_user_by('id', $user_id);

        $easy_author_avatar_profile_image = get_user_meta($user_id, 'easy_author_avatar_profile_image', true);
        $user_passport = get_user_meta($user_id, 'user_passport', true);
        $user_identity = get_user_meta($user_id, 'user_identity', true);
        $user_address = get_user_meta($user_id, 'billing_address_1', true);
        $billing_phone = get_user_meta($user_id, 'billing_phone', true);
        $country_code =  $wpdb->get_var("SELECT wp_designerclub_user_country_code FROM wp_designerclub_custom_userdata_save where wp_designerclub_userid= '$user_id'");

        $response['status_code'] = 200;
        $response['data'] = [
            'ID' => $user_id,
            'display_name' => $userdata->display_name,
            'first_name' => $userdata->user_firstname,
            'last_name' => $userdata->user_lastname,
            'user_name' => $userdata->user_login,
            'user_email' => $userdata->user_email,
            'phone_number' => $billing_phone,
            'user_address' => $user_address,
            'user_profile_image' => $easy_author_avatar_profile_image,
            'user_passport' => $user_passport,
            'user_identity' => $user_identity,
            'country_code' => $country_code,
        ];
        $response['message'] = 'User data fatch successfully!!!';
    }

    return $response;
}

// End Personal Profile Screen api endpoint

//Start Home Page FAQ APi Endpoint

add_action('rest_api_init', 'thedesignerclub_home_faq_apiendpoint');
function thedesignerclub_home_faq_apiendpoint($request)
{

    register_rest_route('wp/v2', 'thedesignerclubhomefaq', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_home_faq',
    ));
}
function thedesignerclub_home_faq(WP_REST_Request $request)
{

    $response = [];

    $response['title'] = 'Home FAQ';
    $response['status_code'] = 200;
    $response['data'] = array(
        0 => array(
            'menuTitle' => 'Lending',
            'data' => array(
                0 => array(
                    'title' => 'Create Your Profile',
                    'answer' => 'Create your very own profile, listing all your Designer ready to wear, bags, shoes and accessories.',
                ),
                1 => array(
                    'title' => 'Security',
                    'answer' => 'Upon checkout the customer will need to provide ID and confirm the terms and conditions. This legally gives you the right to take action on any of your belongings if they were never returned or damaged beyond repair. we provide full support. ',
                ),
                2 => array(
                    'title' => 'Receiving Bookings',
                    'answer' => 'When a Renter books one of your items it will appear in your booking section with all your renters details, your are responsible for getting all your items posted in time for the renters event date.',
                ),
                3 => array(
                    'title' => 'Payments',
                    'answer' => 'All payments will be processed to your nominated bank account within a week after the chosen hire date.',
                ),
            ),
        ),
        1 => array(
            'menuTitle' => 'Renting',
            'data' => array(
                0 => array(
                    'title' => 'When will my item arrive?',
                    'answer' => 'You will receive your items within 2 days of your event, unless you request for your items to be delivered earlier and the lender is able to post it earlier for you. After your 4 or 10 day rental you will need to post the items back providing your lender with a tracking number. Your lender covers your dry cleaning cost.',
                ),
                1 => array(
                    'title' => 'Choose your item',
                    'answer' => 'Browse through hundreds of designer items and request to book your chosen items, every item will be either accepted or denied by the lender within 24 hours If you have any enquiries you will be able to discuss them with the lender who owns the item.',
                ),
                2 => array(
                    'title' => 'Postage',
                    'answer' => '-Express post-Standard post-Same day courier option. You will need to discuss this option with your lender.',
                ),
                3 => array(
                    'title' => 'Payment Methods',
                    'answer' => '-Visa/master, card-Afterpay-Paypal',
                ),
            ),
        ),
    );

    return $response;
}

// End Home Page FAQ APi Endpoint

//Start wishlist api endpoints
function designerclub_custom_wishlist_save_fn($user_id, $product_id)
{

    global $wpdb;

    $thedesignerclub_user_tablename = $wpdb->prefix . 'designerclub_custom_wishlist_save';

    //Save Phone Number With userID in database
    $wpdb->insert($thedesignerclub_user_tablename, array(
        'wp_designerclub_userid' => $user_id,
        'wp_designerclub_productid' => $product_id,
    ));
}

add_action('rest_api_init', 'thedesignerclub_wishlist_api_endpoint');
function thedesignerclub_wishlist_api_endpoint($request)
{

    register_rest_route('wp/v2', 'wishlistapp', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_wishlist_api',
    ));
}
function thedesignerclub_wishlist_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $user_id = $request->get_param('user_id');
    $product_id = $request->get_param('product_id');

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';
    } elseif (empty($product_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Product id is not found!!!';
    } else {

        designerclub_custom_wishlist_save_fn($user_id, $product_id);
        $response['status_code'] = 200;
        $response['data'] = $user_id;
        $response['message'] = 'Product add in wishlist successfully!!!';
    }

    return $response;
}
//End wishlist api endpoints

//Statrt show product wishlist api endpoint

add_action('rest_api_init', 'thedesignerclub_show_wishlist_product_data_api_endpoint');
function thedesignerclub_show_wishlist_product_data_api_endpoint($request)
{

    register_rest_route('wp/v2', 'wishlistdata', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_show_wishlist_product_data_api',
    ));
}
function thedesignerclub_show_wishlist_product_data_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $user_id = $request->get_param('user_id');

    $check = $wpdb->get_results("SELECT * FROM wp_designerclub_custom_wishlist_save WHERE wp_designerclub_userid='" . $user_id . "'");

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';
    } elseif (empty($check)) {
        $response['status_code'] = 404;
        $response['message'] = 'Your wishlist is empty!!!';
    } else {
        $response['status_code'] = 200;
        $response['message'] = 'Product add in wishlist successfully!!!';
        if (!empty($check)) {
            foreach ($check as $wp_formmaker_submits) {

                $product_array[] = $wp_formmaker_submits->wp_designerclub_productid;
            }
        } else {
            $product_array[] = 'Product data not found!!!';
        }
        $productallID = implode(',', array_filter($product_array));
        $response['data'] = $productallID;
    }

    return $response;
}

//End show product wishlist api endpoint

//Start Remove wishlist api endpoint

add_action('rest_api_init', 'thedesignerclub_remove_wishlist_product_data_api_endpoint');
function thedesignerclub_remove_wishlist_product_data_api_endpoint($request)
{

    register_rest_route('wp/v2', 'remove_wishlist_data', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_remove_wishlist_product_data_api',
    ));
}
function thedesignerclub_remove_wishlist_product_data_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $user_id = $request->get_param('user_id');
    $product_id = $request->get_param('product_id');

    $sql = "SELECT `id`, `wp_designerclub_userid`, `wp_designerclub_productid` FROM `wp_designerclub_custom_wishlist_save` WHERE `wp_designerclub_userid`='" . $user_id . "'";

    if (!empty($product_id)) {
        $sql .= " AND `wp_designerclub_productid`='" . $product_id . "'";
    }

    $check = $wpdb->get_results($sql);

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';
    } else {
        if (!empty($check)) {

            foreach ($check as $key => $value) {
                $wpdb->delete('wp_designerclub_custom_wishlist_save', array('id' => $value->id));
                $response['status_code'] = 200;
                $response['data'] = $value->id;
                $response['message'] = 'Product removed from wishlist successfully!!!';
            }
        }
    }

    return $response;
}

//End Remove wishlist api endpoint

// Start Add Vendor data in rest api for woocomerce
add_filter('woocommerce_rest_prepare_product_object', 'filter_product_response', 10, 3);
function filter_product_response($response, $post, $request)
{
    // Customize response data here
    $product_id = $post->get_id();

    $vendor_Id = get_post_field('post_author', $product_id);
    $user = get_user_by('id', $vendor_Id);

    $vendor_image = esc_url(get_avatar_url($vendor_Id));
    $vendor_first_name = $user->user_firstname;
    $vendor_last_name = $user->user_lastname;
    $vendor_email = $user->user_email;

    $response->data["vendor_Id"] = $vendor_Id;
    $response->data["vendor_image_url"] = $vendor_image;
    $response->data["vendor_email"] = $vendor_email;
    $response->data["vendor_name"] = $vendor_first_name . ' ' . $vendor_last_name;

    return $response;
}
// End Add Vendor data in rest api for woocomerce

// Start top renters api endpoint

function top_renters_get_product_id()
{

    $str_array = array();
    $productidarray = array();

    $vendor_response = [];

    $product_args['post_type'] = 'product';
    $product_args['post_status'] = 'publish';
    $product_args['posts_per_page'] = 50;
    $product_args['meta_key'] = 'total_sales';
    $product_args['orderby'] = 'rand';

    $product_loop = new WP_Query($product_args);
    if ($product_loop->have_posts()) {
        while ($product_loop->have_posts()) {

            $product_loop->the_post();

            $product_id = get_the_ID();

            $vendor_Id = get_post_field('post_author', $product_id);
            $str_array[] = (int) $vendor_Id;
            $array_unique = array_unique($str_array);
        }
        wp_reset_postdata();
    }

    if (!empty($array_unique)) {
        foreach ($array_unique as $vandorkey => $vandorname) {

            $user = get_user_by('id', $vandorname);

            $vendor_image = esc_url(get_avatar_url($vandorname));
            $vendor_first_name = $user->user_firstname;
            $vendor_last_name = $user->user_lastname;

            $temp_array = array();

            $temp_array['vendor_ID'] = $user->ID;
            $temp_array['vendor_image'] = $vendor_image;
            $temp_array['vendor_full_name'] = $vendor_first_name . ' ' . $vendor_last_name;

            $vendor_response[] = $temp_array;
        }
    }

    return $vendor_response;
}

add_action('rest_api_init', 'thedesignerclub_top_renters_data_api_endpoint');
function thedesignerclub_top_renters_data_api_endpoint($request)
{

    register_rest_route('wp/v2', 'top_renters', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_top_renters_data_api',
    ));
}
function thedesignerclub_top_renters_data_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];

    $response['status_code'] = 200;
    $response['data'] = top_renters_get_product_id();
    $response['message'] = 'Product removed from wishlist successfully!!!';

    return $response;
}

// End top renters api endpoint

// Start Top renters single page api endpoints

function top_renters_get_product_details($vendor_ID)
{

    $response = [];

    $product_args2['post_type'] = 'product';
    $product_args2['post_status'] = 'publish';
    $product_args2['posts_per_page'] = -1;
    $product_args2['orderby'] = 'rand';
    $product_args2['author'] = $vendor_ID;

    $the_query = new WP_Query($product_args2);

    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {

            global $product;

            $terms = array();

            $the_query->the_post();

            $product_id = $the_query->post->ID;

            $alldatapass = array();

            $alldatapass['product_id'] = $product_id;
            $alldatapass['product_title'] = get_the_title();
            $test = wp_get_object_terms($product_id, 'product_cat');
            $alldatapass['product_term'] = $test;

            $response[] = $alldatapass;
        }
        wp_reset_postdata();
    }

    return $response;
}

add_action('rest_api_init', 'thedesignerclub_top_renters_details_api_endpoint');
function thedesignerclub_top_renters_details_api_endpoint($request)
{

    register_rest_route('wp/v2', 'toprenters_details', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_top_renters_details_api',
    ));
}
function thedesignerclub_top_renters_details_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];

    $vendor_ID = $request->get_param('vendor_ID');

    if (empty($vendor_ID)) {
        $response['status_code'] = 404;
        $response['message'] = 'Something went wrong please try again!!!';
    } else {
        $response['status_code'] = 200;
        $response['data'] = top_renters_get_product_details($vendor_ID);
        $response['message'] = 'Top renters details data fetch successfully!!!';
    }

    return $response;
}

// End Top renters single page api endpoints

// Start save billing address api endpoints

add_action('rest_api_init', 'thedesignerclub_save_multiple_billing_address_api_endpoint');
function thedesignerclub_save_multiple_billing_address_api_endpoint($request)
{

    register_rest_route('wp/v2', 'save_billing_address', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_save_multiple_billing_address_api',
    ));
}
function thedesignerclub_save_multiple_billing_address_api(WP_REST_Request $request)
{

    global $wpdb;

    $billing_address_array = array();

    $response = [];

    $user_id = $request->get_param('user_id');
    $billing_first_name = $request->get_param('billing_first_name');
    $billing_last_name = $request->get_param('billing_last_name');
    $billing_country = $request->get_param('billing_country');
    $billing_address_1 = $request->get_param('billing_address_1');
    $billing_city = $request->get_param('billing_city');
    $billing_state = $request->get_param('billing_state');
    $billing_postcode = $request->get_param('billing_postcode');
    $billing_phone = $request->get_param('billing_phone');
    $billing_email = $request->get_param('billing_email');

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';
    } elseif (empty($billing_first_name)) {
        $response['status_code'] = 404;
        $response['message'] = 'Billing First name is a required field!!!';
    } elseif (empty($billing_last_name)) {
        $response['status_code'] = 404;
        $response['message'] = 'Billing Last name is a required field!!!';
    } elseif (empty($billing_country)) {
        $response['status_code'] = 404;
        $response['message'] = 'Billing Country / Region is a required field!!!';
    } elseif (empty($billing_address_1)) {
        $response['status_code'] = 404;
        $response['message'] = 'Billing Street address is a required field!!!';
    } elseif (empty($billing_city)) {
        $response['status_code'] = 404;
        $response['message'] = 'Billing Town / City is a required field!!!';
    } elseif (empty($billing_state)) {
        $response['status_code'] = 404;
        $response['message'] = 'Billing State / County is a required field!!!';
    } elseif (empty($billing_postcode)) {
        $response['status_code'] = 404;
        $response['message'] = 'Billing Postcode / ZIP is a required field!!!';
    } elseif (empty($billing_phone)) {
        $response['status_code'] = 404;
        $response['message'] = 'Billing Phone is a required field!!!';
    } elseif (empty($billing_email)) {
        $response['status_code'] = 404;
        $response['message'] = 'Billing Email address is a required field!!!';
    } else {

        $addaddress = array();
        $billingarray = array();
        $default_billing = array();

        $firstaddressarray = array();

        $set_default_billing = ($set_default_billing) ? $set_default_billing : 'address_0';

        $merger_address = get_user_meta($user_id, 'thwma_custom_address', true);

        if (!empty($merger_address['billing'])) {
            $i = 0;
            foreach ($merger_address as $key => $value) {
                if ($key == 'billing') {
                    $count = count($value);
                    $newcount = $count + $i;
                    $addaddress['address_' . $newcount . ''] = array(
                        'billing_heading' => 'Home',
                        'billing_first_name' => $billing_first_name,
                        'billing_last_name' => $billing_last_name,
                        'billing_country' => $billing_country,
                        'billing_address_1' => $billing_address_1,
                        'billing_city' => $billing_city,
                        'billing_state' => $billing_state,
                        'billing_postcode' => $billing_postcode,
                        'billing_phone' => $billing_phone,
                        'billing_email' => $billing_email,
                    );
                    $appendnewaddress = array_merge($value, $addaddress);
                    $billingarray['billing'] = $appendnewaddress;
                    $default_billing['default_billing'] = 'address_' . $newcount . '';
                    $appendnewaddress2 = array_merge($billingarray, $default_billing);
                    update_user_meta($user_id, 'thwma_custom_address', $appendnewaddress2);
                }
                $i++;
            }
        } else {

            $firstaddressarray['address_0'] = array(
                'billing_heading' => 'Home',
                'billing_first_name' => $billing_first_name,
                'billing_last_name' => $billing_last_name,
                'billing_country' => $billing_country,
                'billing_address_1' => $billing_address_1,
                'billing_city' => $billing_city,
                'billing_state' => $billing_state,
                'billing_postcode' => $billing_postcode,
                'billing_phone' => $billing_phone,
                'billing_email' => $billing_email,
            );
            $billingarray['billing'] = $firstaddressarray;
            $default_billing['default_billing'] = 'address_0';
            $appendnewaddress2 = array_merge($billingarray, $default_billing);
            update_user_meta($user_id, 'thwma_custom_address', $appendnewaddress2);
        }

        $response['status_code'] = 200;
        $response['message'] = 'Billing address successfully added!!!';
    }

    return $response;
}

add_action('rest_api_init', 'thedesignerclub_show_multiple_billing_address_api_endpoint');
function thedesignerclub_show_multiple_billing_address_api_endpoint($request)
{

    register_rest_route('wp/v2', 'show_billing_address', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_show_multiple_billing_address_api',
    ));
}
function thedesignerclub_show_multiple_billing_address_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];

    $user_id = $request->get_param('user_id');

    $custom_address = get_user_meta($user_id, 'thwma_custom_address', true);

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';
    } elseif (empty($custom_address['billing'])) {
        $response['status_code'] = 404;
        $response['message'] = 'No address found!!!';
    } else {

        $response['status_code'] = 200;
        $response['message'] = 'Address found successfully!!!';
        $response['data'] = $custom_address;
    }

    return $response;
}

add_action('rest_api_init', 'thedesignerclub_default_multiple_billing_address_api_endpoint');
function thedesignerclub_default_multiple_billing_address_api_endpoint($request)
{

    register_rest_route('wp/v2', 'default_billing_address', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_default_multiple_billing_address_api',
    ));
}
function thedesignerclub_default_multiple_billing_address_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];

    $user_id = $request->get_param('user_id');
    $set_default_billing = $request->get_param('set_default_billing');
    $default_address = get_user_meta($user_id, 'thwma_custom_address', true);

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';
    } elseif (empty($set_default_billing)) {
        $response['status_code'] = 404;
        $response['message'] = 'Address not found!!!';
    } else {
        if (!empty($default_address)) {
            foreach ($default_address['billing'] as $key => $value) {

                if ($set_default_billing == $key) {

                    update_user_meta($user_id, 'billing_first_name', $value['billing_first_name']);
                    update_user_meta($user_id, 'billing_last_name', $value['billing_last_name']);
                    update_user_meta($user_id, 'billing_country', $value['billing_country']);
                    update_user_meta($user_id, 'billing_address_1', $value['billing_address_1']);
                    update_user_meta($user_id, 'billing_city', $value['billing_city']);
                    update_user_meta($user_id, 'billing_state', $value['billing_state']);
                    update_user_meta($user_id, 'billing_postcode', $value['billing_postcode']);
                    update_user_meta($user_id, 'billing_phone', $value['billing_phone']);
                    update_user_meta($user_id, 'billing_email', $value['billing_email']);
                }
            }
            $default_address['default_billing'] = $set_default_billing;
            update_user_meta($user_id, 'thwma_custom_address', $default_address);

            $response['status_code'] = 200;
            $response['data'] = $set_default_billing;
            $response['message'] = 'Set default Billing address successfully!!!';
        }
    }

    return $response;
}

// Start delete address

add_action('rest_api_init', 'thedesignerclub_delete_billing_address_api_endpoint');
function thedesignerclub_delete_billing_address_api_endpoint($request)
{

    register_rest_route('wp/v2', 'delete_billing_address', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_delete_billing_address_api',
    ));
}
function thedesignerclub_delete_billing_address_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];

    $user_id = $request->get_param('user_id');
    $delete_billing_key_address = $request->get_param('delete_billing_key_address');
    $default_address = get_user_meta($user_id, 'thwma_custom_address', true);

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';
    } elseif (empty($delete_billing_key_address)) {
        $response['status_code'] = 404;
        $response['message'] = 'Address not found!!!';
    } else {

        if (!empty($default_address)) {

            if ($default_address['default_billing'] == $delete_billing_key_address) {
                $response['status_code'] = 404;
                $response['data'] = $delete_billing_key_address;
                $response['message'] = 'Default address can not be deleted!!!';
            } else {

                unset($default_address['billing'][$delete_billing_key_address]);
                update_user_meta($user_id, 'thwma_custom_address', $default_address);

                $response['status_code'] = 200;
                $response['data'] = $delete_billing_key_address;
                $response['message'] = 'Delete Billing address successfully!!!';
            }
        } else {
            update_user_meta($user_id, 'billing_first_name', false);
            update_user_meta($user_id, 'billing_last_name', false);
            update_user_meta($user_id, 'billing_country', false);
            update_user_meta($user_id, 'billing_address_1', false);
            update_user_meta($user_id, 'billing_city', false);
            update_user_meta($user_id, 'billing_state', false);
            update_user_meta($user_id, 'billing_postcode', false);
            update_user_meta($user_id, 'billing_phone', false);
            update_user_meta($user_id, 'billing_email', false);
        }
    }

    return $response;
}

// End delete address

// Start edit address

add_action('rest_api_init', 'thedesignerclub_edit_billing_address_api_endpoint');
function thedesignerclub_edit_billing_address_api_endpoint($request)
{

    register_rest_route('wp/v2', 'edit_billing_address', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_edit_billing_address_api',
    ));
}
function thedesignerclub_edit_billing_address_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];

    $user_id = $request->get_param('user_id');
    $edit_billing_key_address = $request->get_param('edit_billing_key_address');

    $billing_first_name = $request->get_param('billing_first_name');
    $billing_last_name = $request->get_param('billing_last_name');
    $billing_country = $request->get_param('billing_country');
    $billing_address_1 = $request->get_param('billing_address_1');
    $billing_city = $request->get_param('billing_city');
    $billing_state = $request->get_param('billing_state');
    $billing_postcode = $request->get_param('billing_postcode');
    $billing_phone = $request->get_param('billing_phone');
    $billing_email = $request->get_param('billing_email');

    $default_address = get_user_meta($user_id, 'thwma_custom_address', true);

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';
    } elseif (empty($edit_billing_key_address)) {
        $response['status_code'] = 404;
        $response['message'] = 'Address not found!!!';
    } elseif (empty($billing_first_name)) {
        $response['status_code'] = 404;
        $response['message'] = 'Billing First name is a required field!!!';
    } elseif (empty($billing_last_name)) {
        $response['status_code'] = 404;
        $response['message'] = 'Billing Last name is a required field!!!';
    } elseif (empty($billing_country)) {
        $response['status_code'] = 404;
        $response['message'] = 'Billing Country / Region is a required field!!!';
    } elseif (empty($billing_address_1)) {
        $response['status_code'] = 404;
        $response['message'] = 'Billing Street address is a required field!!!';
    } elseif (empty($billing_city)) {
        $response['status_code'] = 404;
        $response['message'] = 'Billing Town / City is a required field!!!';
    } elseif (empty($billing_state)) {
        $response['status_code'] = 404;
        $response['message'] = 'Billing State / County is a required field!!!';
    } elseif (empty($billing_postcode)) {
        $response['status_code'] = 404;
        $response['message'] = 'Billing Postcode / ZIP is a required field!!!';
    } elseif (empty($billing_phone)) {
        $response['status_code'] = 404;
        $response['message'] = 'Billing Phone is a required field!!!';
    } elseif (empty($billing_email)) {
        $response['status_code'] = 404;
        $response['message'] = 'Billing Email address is a required field!!!';
    } else {

        if (!empty($default_address)) {

            $response['status_code'] = 200;
            $response['oldaddress'] = $default_address['billing'][$edit_billing_key_address];

            $replacements = array(
                'billing_first_name' => $billing_first_name,
                'billing_last_name' => $billing_last_name,
                'billing_country' => $billing_country,
                'billing_address_1' => $billing_address_1,
                'billing_city' => $billing_city,
                'billing_state' => $billing_state,
                'billing_postcode' => $billing_postcode,
                'billing_phone' => $billing_phone,
                'billing_email' => $billing_email,
            );

            $default_address['billing'][$edit_billing_key_address] = $replacements;
            update_user_meta($user_id, 'thwma_custom_address', $default_address);
            $response['newaddress'] = $default_address;
            $response['message'] = 'Save Billing address successfully!!!';
        }
    }

    return $response;
}

// End edit address

// End save billing address api endpoints

//Start Check phone number uniq api ednpoint

add_action('rest_api_init', 'thedesignerclub_check_phonenumber_uniq_api_ednpoint');
function thedesignerclub_check_phonenumber_uniq_api_ednpoint($request)
{

    register_rest_route('wp/v2', 'check_uniqphonenumber', array(
        'methods' => 'GET',
        'callback' => 'thedesignerclub_check_phonenumber_uniq_api',
    ));
}
function thedesignerclub_check_phonenumber_uniq_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $phone_number = $request->get_param('phone_number');

    $check = $wpdb->get_results("SELECT * FROM wp_designerclub_custom_userdata_save");

    $response['data'] = $check;

    if (empty($check)) {
        $response['status_code'] = 404;
        $response['message'] = 'We can\'t find data for mobile number!!!';
    } else {

        $response['status_code'] = 200;
        $response['data'] = $check;
        $response['message'] = 'All mobile number fetch successfully!!!';
    }
    return $response;
}

//End Check phone number uniq api ednpoint

// Start Total Ering api endpoint

function get_commission_products($user_id)
{
    global $wpdb;

    $vendor_products = array();
    $ids = array();
    $sql = '';

    $sql .= "SELECT product_id FROM {$wpdb->prefix}pv_commission WHERE vendor_id = {$user_id} ";

    $sql .= " AND status != 'reversed' GROUP BY product_id";

    $results = $wpdb->get_results($sql);

    foreach ($results as $value) {
        $ids[] = $value->product_id;
    }

    if (!empty($ids)) {
        $vendor_products = get_posts(
            array(
                'numberposts' => -1,
                'post_type' => array('product', 'product_variation'),
                'order' => 'DESC',
                'include' => $ids,
            )
        );
    }

    return $vendor_products;
}

add_action('rest_api_init', 'thedesignerclub_user_total_earning_api_ednpoint');
function thedesignerclub_user_total_earning_api_ednpoint($request)
{

    register_rest_route('wp/v2', 'user_total_earning', array(
        'methods' => 'GET',
        'callback' => 'thedesignerclub_user_total_earning_api',
    ));
}
function thedesignerclub_user_total_earning_api(WP_REST_Request $request)
{

    $response = [];

    $user_id = $request->get_param('user_id');

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';
    } else {
        $vendor_products = get_commission_products($user_id);
        $total_cost = array();
        if (isset($vendor_products) && !empty($vendor_products)) {
            foreach ($vendor_products as $product) {
                global $wpdb;
                $order_status = array('wc-completed', 'wc-processing');
                $results = $wpdb->get_col("
                          SELECT order_items.order_id
                          FROM {$wpdb->prefix}woocommerce_order_items as order_items
                          LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
                          LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
                          WHERE posts.post_type = 'shop_order'
                          AND posts.post_status IN ( '" . implode("','", $order_status) . "' )
                          AND order_items.order_item_type = 'line_item'
                          AND order_item_meta.meta_value = '$product->ID'
                    ");

                foreach ($results as $order_id) {
                    $order = new WC_Order($order_id);
                    $items = $order->get_items();
                    foreach ($items as $item) {
                        $total = $item->get_total();
                        $commission_rate = WCV_Commission::get_commission_rate($product_id);
                        $commission_price = $total * $commission_rate / 100;

                        if (!$ID = $item->get_product_id()) {
                            continue;
                        }
                        // get accpect/reject status
                        $accept_reject_lender =
                            get_user_meta($user_id, 'vendor_report_accept_reject_lender_' . $order_id . '_' . $ID, true);

                        $accept_reject_admin = null;

                        if (empty($accept_reject)) {
                            $accept_reject_admin =
                                get_user_meta($user_id, 'vendor_report_accept_reject_admin_' . $order_id . '_' . $ID, true);
                        }

                        if (!empty($accept_reject_lender) || !empty($accept_reject_admin)) {
                            if ((empty($accept_reject_lender) || $accept_reject_lender == 'accepted') && (empty($accept_reject_admin) || $accept_reject_admin == 'accepted')) {
                                $total_cost[] = $commission_price;
                            }
                        }
                    }
                }
            }
        }
        $total_commision = array_sum($total_cost);
        $response['status_code'] = 200;
        $response['data'] = $total_commision;
    }
    return $response;
}

// End Total Ering api endpoint

// Start search filter api endpoint

add_action('rest_api_init', 'thedesignerclub_search_with_meta_query_api_ednpoint');
function thedesignerclub_search_with_meta_query_api_ednpoint($request)
{

    register_rest_route('wp/v2', 'custom_meta_with_search', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_search_with_meta_query_api',
    ));
}

function thedesignerclub_search_with_meta_query_api(WP_REST_Request $request)
{

    $response = [];
    $metaarr = [];

    $keyword = $request->get_param('keyword');
    $min_price = $request->get_param('min_price');
    $max_price = $request->get_param('max_price');
    $size = $request->get_param('size');
    $color = $request->get_param('color');
    $category = $request->get_param('category');

    if (!empty($min_price) && !empty($max_price)) {
        $metaarr[] = array(
            'key' => 'rrp',
            'value' => array($min_price, $max_price),
            'type' => 'DECIMAL',
            'compare' => 'BETWEEN',
        );
    }

    if (!empty($size)) {
        $metaarr[] = array(
            'key' => 'pa_size',
            'value' => $size,
            'compare' => '=',
        );
    }

    if (!empty($color)) {
        $metaarr[] = array(
            'key' => 'pa_color',
            'value' => $color,
            'compare' => '=',
        );
    }

    if (!empty($metaarr)) {

        $meta_query = array(
            'relation' => 'AND',
            $metaarr,
        );
    }

    if (!empty($category)) {
        $tax_query = array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $category,
            ),
        );
    }

    if (!empty($keyword)) {
        $product_args['post_type'] = 'product';
        $product_args['s'] = $keyword;
        $product_args['post_status'] = 'publish';
        $product_args['posts_per_page'] = -1;
        $product_args['orderby'] = 'title';
        $product_args['order'] = 'ASC';
        if (!empty($meta_query)) {
            $product_args['meta_query'] = $meta_query;
        }
        if (!empty($tax_query)) {
            $product_args['tax_query'] = $tax_query;
        }
    } else {
        $product_args['post_type'] = 'product';
        $product_args['post_status'] = 'publish';
        $product_args['posts_per_page'] = -1;
        $product_args['orderby'] = 'title';
        $product_args['order'] = 'ASC';
        if (!empty($meta_query)) {
            $product_args['meta_query'] = $meta_query;
        }
        if (!empty($tax_query)) {
            $product_args['tax_query'] = $tax_query;
        }
    }

    $product_loop = new WP_Query($product_args);

    if ($product_loop->have_posts()) {
        while ($product_loop->have_posts()) {
            $product_loop->the_post();

            $product_ID = get_the_ID();

            $response['data'][] = $product_ID;
        }
        wp_reset_postdata();

        $response['status_code'] = 200;
        $response['message'] = 'Product searching successfully!!!';
    } else {
        $response['status_code'] = 404;
        $response['message'] = 'Apologies, but no results were found. Perhaps searching will help find a related post.';
    }

    return $response;
}

// End search filter api endpoint

// Start search filter api endpoint

add_action('rest_api_init', 'thedesignerclub_search_custom_filter_api_ednpoint');
function thedesignerclub_search_custom_filter_api_ednpoint($request)
{

    register_rest_route('wp/v2', 'search_custom_filter', array(
        'methods' => 'GET',
        'callback' => 'thedesignerclub_search_custom_filter_api',
    ));
}
function thedesignerclub_search_custom_filter_api(WP_REST_Request $request)
{

    $response = [];

    global $wpdb;

    //Product price code

    $results = $wpdb->get_results("SELECT meta_value FROM wp_postmeta WHERE meta_key = 'rental_price'");

    $prices = array();


    foreach ($results as $result) {
        $prices[] = $result->meta_value;
    }
    /*  echo "<pre>";
    print_r($prices);
    echo "</pre>"; */
    $response['prices'] = array(
        'min_price' => min($prices), //0, 
        'max_price' => max($prices), //600,
    );

    //End Product price code

    //Attribute getting code

    $size_attribute_terms = get_terms(array(
        'taxonomy' => 'pa_size',
        'hide_empty' => false,
    ));

    $response['size_attributes'] = $size_attribute_terms;
   

    //End Attribute getting code

    //Color code getting

    $color_attribute_terms = get_terms(array(
        'taxonomy' => 'pa_color',
        'hide_empty' => false,
    ));

    $response['color_attributes'] = $color_attribute_terms;

    //End Color code getting

    //Product category getting code

    $product_categories = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
    ));

    $response['categories'] = $product_categories;


    //End Product category getting code

    return $response;
}

// End search filter api endpoint

// Start Post_Author set api when create product api endpoint

add_action('rest_api_init', 'add_product_set_post_author_api_endpoint');
function add_product_set_post_author_api_endpoint($request)
{

    register_rest_route('wp/v2', 'add_product_set_post_author', array(
        'methods' => 'POST',
        'callback' => 'add_product_set_post_author_api',
    ));
}
function add_product_set_post_author_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];

    $product_id = $request->get_param('product_id');
    $user_id = $request->get_param('user_id');

    if (empty($product_id) || empty($user_id)) {

        $response['status_code'] = 404;
        $response['message'] = 'Something went wrong!!!';
    } else {

        $data = $wpdb->query($wpdb->prepare("UPDATE `wp_posts` SET `post_author` = %s WHERE ID= %s", array($user_id, $product_id)));
        $response['status_code'] = 200;
        $response['data'] = $data;
        $response['message'] = 'Successfully';
    }

    return $response;
}

// End Post_Author set api when create product api endpoint

// Start Payout details api endpoint

add_action('rest_api_init', 'set_payout_details_api_endpoint');
function set_payout_details_api_endpoint($request)
{

    register_rest_route('wp/v2', 'set_payout_details', array(
        'methods' => 'POST',
        'callback' => 'set_payout_details_api',
    ));
}
function set_payout_details_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];

    $user_id = $request->get_param('user_id');
    $user_account_name = $request->get_param('user_account_name');
    $user_account_number = $request->get_param('user_account_number');
    $user_bsb = $request->get_param('user_bsb');

    if (empty($user_id)) {

        $response['status_code'] = 404;
        $response['message'] = 'Something went wrong!!!';
    } elseif (empty($user_account_name)) {

        $response['status_code'] = 404;
        $response['message'] = 'Please enter your account name!!!';
    } elseif (empty($user_account_number)) {

        $response['status_code'] = 404;
        $response['message'] = 'Please enter your account number!!!';
    } elseif (empty($user_bsb)) {

        $response['status_code'] = 404;
        $response['message'] = 'Please enter your account BSB!!!';
    } else {

        update_user_meta($user_id, 'user_account_name', $user_account_name);
        update_user_meta($user_id, 'user_account_number', $user_account_number);
        update_user_meta($user_id, 'user_bsb', $user_bsb);
        $response['status_code'] = 200;
        $response['data'] = $user_id;
        $response['message'] = 'Your payout details has been added!!!';
    }

    return $response;
}

// End Payout details api endpoint

//Start Payout details GET api ednpoint

add_action('rest_api_init', 'thedesignerclub_check_get_payout_details_api_ednpoint');
function thedesignerclub_check_get_payout_details_api_ednpoint($request)
{

    register_rest_route('wp/v2', 'get_payout_details', array(
        'methods' => 'GET',
        'callback' => 'thedesignerclub_get_payout_details_api',
    ));
}
function thedesignerclub_get_payout_details_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $user_id = $request->get_param('user_id');

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Something went wrong!!!';
    } else {

        $user_account_name = get_user_meta($user_id, 'user_account_name', true);
        $user_account_number = get_user_meta($user_id, 'user_account_number', true);
        $user_bsb = get_user_meta($user_id, 'user_bsb', true);

        $response['status_code'] = 200;
        $response['data'] = array(

            'user_account_name' => $user_account_name,
            'user_account_number' => $user_account_number,
            'user_bsb' => $user_bsb,
        );
        $response['message'] = 'Your payout details fetch has been successfully!!!';
    }
    return $response;
}

//End Payout details GET api ednpoint

//Start notification api endpoints
function designerclub_notification_token_save_fn($user_id, $notification_token)
{

    global $wpdb;

    $thedesignerclub_user_tablename = $wpdb->prefix . 'designerclub_notification_token';

    //Save Phone Number With userID in database
    $wpdb->insert($thedesignerclub_user_tablename, array(
        'user_id' => $user_id,
        'notification_token' => $notification_token,
    ));
}

add_action('rest_api_init', 'thedesignerclub_notification_api_endpoint');
function thedesignerclub_notification_api_endpoint($request)
{

    register_rest_route('wp/v2', 'notification', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_notification_api',
    ));
}
function thedesignerclub_notification_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $user_id = $request->get_param('user_id');
    $notification_token = $request->get_param('notification_token');

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';
    } elseif (empty($notification_token)) {
        $response['status_code'] = 404;
        $response['message'] = 'Notification token is missing!!!';
    } else {
        designerclub_notification_token_save_fn($user_id, $notification_token);
        $response['status_code'] = 200;
        $response['data'] = array(
            'user_id' => $user_id,
            'notification_token' => $notification_token,
        );
        $response['message'] = 'Notification token add in successfully!!!';
    }

    return $response;
}
//End notification api endpoints

// Ticket system file enque

function create_support_ticket_post_type()
{
    register_post_type(
        'support_ticket',
        array(
            'labels' => array(
                'name' => 'Support Tickets',
                'singular_name' => 'Support Ticket',
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor'),
        )
    );
}
add_action('init', 'create_support_ticket_post_type');

function add_support_ticket_custom_fields()
{
    add_meta_box('support_ticket_custom_fields', 'Support Ticket Details', 'display_support_ticket_custom_fields', 'support_ticket', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_support_ticket_custom_fields');

function display_support_ticket_custom_fields($post)
{
    $ticket_status = get_post_meta($post->ID, 'ticket_status', true);
    $user_id = get_post_meta($post->ID, 'user_id', true);
    $archive_status = get_post_meta($post->ID, 'archive_status', true);
    ?>
    <p>
        <label for="ticket_status">Ticket Status:</label>
        <select id="ticket_status" name="ticket_status">
            <option value="pending" <?php selected($ticket_status, 'pending'); ?>>Pending</option>
            <option value="completed" <?php selected($ticket_status, 'completed'); ?>>Completed</option>
        </select>
    </p>
    <p>
        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" value="<?php echo $user_id; ?>" readonly>
    </p>
    <p>
        <label for="archive_status">Archive status:</label>
        <input type="text" name="archive_status" value="<?php echo $archive_status; ?>" readonly>
    </p>
<?php
}

function save_support_ticket_custom_fields($post_id)
{
    if (array_key_exists('ticket_status', $_POST)) {
        update_post_meta($post_id, 'ticket_status', $_POST['ticket_status']);
    }
    if (array_key_exists('user_id', $_POST)) {
        update_post_meta($post_id, 'user_id', $_POST['user_id']);
    }
    if (array_key_exists('archive_status', $_POST)) {
        update_post_meta($post_id, 'archive_status', $_POST['archive_status']);
    }
}
add_action('save_post', 'save_support_ticket_custom_fields');

// Start Generate enquiry api endpoin

add_action('rest_api_init', 'thedesignerclub_generate_enquiry_api_endpoint');
function thedesignerclub_generate_enquiry_api_endpoint($request)
{

    register_rest_route('wp/v2', 'generate_enquiry', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_generate_enquiry_api',
    ));
}
function thedesignerclub_generate_enquiry_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $user_id = $request->get_param('user_id');
    $subject = $request->get_param('subject');
    $description = $request->get_param('description');

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';
    } elseif (empty($subject)) {
        $response['status_code'] = 404;
        $response['message'] = 'Subject is missing!!!';
    } elseif (empty($description)) {
        $response['status_code'] = 404;
        $response['message'] = 'Description is missing!!!';
    } else {

        // Gather post data.
        $my_post = array(
            'post_type' => 'support_ticket',
            'post_title' => $subject,
            'post_content' => $description,
            'post_status' => 'publish',
            'meta_input' => array(
                'user_id' => $user_id,
                'ticket_status' => 'pending',
                'archive_status' => 'unarchive',
            ),
        );

        // Insert the post into the database.
        wp_insert_post($my_post);
        $response['status_code'] = 200;
        $response['data'] = $my_post;
        $response['message'] = 'Generate enquiry successfully!!!';
    }

    return $response;
}

// End Generate enquiry api endpoint

// Start List Generate enquiry api endpoint

add_action('rest_api_init', 'thedesignerclub_enquiry_list_api_endpoint');
function thedesignerclub_enquiry_list_api_endpoint($request)
{

    register_rest_route('wp/v2', 'enquiry_list', array(
        'methods' => 'GET',
        'callback' => 'thedesignerclub_enquiry_list_api',
    ));
}
function thedesignerclub_enquiry_list_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $user_id = $request->get_param('user_id');
    $archive_status = $request->get_param('archive_status');

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';
    } else {

        $support_ticket_meta_query = array(
            'relation' => 'AND',
            array(
                'key' => 'user_id',
                'value' => $user_id,
                'compare' => 'IN',
            ),
            array(
                'key' => 'archive_status',
                'value' => $archive_status,
                'compare' => '=',
            ),
        );

        $support_ticket_args['post_type'] = 'support_ticket';
        $support_ticket_args['post_status'] = 'publish';
        $support_ticket_args['posts_per_page'] = -1;
        $support_ticket_args['meta_query'] = $support_ticket_meta_query;

        $support_ticket_loop = new WP_Query($support_ticket_args);

        if ($support_ticket_loop->have_posts()) {
            while ($support_ticket_loop->have_posts()) {
                $support_ticket_loop->the_post();

                $response['data'][] = array(
                    'postData' => get_post(get_the_ID()),
                    'postMeta' => get_post_meta(get_the_ID()),
                );
            }
            wp_reset_postdata();
            $response['status_code'] = 200;
            $response['message'] = 'Generate enquiry list successfully!!!';
        } else {
            $response['status_code'] = 404;
            $response['message'] = 'No enquiry list found!!!';
        }
    }

    return $response;
}

// End List Generate enquiry api endpoint

// Start archive status generate enquiry api endpoint

add_action('rest_api_init', 'thedesignerclub_enquiry_status_api_endpoint');
function thedesignerclub_enquiry_status_api_endpoint($request)
{

    register_rest_route('wp/v2', 'enquiry_status', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_enquiry_status_api',
    ));
}
function thedesignerclub_enquiry_status_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $post_id = $request->get_param('post_id');
    $archive = $request->get_param('archive');

    if (empty($post_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Post id is not found!!!';
    } else {

        if ($archive == 'delete') {
            wp_delete_post($post_id);
            $response['status_code'] = 200;
            $response['data'] = $post_id;
            $response['message'] = 'Enquiry deleted successfully!!!';
        } else {
            update_post_meta($post_id, 'archive_status', $archive);
            $response['status_code'] = 200;
            $response['data'] = $archive;
            $response['message'] = 'Enquiry status updated successfully!!!';
        }
    }

    return $response;
}

// End archive status generate enquiry api endpoint

// Start Chat enquiry api endpoint

function designerclub_enquiry_chat_save_fn($post_id, $discussion, $role_type, $chat_type)
{

    global $wpdb;

    $designerclub_support_ticket_enquiry = $wpdb->prefix . 'designerclub_support_ticket_enquiry';

    //Save Phone Number With userID in database
    $wpdb->insert($designerclub_support_ticket_enquiry, array(
        'post_id' => $post_id,
        'discussion' => $discussion,
        'role_type' => $role_type,
        'chat_type' => $chat_type,
    ));
}

add_action('rest_api_init', 'thedesignerclub_chat_enquiry_api_endpoint');
function thedesignerclub_chat_enquiry_api_endpoint($request)
{

    register_rest_route('wp/v2', 'enquiry_chat', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_chat_enquiry_api',
    ));
}
function thedesignerclub_chat_enquiry_api(WP_REST_Request $request)
{

    $response = [];
    $post_id = $request->get_param('post_id');
    $discussion = $request->get_param('discussion');
    $role_type = $request->get_param('role_type');
    $chat_type = $request->get_param('chat_type');

    if (empty($post_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Post is not found!!!';
    } elseif (empty($discussion)) {
        $response['status_code'] = 404;
        $response['message'] = 'Please enter your message!!!';
    } elseif (empty($role_type)) {
        $response['status_code'] = 404;
        $response['message'] = 'Enter role type!!!';
    } else {
        designerclub_enquiry_chat_save_fn($post_id, $discussion, $role_type, $chat_type);
        $response['status_code'] = 200;
        $response['message'] = 'Chat added successfully!!!';
    }

    if ($role_type == 'user') {

        $get_the_permalink = get_the_permalink($post_id);

        $to = get_option('admin_email');
        $subject = 'You have received one new message from app side, Click on the link below to reply!!!';
        $body = 'The is chat URL : ' . $get_the_permalink . '';
        $headers = array('Content-Type: text/html; charset=UTF-8');

        wp_mail($to, $subject, $body, $headers);
    }

    return $response;
}

// End archive status generate enquiry api endpoint

// Start Chat list api endpoint

add_action('rest_api_init', 'thedesignerclub_enquiry_chat_data_api_endpoint');
function thedesignerclub_enquiry_chat_data_api_endpoint($request)
{

    register_rest_route('wp/v2', 'enquiry_chat_data', array(
        'methods' => 'GET',
        'callback' => 'thedesignerclub_enquiry_chat_data_api',
    ));
}
function thedesignerclub_enquiry_chat_data_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];

    $post_id = $request->get_param('post_id');

    if (empty($post_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Post is not found!!!';
    } else {

        $check = $wpdb->get_results("SELECT * FROM wp_designerclub_support_ticket_enquiry WHERE post_id=" . $post_id . " ORDER BY ID ASC");

        $response['status_code'] = 200;
        $response['data'] = $check;
        $response['message'] = 'Chat data listed successfully!!!';
    }

    return $response;
}

// End Chat list api endpoint

// Start Archive total count api endpoint

add_action('rest_api_init', 'thedesignerclub_archive_total_count_api_endpoint');
function thedesignerclub_archive_total_count_api_endpoint($request)
{

    register_rest_route('wp/v2', 'archive_total_count', array(
        'methods' => 'GET',
        'callback' => 'thedesignerclub_archive_total_count_api',
    ));
}
function thedesignerclub_archive_total_count_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];

    $user_id = $request->get_param('user_id');

    if (empty($user_id)) {

        $response['status_code'] = 404;
        $response['data'] = '0';
        $response['message'] = 'User id not found!!!';
    } else {

        $support_ticket_meta_query = array(
            'relation' => 'AND',
            array(
                'key' => 'user_id',
                'value' => $user_id,
                'compare' => 'IN',
            ),
            array(
                'key' => 'archive_status',
                'value' => 'archive',
                'compare' => '=',
            ),
        );

        $support_ticket_args['post_type'] = 'support_ticket';
        $support_ticket_args['post_status'] = 'publish';
        $support_ticket_args['posts_per_page'] = -1;
        $support_ticket_args['meta_query'] = $support_ticket_meta_query;

        $support_ticket_loop = new WP_Query($support_ticket_args);

        if ($support_ticket_loop->have_posts()) {
            while ($support_ticket_loop->have_posts()) {
                $support_ticket_loop->the_post();

                $response['data'] = $support_ticket_loop->found_posts;
            }
            wp_reset_postdata();
            $response['status_code'] = 200;
            $response['message'] = 'Given total count archive posts!!!';
        } else {
            $response['status_code'] = 404;
            $response['data'] = '0';
            $response['message'] = 'Not found any archive posts!!!';
        }
    }

    return $response;
}

// End Archive total count api endpoint

// Start Chat generate token api endpoint

add_action('rest_api_init', 'thedesignerclub_create_access_tokens_for_conversations_api_endpoint');
function thedesignerclub_create_access_tokens_for_conversations_api_endpoint($request)
{
    register_rest_route('wp/v2', 'create_access_tokens_for_conversations', array(
        'methods' => 'GET',
        'callback' => 'thedesignerclub_create_access_tokens_for_conversations_api',
    ));
}
function thedesignerclub_create_access_tokens_for_conversations_api(WP_REST_Request $request)
{
    global $wpdb;
    $response = [];
    $identity = $request->get_param('identity');

    if (empty($identity)) {
        $response['status_code'] = 404;
        $response['message'] = 'User identity not found!!!';
    } else {
        $token = new AccessToken(
            TWILLIO_ACCOUNT_SID,
            TWILLIO_API_KEY,
            TWILLIO_API_SECRET,
            3600,
            $identity
        );

        // Create the Chat grant
        $chatGrant = new ChatGrant();
        $chatGrant->setServiceSid(TWILLIO_SERVICE_SID);

        // Add the Chat grant to the access token
        $token->addGrant($chatGrant);

        // Return the access token as a JSON response
        $response['status_code'] = 200;
        $response['message'] = 'User identity token successfully generated!!!';
        $response['data'] = $token->toJWT();
    }

    return $response;
}

// End Chat generate token endpoint

//Start Cart Insert api endpoints
function designerclub_custom_cart_data_save_fn($user_id, $product_id, $product_size, $product_to_date, $product_from_date, $product_delivery_fees)
{

    global $wpdb;

    $cart_data_save_from_app = $wpdb->prefix . 'designerclub_cart_data_save_from_app';

    //Save Cart Data in database
    $wpdb->insert($cart_data_save_from_app, array(
        'user_id' => $user_id,
        'product_id' => $product_id,
        'product_size' => $product_size,
        'product_to_date' => $product_to_date,
        'product_from_date' => $product_from_date,
        'product_delivery_fees' => $product_delivery_fees,
    ));
}

add_action('rest_api_init', 'thedesignerclub_cart_data_api_endpoint');
function thedesignerclub_cart_data_api_endpoint($request)
{

    register_rest_route('wp/v2', 'add_cart_data', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_cart_data_api',
    ));
}
function thedesignerclub_cart_data_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $user_id = $request->get_param('user_id');
    $product_id = $request->get_param('product_id');
    $product_size = $request->get_param('product_size');
    $product_to_date = $request->get_param('product_to_date');
    $product_from_date = $request->get_param('product_from_date');
    $product_delivery_fees = $request->get_param('product_delivery_fees');

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';
    } elseif (empty($product_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Product id is not found!!!';
    } elseif (empty($product_size)) {
        $response['status_code'] = 404;
        $response['message'] = 'Product size is not found!!!';
    } elseif (empty($product_to_date)) {
        $response['status_code'] = 404;
        $response['message'] = 'Can you please enter the date correctly!!!';
    } elseif (empty($product_from_date)) {
        $response['status_code'] = 404;
        $response['message'] = 'Can you please enter the date correctly?!!!';
    } else {

        designerclub_custom_cart_data_save_fn($user_id, $product_id, $product_size, $product_to_date, $product_from_date, $product_delivery_fees);
        $response['status_code'] = 200;
        $response['data'] = array(
            'user_id' => $user_id,
            'product_id' => $product_id,
            'product_size' => $product_size,
            'product_to_date' => $product_to_date,
            'product_from_date' => $product_from_date,
            'product_delivery_fees' => $product_delivery_fees,
        );
        $response['message'] = 'Product add in cart successfully!!!';
    }

    return $response;
}
//End Cart Insert api endpoints

//Statrt Cart Show data api endpoint

add_action('rest_api_init', 'thedesignerclub_show_addtocart_data_api_endpoint');
function thedesignerclub_show_addtocart_data_api_endpoint($request)
{

    register_rest_route('wp/v2', 'cartdata', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_show_addtocart_data_api',
    ));
}
function thedesignerclub_show_addtocart_data_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $user_id = $request->get_param('user_id');

    $check = $wpdb->get_results("SELECT * FROM wp_designerclub_cart_data_save_from_app WHERE user_id='" . $user_id . "'");

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';
    } elseif (empty($check)) {
        $response['status_code'] = 404;
        $response['message'] = 'Your cart is empty!!!';
    } else {
        $response['status_code'] = 200;
        $response['data'] = $check;
        $response['message'] = 'Product add in cart data show successfully!!!';
    }

    return $response;
}

//End Cart Show data api endpoint

//Start Remove cart item api endpoint

add_action('rest_api_init', 'thedesignerclub_remove_cart_item_api_endpoint');
function thedesignerclub_remove_cart_item_api_endpoint($request)
{

    register_rest_route('wp/v2', 'remove_cart_item', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_remove_cart_item_api',
    ));
}
function thedesignerclub_remove_cart_item_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $user_id = $request->get_param('user_id');
    $product_id = $request->get_param('product_id');

    $sql = "SELECT `id`, `user_id`, `product_id` FROM `wp_designerclub_cart_data_save_from_app` WHERE `user_id`='" . $user_id . "'";

    if (!empty($product_id)) {
        $sql .= " AND `product_id`='" . $product_id . "'";
    }

    $check = $wpdb->get_results($sql);

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';
    } elseif (empty($product_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Product id is not found!!!';
    } else {
        if (!empty($check)) {

            foreach ($check as $key => $value) {
                $wpdb->delete('wp_designerclub_cart_data_save_from_app', array('id' => $value->id));
                $response['status_code'] = 200;
                $response['data'] = $value->id;
                $response['message'] = 'Product removed from cart successfully!!!';
            }
        }
    }

    return $response;
}

//End Remove cart item api endpoint

//Start Add stripe card multiple api endpoint

add_action('rest_api_init', function ($request) {
    register_rest_route('stripe/v1', '/create-card', array(
        'methods' => 'POST',
        'callback' => 'create_card',
    ));
});

function create_card(WP_REST_Request $request)
{

    global $stripe;

    $response = [];

    //Provide me user Email
    $customer_id = $request->get_param('customer_id');
    $customer_name = $request->get_param('customer_name');

    $card_number = $request->get_param('card_number');
    $card_exp_month = $request->get_param('card_exp_month');
    $card_exp_year = $request->get_param('card_exp_year');
    $card_cvc = $request->get_param('card_cvc');

    if (empty($customer_id)) {

        $response['status_code'] = 404;
        $response['message'] = 'Customer id is not found!!!';
    } elseif (empty($customer_name)) {

        $response['status_code'] = 404;
        $response['message'] = 'Enter your card holder name!!!';
    } elseif (empty($card_number)) {

        $response['status_code'] = 404;
        $response['message'] = 'Enter your card number!!!';
    } elseif (empty($card_exp_month)) {

        $response['status_code'] = 404;
        $response['message'] = 'Enter your card expiry month Number!!!';
    } elseif (empty($card_exp_year)) {

        $response['status_code'] = 404;
        $response['message'] = 'Enter your card expiry year Number!!!';
    } elseif (empty($card_cvc)) {

        $response['status_code'] = 404;
        $response['message'] = 'Enter your card cvv Number!!!';
    } else {

        $stripe = new \Stripe\StripeClient(
            'sk_test_AxpTFKWmFAEB5vdqQ9kPxn66'
        );

        global $wpdb;
        //Get customer details
        $get_customer_token = $stripe->customers->all(['email' => $customer_id]);

        if (!empty($get_customer_token->data[0]['id'])) {
            $get_user_key = $get_customer_token->data[0]['id'];
        } else {
            $get_customer_tokenn = $stripe->customers->create([
                'name' => $customer_name,
                'email' => $customer_id,
            ]);
            $get_user_key = $get_customer_tokenn['id'];
        }

        // Create a payment method
        try {
            $payment_method = $stripe->paymentMethods->create([
                'type' => 'card',
                'card' => [
                    'number' => $card_number,
                    'exp_month' => $card_exp_month,
                    'exp_year' => $card_exp_year,
                    'cvc' => $card_cvc,
                ],
            ]);
            // Attach the payment method to the customer
            $stripe->paymentMethods->attach(
                $payment_method->id,
                ['customer' => $get_user_key]
            );
            $token = $stripe->tokens->create([
                'card' => [
                    'number'    => $card_number,
                    'exp_month' => $card_exp_month,
                    'exp_year'  => $card_exp_year,
                    'cvc'       => $card_cvc,
                ],
            ]);

            $token_id = $token->id;
            $payment_token = new WC_Payment_Token_CC();
            $payment_token->set_token($token_id);

            $card_data = $wpdb->prefix . 'insert_card';

            //Save Card Data in database
            $wpdb->insert($card_data, array(
                'user_id' => $customer_id,
                'card_id' => $token['card']['id'],
                'fingerprint' => $payment_method['card']['fingerprint'],
                'credit_card_token' => $token_id,
                'brand' => $payment_method['card']['brand'],
                'card_holder_name' => $customer_name,
                'card_number' => $card_number,
                'expiry_date' => $card_exp_month . '/' . $card_exp_year,
                'cvv' => $card_cvc,
                'card_type' => $payment_method['card']['funding'],
                'is_default' => 0,
                'status' => $payment_method['livemode'],
            ));
            $response['status_code'] = 200;
            $response['data'] = $payment_method;
            $response['message'] = 'your card has been added to stripe payment gateway!!!';
        } catch (Exception $e) {
            $response['status_code'] = 404;
            $response['data'] = new WP_Error('stripe_error', $e->getMessage(), array('status' => 500));
            $response['message'] = $e->getMessage();
        }
    }

    return $response;
}

//End Add stripe card multiple api endpoint

//Start List stripe card api endpoint

add_action('rest_api_init', function ($request) {
    register_rest_route('stripe/v1', '/list-card', array(
        'methods' => 'GET',
        'callback' => 'create_card_list',
    ));
});
add_action('rest_api_init', function ($request) {
    register_rest_route('stripe/v1', '/list-card2', array(
        'methods' => 'GET',
        'callback' => 'create_card_list2',
    ));
});
function create_card_list2(WP_REST_Request $request)
{

    global $stripe;
    global $wpdb;

    $response = [];

    //Provide me user Email
    $customer_id = $request->get_param('customer_id');

    $card_details = $wpdb->get_results(
        "SELECT *
        FROM {$wpdb->prefix}insert_card
        WHERE user_id =$customer_id"
    );

    print_r($card_details);

    die;
    if (empty($customer_id)) {

        $response['status_code'] = 404;
        $response['message'] = 'Customer id is not found!!!';
    } else {

        $stripe = new \Stripe\StripeClient(
            'sk_test_AxpTFKWmFAEB5vdqQ9kPxn66'
        );

        //Get customer details
        $get_customer_token = $stripe->customers->all(['email' => $customer_id]);

        if (!empty($get_customer_token->data[0]['id'])) {
            $get_user_key = $get_customer_token->data[0]['id'];
        }

        // Create a payment method
        try {
            // Attach the payment method to the customer
            $allSources = $stripe->paymentMethods->all([
                'customer' => $get_user_key,
                'type' => 'card',
            ]);




            $response['status_code'] = 200;
            $response['data'] = $allSources->data;
            $response['message'] = 'your card has showing data here!!!';
        } catch (Exception $e) {
            $response['status_code'] = 404;
            $response['message'] = new WP_Error('stripe_error', $e->getMessage(), array('status' => 500));
        }
    }

    return $response;
}

function create_card_list(WP_REST_Request $request)
{

    global $stripe;

    $response = [];

    //Provide me user Email
    $customer_id = $request->get_param('customer_id');

    if (empty($customer_id)) {

        $response['status_code'] = 404;
        $response['message'] = 'Customer id is not found!!!';
    } else {

        $stripe = new \Stripe\StripeClient(
            'sk_test_AxpTFKWmFAEB5vdqQ9kPxn66'
        );

        //Get customer details
        $get_customer_token = $stripe->customers->all(['email' => $customer_id]);

        if (!empty($get_customer_token->data[0]['id'])) {
            $get_user_key = $get_customer_token->data[0]['id'];
        }

        // Create a payment method
        try {
            // Attach the payment method to the customer
            $allSources = $stripe->paymentMethods->all([
                'customer' => $get_user_key,
                'type' => 'card',
            ]);

            $response['status_code'] = 200;
            $response['data'] = $allSources->data;
            $response['message'] = 'your card has showing data here!!!';
        } catch (Exception $e) {
            $response['status_code'] = 404;
            $response['message'] = new WP_Error('stripe_error', $e->getMessage(), array('status' => 500));
        }
    }

    return $response;
}

//End List stripe card api endpoint

//Start delete stripe card api endpointd

add_action('rest_api_init', function ($request) {
    register_rest_route('stripe/v1', '/delete-card', array(
        'methods' => 'POST',
        'callback' => 'delete_card_list',
        'permission_callback' => '__return_true',
    ));
});

function delete_card_list(WP_REST_Request $request)
{

    global $stripe;

    $response = [];

    //Provide me user Email
    $payment_method_id = $request->get_param('payment_method_id');

    if (empty($payment_method_id)) {

        $response['status_code'] = 404;
        $response['message'] = 'Invalid payment method ID!!!';
    } else {

        $stripe = new \Stripe\StripeClient(
            'sk_test_AxpTFKWmFAEB5vdqQ9kPxn66'
        );

        try {
            // Attach the payment method to the customer
            $payment_method = $stripe->paymentMethods->retrieve(
                $payment_method_id,
                []
            );
            $payment_method->detach();
            //$payment_method->delete();

            $response['status_code'] = 200;
            $response['data'] = $payment_method;
            $response['message'] = 'Payment method has been deleted!!!';
        } catch (Exception $e) {
            $response['status_code'] = 404;
            $response['message'] = $e->getMessage();
        }
    }

    return $response;
}

//End delete stripe card api endpointd

//Start Order screen api endpoint

add_action('rest_api_init', 'thedesignerclub_ordersrentlist_api_endpoint');
function thedesignerclub_ordersrentlist_api_endpoint($request)
{

    register_rest_route('wp/v2', 'ordersrentlist', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_ordersrentlist_api',
    ));
}
function thedesignerclub_ordersrentlist_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $order_screen_tab = $request->get_param('order_screen_tab');
    $user_id = $request->get_param('user_id');

    if (empty($order_screen_tab)) {
        $response['status_code'] = 404;
        $response['message'] = 'Order screen not found!!!';
    } else {

        if ($order_screen_tab == 'current') {

            $order = wc_get_customer_last_order($user_id);

            if ($order) {
                // Get the order ID, order total, order date, etc.
                $order_id = $order->get_id();
                $response['status_code'] = 200;
                $response['data'] = $order_id;
                $response['message'] = 'Current order found successfully!!!';
            } else {
                $response['status_code'] = 404;
                $response['message'] = 'No current order found!!!';
            }
        } elseif ($order_screen_tab == 'upcoming') {

            $orderID = array();

            $orders = wc_get_orders(array(
                'status' => array('wc-processing', 'wc-on-hold'),
                'type' => 'shop_order',
                'customer_id' => $user_id,
                'limit' => -1,
            ));

            // Loop through the orders
            foreach ($orders as $order) {
                // Get the order ID, order total, order date, etc.
                $orderID[] = $order->get_id();
            }
            if (!empty($orderID)) {
                $response['status_code'] = 200;
                $response['data'] = $orderID;
                $response['message'] = 'Upcoming order found successfully!!!';
            } else {
                $response['status_code'] = 2;
                $response['message'] = 'Upcoming order not found !!!';
            }
        } elseif ($order_screen_tab == 'completed') {

            $orderID = array();

            $orders = wc_get_orders(array(
                'status' => array('wc-completed', 'wc-cancelled'),
                'type' => 'shop_order',
                'customer_id' => $user_id,
                'limit' => -1,
            ));
            // Loop through the orders
            foreach ($orders as $order) {
                // Get the order ID, order total, order date, etc.
                $orderID[] = $order->get_id();
            }
            if (!empty($orderID)) {
                $response['status_code'] = 200;
                $response['data'] = $orderID;
                $response['message'] = 'Completed and Cancelled order found successfully!!!';
            } else {
                $response['status_code'] = 2;
                $response['message'] = 'Completed and Cancelled order not found !!!';
            }
        } else {
            $response['status_code'] = 404;
            $response['message'] = 'Something went wrong for orders tab!!!';
        }
    }

    return $response;
}

//End Order screen api endpoint

//Order object override filter
add_filter('woocommerce_rest_prepare_shop_order_object', 'custom_order_api_data', 10, 3);
function custom_order_api_data($response, $order, $request)
{

    $user_id = $request->get_param('user_id');

    $i = 0;
    $items_order = $order->get_items();
    $recent_author = get_user_by('ID', $order->customer_id);
    $response->data['recent_author'] = $recent_author->data;

    //recent author get profile image url,
    $vendor_image = esc_url(get_avatar_url($recent_author));
    $response->data['recent_author_image'] = $vendor_image;

    //Get who user is create the order code
    $user_passport = get_user_meta($order->customer_id, 'user_passport', true);
    $user_identity = get_user_meta($order->customer_id, 'user_identity', true);
    $response->data['user_passport'] = $user_passport;
    $response->data['user_identity'] = $user_identity;

    foreach ($items_order as $item_obj) {
        $count = count($response->data['line_items']);
        for ($i = 0; $i < $count; $i++) {
            $product_id = $response->data['line_items'][$i]['product_id'];
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'thumbnail');
            $response->data['line_items'][$i]['feature_image'] = $image[0];

            //Vendor accept reject get value
            $vendor_product_status = get_user_meta($user_id, 'vendor_report_accept_reject_lender_' . $item_obj->get_order_id() . '_' . $product_id, true);
            $response->data['line_items'][$i]['vendor_product_status'] = $vendor_product_status;

            //Vendor get mobile number. it's client requirments
            $vendor_phone_number = get_user_meta($user_id, 'billing_phone', true);
            $response->data['line_items'][$i]['vendor_phone_number'] = $vendor_phone_number;
        }
    }
    return $response;
}

// Start Monthly wise my earing screen api endpoint

add_action('rest_api_init', 'thedesignerclub_earning_graph_api_endpoint');
function thedesignerclub_earning_graph_api_endpoint($request)
{

    register_rest_route('wp/v2', 'earning_monthly', array(
        'methods' => 'GET',
        'callback' => 'thedesignerclub_earning_graph_api',
    ));
}
function thedesignerclub_earning_graph_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $results = [];

    $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
    $month = isset($_GET['month']) ? intval($_GET['month']) : date('m');

    $customer_id = $request->get_param('customer_id');

    if (empty($customer_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Something went wrong for orders tab!!!';
    } else {

        $order_years = $wpdb->get_col(
            "
            SELECT DISTINCT YEAR(post_date) as year
            FROM {$wpdb->prefix}posts
            WHERE post_type = 'shop_order'
            AND post_status IN ('wc-completed', 'wc-processing', 'wc-on-hold')
            ORDER BY year DESC
            "
        );

        foreach ($order_years as $year) {
            $order_months = $wpdb->get_col(
                "
                SELECT DISTINCT MONTH(post_date) as month
                FROM {$wpdb->prefix}posts
                WHERE post_type = 'shop_order'
                AND post_status IN ('wc-completed', 'wc-processing', 'wc-on-hold')
                AND YEAR(post_date) = $year
                ORDER BY month DESC
                "
            );

            foreach ($order_months as $month) {
                $customers = $wpdb->get_col(
                    "
                    SELECT DISTINCT meta_value as customer_id
                    FROM {$wpdb->prefix}postmeta
                    WHERE meta_key = '_customer_user'
                    AND meta_value = $customer_id
                    AND post_id IN (
                        SELECT ID
                        FROM {$wpdb->prefix}posts
                        WHERE post_type = 'shop_order'
                        AND post_status IN ('wc-completed', 'wc-processing', 'wc-on-hold')
                        AND YEAR(post_date) = $year
                        AND MONTH(post_date) = $month

                    )
                    "
                );

                foreach ($customers as $customer_id) {
                    $customer_orders = $wpdb->get_results(
                        "
                        SELECT *
                        FROM {$wpdb->prefix}posts
                        WHERE post_type = 'shop_order'
                        AND post_status IN ('wc-completed', 'wc-processing', 'wc-on-hold')
                        AND YEAR(post_date) = $year
                        AND MONTH(post_date) = $month
                        AND ID IN (
                            SELECT post_id
                            FROM {$wpdb->prefix}postmeta
                            WHERE meta_key = '_customer_user'
                            AND meta_value = $customer_id
                        )
                        "
                    );

                    if ($customer_orders) {
                        $results[$year][$month] = $customer_orders;
                    }
                }
            }
        }

        $response['status_code'] = 200;
        $response['data'] = $results;
        $response['message'] = 'Monthly order data fetch successfully!!!';
    }

    return $response;
}

//End Monthly wise my earing screen api endpoint

// Start yearly wise my earing screen api endpoint

add_action('rest_api_init', 'thedesignerclub_earning_yearly_graph_api_endpoint');
function thedesignerclub_earning_yearly_graph_api_endpoint($request)
{

    register_rest_route('wp/v2', 'earning_yearly', array(
        'methods' => 'GET',
        'callback' => 'thedesignerclub_earning_yearly_graph_api',
    ));
}
function thedesignerclub_earning_yearly_graph_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $results = [];

    $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
    $month = isset($_GET['month']) ? intval($_GET['month']) : date('m');

    $customer_id = $request->get_param('customer_id');

    if (empty($customer_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Something went wrong for orders tab!!!';
    } else {

        $order_years = $wpdb->get_col(
            "
            SELECT DISTINCT YEAR(post_date) as year
            FROM {$wpdb->prefix}posts
            WHERE post_type = 'shop_order'
            AND post_status IN ('wc-completed', 'wc-processing')
            ORDER BY year DESC
            "
        );

        foreach ($order_years as $year) {
            $customers = $wpdb->get_col(
                "
                SELECT DISTINCT meta_value as customer_id
                FROM {$wpdb->prefix}postmeta
                WHERE meta_key = '_customer_user'
                AND meta_value = $customer_id
                AND post_id IN (
                    SELECT ID
                    FROM {$wpdb->prefix}posts
                    WHERE post_type = 'shop_order'
                    AND post_status IN ('wc-completed', 'wc-processing')
                    AND YEAR(post_date) = $year
                )
                "
            );

            foreach ($customers as $customer_id) {
                $customer_orders = $wpdb->get_results(
                    "
                    SELECT *
                    FROM {$wpdb->prefix}posts
                    WHERE post_type = 'shop_order'
                    AND post_status IN ('wc-completed', 'wc-processing')
                    AND YEAR(post_date) = $year
                    AND ID IN (
                        SELECT post_id
                        FROM {$wpdb->prefix}postmeta
                        WHERE meta_key = '_customer_user'
                        AND meta_value = $customer_id
                    )
                    "
                );

                if ($customer_orders) {
                    $results[$year][$customer_id] = $customer_orders;
                }
            }
        }

        $response['status_code'] = 200;
        $response['data'] = $results;
        $response['message'] = 'Yearly order data fetch successfully!!!';
    }

    return $response;
}

//End Monthly wise my earing screen api endpoint

// Start weekly wise my earing screen api endpoint

add_action('rest_api_init', 'thedesignerclub_earning_weekly_graph_api_endpoint');
function thedesignerclub_earning_weekly_graph_api_endpoint($request)
{

    register_rest_route('wp/v2', 'earning_weekly', array(
        'methods' => 'GET',
        //'callback' => 'thedesignerclub_weekly_earning_graph_api',
        'callback' => 'thedesignerclub_earning_weekly_graph_api',
    ));
    register_rest_route('wp/v2', 'earning_graph', array(
        'methods' => 'GET',
        'callback' => 'thedesignerclub_earning_api',
    ));
}
function thedesignerclub_earning_api(WP_REST_Request $request)
{
    global $wpdb;
    $response = [];
    $results = [];
    $customer_id = $request->get_param('customer_id');
    if (empty($customer_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Something went wrong for orders tab!!!';
    } else {
        $customer_orders = $wpdb->get_results("SELECT
                DATE(post_date) as daily_date,
                WEEK(post_date) as WEEK_OF_YEAR,
                DATE_FORMAT(post_date, '%Y-%m') as MONTH_OF_YEAR,
                YEAR(post_date) as OF_YEAR,
                SUM(CASE WHEN DATE(post_date) = DATE(NOW()) THEN meta_value ELSE 0 END) as today_sales,
                SUM(CASE WHEN YEARWEEK(post_date, 1) = YEARWEEK(NOW(), 1) THEN meta_value ELSE 0 END) as weekly_sales,
                SUM(CASE WHEN DATE_FORMAT(post_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m') THEN meta_value ELSE 0 END) as monthly_sales,
                SUM(CASE WHEN YEAR(post_date) = YEAR(NOW()) THEN meta_value ELSE 0 END) as yearly_sales
            FROM wp_posts
            INNER JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id
            WHERE post_type = 'shop_order'
            AND post_status IN ('wc-completed', 'wc-processing')
            AND meta_key = '_order_total'
            AND ID IN (SELECT post_id FROM wp_postmeta WHERE meta_key = '_customer_user' AND meta_value = $customer_id)
            GROUP BY daily_date, WEEK_OF_YEAR, MONTH_OF_YEAR, OF_YEAR
            ORDER BY daily_date DESC, WEEK_OF_YEAR DESC, MONTH_OF_YEAR DESC, OF_YEAR DESC;
    ");

        /* $customer_orders = $wpdb->get_results("SELECT COALESCE(SUM(pm.meta_value),0) as COALESCE, p.post_date, YEAR(p.post_date) as OF_YEAR, MONTH(p.post_date) as MONTH_OF_YEAR, WEEK(p.post_date) as WEEK_OF_YEAR
        FROM thedesignerclub_wp.wp_posts as p 
        INNER JOIN wp_postmeta as pm ON p.ID = pm.post_id 
        WHERE 
         p.post_type = 'shop_order' 
        AND p.post_status IN ('wc-completed', 'wc-processing')
        AND pm.meta_key = '_order_total'
        AND ID IN (SELECT p.post_id FROM wp_postmeta WHERE pm.meta_key = '_customer_user' AND meta_value =  $customer_id) 
        GROUP BY YEAR(p.post_date), MONTH(p.post_date), WEEK(p.post_date)"); */

        if ($customer_orders) {
            $results = $customer_orders;
        }
        if ($results) {
            $response['status_code'] = 200;
            $response['data'] = $results;
            $response['message'] = 'Daily,Weekly,Monthly and Yearly order data fetch successfully!!!';
        } else {
            $response['status_code'] = 404;
            $response['data'] =
                [
                    "daily_date" => "0",
                    "WEEK_OF_YEAR" => "0",
                    "MONTH_OF_YEAR" => "0",
                    "OF_YEAR" => "0",
                    "today_sales" => "0",
                    "weekly_sales" => "0",
                    "monthly_sales" => "0",
                    "yearly_sales" => "0"
                ];
            $response['message'] = 'Data not found!!!';
        }
    }

    return $response;
}

function thedesignerclub_weekly_earning_graph_api(WP_REST_Request $request)
{
    global $wpdb;

    $response = [];
    $results = [];

    $customer_id = $request->get_param('customer_id');
    if (empty($customer_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Something went wrong for orders tab!!!';
    } else {
        $customer_orders = $wpdb->get_results("SELECT DATE(post_date) as date, COUNT(ID) as order_count, SUM(meta.meta_value) as order_total 
        FROM wp_posts 
        INNER JOIN wp_postmeta AS meta ON wp_posts.ID = meta.post_id 
        WHERE post_type = 'shop_order' 
        AND post_status IN ('wc-processing', 'wc-completed') 
        AND meta_key = '_customer_user'
        AND meta_value = $customer_id
        AND post_date BETWEEN DATE_SUB(DATE_FORMAT(NOW(),'%Y-%m-%d'), INTERVAL 6 DAY) AND DATE_FORMAT(NOW(),'%Y-%m-%d')
        GROUP BY date 
        ORDER BY date DESC");
        if ($customer_orders) {
            $results = $customer_orders;
        }
    }
    $response['status_code'] = 200;
    $response['data'] = $results;
    $response['message'] = 'Weekly order data fetch successfully!!!';

    return $response;
}
function thedesignerclub_earning_weekly_graph_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $results = [];

    $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
    $month = isset($_GET['month']) ? intval($_GET['month']) : date('m');

    $customer_id = $request->get_param('customer_id');

    if (empty($customer_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Something went wrong for orders tab!!!';
    } else {

        $order_weeks = $wpdb->get_col(
            "
            SELECT DISTINCT YEAR(post_date) as year, WEEK(post_date, 1) as week
            FROM {$wpdb->prefix}posts
            WHERE post_type = 'shop_order'
            AND post_status IN ('wc-completed', 'wc-processing')
            ORDER BY year DESC, week DESC
            "
        );

        foreach ($order_weeks as $order_week) {
            $year = substr($order_week, 0, 4);
            $week = substr($order_week, 4);

            $customers = $wpdb->get_col(
                "
                SELECT DISTINCT meta_value as customer_id
                FROM {$wpdb->prefix}postmeta
                WHERE meta_key = '_customer_user'
                AND meta_value = $customer_id
                AND post_id IN (
                    SELECT ID
                    FROM {$wpdb->prefix}posts
                    WHERE post_type = 'shop_order'
                    AND post_status IN ('wc-completed', 'wc-processing')
                    AND YEAR(post_date) = $year
                    AND WEEK(post_date, 1) = $week
                )
                "
            );

            foreach ($customers as $customer_id) {
                $customer_orders = $wpdb->get_results(
                    "
                    SELECT *
                    FROM {$wpdb->prefix}posts
                    WHERE post_type = 'shop_order'
                    AND post_status IN ('wc-completed', 'wc-processing')
                    AND YEAR(post_date) = $year
                    AND WEEK(post_date, 1) = $week
                    AND ID IN (
                        SELECT post_id
                        FROM {$wpdb->prefix}postmeta
                        WHERE meta_key = '_customer_user'
                        AND meta_value = $customer_id
                    )
                    "
                );

                if ($customer_orders) {
                    $results[$year][$week][$customer_id] = $customer_orders;
                }
            }
        }

        $response['status_code'] = 200;
        $response['data'] = $results;
        $response['message'] = 'Weekly order data fetch successfully!!!';
    }

    return $response;
}

//End Monthly wise my earing screen api endpoint

//Start leading api endpoint ( No need this api after development we will removed this api )

add_action('rest_api_init', 'thedesignerclub_leading_orders_api_endpoint');
function thedesignerclub_leading_orders_api_endpoint($request)
{

    register_rest_route('wp/v2', 'leading_orders', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_leading_orders_api',
    ));
}
function thedesignerclub_leading_orders_api(WP_REST_Request $request)
{
    global $wpdb;

    $response = [];
    $productData = [];

    $user_id = $request->get_param('user_id');

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Something went wrong for orders tab!!!';
    } else {

        $vendor_products = get_commission_products($user_id);

        if (isset($vendor_products) && !empty($vendor_products)) {

            $vendor_products = array_reverse($vendor_products);

            $total_cost = 0;

            foreach ($vendor_products as $product) {
                global $wpdb;
                $order_status = array('wc-completed', 'wc-processing');
                $results[] = $wpdb->get_col("
                    SELECT order_items.order_id
                    FROM {$wpdb->prefix}woocommerce_order_items as order_items
                    LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
                    LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
                    WHERE posts.post_type = 'shop_order'
                    AND posts.post_status IN ( '" . implode("','", $order_status) . "' )
                    AND order_items.order_item_type = 'line_item'
                    AND order_item_meta.meta_value = '$product->ID'
                ");
                $ids[] = $product->ID;
            }

            $c = 0;
            foreach ($results as $keys) {
                foreach ($keys as $key => $id) {
                    $result[] = $id;
                }
            }

            arsort($result);

            foreach ($result as $order_id) {
                $order = new WC_Order($order_id);

                $recent_author = get_user_by('ID', $order->customer_id);
                $get_avatar_author_url = get_avatar_url($recent_author->user_email);
                // Get user display name
                $author_display_name = $recent_author->display_name;
                $author_nicename = $recent_author->user_nicename;
                $get_author_gravatar = get_avatar_url($author_id, array('size' => 450));

                $chat_id = $wpdb->get_col("SELECT mgs_id FROM `wp_fep_participants` WHERE `mgs_participant` IN ($order->customer_id,$user_id) GROUP BY mgs_id HAVING COUNT(mgs_id) > 1 LIMIT 1
                    ");

                $items = $order->get_items();

                usort($items, function ($itemA, $itemB) {
                    $date_fromA = $itemA->get_meta('FROM', true);
                    $date_fromB = $itemB->get_meta('FROM', true);

                    return - ($date_fromA <=> $date_fromB);
                });

                foreach ($items as $item) {
                    if (!in_array($item->get_product_id(), $ids)) {
                        continue;
                    }
                    $ID = $item->get_product_id();
                    $the_post = get_post($item->get_product_id());

                    if (!WCV_Vendors::is_vendor($the_post->post_author)) {
                        continue;
                    }

                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($ID), 'small');

                    $product_name = $item['name'];
                    $product_id = $item['product_id'];
                    $date_from = $item->get_meta('FROM', true);
                    $date_to = $item->get_meta('TO', true);
                    $date_from = date("d/m/y", strtotime($date_from));
                    $date_to = date("d/m/y", strtotime($date_to));
                    $size = $item->get_meta('Size', true);
                    $commission_rate = WCV_Commission::get_commission_rate($product_id);
                    $total = $item->get_total();
                    $commission_price = $total * $commission_rate / 100 + $order->shipping_total;

                    //Price and Postage details
                    $order = wc_get_order($order_id);
                    $shipping_method_total = 0;
                    foreach ($order->get_items('shipping') as $item_id => $item) {
                        $shipping_method_total = $item->get_total() + $shipping_method_total;
                    }
                    if ($shipping_method_total > 0) {
                        $product_delivery_fees = '$' . $shipping_method_total;
                    } else {
                        $product_delivery_fees = 'Free Local Pickup';
                    }

                    if ($size != '') {
                        $size = $size;
                    }

                    $productData[] = array(
                        'order_id' => $order_id,
                        'product_id' => $product_id,
                        'product_name' => $product_name,
                        'product_image' => $image[0],
                        'date_from' => $date_from,
                        'date_to' => $date_to,
                        'product_delivery_fees' => $product_delivery_fees,
                        'product_size' => $size,
                        'product_price' => '$' . $commission_price,
                        'product_renter_name' => $recent_author->first_name . " " . $recent_author->last_name,
                        'product_renter_email' => $recent_author->user_email,
                        'product_renter_image' => $get_avatar_author_url,
                        'product_postal_address' => $order->get_billing_address_1() . ' ' . $order->get_billing_city() . ' ' . $order->get_billing_state() . ' ' . $order->get_billing_postcode(),
                    );
                }
            }

            $response['status_code'] = 200;
            $response['data'] = $productData;
            $response['message'] = 'Your order data fetch successfully!!!';
        }
    }

    return $response;
}

//End leading api endpoint

//Start Accept Reject leading api point

add_action('rest_api_init', 'thedesignerclub_leading_accept_reject_orders_api_endpoint');
function thedesignerclub_leading_accept_reject_orders_api_endpoint($request)
{

    register_rest_route('wp/v2', 'leading_accept_reject_orders', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_leading_accept_reject_orders_api',
    ));
}
function thedesignerclub_leading_accept_reject_orders_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $productData = [];

    $user_id = $request->get_param('user_id');
    $order_id = $request->get_param('order_id');
    $order_product_id = $request->get_param('order_product_id');
    $order_accept_reject = $request->get_param('order_accept_reject');


    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Something went wrong for orders tab!!!';
    } elseif (empty($order_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Order id is not found!!!';
    } elseif (empty($order_product_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Order product id not found!!!';
    } elseif (empty($order_accept_reject)) {
        $response['status_code'] = 404;
        $response['message'] = 'Accept&Reject action not found!!!';
    } else {
        //Accept Reject code
        $current_user = get_userdata($user_id);
        $lender_email = $current_user->user_email;
        $lender_name = $current_user->user_firstname . " " . $current_user->user_lastname;
        $order = wc_get_order($order_id);
        $renter_email = $order->data['billing']['email'];
        $renter_name = $order->data['billing']['first_name'] . ' ' . $order->data['billing']['last_name'];

        if (isset($order_id)) {

            $accept_reject_admin = null;
            $admin_user = get_user_by('login', 'designerclub');
            $admin_id = $admin_user->ID;

            if ($user_id == $admin_id) {
                update_user_meta($admin_id, 'vendor_report_accept_reject_admin_' . $order_id . '_' . $order_product_id, $order_accept_reject);
            } else {
                update_user_meta($user_id, 'vendor_report_accept_reject_lender_' . $order_id . '_' . $order_product_id, $order_accept_reject);
            }
            $headers = 'Content-type:text/html';

            if ($order_accept_reject == 'accepted') {
                $subject = '[' . get_bloginfo('name') . '] New Order Confirmation (' . $order_id . ')';
                $message = 'Hi ' . $lender_name . ' <p>Thankyou for confirming the renters request please ensure you post out as early as possible to make sure the item arrives on time & please check the item is in the same condition as the photos shown of the item.</p>';
                wp_mail($lender_email, $subject, $message, $headers);


                $subject2 = '[' . get_bloginfo('name') . '] New Order Confirmation (' . $order_id . ')';
                $message2 = 'Hi ' . $renter_name . ' <p>We would like you to inform you that your order has been CONFIRMED by the Lender, for any enquiries about the item or dates chosen please contact the lender on the website. thankyou</p>';
                wp_mail($renter_email, $subject2, $message2, $headers);

                /* notification if accepted   */
                $registration_ids = get_user_meta($user_id, 'device_token', true);
                $data = [
                    'title' => 'Your Request accepted',
                    'message' => 'has been accepted ',
                    'user_id' =>  $user_id,
                    'order_id' =>  $order_id,
                    'notification_tag' => 'Request accepted',
                ];
                $response['notification'] = send_notification($registration_ids, $data);
                insert_notification_data($data);

                $data = [
                    'title' => 'Your Request accepted',
                    'message' => 'has been accepted ',
                    'user_id' =>  $user_id,
                    'order_id' =>  $order_id,
                    'notification_tag' => 'Request accepted',
                ];
                $response['notification'] = send_notification($registration_ids, $data);
                insert_notification_data($data);
            } else {
                $subject = '[' . get_bloginfo('name') . '] New Order Cancellation (' . $order_id . ')';
                $message = 'Hi ' . $lender_name . ' <p> The designer club has acknowledged your request to cancel the booking, if this item is no longer available for hire please take it off your listed items, thankyou.</p>';
                wp_mail($lender_email, $subject, $message, $headers);

                $subject2 = '[' . get_bloginfo('name') . '] New Order Cancellation (' . $order_id . ')';
                $message2 = 'Hi ' . $renter_name . ' <p> We are sorry to inform you that your recently booked item on the Designer Club is currently not Available, payment will not go through for this item. thankyou</p>';
                wp_mail($renter_email, $subject2, $message2, $headers);

                /* notification if rejected   */
                $registration_ids = get_user_meta($user_id, 'device_token', true);
                $data = [
                    'title' => 'Your Request rejected',
                    'message' => 'has been rejected ',
                    'user_id' =>  $user_id,
                    'order_id' =>  $order_id,
                    'notification_tag' => 'Request rejected',
                ];
                $response['notification'] = send_notification($registration_ids, $data);
                insert_notification_data($data);
            }

            $msg = 'Order id : ' . $order_id . '</br>';
            $email = get_option('admin_email');
            $msg .= 'Renter Name : ' . $renter_name . ' Renter Email : ' . $renter_email . '</br>';
            $msg .= 'Lender Name : ' . $lender_name . ' Lender Email : ' . $lender_email . '</br>';
            wp_mail($email, $subject, $msg, $headers);
        }

        $response['status_code'] = 200;
        $response['data'] = array(
            'lender_email' => $lender_email,
            'renter_email' => $renter_email,
            'order_id' => $order_id,
            'order_product_id' => $order_product_id,
            'renter_name' => $renter_name,
            'lender_name' => $lender_name,
        );
        $response['message'] = 'Accept&Reject mail sent successfully!!!';

        //End Accept Reject code
    }

    return $response;
}

//End Accept Reject leading api point

//Start Request order tab api endpoint

add_action('rest_api_init', 'thedesignerclub_leading_requested_orders_orders_api_endpoint');
function thedesignerclub_leading_requested_orders_orders_api_endpoint($request)
{
    register_rest_route('wp/v2', 'leading_requested_orders', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_leading_requested_orders_orders_api',
    ));
}
function thedesignerclub_leading_requested_orders_orders_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $productData = [];

    $user_id = $request->get_param('user_id');

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Something went wrong for orders tab!!!';
    } else {

        $vendor_products = get_commission_products($user_id);

        if (isset($vendor_products) && !empty($vendor_products)) {

            $vendor_products = array_reverse($vendor_products);

            $total_cost = 0;

            foreach ($vendor_products as $product) {
                global $wpdb;
                $order_status = array('wc-completed', 'wc-processing');
                $results[] = $wpdb->get_col("
                    SELECT order_items.order_id
                    FROM {$wpdb->prefix}woocommerce_order_items as order_items
                    LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
                    LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
                    WHERE posts.post_type = 'shop_order'
                    AND posts.post_status IN ( '" . implode("','", $order_status) . "' )
                    AND order_items.order_item_type = 'line_item'
                    AND order_item_meta.meta_value = '$product->ID'
                ");
                $ids[] = $product->ID;
            }



            $c = 0;
            foreach ($results as $keys) {
                foreach ($keys as $key => $id) {
                    $result[] = $id;
                }
            }

            arsort($result);

            foreach ($result as $order_id) {
                $order = new WC_Order($order_id);
                $recent_author = get_user_by('ID', $order->customer_id);
                $get_avatar_author_url = get_avatar_url($recent_author->user_email);
                // Get user display name
                $author_display_name = $recent_author->display_name;
                $author_nicename = $recent_author->user_nicename;
                $get_author_gravatar = get_avatar_url($author_id, array('size' => 450));

                $chat_id = $wpdb->get_col("SELECT mgs_id FROM `wp_fep_participants` WHERE `mgs_participant` IN ($order->customer_id,$user_id) GROUP BY mgs_id HAVING COUNT(mgs_id) > 1 LIMIT 1
                    ");

                $items = $order->get_items();

                usort($items, function ($itemA, $itemB) {
                    $date_fromA = $itemA->get_meta('FROM', true);
                    $date_fromB = $itemB->get_meta('FROM', true);

                    return - ($date_fromA <=> $date_fromB);
                });

                foreach ($items as $item) {
                    if (!in_array($item->get_product_id(), $ids)) {
                        continue;
                    }
                    $ID = $item->get_product_id();
                    $the_post = get_post($item->get_product_id());

                    //$user_last = 'vendor_report_accept_reject_lender_' . $ID . '_' . $the_post->ID;

                    $get_meta_user_last = get_user_meta($user_id, 'vendor_report_accept_reject_lender_' . $order_id . '_' . $ID, true);

                    if ($get_meta_user_last != 'accepted' && $get_meta_user_last != 'rejected') {
                        $productData[] = $order_id;
                    }
                }
            }
            $response['status_code'] = 200;
            $response['data'] = $productData;
            $response['message'] = 'Request order list successfully!!!';
        } else {
            $response['status_code'] = 404;
            $response['message'] = 'No Request order list found!!!';
        }
    }
    return $response;
}

//End Request order tab api endpoint

//Start Current order tab api endpoint

add_action('rest_api_init', 'thedesignerclub_leading_current_orders_orders_api_endpoint');
function thedesignerclub_leading_current_orders_orders_api_endpoint($request)
{

    register_rest_route('wp/v2', 'leading_current_orders', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_leading_current_orders_orders_api',
    ));
}
function thedesignerclub_leading_current_orders_orders_api(WP_REST_Request $request)
{
    //  return ['response'=> 'uiksdghfoi']; 

    global $wpdb;

    $response = [];
    $productData = [];

    $user_id = $request->get_param('user_id');

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Something went wrong for orders tab!!!';
    } else {

        $vendor_products = get_commission_products($user_id);

        if (isset($vendor_products) && !empty($vendor_products)) {

            $vendor_products = array_reverse($vendor_products);

            $total_cost = 0;

            foreach ($vendor_products as $product) {
                global $wpdb;
                $order_status = array('wc-completed', 'wc-processing');
                $results[] = $wpdb->get_col("
                    SELECT order_items.order_id
                    FROM {$wpdb->prefix}woocommerce_order_items as order_items
                    LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
                    LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
                    WHERE posts.post_type = 'shop_order'
                    --AND posts.post_status IN ( '" . implode("','", $order_status) . "' )
                    AND order_items.order_item_type = 'line_item'
                    AND order_item_meta.meta_value = '$product->ID'
                ");
                $ids[] = $product->ID;
            }

            $c = 0;
            foreach ($results as $keys) {
                foreach ($keys as $key => $id) {
                    $result[] = $id;
                }
            }

            arsort($result);

            foreach ($result as $order_id) {
                $order = new WC_Order($order_id);

                $recent_author = get_user_by('ID', $order->customer_id);
                $get_avatar_author_url = get_avatar_url($recent_author->user_email);
                // Get user display name
                $author_display_name = $recent_author->display_name;
                $author_nicename = $recent_author->user_nicename;
                $get_author_gravatar = get_avatar_url($author_id, array('size' => 450));

                $chat_id = $wpdb->get_col("SELECT mgs_id FROM `wp_fep_participants` WHERE `mgs_participant` IN ($order->customer_id,$user_id) GROUP BY mgs_id HAVING COUNT(mgs_id) > 1 LIMIT 1
                    ");

                $items = $order->get_items();

                usort($items, function ($itemA, $itemB) {
                    $date_fromA = $itemA->get_meta('FROM', true);
                    $date_fromB = $itemB->get_meta('FROM', true);

                    return - ($date_fromA <=> $date_fromB);
                });

                foreach ($items as $item) {
                    if (!in_array($item->get_product_id(), $ids)) {
                        continue;
                    }
                    $ID = $item->get_product_id();
                    $the_post = get_post($item->get_product_id());

                    $get_meta_user_last = get_user_meta($user_id, 'vendor_report_accept_reject_lender_' . $order_id . '_' . $ID, true);

                    if ($get_meta_user_last != 'accepted' && $get_meta_user_last != 'rejected') {
                        $productData[] = $order_id;
                    }
                }
            }
            $response['status_code'] = 200;
            $response['data'] = $productData[0];
            $response['message'] = 'Request order list successfully!!!';
        } else {
            $response['status_code'] = '2';
            $response['message'] = 'No Request order list found';
        }
    }

    return $response;
}

//End Request order tab api endpoint

//Start Upcoming order tab api endpoint

add_action('rest_api_init', 'thedesignerclub_leading_upcoming_orders_orders_api_endpoint');
function thedesignerclub_leading_upcoming_orders_orders_api_endpoint($request)
{

    register_rest_route('wp/v2', 'leading_upcoming_orders', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_leading_upcoming_orders_orders_api',
    ));
}
function thedesignerclub_leading_upcoming_orders_orders_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $productData = [];

    $user_id = $request->get_param('user_id');

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Something went wrong for orders tab!!!';
    } else {

        $vendor_products = get_commission_products($user_id);

        if (isset($vendor_products) && !empty($vendor_products)) {

            $vendor_products = array_reverse($vendor_products);

            $total_cost = 0;

            foreach ($vendor_products as $product) {
                global $wpdb;
                $order_status = array('wc-completed', 'wc-processing');
                $results[] = $wpdb->get_col("
                    SELECT order_items.order_id
                    FROM {$wpdb->prefix}woocommerce_order_items as order_items
                    LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
                    LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
                    WHERE posts.post_type = 'shop_order'
                    AND posts.post_status IN ( '" . implode("','", $order_status) . "' )
                    AND order_items.order_item_type = 'line_item'
                    AND order_item_meta.meta_value = '$product->ID'
                ");
                $ids[] = $product->ID;
            }

            $c = 0;
            foreach ($results as $keys) {
                foreach ($keys as $key => $id) {
                    $result[] = $id;
                }
            }

            arsort($result);

            foreach ($result as $order_id) {
                $order = new WC_Order($order_id);

                $recent_author = get_user_by('ID', $order->customer_id);
                $get_avatar_author_url = get_avatar_url($recent_author->user_email);
                // Get user display name
                $author_display_name = $recent_author->display_name;
                $author_nicename = $recent_author->user_nicename;
                $get_author_gravatar = get_avatar_url($author_id, array('size' => 450));

                $chat_id = $wpdb->get_col("SELECT mgs_id FROM `wp_fep_participants` WHERE `mgs_participant` IN ($order->customer_id,$user_id) GROUP BY mgs_id HAVING COUNT(mgs_id) > 1 LIMIT 1
                    ");

                $items = $order->get_items();
                usort($items, function ($itemA, $itemB) {
                    $date_fromA = $itemA->get_meta('FROM', true);
                    $date_fromB = $itemB->get_meta('FROM', true);

                    return - ($date_fromA <=> $date_fromB);
                });

                foreach ($items as $item) {
                    if (!in_array($item->get_product_id(), $ids)) {
                        continue;
                    }
                    $ID = $item->get_product_id();
                    $the_post = get_post($item->get_product_id());

                    $productData[] = $order_id;
                }
            }
            $response['status_code'] = 200;
            $response['data'] = $productData;
            $response['message'] = 'Upcoming order list successfully!!!';
        } else {
            $response['status_code'] = '2';
            $response['message'] = 'Upcoming order not found...';
        }
    }

    return $response;
}

//End Upcoming order tab api endpoint

//Start Completed order tab api endpoint

add_action('rest_api_init', 'thedesignerclub_leading_completed_orders_api_endpoint');
function thedesignerclub_leading_completed_orders_api_endpoint($request)
{

    register_rest_route('wp/v2', 'leading_completed_orders', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_leading_completed_orders_api',
    ));
}
function thedesignerclub_leading_completed_orders_api(WP_REST_Request $request)
{

    global $wpdb;
    $response = [];
    $productData = [];
    $user_id = $request->get_param('user_id');

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Something went wrong for orders tab!!!';
    } else {

        $vendor_products = get_commission_products($user_id);

        if (isset($vendor_products) && !empty($vendor_products)) {

            $vendor_products = array_reverse($vendor_products);

            $total_cost = 0;

            foreach ($vendor_products as $product) {
                global $wpdb;
                $order_status = array('wc-completed', 'wc-cancelled');
                $results[] = $wpdb->get_col("
                    SELECT order_items.order_id
                    FROM {$wpdb->prefix}woocommerce_order_items as order_items
                    LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
                    LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
                    WHERE posts.post_type = 'shop_order'
                    AND posts.post_status IN ( '" . implode("','", $order_status) . "' )
                    AND order_items.order_item_type = 'line_item'
                    AND order_item_meta.meta_value = '$product->ID'
                ");
                $ids[] = $product->ID;
            }

            $c = 0;
            foreach ($results as $keys) {
                foreach ($keys as $key => $id) {
                    $result[] = $id;
                }
            }

            arsort($result);

            foreach ($result as $order_id) {
                $order = new WC_Order($order_id);

                $items = $order->get_items();

                foreach ($items as $item) {
                    if (!in_array($item->get_product_id(), $ids)) {
                        continue;
                    }
                    $ID = $item->get_product_id();
                    $the_post = get_post($item->get_product_id());
                    $productData[] = $order_id;
                }
            }
            $response['status_code'] = 200;
            $response['data'] = $productData;
            $response['message'] = 'Completed order list successfully!!!';
        } else {
            $response['status_code'] = '2';
            $response['message'] = 'Completed order not found...';
        }
    }

    return $response;
}

//End Upcoming order tab api endpoint

//Start Dispute custom post type

function create_designerclub_dispute_post_type()
{
    register_post_type(
        'designerclub_dispute',
        array(
            'labels' => array(
                'name' => 'Dispute',
                'singular_name' => 'Dispute',
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
        )
    );
}
add_action('init', 'create_designerclub_dispute_post_type');

//End Dispute custom post type

// Start Dispute enquiry api endpoin

add_action('rest_api_init', 'thedesignerclub_dispute_message_api_endpoint');
function thedesignerclub_dispute_message_api_endpoint($request)
{

    register_rest_route('wp/v2', 'dispute_message', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_dispute_message_api',
    ));
}
function thedesignerclub_dispute_message_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $product_id = $request->get_param('product_id');
    $dispute_content = $request->get_param('dispute_content');

    if (empty($product_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Product id is missing!!!';
    } elseif (empty($dispute_content)) {
        $response['status_code'] = 404;
        $response['message'] = 'Dispute content is missing!!!';
    } else {

        $product = get_post($product_id);
        $product_title = $product->post_title . ' - #' . $product_id;
        $product_image = get_post_thumbnail_id($product_id, 'full');
        $thumbnail_id = $product_image;

        if ($product) {
            // Gather post data.
            $dispute_post = array(
                'post_type' => 'designerclub_dispute',
                'post_title' => $product_title,
                'post_content' => $dispute_content,
                'post_status' => 'publish',
                '_thumbnail_id' => $thumbnail_id,
            );

            // Insert the post into the database.
            wp_insert_post($dispute_post);
            $response['status_code'] = 200;
            $response['data'] = $dispute_post;
            $response['message'] = 'Thank you for Dispute message. It has been sent.!!!';
        } else {
            $response['status_code'] = 404;
            $response['message'] = 'Product not found!!!';
        }
    }

    return $response;
}

// End Dispute enquiry api endpoint


//Start Chat user sid save data api endpoints
function designerclub_chat_user_sid_data_save_fn($user_id, $user_id_second, $product_iD, $chat_sid)
{

    global $wpdb;

    $thedesignerclub_user_tablename = $wpdb->prefix . 'designerclub_chat_user_sid_data';

    //Save Phone Number With userID in database
    $wpdb->insert($thedesignerclub_user_tablename, array(
        'user_id' => $user_id,
        'user_id_second' => $user_id_second,
        'product_iD' => $product_iD,
        'chat_sid' => $chat_sid,
    ));
}

add_action('rest_api_init', 'thedesignerclub_chat_user_sid_data_api_endpoint');
function thedesignerclub_chat_user_sid_data_api_endpoint($request)
{

    register_rest_route('wp/v2', 'charsidsave', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_chat_user_sid_data_api',
    ));
}
function thedesignerclub_chat_user_sid_data_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $user_id = $request->get_param('user_id');
    $user_id_second = $request->get_param('user_id_second');
    $product_iD = $request->get_param('product_iD');
    $chat_sid = $request->get_param('chat_sid');

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';
    } elseif (empty($user_id_second)) {
        $response['status_code'] = 404;
        $response['message'] = 'Opposite user id is missing!!!';
    } elseif (empty($product_iD)) {
        $response['status_code'] = 404;
        $response['message'] = 'Product id is missing!!!';
    } elseif (empty($chat_sid)) {
        $response['status_code'] = 404;
        $response['message'] = 'Chat sid is missing!!!';
    } else {
        designerclub_chat_user_sid_data_save_fn($user_id, $user_id_second, $product_iD, $chat_sid);
        $response['status_code'] = 200;
        $response['data'] = array(
            'user_id' => $user_id,
            'user_id_second' => $user_id_second,
            'product_iD' => $product_iD,
            'chat_sid' => $chat_sid,
        );
        $response['message'] = 'Chat user data add in successfully!!!';
    }

    return $response;
}
//End Chat user sid save data api endpoints

//Start Provide chat sid api endpoint

add_action('rest_api_init', 'thedesignerclub_provide_chatsid_api_endpoint');
function thedesignerclub_provide_chatsid_api_endpoint($request)
{

    register_rest_route('wp/v2', 'provide_chatsid', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_provide_chatsid_api',
    ));
}
function thedesignerclub_provide_chatsid_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];
    $user_id = $request->get_param('user_id');
    $user_id_second = $request->get_param('user_id_second');
    $product_iD = $request->get_param('product_iD');

    $sql = "SELECT * FROM `wp_designerclub_chat_user_sid_data` WHERE user_id=" . $user_id . " AND user_id_second=" . $user_id_second . " AND product_iD=" . $product_iD . "";

    $check = $wpdb->get_results($sql);

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';
    } elseif (empty($user_id_second)) {
        $response['status_code'] = 404;
        $response['message'] = 'Second user id is not found!!!';
    } elseif (empty($product_iD)) {
        $response['status_code'] = 404;
        $response['message'] = 'Product id is not found!!!';
    } else {
        if (!empty($check)) {

            foreach ($check as $key => $value) {
                $response['status_code'] = 200;
                $response['data'] = $value->chat_sid;
                $response['message'] = 'Chat sid fetch successfully!!!';
            }
        }
    }

    return $response;
}

//End Provide chat sid api endpoint

// Register the custom REST API endpoint

add_action('rest_api_init', 'designerclub_custom_api_endpoint');
function designerclub_custom_api_endpoint()
{
    register_rest_route('wc/v3', '/create-order', array(
        'methods' => 'POST',
        'callback' => 'designerclub_create_order_api_callback',
    ));
    register_rest_route('wc/v3', '/cancel-order', array(
        'methods' => 'POST',
        'callback' => 'designerclub_cancel_order_api_callback',
    ));
    register_rest_route('wc/v3', '/capture-payment', array(
        'methods'  => 'POST',
        'callback' => 'designerclub_custom_capture_payment_endpoint_callback',
    ));
    register_rest_route('wc/v3', '/search-rentel', array(
        'methods'  => 'GET',
        'callback' => 'designerclub_custom_search_renter_endpoint_callback',
    ));
    register_rest_route('wc/v3', '/lender-payout', array(
        'methods'  => 'POST',
        'callback' => 'designerclub_custom_weekly_settlement_of_leander_callback',
    ));
    register_rest_route('wc/v3', '/product-filter', array(
        'methods'  => 'GET',
        'callback' => 'designerclub_custom_product_filter_callback',
    ));
    register_rest_route('wc/v3', '/product_filter', array(
        'methods'  => 'GET',
        'callback' => 'custom_product_filter_callback',
    ));
}

function designerclub_custom_product_filter_callback($request)
{
    $response = [];
    $metaarr = [];

    $keyword = $request->get_param('keyword');
    $min_price = $request->get_param('min_price');
    $max_price = $request->get_param('max_price');
    $size = $request->get_param('size');
    $color = $request->get_param('color');
    $category = $request->get_param('category');

    if (!empty($min_price) && !empty($max_price)) {
        $meta_price[] = array(
            'key' => 'rental_price',
            'value' => array($min_price, $max_price),
            'type' => 'DECIMAL',
            'compare' => 'BETWEEN',
        );
    }
    if (!empty($size)) {
        $metaarr[] = array(
            'taxonomy' => 'pa_size',
            'field' => 'slug',
            'terms' => $size,
        );
    }

    if (!empty($color)) {
        $metaarr[] = array(
            'taxonomy' => 'pa_color',
            'field' => 'slug',
            'terms' => $color,
        );
    }

    if (!empty($metaarr)) {

        $meta_query = array(
            'relation' => 'OR',
            $metaarr,
        );
    }

    if (!empty($category)) {
        $tax_query = array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $category,
            ),
        );
    }

    if (!empty($keyword)) {
        $product_args['post_type'] = 'product';
        $product_args['s'] = $keyword;
        $product_args['post_status'] = 'publish';
        $product_args['orderby'] = 'meta_value_num';
        $product_args['meta_key'] = 'rental_price';
        $product_args['order'] = 'DESC';
        $product_args['posts_per_page'] = -1;
        if (!empty($meta_price)) {
            $product_args['meta_query'] = $meta_price;
        }
        if ((!empty($meta_price)) && (!empty($meta_query))) {
            $product_args['meta_query'] = $meta_price;
            $product_args['tax_query'] = $meta_query;
        }
        if ((!empty($tax_query)) && (!empty($meta_query))) {
            $product_args['tax_query'] = $tax_query;
            $product_args['tax_query'] = $meta_query;
        }
        if ((!empty($tax_query)) && (!empty($meta_price))) {
            $product_args['tax_query'] = $tax_query;
            $product_args['meta_query'] = $meta_price;
        }
        if (!empty($tax_query) && (!empty($meta_price)) && (!empty($meta_query))) {
            $product_args['meta_query'] = $meta_price;
            $product_args['tax_query'] = $tax_query;
            $product_args['tax_query'] = $meta_query;
        }
    } else {
        $product_args['post_type'] = 'product';
        $product_args['post_status'] = 'publish';
        $product_args['orderby'] = 'meta_value_num';
        $product_args['meta_key'] = 'rental_price';
        $product_args['order'] = 'DESC';
        $product_args['posts_per_page'] = -1;
        if (!empty($meta_price)) {
            $product_args['meta_query'] = $meta_price;
        }
        if ((!empty($meta_price)) && (!empty($meta_query))) {
            $product_args['meta_query'] = $meta_price;
            $product_args['tax_query'] = $meta_query;
        }
        if ((!empty($tax_query)) && (!empty($meta_query))) {
            $product_args['tax_query'] = $tax_query;
            $product_args['tax_query'] = $meta_query;
        }
        if ((!empty($tax_query)) && (!empty($meta_price))) {
            $product_args['tax_query'] = $tax_query;
            $product_args['meta_query'] = $meta_price;
        }
        if (!empty($tax_query) && (!empty($meta_price)) && (!empty($meta_query))) {
            $product_args['meta_query'] = $meta_price;
            $product_args['tax_query'] = $tax_query;
            $product_args['tax_query'] = $meta_query;
        }
    }

    /*    echo "<pre>";
    print_r($product_args);
    echo "</pre>";
    die; */
    $product_loop = new WP_Query($product_args);


    if ($product_loop->have_posts()) {
        while ($product_loop->have_posts()) {
            $product_loop->the_post();

            $product = wc_get_product(get_the_ID());
            $product_categories = get_the_terms(get_the_ID(), 'product_cat');
            $categories = array();
            foreach ($product_categories as $category) {
                $categories[] = array(
                    'id' => $category->term_id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                );
            }
            /* echo "<pre>";
            print_r($product);
            echo "</pre>"; */
            /*    $product_ID = get_the_ID(); */
            $products[] = $product->get_id();

            /* $response['data'][] = $product_ID; */
           /*  $products[] = array(
                'id' => $product->get_id(),
                'name' => $product->get_name(),
                'price' =>  get_post_meta($product->get_id(), 'rrp', true),
                'color' => $product->get_attribute('pa_color'),
                'size' => $product->get_attribute('pa_size'),
                'categories' => $categories,
            ); */
        }
        wp_reset_postdata();
        $response['data'] = $products;
        $response['status_code'] = 200;
        $response['message'] = 'Product searching successfully!!!';
    } else {
        $response['status_code'] = 404;
        $response['message'] = 'Apologies, but no results were found. Perhaps searching will help find a related post.';
    }

    return $response;
}
 function custom_product_filter_callback($request)
{
    $response = [];
    $metaarr = [];

    $keyword = $request->get_param('keyword');
    $min_price = $request->get_param('min_price');
    $max_price = $request->get_param('max_price');
    $size = $request->get_param('size');
    $color = $request->get_param('color');
    $category = $request->get_param('category');

    if (!empty($min_price) && !empty($max_price)) {
        $meta_price[] = array(
            'key' => 'rental_price',
            'value' => array($min_price, $max_price),
            'type' => 'DECIMAL',
            'compare' => 'BETWEEN',
        );
    }
    if (!empty($size)) {
        $metaarr[] = array(
            'taxonomy' => 'pa_size',
            'field' => 'slug',
            'terms' => $size,
        );
    }

    if (!empty($color)) {
        $metaarr[] = array(
            'taxonomy' => 'pa_color',
            'field' => 'slug',
            'terms' => $color,
        );
    }

    if (!empty($metaarr)) {

        $meta_query = array(
            'relation' => 'OR',
            $metaarr,
        );
    }

    if (!empty($category)) {
        $tax_query = array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $category,
            ),
        );
    }

    if (!empty($keyword)) {
        $product_args['post_type'] = 'product';
        $product_args['s'] = $keyword;
        $product_args['post_status'] = 'publish';
        $product_args['orderby'] = 'meta_value_num';
        $product_args['meta_key'] = 'rental_price';
        $product_args['order'] = 'DESC';
        $product_args['posts_per_page'] = -1;
        if (!empty($meta_price)) {
            $product_args['meta_query'] = $meta_price;
        }
        if ((!empty($meta_price)) && (!empty($meta_query))) {
            $product_args['meta_query'] = $meta_price;
            $product_args['tax_query'] = $meta_query;
        }
        if ((!empty($tax_query)) && (!empty($meta_query))) {
            $product_args['tax_query'] = $tax_query;
            $product_args['tax_query'] = $meta_query;
        }
        if ((!empty($tax_query)) && (!empty($meta_price))) {
            $product_args['tax_query'] = $tax_query;
            $product_args['meta_query'] = $meta_price;
        }
        if (!empty($tax_query) && (!empty($meta_price)) && (!empty($meta_query))) {
            $product_args['meta_query'] = $meta_price;
            $product_args['tax_query'] = $tax_query;
            $product_args['tax_query'] = $meta_query;
        }
    } else {
        $product_args['post_type'] = 'product';
        $product_args['post_status'] = 'publish';
        $product_args['orderby'] = 'title';
        $product_args['orderby'] = 'meta_value_num';
        $product_args['meta_key'] = 'rental_price';
        $product_args['order'] = 'DESC';
        $product_args['posts_per_page'] = -1;
        if (!empty($meta_price)) {
            $product_args['meta_query'] = $meta_price;
        }
        if ((!empty($meta_price)) && (!empty($meta_query))) {
            $product_args['meta_query'] = $meta_price;
            $product_args['tax_query'] = $meta_query;
        }
        if ((!empty($tax_query)) && (!empty($meta_query))) {
            $product_args['tax_query'] = $tax_query;
            $product_args['tax_query'] = $meta_query;
        }
        if ((!empty($tax_query)) && (!empty($meta_price))) {
            $product_args['tax_query'] = $tax_query;
            $product_args['meta_query'] = $meta_price;
        }
        if (!empty($tax_query) && (!empty($meta_price)) && (!empty($meta_query))) {
            $product_args['meta_query'] = $meta_price;
            $product_args['tax_query'] = $tax_query;
            $product_args['tax_query'] = $meta_query;
        }
    }

        /* echo "<pre>";
    print_r($product_args);
    echo "</pre>";
    die;  */
    $product_loop = new WP_Query($product_args);


    if ($product_loop->have_posts()) {
        while ($product_loop->have_posts()) {
            $product_loop->the_post();

            $product = wc_get_product(get_the_ID());
            $product_categories = get_the_terms(get_the_ID(), 'product_cat');
            $categories = array();
            foreach ($product_categories as $category) {
                $categories[] = array(
                    'id' => $category->term_id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                );
            }
            /* echo "<pre>";
            print_r($product);
            echo "</pre>"; */
            /*    $product_ID = get_the_ID(); */
           // $products[] = $product->get_id();

            /* $response['data'][] = $product_ID; */
             $products[] = array(
                'id' => $product->get_id(),
                'name' => $product->get_name(),
                'price' =>  get_post_meta($product->get_id(), 'rental_price', true),
                'color' => $product->get_attribute('pa_color'),
                'size' => $product->get_attribute('pa_size'),
                'categories' => $categories,
            ); 
        }
        wp_reset_postdata();
        $response['data'] = $products;
        $response['status_code'] = 200;
        $response['message'] = 'Product searching successfully!!!';
    } else {
        $response['status_code'] = 404;
        $response['message'] = 'Apologies, but no results were found. Perhaps searching will help find a related post.';
    }

    return $response;
} 
function designerclub_create_order_api_callback($request)
{
    $response = [];

    global $stripe;
    $parameters         = $request->get_params();
    $customer_id        = $request->get_param('customer_id');
    $customer_name      = $request->get_param('customer_name');
    $amount             = $parameters['amount'];
    $shipping_charges   = $parameters['shipping_total'];
    $coupon_code        = $parameters['coupon_code'];
    $discount_total     = $parameters['discount_total'];
    $customer_token     = $parameters['customer_token'];
    $pm_token           = $parameters['pm_token'];

    $error          = new WP_Error();
    $customer = new WC_Customer($customer_id);

    if (empty($customer_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Customer id is not found!!!';
    }
    if (empty($amount)) {
        $response['status_code'] = 404;
        $response['message'] = 'Amount is missing!!!';
    }
    if (empty($shipping_charges)) {
        $response['status_code'] = 404;
        $response['message'] = 'Shiphing is missing!!!';
    }

    // Use the WooCommerce API to create a new order and add the card token as a payment method
    $order_data = array(
        'payment_method' => 'stripe',
        'payment_method_title' => 'Credit Card',
        'set_paid' => true,
        'billing' => array(
            'first_name' => $parameters['billing_first_name'],
            'last_name' => $parameters['billing_last_name'],
            'address_1' => $parameters['billing_address_1'],
            'address_2' => $parameters['billing_address_2'],
            'city' => $parameters['billing_city'],
            'state' => $parameters['billing_state'],
            'postcode' => $parameters['billing_postcode'],
            'country' => $parameters['billing_country'],
            'email' => $parameters['billing_email'],
            'phone' => $parameters['billing_phone'],
        ),
        'line_items' => $parameters['line_items'],
        'shipping_total' => $parameters['shipping_total']
    );
    global $woocommerce;
    $order = wc_create_order();

    $order->set_address($order_data['billing'], 'billing');
    $order->set_address($order_data['billing'], 'shipping');

    $order->set_payment_method('stripe');
    $order->set_payment_method_title('Credit Card');

    foreach ($order_data['line_items'] as $value) {
        $product_id = $value['product_id'];
        $lineItemId = $order->add_product(wc_get_product($product_id), 1, [
            'subtotal'     => $value['price'],
            'total'        => $value['price'],
        ]);
        wc_update_order_item_meta($lineItemId, 'FROM',     $value['FROM']);
        wc_update_order_item_meta($lineItemId, 'TO',       $value['TO']);
        wc_update_order_item_meta($lineItemId, 'Size',     $value['Size']);
        wc_update_order_item_meta($lineItemId, 'Rent By',  $value['Rent By']);
    }
    // Add service fees 
    $fees_item                 = new WC_Order_Item_Fee();
    $fees_item->set_props(
        array(
            'name'      => 'Service Fee',
            'amount'    => $parameters['service_fee'],
            'total'     => $parameters['service_fee'],
        )
    );
    do_action('woocommerce_checkout_create_order_fee_item', $fees_item, $order);
    $order->add_item($fees_item);
    $order->save();

    $shipping_item = new WC_Order_Item_Shipping();
    $shipping_item->set_method_title('Flat rate');
    $shipping_item->set_method_id('free_shipping:1');
    $shipping_item->set_total($shipping_charges);

    $order->add_item($shipping_item);

    if (!empty($coupon_code) && !empty($discount_total)) { //$order->remove_item( $line_item_id );

        wc_delete_order_item($line_item_id);
        wc_delete_order_item_meta($line_item_id);
        $order->add_coupon($coupon_code, $discount_total);
    }
    update_post_meta($order->id, '_cart_discount', $discount_total);
    update_post_meta($order->id, '_recorded_coupon_usage_counts', 'yes');
    update_post_meta($order->id, '_order_shipping', $shipping_charges);
    update_post_meta($order->id, '_order_total', $amount);
    update_post_meta($order->id, '_customer_user',  $customer_id);

    add_post_meta($order->id, '_app_order', 'yes', true);

    $transaction_id = $order->get_transaction_id();
    update_post_meta($order->id, '_transaction_id',  $transaction_id);

    $order->set_status('wc-processing', 'Order is created programmatically');
    $order->save();


    // $order->update_status('wc-processing', 'Order created...');
    // Return a response
    try {
        $order = new WC_Order($order->id);

        $registration_ids = get_user_meta($customer_id, 'device_token', true);

        $data = [
            'title' => 'Your Order',
            'message' => 'processed successfully',
            'order_id' => $order->id,
            'user_id' =>  $customer_id,
            'notification_tag' => 'Order Created',
        ];
        $response['notification'] = send_notification($registration_ids, $data);
        insert_notification_data($data);

        $stripe = new \Stripe\StripeClient(
            STRIPE_SECRET_KEY
        );
        global $stripe;
        $paymentIntent =  $stripe->paymentIntents->create([
            'amount'               => $order->get_total() * 100,
            'currency'             => $order->get_currency(),
            'customer'             => $customer_token,
            'payment_method'       => $pm_token,
            'automatic_payment_methods' => [
                'enabled' => 'false',
            ],
            'payment_method_options' => [
                'card' => [
                    'capture_method' => 'manual',
                ],
            ],
        ]);
        $paymentIntent_Confirmed =  $stripe->paymentIntents->confirm(
            $paymentIntent->id,
            ['payment_method' => $pm_token]
        );
        add_post_meta($order->id, '_payment_intent_id', $paymentIntent->id);
        update_post_meta($order->id, '_transaction_id',  $paymentIntent->id);
        $order->add_order_note(sprintf(__('Stripe charge complete (Payment Intent ID: %s)', 'woocommerce-gateway-stripe'), $paymentIntent->id));

        global $wpdb;
        $sql = 'DELETE FROM `wp_designerclub_cart_data_save_from_app` WHERE user_id = ' . $customer_id;
        $wpdb->query($sql);
        $response = array(
            'data'        => ['order_id' => $order->id, 'payment_method' => $pm_token, 'payment_intent_id' => $paymentIntent->id, 'capture_created_date' => $paymentIntent_Confirmed->created],
            'status_code' =>  200,
            'message'     => 'Order processed and captured payment successfully'
        );
        $registration_ids = get_user_meta($customer_id, 'device_token', true);

        $data = [
            'title' => 'Your payment with',
            'message' => 'has been captured successfully',
            'order_id' => $order->id,
            'user_id' =>  $customer_id,
            'notification_tag' => 'Payment captured',
        ];
        $response['notification'] = send_notification($registration_ids, $data);
        insert_notification_data($data);
    } catch (Exception $e) {
        $response = array(
            'status_code' => 404,
            'message'     => 'Order cannot be processed ' . 'Stripe error' . $e->getMessage()
        );
    }
    return new WP_REST_Response($response, 200);
}
function designerclub_cancel_order_api_callback($request)
{
    $response = [];

    global $stripe;
    $parameters         =  $request->get_params();
    $line_item_id       =  $parameters['line_item_id'];
    $order_id           =  $parameters['order_id'];
    $user_id            =  $parameters['user_id'];
    try {
        $order = wc_get_order($order_id);
        if ($order) {
            foreach ($order->get_items() as $item_id => $item) {
                if ($item_id == $line_item_id) {
                    wc_update_order_item_meta($item_id, 'thwma_order_shipping_status', 'wc-cancelled');
                    $order->update_status('cancelled');
                    $response['data'] = $order->get_status();
                    $response['status_code'] = 200;
                    $response['message'] = "Order item has been cancelled successfully!!!";

                    $registration_ids = get_user_meta($user_id, 'device_token', true);
                    $data = [
                        'title' => 'Order Cancelled',
                        'message' => 'has been cancelled',
                        'user_id' =>  $user_id,
                        'order_id' =>  $order_id,
                        'notification_tag' => 'Order cancelled',
                    ];
                    $response['notification'] = send_notification($registration_ids, $data);
                    insert_notification_data($data);
                }
            }
        }
    } catch (Exception $e) {
        $response['data'] = $e->getMessage();
        $response['status_code'] = 404;
        $response['message'] = "Order item can not be cancelled!!!";
    }
    return $response;
}
function designerclub_custom_cron_schedule($schedules)
{
    $schedules['every_five_mins'] = array(
        'interval' => 300, // Every 6 hours
        'display'  => __('Every 5 mins'),
    );
    return $schedules;
}
add_filter('cron_schedules', 'designerclub_custom_cron_schedule');

//Schedule an action if it's not already scheduled
if (!wp_next_scheduled('designerclub_cron_hook')) {
    wp_schedule_event(time(), 'every_five_mins', 'designerclub_cron_hook');
}
add_action('designerclub_cron_hook', 'designerclub_custom_weekly_settlement_of_leander_cron_callback');


/* Corn job for every 24 hours */
if (!wp_next_scheduled('designerclub_check_order_intent')) { // if it hasn't been scheduled
    wp_schedule_event(strtotime('12:00:00'), 'daily', 'designerclub_check_order_intent');
}
add_action('designerclub_check_order_intent', 'designerclub_order_check_cron_callback');
add_action('designerclub_check_order_intent', 'designerclub_custom_weekly_settlement_of_leander_cron_callback');

function designerclub_custom_capture_payment_endpoint_callback($request)
{
    $response = [];
    try {
        global $stripe;
        $stripe = new \Stripe\StripeClient(
            STRIPE_SECRET_KEY
        );
        $order_args = array(
            'meta_key'      => '_app_order',
            'meta_value'    => 'yes',
            'meta_compare'  => '=',
        );
        $orders = wc_get_orders($order_args);
        foreach ($orders as $order) {
            $order_id               = $order->id;
            $order                  =  new WC_Order($order_id);
            $payment_intent_id      = get_post_meta($order_id, '_payment_intent_id', true);
            $order_items = $order->get_items();
            foreach ($order_items as $item) {
                $order_product_id    = $item->get_product_id();
                $booking_date        = $item->get_meta("FROM");
                $booking_end_date    = $item->get_meta("TO");
                if (isset($order_id)) {
                    $accept_reject_admin = null;
                    $post = get_post($order_product_id);
                    $post_author = $post->post_author;
                    $author_id = get_post_field('post_author', $order_product_id);
                    $admin_user = get_user_by('login', 'designerclub');
                    $admin_id = $admin_user->ID;

                    if ($author_id == $admin_id) {
                        $order_accept_reject = get_user_meta($admin_id, 'vendor_report_accept_reject_admin_' . $order_id . '_' . $order_product_id, $order_accept_reject);
                    } else {
                        $order_accept_reject = get_user_meta($author_id, 'vendor_report_accept_reject_lender_' . $order_id . '_' . $order_product_id, $order_accept_reject);
                    }
                    if ($order_accept_reject == 'accepted') {
                        $today_date = date('Y/m/d');
                        $booking_date_timestamp = strtotime($booking_date);
                        $today_date_timestamp   = strtotime($today_date);
                        if ($booking_date_timestamp == $today_date_timestamp) {
                            $stripe->paymentIntents->capture(
                                $payment_intent_id
                            );
                            $response['message'] =  "Payment captured";
                            $response['status_code'] =  200;
                            $order->update_status('completed', 'Payment Captured via Stripe');


                            $to = 'madhvik.hyperlinkinfosystem@gmail.com';
                            $subject = "Payment captured" . $order->id;
                            $message = 'Payment captured while item is accepted.....';
                            $headers = 'From: ' . $to . "\r\n" .
                                'Reply-To: ' . 'madhvik.hyperlinkinfosystem@gmail.com' . "\r\n";

                            //Here put your Validation and send mail
                            wp_mail($to, $subject, $message, $headers);
                        } else {
                            $stripe->paymentIntents->update(
                                $payment_intent_id,
                                ['metadata' => ['order_id' => $order_id]]
                            );
                            $response['message'] = "Payment captured updated";
                            $response['status_code'] =  200;

                            $to = 'madhvik.hyperlinkinfosystem@gmail.com';
                            $subject = "Payment intent is updated" . $order->id . $payment_intent_id;
                            $message = 'Payment intent is updated as the booking date is more than 7 days it accepted';
                            $headers = 'From: ' . $to . "\r\n" .
                                'Reply-To: ' . 'madhvik.hyperlinkinfosystem@gmail.com' . "\r\n";

                            //Here put your Validation and send mail
                            wp_mail($to, $subject, $message, $headers);
                        }
                    } elseif ($order_accept_reject == 'rejected') {
                        $stripe->paymentIntents->cancel(
                            $payment_intent_id,
                            []
                        );
                        $order->update_status('cancelled', 'Payment cannot capture order cancelled');
                        $response['message'] =  "Payment Intent created has been cancelled";
                        $response['status_code'] =  200;

                        $to = 'madhvik.hyperlinkinfosystem@gmail.com';
                        $subject = "Payment intent is cancelled when item is rejected " . $order->id;
                        $message = 'Payment intent is cancelled  also order is being cancelled when item is rejected....';
                        $headers = 'From: ' . $to . "\r\n" .
                            'Reply-To: ' . 'madhvik.hyperlinkinfosystem@gmail.com' . "\r\n";

                        //Here put your Validation and send mail
                        wp_mail($to, $subject, $message, $headers);
                    } else {
                        // $order_date = $order->order_date;
                        $order_date = $order->get_date_created();
                        $order_timezone = $order->get_date_created()->getTimezone();
                        $current_time = new DateTime('now', $order_timezone);

                        // Calculate the time difference between the order date and the current time
                        $time_diff = $current_time->diff($order_date);

                        // Check if the time difference is greater than 1 hour
                        if ($time_diff->h >= 1 || $time_diff->days > 0) {
                            echo "It has been more than 1 hour since the order was placed.";
                            $stripe->paymentIntents->cancel(
                                $payment_intent_id,
                                []
                            );
                            $order->update_status('cancelled', 'Payment cannot capture order cancelled');
                            $response['message'] =  "Payment Intent created has been cancelled";
                            $response['status_code'] =  200;

                            $to = 'madhvik.hyperlinkinfosystem@gmail.com';
                            $subject = "Payment intent is cancelled as item has no action  " . $order->id;
                            $message = 'Payment intent and order has been cancelled as there is no action more than 24 hours for as of now it is for 1 hour....';
                            $headers = 'From: ' . $to . "\r\n" .
                                'Reply-To: ' . 'madhvik.hyperlinkinfosystem@gmail.com' . "\r\n";

                            //Here put your Validation and send mail
                            wp_mail($to, $subject, $message, $headers);
                        } else {
                            $to = 'madhvik.hyperlinkinfosystem@gmail.com';
                            $subject = "Payment intent is cancelled as item has no action  " . $order->id;
                            $message = 'It has not been more than 1 hour since the order was placed. so no order cancellation is there...';
                            $headers = 'From: ' . $to . "\r\n" .
                                'Reply-To: ' . 'madhvik.hyperlinkinfosystem@gmail.com' . "\r\n";

                            //Here put your Validation and send mail
                            wp_mail($to, $subject, $message, $headers);
                            echo "It has not been more than 1 hour since the order was placed.";
                            $response['message'] =  "Order has not cancelled";
                            $response['status_code'] =  200;
                        }
                    }
                }
            }
            $response['message'] = "Passed from all the conditions!!!";
            $response['status_code'] = 200;
        }
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
        $response['status_code'] = 404;
    }
    return $response;
}

function designerclub_order_check_cron_callback()
{
    try {
        global $stripe;
        $stripe = new \Stripe\StripeClient(
            STRIPE_SECRET_KEY
        );
        $order_args = array(
            'meta_key'      => '_app_order',
            'meta_value'    => 'yes',
            'meta_compare'  => '=',
        );
        $orders = wc_get_orders($order_args);
        foreach ($orders as $order) {
            $order_id               = $order->id;
            $order                  =  new WC_Order($order_id);
            $payment_intent_id      = get_post_meta($order_id, '_payment_intent_id', true);
            $order_items = $order->get_items();
            foreach ($order_items as $item) {
                $order_product_id    = $item->get_product_id();
                $booking_date        = $item->get_meta("FROM");
                $booking_end_date    = $item->get_meta("TO");
                if (isset($order_id)) {
                    $accept_reject_admin = null;
                    $post = get_post($order_product_id);
                    $post_author = $post->post_author;
                    $author_id = get_post_field('post_author', $order_product_id);
                    $admin_user = get_user_by('login', 'designerclub');
                    $admin_id = $admin_user->ID;

                    if ($author_id == $admin_id) {
                        $order_accept_reject = get_user_meta($admin_id, 'vendor_report_accept_reject_admin_' . $order_id . '_' . $order_product_id, $order_accept_reject);
                    } else {
                        $order_accept_reject = get_user_meta($author_id, 'vendor_report_accept_reject_lender_' . $order_id . '_' . $order_product_id, $order_accept_reject);
                    }

                    if ($order_accept_reject == 'accepted') {
                        $today_date = date('Y/m/d');
                        $booking_date_timestamp = strtotime($booking_date);
                        $today_date_timestamp   = strtotime($today_date);
                        if ($booking_date_timestamp == $today_date_timestamp) {
                            $stripe->paymentIntents->capture(
                                $payment_intent_id
                            );
                            $order->update_status('completed', 'Payment Captured via Stripe');

                            $to = 'madhvik.hyperlinkinfosystem@gmail.com';
                            $subject = "Payment captured " . $order->id;
                            $message = 'Payment captured while item is accepted.....';
                            $headers = 'From: ' . $to . "\r\n" .
                                'Reply-To: ' . 'madhvik.hyperlinkinfosystem@gmail.com' . "\r\n";

                            //Here put your Validation and send mail
                            wp_mail($to, $subject, $message, $headers);
                        } else {
                            $stripe->paymentIntents->update(
                                $payment_intent_id,
                                ['metadata' => ['order_id' => $order_id]]
                            );

                            echo "Payment captured updated";

                            $to = 'madhvik.hyperlinkinfosystem@gmail.com';
                            $subject = "Payment intent is updated  " . $order->id . " " . $payment_intent_id;
                            $message = 'Payment intent is updated as the booking date is more than 7 days it accepted';
                            $headers = 'From: ' . $to . "\r\n" .
                                'Reply-To: ' . 'madhvik.hyperlinkinfosystem@gmail.com' . "\r\n";

                            //Here put your Validation and send mail
                            wp_mail($to, $subject, $message, $headers);
                        }
                    } elseif ($order_accept_reject == 'rejected') {
                        $stripe->paymentIntents->cancel(
                            $payment_intent_id,
                            []
                        );
                        $order->update_status('cancelled', 'Payment cannot capture order cancelled');
                        echo  "Payment Intent created has been cancelled";

                        $to = 'madhvik.hyperlinkinfosystem@gmail.com';
                        $subject = "Payment intent is cancelled when item is rejected " . $order->id;
                        $message = 'Payment intent is cancelled  also order is being cancelled when item is rejected....';
                        $headers = 'From: ' . $to . "\r\n" .
                            'Reply-To: ' . 'madhvik.hyperlinkinfosystem@gmail.com' . "\r\n";

                        //Here put your Validation and send mail
                        wp_mail($to, $subject, $message, $headers);
                    } else {
                        // $order_date = $order->order_date;
                        $order_date = $order->get_date_created();
                        $order_timezone = $order->get_date_created()->getTimezone();
                        $current_time = new DateTime('now', $order_timezone);

                        // Calculate the time difference between the order date and the current time
                        $time_diff = $current_time->diff($order_date);

                        // Check if the time difference is greater than 1 hour
                        if ($time_diff->h >= 24 || $time_diff->days > 0) {
                            echo "It has been more than 1 hour since the order was placed.";
                            $stripe->paymentIntents->cancel(
                                $payment_intent_id,
                                []
                            );
                            $order->update_status('cancelled', 'Payment cannot capture order cancelled');
                            echo  "Payment Intent created has been cancelled";

                            $to = 'madhvik.hyperlinkinfosystem@gmail.com';
                            $subject = "Payment intent is cancelled as item has no action  " . $order->id;
                            $message = 'Payment intent and order has been cancelled as there is no action more than 24 hours for as of now it is for 1 hour....';
                            $headers = 'From: ' . $to . "\r\n" .
                                'Reply-To: ' . 'madhvik.hyperlinkinfosystem@gmail.com' . "\r\n";

                            //Here put your Validation and send mail
                            wp_mail($to, $subject, $message, $headers);
                        } else {
                            $to = 'madhvik.hyperlinkinfosystem@gmail.com';
                            $subject = "Payment intent is cancelled as item has no action  " . $order->id;
                            $message = 'It has not been more than 1 hour since the order was placed. so no order cancellation is there...';
                            $headers = 'From: ' . $to . "\r\n" .
                                'Reply-To: ' . 'madhvik.hyperlinkinfosystem@gmail.com' . "\r\n";

                            //Here put your Validation and send mail
                            wp_mail($to, $subject, $message, $headers);
                            echo "It has not been more than 1 hour since the order was placed.";
                            echo  "Order has not cancelled";
                        }
                    }
                }
            }
            echo "Passed from all the conditions!!!";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function designerclub_custom_search_renter_endpoint_callback($request)
{
    $params = $request->get_params();
    $search_query = isset($params['product_name']) ? $params['product_name'] : '';


    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        's' => $search_query,
    );

    $products = wc_get_products($args);


    $response_data = array();
    try {
        foreach ($products as $product) {
            $author_id = get_post_field('post_author', $product->id);
            // Get the custom field value
            $get_shoe_brand = get_post_meta($product->id, 'shoes_brand', true);
            $get_dress_brand = get_post_meta($product->id, 'dress_brand', true);
            $get_bag_brand = get_post_meta($product->id, 'bag_brand', true);
            $get_accessories_brand = get_post_meta($product->id, 'accessories_brand', true);
            //$product_categories =

            $response_data[] = array(
                'id' => $product->get_id(),
                'title' => $product->get_name(),
                /*'description' =>  array('shoe_brand'=>$get_shoe_brand,'dress_brand'=>$get_dress_brand,'bag_brand'=>$get_bag_brand,'accessories_brand'=>$get_accessories_brand), */
                'vendor_image_url' => get_avatar_url($author_id, array('size' => 450)),
                'rentPrice' => get_post_meta($product->id, 'rental_price', true),
                'RRP' => get_post_meta($product->id, 'rrp', true),
                'image' => wp_get_attachment_url(get_post_thumbnail_id($product->id)),
                'category' =>  get_the_terms($product->id, 'product_cat'),

            );
        }

        $response['status_code'] = 200;
        $response['data'] = $response_data;
        $response['message'] = 'Products found successfully!!!';
    } catch (Exception $e) {
        $response['status_code'] = 404;
        $response['error'] = $e->get_message();
        $response['message'] = 'Products not found!!!';
    }

    return new WP_REST_Response($response, 200);
}

if (isset($_REQUEST["id"]) && trim($_REQUEST["id"]) == 'link1') {

    $user_identity = get_userdata(2);
    echo "<pre>";
    //print_r($user_identity);
    print_r(create_twilio_user_add_in_twilio($user_identity->data));
    echo "</pre>";
    die;

    $color = 'white';
    $size = '8';
    $min_price = '80';
    $max_price = '800';
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        's' => $search_term,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'pa_color',
                'field' => 'slug',
                'terms' => $color,
            ),
            array(
                'taxonomy' => 'pa_size',
                'field' => 'slug',
                'terms' => $size,
            ),
        ),
        'meta_query' => array(
            array(
                'key' => '_price',
                'value' => array($min_price, $max_price),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            )
        )
    );

    $query = new WP_Query($args);

    echo "<pre>";
    print_r($query);
    echo "</pre>";
    die;
    // designerclub_custom_weekly_settlement_of_leander_cron_callback();
    $user_data  = get_userdata(1201);
    $user_meta  = get_user_meta(1201);
    echo "<pre>";
    print_r($user_data);
    print_r($user_meta);

    designerclub_order_check_cron_callback();

    //designerclub_custom_weekly_settlement_of_leander();



    $tax_query = array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => 'alice-mccall',
        ),
    );
    $product_args['post_type'] = 'product';
    $product_args['s'] = "dress";
    $product_args['post_status'] = 'publish';
    $product_args['posts_per_page'] = -1;
    $product_args['orderby'] = 'title';
    $product_args['order'] = 'ASC';
    $product_args['tax_query'] = $tax_query;
    if (!empty($meta_query)) {
        $product_args['meta_query'] = $meta_query;
    }
    if (!empty($tax_query)) {
    }
    $product_loop = new WP_Query($product_args);

    $query = new WC_Product_Query(array(
        'limit' => 10,
        'orderby' => 'date',
        'order' => 'DESC',
        'return' => 'ids',
    ));
    $products = $query->get_products();


    echo "<pre>";
    print_r($query);
    echo "</pre>";
    die;
    print_r($product_args);
}
add_action('rest_api_init', 'designerclub_api_endpoint');
function designerclub_api_endpoint()
{
    register_rest_route('wc/v3', '/filter_demo', array(
        'methods'  => 'GET',
        'callback' => 'designer_club__custom_product_meta',
    ));
}
function designer_club__custom_product_meta($request)
{
    $params = $request->get_params();
    $search_query = isset($params['product_name']) ? $params['product_name'] : '';


    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        's' => $search_query,
    );

    $products = wc_get_products($args);


    $response_data = array();
    try {
        foreach ($products as $product) {
            $author_id = get_post_field('post_author', $product->id);

            $response_data[] = array(
                'id' => $product->get_id(),
                'title' => $product->get_name(),
                'vendor_image_url' => get_avatar_url($author_id, array('size' => 450)),
                'rentPrice' => get_post_meta($product->id, 'rental_price', true),
                'RRP' => get_post_meta($product->id, 'rrp', true),
                'image' => wp_get_attachment_url(get_post_thumbnail_id($product->id)),
                'color' => $product->get_attribute('pa_color'),
                'size' => $product->get_attribute('pa_size'),
            );
        }

        $response['status_code'] = 200;
        $response['data'] = $response_data;
        $response['message'] = 'Products found successfully!!!';
    } catch (Exception $e) {
        $response['status_code'] = 404;
        $response['error'] = $e->get_message();
        $response['message'] = 'Products not found!!!';
    }

    return new WP_REST_Response($response, 200);
}
//designerclub_custom_weekly_settlement_of_leander();

function getIPAddress()
{
    //whether ip is from the share internet  
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    //whether ip is from the remote address  
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

//echo 'User Real IP Address - '.$ip;  

function designerclub_custom_weekly_settlement_of_leander_callback($request)
{
    $response = [];
    try {
        global $stripe;
        $stripe = new \Stripe\StripeClient(
            STRIPE_SECRET_KEY
        );
        $order_args = array(
            'meta_key'      => '_app_order',
            'meta_value'    => 'yes',
            'meta_compare'  => '=',
            'status'        => 'completed',
        );
        $orders = wc_get_orders($order_args);

        foreach ($orders as $order) {
            $order_id               = $order->id;
            $order                  =  new WC_Order($order_id);
            $order_items = $order->get_items();
            foreach ($order_items as $item) {
                $order_product_id    = $item->get_product_id();
                $order_completed_date = get_post_modified_time('Ymd', false, $order_id);
                $modified_date_plus_7_days = date('Ymd', strtotime('+7 days', strtotime($order_completed_date)));
                $current_date = date('Ymd');
                if (isset($order_id))/* ($modified_date_plus_7_days >= $current_date) */ {
                    $post = get_post($order_product_id);
                    $post_author = $post->post_author;
                    $author_id = get_post_field('post_author', $order_product_id);
                    $user_data  = get_userdata($author_id);
                    $user_meta  = get_user_meta($author_id);
                    $account_list = $stripe->accounts->all();

                    $account_email =  $account_list->data[0]['email'];
                    $user_email      = $user_data->user_email;
                    $user_account_name      = $user_data->display_name;
                    $user_dob        = $user_data->user_registered;
                    $user_dob_unix = strtotime($user_dob);
                    $month = date('m', $user_dob_unix);
                    $day   = date('d', $user_dob_unix);
                    $year  = date('y', $user_dob_unix);
                    $user_first_name = get_user_meta($author_id, 'first_name', true);
                    $user_last_name  = get_user_meta($author_id, 'last_name', true);
                    $user_phone      = get_user_meta($author_id, 'billing_phone', true);
                    $user_billing_email = get_user_meta($author_id, 'billing_email', true);
                    $user_billing_address_1 = get_user_meta($author_id, 'billing_address_1', true);
                    $user_billing_city = get_user_meta($author_id, 'billing_city', true);
                    $user_billing_country = get_user_meta($author_id, 'billing_country', true);
                    $user_billing_state = get_user_meta($author_id, 'billing_state', true);
                    $user_billing_postcode = get_user_meta($author_id, 'billing_postcode', true);
                    $user_user_passport = get_stylesheet_directory() . '/img/dummy.pdf';
                    $user_bsb = get_user_meta($author_id, 'user_bsb', true);
                    $user_account_number = get_user_meta($author_id, 'user_account_number', true);
                    $user_url = get_site_url();
                    $ip = getIPAddress();
                    $current_timestamp  = strtotime(date('Ymd'));

                    if ($account_email !== $user_email) {
                        try {
                            $fp = fopen($user_user_passport, 'r');
                            $verification_doc = $stripe->files->create([
                                'purpose' => 'identity_document',
                                'file' => $fp
                            ]);
                            $account_create =  $stripe->accounts->create(
                                [
                                    'country' => 'AU',
                                    'email' => $user_email,
                                    'type' => 'custom',
                                    "requested_capabilities" => ['card_payments', 'transfers'],
                                    'business_profile' => [
                                        "mcc"  => '7296',
                                        "name" =>  $user_data->display_name,
                                        'url' =>  $user_url,
                                        "product_description" => "rental_products",
                                    ],
                                    'legal_entity' => [
                                        'first_name' => $user_first_name,
                                        'last_name' => $user_last_name,
                                        'personal_email' => $user_billing_email,
                                        'personal_phone_number' => $user_phone,
                                        'type' => 'individual',
                                        'dob' => [
                                            'day' => '01',
                                            'month' => '01',
                                            'year' => '1901',
                                        ],
                                        'personal_address' => [
                                            'city' => $user_billing_city,
                                            'line1' => $user_billing_address_1,
                                            'postal_code' =>  $user_billing_postcode,
                                            'state' => $user_billing_state,
                                        ],
                                        'verification' => [
                                            'additional_document' => [
                                                'back' => $verification_doc,
                                            ],
                                            'document' => [
                                                'back' => $verification_doc,
                                            ],
                                        ],
                                    ],
                                    ['tos_acceptance' => ['date' => $current_timestamp, 'ip' => $ip]],
                                ]
                            );

                            update_user_meta($author_id, '_account_id', $account_create->id);

                            $account_create_external =  $stripe->accounts->createExternalAccount(
                                $account_create->id,
                                [
                                    'external_account' => [
                                        "object" => "bank_account",
                                        "account_holder_name" => $user_account_name,
                                        "account_holder_type" => "company",
                                        "bank_name" => "STRIPE BANK",
                                        "country" => "AU",
                                        "currency" => "aud",
                                        "account_number" => $user_account_number,
                                        "routing_number" => $user_bsb,
                                    ],
                                ]
                            );
                            $payouts = $stripe->payouts->create(
                                [
                                    'amount' => 1000,
                                    'currency' => 'aud',
                                    'source_type' => 'card',
                                ],
                                ['stripe_account' => $account_create->id]
                            );

                            $response['data'] = $account_create;
                            $response['message'] = "Your account has been created wait for the payout transfer";
                            $response['status_code'] = 200;
                        } catch (Exception $e) {
                            $response['message'] = $e->getMessage();
                            $response['status_code'] = 404;
                        }
                    } else {
                        $account_id =  get_user_meta($author_id, '_account_id', true);
                        $payouts = $stripe->payouts->create(
                            [
                                'amount' => 2,
                                'currency' => 'aud',
                                'source_type' => 'card',
                            ],
                            ['stripe_account' => $account_id]
                        );
                        $response['message'] = "Your payout will directly created";
                        $response['status_code'] = 200;
                    }
                } else {
                    echo "No settlement";
                }
            }
        }
        $response['data'] = $account_create;
        $response['message'] = "Account and payout created!!!";
        $response['status_code'] = 200;
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
        $response['status_code'] = 404;
    }
    return $response;
}

function designerclub_custom_weekly_settlement_of_leander_cron_callback()
{

    try {
        global $stripe;
        $stripe = new \Stripe\StripeClient(
            STRIPE_SECRET_KEY
        );
        $order_args = array(
            'meta_key'      => '_app_order',
            'meta_value'    => 'yes',
            'meta_compare'  => '=',
            'status'        => 'completed',
        );
        $orders = wc_get_orders($order_args);

        foreach ($orders as $order) {
            $order_id               = $order->id;
            $order                  =  new WC_Order($order_id);
            $order_items = $order->get_items();

            echo  $designer_amt = $order->get_total() * 100;
            echo $vendor_share_amt = $designer_amt - ($designer_amt * 15 / 100);

            foreach ($order_items as $item) {
                $order_product_id    = $item->get_product_id();
                $order_completed_date = get_post_modified_time('Ymd', false, $order_id);
                $modified_date_plus_7_days = date('Ymd', strtotime('+7 days', strtotime($order_completed_date)));
                $current_date = date('Ymd');
                if /* (isset($order_id)) */ ($modified_date_plus_7_days >= $current_date) {
                    echo "7 days over";
                    $post = get_post($order_product_id);
                    $author_id = get_post_field('post_author', $order_product_id);
                    $user_data  = get_userdata($author_id);
                    $user_meta  = get_user_meta($author_id);
                    $account_list = $stripe->accounts->all();
                    $account_email =  $account_list->data[0]['email'];
                    $user_email      = $user_data->user_email;
                    $user_account_name      = $user_data->display_name;
                    $user_dob        = $user_data->user_registered;
                    $user_dob_unix = strtotime($user_dob);
                    $month = date('m', $user_dob_unix);
                    $day   = date('d', $user_dob_unix);
                    $year  = date('y', $user_dob_unix);
                    $user_first_name = get_user_meta($author_id, 'first_name', true);
                    $user_last_name  = get_user_meta($author_id, 'last_name', true);
                    $user_phone      = get_user_meta($author_id, 'billing_phone', true);
                    $user_billing_email = get_user_meta($author_id, 'billing_email', true);
                    $user_billing_address_1 = get_user_meta($author_id, 'billing_address_1', true);
                    $user_billing_city = get_user_meta($author_id, 'billing_city', true);
                    $user_billing_country = get_user_meta($author_id, 'billing_country', true);
                    $user_billing_state = get_user_meta($author_id, 'billing_state', true);
                    $user_billing_postcode = get_user_meta($author_id, 'billing_postcode', true);
                    $user_user_passport = get_stylesheet_directory() . '/img/dummy.pdf';
                    $user_bsb = get_user_meta($author_id, 'user_bsb', true);
                    $user_account_number = get_user_meta($author_id, 'user_account_number', true);
                    $user_url = get_site_url();
                    $ip = getIPAddress();
                    $current_timestamp  = strtotime(date('Ymd'));

                    if ($account_email !== $user_email) {
                        echo "not matched";
                        try {
                            $fp = fopen($user_user_passport, 'r');
                            $verification_doc = $stripe->files->create([
                                'purpose' => 'identity_document',
                                'file' => $fp
                            ]);
                            $account_create =  $stripe->accounts->create(
                                [
                                    'country' => 'AU',
                                    'email' => $user_email,
                                    'type' => 'custom',
                                    "requested_capabilities" => ['card_payments', 'transfers'],
                                    'business_profile' => [
                                        "mcc"  => '7296',
                                        "name" =>  $user_data->display_name,
                                        'url' =>  $user_url,
                                        "product_description" => "rental_products",
                                    ],
                                    'legal_entity' => [
                                        'first_name' => $user_first_name,
                                        'last_name' => $user_last_name,
                                        'personal_email' => $user_billing_email,
                                        'personal_phone_number' => $user_phone,
                                        'type' => 'individual',
                                        'dob' => [
                                            'day' => '01',
                                            'month' => '01',
                                            'year' => '1901',
                                        ],
                                        'personal_address' => [
                                            'city' => $user_billing_city,
                                            'line1' => $user_billing_address_1,
                                            'postal_code' =>  $user_billing_postcode,
                                            'state' => $user_billing_state,
                                        ],
                                        'verification' => [
                                            'additional_document' => [
                                                'back' => $verification_doc,
                                            ],
                                            'document' => [
                                                'back' => $verification_doc,
                                            ],
                                        ],
                                    ],
                                    ['tos_acceptance' => ['date' => $current_timestamp, 'ip' => $ip]],
                                ]
                            );

                            update_user_meta($author_id, '_account_id', $account_create->id);

                            $account_create_external =  $stripe->accounts->createExternalAccount(
                                $account_create->id,
                                [
                                    'external_account' => [
                                        "object" => "bank_account",
                                        "account_holder_name" => $user_account_name,
                                        "account_holder_type" => "company",
                                        "bank_name" => "STRIPE BANK",
                                        "country" => "AU",
                                        "currency" => "aud",
                                        "account_number" => $user_account_number,
                                        "routing_number" => $user_bsb,
                                    ],
                                ]
                            );
                            if (empty($payout->id)) {
                                $designer_amt = $order->get_total() * 100;
                                $vendor_share_amt = $designer_amt - ($designer_amt * 15 / 100);
                                $payouts = $stripe->payouts->create(
                                    [
                                        'amount' => $vendor_sha,
                                        'currency' => 'aud',
                                        'source_type' => 'card',
                                    ],
                                    ['stripe_account' => $account_create->id]
                                );
                            }


                            echo $account_create->id;
                            echo "Your account has been created wait for the payout transfer";
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
                    } else {
                        $account_id =  get_user_meta($author_id, '_account_id', true);

                        $payouts = $stripe->payouts->create(
                            [
                                'amount' => 2,
                                'currency' => 'aud',
                                'source_type' => 'card',
                            ],
                            ['stripe_account' => 'acct_1MtmYlE8wSXKn4KB']
                        );
                        echo "Your payout will directly created";
                    }
                } else {
                    echo "No settlement";
                }
            }
        }
        echo $account_create->id;
        echo "Account and payout created!!!";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function thedesignerclub_tranding_designers_cat_id()
{
    $shopby_category_id = get_field('trending_designers','option');
    if (!empty($shopby_category_id)) {
        foreach ($shopby_category_id as $category => $cat) {
            $cat_name = $cat->name;
            $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
            $image_url    = wp_get_attachment_url( $thumbnail_id ); 
            if(empty($image_url)){
                $image_url = get_site_url()."/wp-content/uploads/2023/06/images.jpeg";
            }else{
                $image_url    = wp_get_attachment_url( $thumbnail_id ); 
            }

            $temp_array = array();

            $temp_array['vendor_ID'] = $cat->term_id;
            $temp_array['vendor_image'] = $image_url;
            $temp_array['vendor_full_name'] = $cat_name ;
            $vendor_response[] = $temp_array;
        }
    }
    return $vendor_response;
}

add_action('rest_api_init', 'thedesignerclub_trending_designers_api_endpoint');
function thedesignerclub_trending_designers_api_endpoint()
{

    register_rest_route('wp/v2', 'trending_designers', array(
        'methods' => 'POST',
        'callback' => 'trending_designers_get_product_id_callback',
    ));
}
function trending_designers_get_product_id_callback(WP_REST_Request $request)
{
                                        
    $thedesignerclub_tranding_designers_cat_id = thedesignerclub_tranding_designers_cat_id();

    global $wpdb;
    $response = [];
    $response['status_code'] = 200;
    $response['data'] =  $thedesignerclub_tranding_designers_cat_id;
    $response['message'] = 'Trending designers product!!!';

    return $response;
}

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/show-notification', [
        'methods' => 'GET',
        'callback' => 'show_notification_listing_callback',
    ]);
});

function show_notification_listing_callback(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];

    $user_id = $request->get_param('user_id');
    $check = $wpdb->get_results("SELECT * FROM wp_notifications WHERE user_id='" . $user_id . "'");

    if (empty($user_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';
    } elseif (empty($check)) {
        $response['status_code'] = 404;
        $response['message'] = 'You a is empty!!!';
    } else {
        $response['status_code'] = 200;
        $response['message'] = 'Notifications are listed successfully!!!';
        if (!empty($check)) {

            foreach ($check as $user_notification) {

                $notification_array[] = array(
                    'user_id'  => $user_notification->user_id,
                    'order_id' => $user_notification->order_id,
                    'title'    => $user_notification->title,
                    'message' => $user_notification->message,
                    'date'    =>  $user_notification->created_at
                );
            }
        } else {
            $notification_array[] = 'No notifications are there!!!';
        }
        $response['data'] = $notification_array;
    }
    return $response;
}
function send_notification($registration_ids, $data)
{
    $SERVER_API_KEY = ('AAAAhDGGNbQ:APA91bHUWrc0gfxmmNZz0SWIpmZb5R5VaQh2DmRRg4mOZt-ZA3ziig_wjMmcFm3Q7pHgJCoCxZzK5yM1kghlh-qIHPuFbMKlVIrwjWDPMvK8P9z2OX4turPjid9w4ksPBd1seZs_16Lo');

    $fields = array(
        'to' => $registration_ids,
        'data' => $data,
    );

    $dataString = json_encode($fields);

    $headers = [
        'Authorization: key=' . $SERVER_API_KEY,
        'Content-Type: application/json',
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    $response_notifi = curl_exec($ch);
    if ($response_notifi === false)
        die('Curl failed ' . curl_error());

    curl_close($ch);

    $response_obj = json_decode($response_notifi);
    if ($response_obj->success == 1) {
        $response['notification'] = "Push notification sent successfully.";
    } else {
        $response['notification'] = "Failed to send push notification: " . $response_obj->results[0]->error;
    }
    return $response;
}


function insert_notification_data($data)
{
    global $wpdb;
    $thedesignerclub_notification_tbl = $wpdb->prefix . 'notifications';
    $wpdb->insert($thedesignerclub_notification_tbl, array(
        'user_id'   => $data['user_id'],
        'order_id'  => $data['order_id'],
        'title'     => $data['title'],
        'message'   => $data['message'],
    ));
}

/* Shop by category selection  */

if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => 'Theme General Settings',
        'menu_title'    => 'Trending Designer Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}


//Create user in twillio chat api
add_action('rest_api_init', 'thedesignerclub_create_user_twillio_api_endpoint');
function thedesignerclub_create_user_twillio_api_endpoint($request)
{

    register_rest_route('wp/v2', 'createuserintwillio', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_create_user_twillio_api',
    ));
}
function thedesignerclub_create_user_twillio_api(WP_REST_Request $request)
{

    global $wpdb;

    $response = [];

    $user_identity = $request->get_param('user_identity');

    $twilio = new Client(TWILLIO_ACCOUNT_SID, f203d4232b15d35adf57f145542f0a09);

    if (empty($user_identity)) {

        $response['status_code'] = 404;
        $response['message'] = 'User id is not found!!!';

    }else {

        $result = $twilio->conversations->v1->users->create($user_identity);

        if ($result) {
            $response['status_code'] = 200;
            $response['data'] = $result;
            $response['message'] = 'Twilio user created successfully!!!';
        }else{
            $response['status_code'] = 404;
            $response['data'] = $result;
            $response['message'] = 'Error creating Twilio user!!!';
        }

    }

    return $response;
}


//Color, Size and brand getting up to category 

add_action('rest_api_init', 'thedesignerclub_get_catsizecolor_api_endpoint');
function thedesignerclub_get_catsizecolor_api_endpoint($request)
{

    register_rest_route('wp/v2', 'catsizecolor', array(
        'methods' => 'GET',
        'callback' => 'thedesignerclub_get_catsizecolor_api',
    ));
}
function thedesignerclub_get_catsizecolor_api(WP_REST_Request $request)
{
    global $wpdb;

    $response = [];

    $cat_id = $request->get_param('cat_id');

    if (empty($cat_id)) {
        $response['status_code'] = 404;
        $response['message'] = 'Cat ID is not found!!!';
    } else {
        $tax_query = [
            [
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $cat_id,
            ],
        ];

        $query_args = [
            'post_type' => 'product',
            'posts_per_page' => -1,
            'tax_query' => $tax_query,
        ];

        $query = new WP_Query($query_args);

        // Process the query results
        $size_attributes = [];
        $color_attributes = [];
        $category_list = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                // Build the product data as per your requirements
                $product = wc_get_product(get_the_ID());

                // Retrieve color and size attributes
                $color = $product->get_attribute('pa_color');
                $size = $product->get_attribute('pa_size');

                // Add non-empty values to the lists
                if (!empty($color)) {
                    $color_attributes[] = get_term_by('slug', $color, 'pa_color');
                }
                if (!empty($size)) {
                    $size_attributes[] = get_term_by('slug', $size, 'pa_size');
                }

                // Retrieve product categories
                $categories = get_the_terms(get_the_ID(), 'product_cat');
                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        $category_list[] = $category;
                    }
                }
            }
        }

        // Reset post data
        wp_reset_postdata();

        // Remove duplicate values and sort the arrays
        $size_attributes = array_values(array_filter(array_unique($size_attributes, SORT_REGULAR)));
        $color_attributes = array_values(array_filter(array_unique($color_attributes, SORT_REGULAR)));
        $category_list = array_values(array_filter(array_unique($category_list, SORT_REGULAR)));

        $response['status_code'] = 200;
        $response['message'] = 'Data listed successfully!!!';
        $response['data']               = array(
            'size_attributes' => $size_attributes,
            'color_attributes' => $color_attributes,
            'categories' => $category_list,
        );
        
    }

    return $response;
}

/* Shop by category api  */

function thedesignerclub_shopby_cat_id()
{
    $shopby_category_id = get_field('shop_by_category','option');
    if (!empty($shopby_category_id)) {
        foreach ($shopby_category_id as $category => $cat) {
            $cat_name = $cat->name;
            $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
            $image_url    = wp_get_attachment_url( $thumbnail_id ); 
            if(empty($image_url)){
                $image_url = get_site_url()."/wp-content/uploads/2023/06/images.jpeg";
            }else{
                $image_url    = wp_get_attachment_url( $thumbnail_id ); 
            }

            $temp_array = array();

            $temp_array['name'] = $cat_name ;
            $temp_array['id'] = $cat->term_id;
            $temp_array['cat_image'] = $image_url;
            $temp_array['is_active'] = 'false';
            $vendor_response[] = $temp_array;
        }
    }
    return $vendor_response;
}

add_action('rest_api_init', 'thedesignerclub_shopby_cat_api_endpoint');
function thedesignerclub_shopby_cat_api_endpoint()
{

    register_rest_route('wp/v2', 'shop_by_category', array(
        'methods' => 'POST',
        'callback' => 'thedesignerclub_shopby_cat_id_callback',
    ));
}
function thedesignerclub_shopby_cat_id_callback(WP_REST_Request $request)
{
                                        
    $thedesignerclub_shopby_cat_id = thedesignerclub_shopby_cat_id();

    global $wpdb;
    $response = [];
    $response['status_code'] = 200;
    $response['data'] =  $thedesignerclub_shopby_cat_id;
    $response['message'] = 'Shop by category listed !!!';

    return $response;
}

/* Shop by category api  */



