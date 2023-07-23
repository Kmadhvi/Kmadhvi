<?php

/**
 * Template part for displaying login model
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tingl
 */

?>

<!--------------Read-more-Modal-------------------->
<div class="modal fade" id="readModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered other-modal">
    <div class="modal-content">
      <div class="modal-body p-0">
        <div class="row">
          <div class="col-lg-12">
            <div class="auth-details other-details">
              <div class="shape-1">
                <img src="<?php echo get_template_directory_uri() ?>/assets/images/leaf.png">
              </div>
              <div class="shape-2">
                <img src="<?php echo get_template_directory_uri() ?>/assets/images/leaf-1.png">
              </div>
              <div class="close" data-bs-dismiss="modal" aria-label="Close">
                <img src="<?php echo get_template_directory_uri() ?>/assets/images/fi-rr-cross.png">
              </div>
              <div class="read-more-details">
                <h3 id="sect_head"></h3>
                <p id="more_view_review"> </p>
              </div>
              <div class="tingling-customers">
                <img src="" id="long_te_img">
                <h4 id="long_t_name"></h4>
                <p id="long_t_deg"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>