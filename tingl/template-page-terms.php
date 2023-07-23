<?php /* Template Name: Terms Of Use page */ ?>

<?php 
get_header();
?>

<?php
$add_page_heading     = get_field('add_page_heading');
$add_page_description    = get_field('add_page_description');
$add_page_link           = get_field('add_page_link');
?>

<div class="main-content">
            
            <section class="privacy-page inner-page">
                <div class="container g-0">
                    <div class="row g-0">
                        <div class="col-md-12">
                            <div class="section-title text-center">
                            <?php 
                                if ($add_page_heading) 
                                { 
                                    echo '<h2>'.$add_page_heading.'</h2>';
                                }
                            ?> 
                                <p>Last Updated: 28/06/2023</p>                                
                            </div>
                        </div>
                    </div>
                    <div class="row g-0 mt-5 justify-content-md-center">
                        <div class=" col-lg-12 ">
                            <div class="about-desc">
                            <?php 
                                if ($add_page_description) {
                                     echo $add_page_description; 
                                } 
                            ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="contact-btn text-center pt-3">
                            <?php 
                                if ($add_page_link) {
                                    echo '<a href="'.$add_page_link['url'].'" class="btn btn-primary">'.$add_page_link['title'].'</a>';
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

</div>

<?php
get_footer();
?>