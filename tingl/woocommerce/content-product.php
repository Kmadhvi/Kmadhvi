<?php
/**
 * The template for displaying product content in the product loop.
 *
 *
 * @package tingl

 */

defined( 'ABSPATH' ) || exit;

$product_id=get_the_ID();
$_product = wc_get_product( $product_id );
$sku = $_product->get_sku();
// Custom design modifications start here
?>
    <div class="col-md-4">
        <div class="shop-box">
            <div class="shop-img">
                <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-fluid">
            </div>
            <div class="shop-desc">
                <h3><?php echo get_the_title(); ?></h3>
                    <p><?php if($_product->get_sale_price()) : echo  "₹".$_product->get_sale_price(); endif; ?><label> <del><?php echo "₹". $_product->get_regular_price(); ?></del></label></p>
                    <a href="#"  data-bs-toggle="modal" data-bs-target="#productdetailModal" data-prod-id="<?php echo $product_id; ?>"data-pro-id = "<?php echo $sku; ?>" class="btn btn-primary w-100 dish_detail_btn">
                    <?php echo esc_html__('Add to cart'); ?></a>
            </div>
        </div>
    </div>

<?php
// Custom design modifications end here