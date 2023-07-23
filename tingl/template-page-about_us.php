<?php /* Template Name: About Us page */ ?>

<?php 
get_header();

?>


<?php
    $add_page_heading = get_field('add_page_heading');
    $add_page_description = get_field('add_page_description');
?>

<div class="main-content">
    <section class="about-page inner-page">
        <div class="container g-0">
            <div class="row g-0">
                <div class="col-md-12">
                    <div class="section-title text-center">
                        <?php
                            if($add_page_heading){
                                echo '<h2>'.$add_page_heading.'</h2>';
                            }
                            ?>
                    </div>
                </div>
            </div>
            <div class="row g-0 mt-5 justify-content-md-center">
                <div class=" col-lg-12 ">
                    <div class="about-desc">
                        <?php
                        if($add_page_description){
                            echo $add_page_description; 
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
         get_template_part('template-parts/content/content-instagram','page');
    ?>
</div>

<?php
get_footer();
?>