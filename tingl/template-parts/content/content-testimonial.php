<?php

/**
 * Template part for displaying testimonial section in whole site
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tingl
 */


?>

<?php

function showrating($starRating){
  for ($star = 1; $star <= 5; $star++) {
    if($starRating >= $star){
      echo '<span><i class="fa-solid fa-star"></i></span>';       
    } else {
      echo '<span><i class="fa-regular fa-star"></i></span>';
    }
  }
}

    $add_section_heading = get_field('add_section_heading');
    if( $add_section_heading || !empty(have_rows('add_testimonial_details')))
    {
      ?>
        <section class="customer-testimonials">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="section-title">
                  <?php 
                    if ($add_section_heading) 
                    {
                      echo '<h2>'.$add_section_heading.'</h2>';
                    } 
                  ?>
                </div>
              </div>
            </div>
            <?php if( !empty(have_rows('add_testimonial_details')) ){ ?>
            <div class="row justify-content-md-end">
              <div class="col-md-11">
                <div class="swiper testimonial-swiper">
                  <div class="swiper-wrapper">
                  <?php  // Loop through rows.
                    while (have_rows('add_testimonial_details')) : the_row();
                      $is_this_a_video_testimonial    = get_sub_field('is_this_a_video_testimonial');
                      $add_testimonial_description    = get_sub_field('add_testimonial_description');
                      $add_rating_number              = get_sub_field('add_rating_number');
                      $add_rating_number              = ($add_rating_number) ? $add_rating_number : '';
                      $add_testimonial_profile_image  = get_sub_field('add_testimonial_profile_image');
                      $add_testimonial_cust_name      = get_sub_field('add_testimonial_cust_name');  
                      $add_testimonial_cust_name      = ($add_testimonial_cust_name) ? $add_testimonial_cust_name : '';
                      $add_testimonial_cust_desig     = get_sub_field('add_testimonial_cust_desig');
                      $add_testimonial_cust_desig     = ($add_testimonial_cust_desig) ? $add_testimonial_cust_desig : '';
                      $add_video                      = get_sub_field('add_video');
                      $add_video_class                = get_sub_field('add_video_class');
                      $add_video_link                 = get_sub_field('add_video_link');
                      $add_video_thumbnail            = get_sub_field('add_video__thumbnail');
                      ?>

                      <div class="swiper-slide">
                        <div class="testimonial-box <?php if($is_this_a_video_testimonial== 1): echo "video-testimonial"; endif;?>" <?php if($add_video_thumbnail): echo 'style="background-image: url('.$add_video_thumbnail['url'].')"'; endif; ?>>
                        <?php 
                        if ($is_this_a_video_testimonial == 0) {
                          if ($add_testimonial_description) {
                                  if (strlen($add_testimonial_description) > 300) {
                                    $stringCut = substr($add_testimonial_description, 0, 300);
                                    $endPoint = strrpos($stringCut, ' ');
                                    $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                    $string .= '<br><br><a href="#" class="readmore-btn" data-bs-toggle="modal" data-bs-target="#readModal" id="readmore_review" section_title="'.$add_section_heading.'" text="' . $add_testimonial_description . '" name="' . $add_testimonial_cust_name . '" img="' . $add_testimonial_profile_image['url'] . '" desi="' . $add_testimonial_cust_desig . '">read more.</a>';
                                ?>
                                    <p class="t_test"><?php echo $string; ?> </p>
                                  <?php } 
                                  else { 
                                    ?>
                                    <p><?php echo $add_testimonial_description; ?> </p>
                                  <?php
                                  }
                                }
                              } else { ?>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#readModal" data-src="<?php if ($add_video_link) : echo $add_video_link; endif; ?>" class="video-link" id="video_play">
                                <img src="<?php echo get_template_directory_uri().'/assets/images/play.png'; ?>" id="video_play">
                              </a>
                            <?php }  ?>
                          
                            <div class="rating">
                           <?php showrating($add_rating_number);
                           ?>
                            </div>
                            <div class="testimonial-profile">
                              <?php 
                              if ($add_testimonial_profile_image) : 
                              ?>
                                <img src="<?php echo $add_testimonial_profile_image['url'] ?>">
                              <?php endif; ?> 
                              <h4><?php echo $add_testimonial_cust_name; ?></h4>
                              <span><?php echo $add_testimonial_cust_desig; ?></span>
                            </div>
                          </div>
                        </div>
                        <?php endwhile; ?>
                      </div>
                      <div class="swiper-pagination"></div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
        </section>
      <?php
    }


get_template_part('/template-model/testimonial-model'); 