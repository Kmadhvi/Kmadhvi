<?php

/**
 * Template part for displaying FAQs section in whole site
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tingl
 */

 if (have_rows('home_page_flexible_settings')) :
    while (have_rows('home_page_flexible_settings')) : the_row();
      /* Banner section starts  */
      if (get_row_layout() == 'frequently_asked_questions') : ?>

            <section class="faq">
                <div class="container-fluid g-0">
                    <div class="row g-0">
                        <div class="col-md-12">
                            <div class="section-title">
                            <?php $add_section_heading = get_sub_field('add_section_heading'); ?>
                                <h2><?php if ($add_section_heading) : echo $add_section_heading; endif; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="row g-0 faq-top justify-content-end justify-content-md-center">
                        <div class=" col-lg-6 col-md-10">
                            <div class="faq-accordian">
                                <div class="accordion" id="accordionExample">
                                    <?php
                                        $i = 0;
                                        while (have_rows('add_faq_details')) : the_row();
                                        $add_faq_question = get_sub_field('add_faq_question');
                                        $add_faq_answer = get_sub_field('add_faq_answer'); ?>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading-<?php echo $i;  ?>">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $i;  ?>" aria-expanded="false" aria-controls="collapseOne">
                                            <?php if ($add_faq_question) : echo $add_faq_question; endif; ?>
                                            </button>
                                            </h2>
                                            <div id="collapse-<?php echo $i;  ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $i;  ?>" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <p><?php if ($add_faq_answer) : echo $add_faq_answer; endif; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                        $i++;
                                        endwhile; 
                                    ?>
                                    </div>
                                <div class="accordian-pagination">
                                    <ul>
                                        <li class="disabled">
                                            <img src="<?php echo get_template_directory_uri() ?>/assets/images/button-prev.png">
                                        </li>
                                        <li class="page-count">
                                            1/<span>4</span>
                                        </li>
                                        <li class="page-next">
                                            <img src="<?php echo get_template_directory_uri() ?>/assets/images/button-next.png">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="faq-img">
                            <?php $add_faq_image = get_sub_field('add_faq_image'); ?>
                                <img src="<?php if ($add_faq_image) : echo $add_faq_image['url']; endif; ?>" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>
