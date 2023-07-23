<?php
/**
 * Template part for displaying login model
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tingl
 */

?>
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered border-radius-modal">
    <div class="modal-content">
      <div class="modal-body p-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="auth-details feedback-modal">
                     <div class="shape-1">
                         <img src="<?php echo get_template_directory_uri().'/assets/images/leaf.png';?>">
                     </div>
                     <div class="shape-2">
                         <img src="<?php echo get_template_directory_uri().'/assets/images/leaf-1.png';?>">
                     </div>
                     <div class="close" data-bs-dismiss="modal" aria-label="Close">
                         <img src="<?php echo get_template_directory_uri().'/assets/images/fi-rr-cross.png';?>">
                     </div>
                     <div class="w-100 text-start">
                         <h3 class="text-start"><?php echo esc_html__('Contact us'); ?></h3>
                         <div class="form-group mt-3 mb-3">
                            <label><?php echo esc_html__('Enter subject'); ?></label>
                            <select class="form-select">
                                <option><?php echo esc_html__('select'); ?></option>
                            </select>
                         </div>
                         <div class="form-group mb-3">
                            <label><?php echo esc_html__('description'); ?></label>
                             <textarea rows="5" class="form-control" placeholder="description"></textarea>
                         </div>
                        <div class="form-group text-center">
                            <a href="#" class="btn btn-primary"><?php echo esc_html__('Submit'); ?></a>
                        </div>
                     </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>