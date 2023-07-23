<!--------------logout-Modal-------------------->

<?php
//session_unset();

// destroy the session
//session_destroy();

?>
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-custom " style="border-radius:14px;">
    <div class="modal-content">
      <div class="modal-body p-0">
            <div class="logut">
                <h2><?php echo esc_html__('Are you sure you want logout?'); ?></h2>
                <div>
                <a href="<?php echo  home_url(); ?>" class="btn btn-secondary-outline"><?php echo esc_html__('Cancel'); ?> </a>
                    <a href="<?php echo wp_logout_url( home_url() ); ?>" class="btn btn-primary"><?php echo esc_html__('Yes'); ?></a>
                </div>
            </div>
      </div>
    </div>
  </div>
</div>

