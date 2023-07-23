<?php

/**
 * Template part for displaying a page subscribe section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tingl
 */

?>
  <!-- subscribe section starts -->
<section class="subscribe-easy">
    <?php
    if (have_rows('home_page_flexible_settings')) :
    ?> <div class="container">
            <div class="row justify-content-center">
                <?php
                while (have_rows('home_page_flexible_settings')) : the_row();
                    if (get_row_layout() == 'easy_to_subscribe') :
                        $add_section_heading = get_sub_field('add_section_heading');
                ?>
                        <div class="col-md-12">
                            <div class="section-title">
                                <h2><?php if ($add_section_heading) : echo $add_section_heading;
                                    endif; ?></h2>
                            </div>
                        </div>
                        <div class="col-lg-10">
                            <div class="subscribe-info">
                                <div class="subscribe-info-left">
                                    <ul>
                                        <?php
                                        while (have_rows('add_subscribe_info_left')) : the_row();
                                            $add_subscribe_info = get_sub_field('add_subscribe_info');
                                            $add_subscribe_image = get_sub_field('add_subscribe_image');
                                        ?>
                                            <li>
                                                <img src="<?php if ($add_subscribe_image) : echo $add_subscribe_image['url'] ?>">
                                            <?php endif; ?>
                                            <span><?php if ($add_subscribe_info) : echo $add_subscribe_info;
                                                    endif; ?></span>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                                <div class="subscribe-info-right">
                                    <?php
                                    $add_subscribe_info_right_image = get_sub_field('add_subscribe_info_right_image');
                                    ?>
                                    <img src="<?php if ($add_subscribe_info_right_image) : echo $add_subscribe_info_right_image['url'] ?>" class="img-fluid">
                                <?php endif; ?>
                                <div class="successful-order">
                                    <?php
                                    $add_subscribe_info_right_des = get_sub_field('add_subscribe_info_right_des');
                                    ?>
                                    <p><?php if ($add_subscribe_info_right_des) : echo $add_subscribe_info_right_des;
                                        endif; ?></p>
                                </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php endif; ?>
        </section>
<!-- subscribe section ends   -->