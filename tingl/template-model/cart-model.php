<?php

/**
 * Template part for displaying cart model
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tingl
 */

?>
<div class="cart-menu">
    <h3>cart (<?php echo absint( WC()->cart->get_cart_contents_count() ); ?> item)</h3>

    <div class="cart-list">
        <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
            ?>
            <div class="item-box">
                <div class="item-left">
                    <img src="<?php echo get_the_post_thumbnail_url($product_id, 'thumbnail'); ?>" class="img-fluid">
                </div>
                <div class="item-right">
                    <a href="#" class="item-del-icon"><img src="<?php echo get_template_directory_uri() . '/assets/images/fi-rr-trash.png'; ?>"></a>
                    <h4><?php echo get_the_title($product_id); ?></h4>
                    <p><?php echo wc_price($_product->get_sale_price()); ?> <del><?php echo wc_price($_product->get_regular_price()); ?></del></p>
                    <span class="d-block">starting date: <?php echo date('jS M', strtotime('25th May')); ?></span>
                    <a href="#" class="btn btn-primary">30 days</a>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="cart-total">
        <div class="subtotal">
            <div class="subtotal-left">
                <h4>Subtotal</h4>
                <span>extra charges may apply</span>
            </div>
            <div class="subtotal-left">
                <h4><?php echo wc_price(WC()->cart->get_subtotal()); ?></h4>
            </div>
        </div>
        <div class="cart-menu-btn text-center">
            <a href="<?php echo wc_get_checkout_url(); ?>" class="btn btn-primary w-75">check out</a>
        </div>
    </div>
</div>



<div class="cart-menu">
    <h3>cart<?php echo absint( WC()->cart->get_cart_contents_count() ) ;//(2 item) ?></h3>

    <div class="cart-list"> 
   <?php  //foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) { ?>
        <div class="item-box">
            <div class="item-left"> 
                <img src="<?php echo get_template_directory_uri(). '/assets/images/shop-img.png'; ?>" class="img-fluid">
            </div>
            <div class="item-right">
                <a href="#" class="item-del-icon"><img src="<?php echo get_template_directory_uri(). '/assets/images/fi-rr-trash.png'; ?>"></a>
                <h4>Max Value</h4>
                <p>₹ 26,100 <del>₹ 30,120</del></p>
                <span class="d-block">staring date : 25th may</span>
                <a href="#" class="btn btn-primary">30 days</a>
            </div>
        </div>
        <div class="item-box">
            <div class="item-left">
                <img src="<?php echo get_template_directory_uri(). '/assets/images/shop-img.png'; ?>" class="img-fluid">
            </div>
            <div class="item-right">
                <a href="#" class="item-del-icon"><img src="<?php echo get_template_directory_uri(). '/assets/images/fi-rr-trash.png'; ?>"></a>
                <h4>Dish name</h4>
                <p>₹ 350 <del>₹ 450</del></p>
                <div class="number-input">
                    <div class="button">
                        <button id="minus-btn">-</button>
                    </div>
                    <div class="number">
                        <h1 id="count">01</h1>
                    </div>
                    <div class="button">
                        <button id="plus-btn">+</button>
                    </div>
                </div>
            </div>
        </div>
        <?php //} ?>
    </div>
    <div class="cart-total">
        <div class="subtotal">
            <div class="subtotal-left">
                <h4>Subtotal</h4>
                <span>extra chaarges may apply</span>
            </div>
            <div class="subtotal-left">
                <h4>₹26,500.00</h4>
            </div>
        </div>
        <div class="cart-menu-btn text-center">
            <a href="<?php echo wc_get_checkout_url();?>"  class="btn btn-primary w-75">check out</a>
        </div>
    </div>
</div> 