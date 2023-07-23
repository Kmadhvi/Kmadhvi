<?php

/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <?php

    get_template_part('template-parts/entry-header');

    if (!is_search()) {
        get_template_part('template-parts/featured-image');
    }

    ?>

    <div class="post-inner <?php echo is_page_template('templates/template-full-width.php') ? '' : 'thin'; ?> ">

        <div class="entry-content">
            <?php $all_fields = get_fields(get_the_ID()); ?>
            <div class="wrapper">
                <header>Question : <?php echo $all_fields['question']; ?><br></header>
                <div class="poll-area">

                    <!-- <input type="radio" name="poll" id="opt"> NAME -->
                    <?php
                    if (have_rows('options')) : ?>
                        <?php $i = 1;
                        while (have_rows('options')) : the_row();
                
                          
                        ?>
                            <div class="row">
                                <div class="column">
                                    <?php if (have_rows('text_option')) {
                                        while (have_rows('text_option')) : the_row();
                                        $sub_value =  get_sub_field('text');
                                        $sub_count =  get_sub_field('count');
                                    ?>
                                            <input type="radio" name="poll" class="poll" id="opt-<?php echo $i; ?>" value="<?php echo $sub_value;?>" data-count= <?php echo $sub_count; ?> /><strong><?php echo $sub_value; ?></strong>

                                    <?php
                                        endwhile;
                                    } ?>

                                </div>

                                <div class="bar-main-<?php echo $i; ?> bar-con">
                                    <div class="bar" style="width: 0 ;"></div>
                                </div>
                            </div>

                            <?php //endforeach; 
                            ?>
                            <!--   </label> -->
                        <?php
                            $i++;
                        endwhile;
                    else :
                        echo "no data found"; ?>

                    <?php endif; ?>
                    <button class="radiocheck">Submit</button>
                    <span id="radiovalue" data-option=""></span>
                </div>
            </div>
        </div>

    </div><!-- .post-inner -->

</article>
<?php   ?>