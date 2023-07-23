<?php
    $post_per_page = 9;
    $paged = 1;
  
    $authorID = $attributes['wp_info']->data->ID;
    $agentInfo = $attributes['agentInfo'];
    $args = array(
        'suppress_filters' => true,
        'post_type' => 'post',
        'author'        =>  $authorID,
        'posts_per_page' => $post_per_page,
        'paged'    => $paged,
    );

    $total_args = array(
      /*  'suppress_filters' => true,*/
        'post_type' => 'post',
        'author'        =>  $authorID,
        'posts_per_page' => -1,        
    );

    $loadedArticle = $paged * $post_per_page;
    $totalArticle = count(get_posts($total_args));
    $allloaded = false;
    if($totalArticle <= $loadedArticle ){
        $allloaded = true;
    }

    $loop = new WP_Query($args);
  /*  echo "<pre>";
    print_r($loop);
    echo "</pre>";
*/
    global $post;
    
    $out = '';
    $counter = 0;
    if ($loop -> have_posts()) :  
        ob_start(); 
        while ($loop -> have_posts()) : $loop -> the_post();
            $counter ++;
             $article_image = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'recent-post-image' );
            $trimmed_content = wp_trim_words( $post->post_content, 20, '...' );
            $articleURL = urlencode(get_permalink());
            $articleTitle = htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
            $twitterURL = 'https://twitter.com/intent/tweet?text='.$articleTitle.'&amp;url='.$articleURL.'&amp;via=Crunchify';
            $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$articleURL;
            $linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$articleURL.'&amp;title='.$articleTitle;

       if($article_image){
            $article_image = 'https://cdn.shortpixel.ai/client/q_glossy,ret_img,w_632,h_334/'.$article_image[0];
        }else{
            $article_image = 'https://cdn.shortpixel.ai/client/q_glossy,ret_img,w_632,h_334/http://csm.demo1.bytestechnolab.com/wp-content/uploads/2020/12/safe-money.png';
        } 
        
        ?>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="published_content">
                <div class="published_main">
                <div class="published-img">
                   <figure>
                    <img alt="<?php echo get_the_title(); ?>" title="<?php echo get_the_title(); ?>" width="400px" height="400px" data-src="<?php echo $article_image; ?>"  src="<?php echo $article_image; ?>">
                    </figure>
                </div>
                <ul class="published-social-icon">
                    <li><a href="<?php echo $twitterURL;?>" target="_blank"><span class="icon-twitter"></span></a></li>
                    <li><a href="<?php echo $linkedInURL;?>" target="_blank"><span class="icon-linkedin"></span></a></li>
                    <li><a href="<?php echo $facebookURL;?>" target="_blank"><span class="icon-facebook"></span></a></li>
                </ul>
            </div>
                <div class="published-text">
                    <h3><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
                    <p>
                        <?php 
                            if(!empty($trimmed_content)){
                                 echo $trimmed_content;  
                            }
                       ?>    
                    </p>
                </div>
            </div>
        </div>
        <?php
        endwhile;
        $AgentListHtml = ob_get_clean();
    endif;
    wp_reset_postdata();

   
?>
<?php if($AgentListHtml): ?>
<section class="art-featuring-section">
    <div class="container">
        <div class="row">
          <div class="col-md-12 p-0">
              <div class="art_featu_title">
                  <h3 class="h1">Published Content and Articles Featuring <?php echo $agentInfo->first_name .' '. $agentInfo->last_name?></h3>
              </div>
          </div>
        </div>
          <div class="col-md-12">
              <div class="certified_art">
                  <h2> Articles By <?php echo $agentInfo->first_name .' '. $agentInfo->last_name?></h2> 
             </div>
          </div>
             <div class="row" id="agent_list_ajax_response">
                 <?php echo $AgentListHtml; ?>
            </div> 
          
            <div class="col-md-12">
                <?php if($allloaded){
                   // echo '<a href="javascript:void(0)" class="agent_article_load_more btn_mone">more</a>';
                }?>    
            </div>
           

    </div>
</section>

 <?php endif;?>
<script type="text/javascript">
    (function($) {
        var paged = 1;

        $(".agent_article_load_more").on("click",function(){ 
            var $this = $(this);
            paged++;
            var default_text = $this.html();
            $.ajax({
                type: 'POST',
                url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                dataType: 'json',
                data: {
                    action: 'more_post_ajax',
                    paged: paged,                  
                    authorID: '<?php echo $authorID ?>',                  
                },
                beforeSend: function() {
                  $this.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                },
                success: function(data, textStatus, XMLHttpRequest){
                    console.log(data);
                    $this.html(default_text);                    
                    $("#agent_list_ajax_response").append(data.html);
                    if(data.all_load){
                       $this.hide(); 
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                   alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            }); 
            
            return false;
        });

    })(jQuery);
</script>