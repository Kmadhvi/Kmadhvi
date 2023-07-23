<?php /* Template Name: FAQ page */ ?>

<?php
get_header();
?>

<?php
$add_section_heading        = get_field('add_section_heading');
$add_section_description    = get_field('add_section_description');
$add_page_link              = get_field('add_page_link');

?>

<div class="main-content">

    <section class="faq-page">
        <div class="container g-0">
            <div class="row g-0">
                <div class="col-md-12">
                    <div class="section-title text-center">
                        <?php
                            if( $add_section_heading )
                            {
                                echo '<h2>'.$add_section_heading.'</h2>';
                            }
                            if( $add_section_description )
                            {
                                echo '<p class="text-center">'.$add_section_description.'</p>';
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row g-0 faq-top justify-content-md-center">
                <div class=" col-lg-9 col-md-10">
                    <div class="faq-accordian">
                        <div class="accordion" id="accordionExample">
                            <?php
                            if (have_rows('add_faq_details')) :
                                $i = 0;
                                while (have_rows('add_faq_details')) : the_row();

                                    $add_faq_question = get_sub_field('add_faq_question');
                                    $add_faq_answer = get_sub_field('add_faq_answer');
                            ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-<?php echo $i;  ?>">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $i;  ?>" aria-expanded="false" aria-controls="collapse-<?php echo $i;  ?>">
                                                <?php if ($add_faq_question) : echo $add_faq_question;
                                                endif; ?>
                                            </button>
                                        </h2>
                                        <div id="collapse-<?php echo $i;  ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $i;  ?>" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p><?php if ($add_faq_answer) : echo $add_faq_answer;
                                                    endif; ?></p>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                    $i++;
                                endwhile;
                            endif;
                            ?>
                        </div>
                        <div class="contact-btn text-center pt-3">
                            <a href="<?php if ($add_page_link) : echo $add_page_link['url'];
                                        endif; ?>" class="btn btn-primary"><?php if ($add_page_link) : echo $add_page_link['title'];
                        endif; ?></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

<?php
get_footer();
?>