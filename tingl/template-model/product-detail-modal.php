<?php

/**
 * Template part for displaying login model
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tingl
 */

 //die;
?>

<!--------------Product-detail-Modal-------------------->
<div class="modal fade" id="productdetailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered other-modal">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="auth-details other-details product-details">
                            <div class="shape-1">
                                <img src="<?php echo get_template_directory_uri() ?>/assets/images/leaf.png">
                            </div>
                            <div class="shape-2">
                                <img src="<?php echo get_template_directory_uri() ?>/assets/images/leaf-1.png">
                            </div>
                            <div class="close" data-bs-dismiss="modal" aria-label="Close">
                                <img src="<?php echo get_template_directory_uri() ?>/assets/images/fi-rr-cross.png">
                            </div>
                            <div class="row w-100">
                                <div class="col-md-6">
                                    <div class="product-details-img">
                                        <img src="<?php echo get_template_directory_uri() ?>/assets/images/product-details-img" class="img-fluid">
                                    </div>                             
                                </div>
                                <div class="col-md-6">
                                    <div class="product-detail-box">
                                        <?php
                                        
                                        echo "<pre>";
                                        print_r($response);
                                        echo "</pre>"; 
                                        ?>
                                        <h2>Dish name</h2>
                                        <span><img src="<?php echo get_template_directory_uri() ?>/assets/images/veg.svg" class="me-1">500 cal.</span>
                                        <div class="price-cart">
                                            <h4>₹ 350</h4>
                                            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" data-product-id="" class="btn btn-primary single_add_to_cart_button">Add to cart</a>
                                        </div>
                                        <div class="product-description">
                                            <h4>Nutritional Info.</h4>
                                            <div class="calories">
                                                <label>500 - Calories</label>
                                                <span><i class="fa-solid fa-circle"></i> Protein - 7g</span>
                                                <span><i class="fa-solid fa-circle"></i> Fat - 12g</span>
                                                <span><i class="fa-solid fa-circle"></i> Carbs - 63g</span>
                                                <span><i class="fa-solid fa-circle"></i> Fiber - 5g</span>
                                            </div>
                                            <div class="pt-3">
                                                <p>This vegan tropical fruit pop made with broken wheat, cashews, almonds sweetened with mango jaggery blend along with other fruits is sure to bring back the nostalgia of summers.</p>
                                                <p>Allergen information: Nuts, gluten.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="rating-review">
                                        <h3>Rating and review <span>4.4 <i class="fa-solid fa-star"></i></span></h3>
                                        <div class="review-slider">
                                                <div class="swiper review-swiper">
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <div class="review-box">
                                                                <div class="review-img">
                                                                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/review-img.png">
                                                                </div>
                                                                <div class="review-desc">
                                                                    <p>“Everyone working in the office is very knowledgeable about all types of dental work and options for your individual needs.”</p>
                                                                </div>
                                                                <div class="review-footer">
                                                                    <label>Sauqi Arief</label>
                                                                    <div>
                                                                        <span>5.0</span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <div class="review-box">
                                                                <div class="review-img">
                                                                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/review-img.png">
                                                                </div>
                                                                <div class="review-desc">
                                                                    <p>“Everyone working in the office is very knowledgeable about all types of dental work and options for your individual needs.”</p>
                                                                </div>
                                                                <div class="review-footer">
                                                                    <label>Sauqi Arief</label>
                                                                    <div>
                                                                        <span>5.0</span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <div class="review-box">
                                                                <div class="review-img">
                                                                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/review-img.png">
                                                                </div>
                                                                <div class="review-desc">
                                                                    <p>“Everyone working in the office is very knowledgeable about all types of dental work and options for your individual needs.”</p>
                                                                </div>
                                                                <div class="review-footer">
                                                                    <label>Sauqi Arief</label>
                                                                    <div>
                                                                        <span>5.0</span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <div class="review-box">
                                                                <div class="review-img">
                                                                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/review-img.png">
                                                                </div>
                                                                <div class="review-desc">
                                                                    <p>“Everyone working in the office is very knowledgeable about all types of dental work and options for your individual needs.”</p>
                                                                </div>
                                                                <div class="review-footer">
                                                                    <label>Sauqi Arief</label>
                                                                    <div>
                                                                        <span>5.0</span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <div class="review-box">
                                                                <div class="review-img">
                                                                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/review-img.png">
                                                                </div>
                                                                <div class="review-desc">
                                                                    <p>“Everyone working in the office is very knowledgeable about all types of dental work and options for your individual needs.”</p>
                                                                </div>
                                                                <div class="review-footer">
                                                                    <label>Sauqi Arief</label>
                                                                    <div>
                                                                        <span>5.0</span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                        <span><i class="fa-solid fa-star"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="swiper-pagination"></div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>