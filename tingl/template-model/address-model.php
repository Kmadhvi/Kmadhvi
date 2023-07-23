<?php
/**
 * Template part for displaying login model
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tingl
 */

?>
<div class="modal fade" id="selectaddressModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg border-radius-modal">
    <div class="modal-content">
      <!-- <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div> -->
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
                         <h3 class="text-start">Select address</h3>
                         <div class="form-group search mb-3">
                             <input type="text" placeholder="search your address" name="" class="form-control">
                             <span><img src="<?php echo get_template_directory_uri() ?>/assets/images/fi-rr-search.svg"></span>
                         </div>
                         <div class="map mb-3">
                         <div id="map" style="height: 300px; width: 100%;"></div>
                         </div>
                         <div class="row">
                             <div class="col-md-12">
                                 <div class="form-group mb-3">
                                    <label>address</label>
                                     <input type="text" placeholder="" class="form-control" name="" id="address_full" value="">
                                 </div>
                             </div>
                             <div class="col-md-3">
                                <div class="form-group mb-3">
                                     <label>Door / flat no.</label>
                                    <input type="text" placeholder="" class="form-control"  id="flatno"  name="" value="">
                                </div>
                             </div>
                             <div class="col-md-3">
                                <div class="form-group mb-3">
                                     <label>landmark</label>
                                     <input type="text" placeholder="" class="form-control" id="landmark" name="" value="">
                                 </div>
                             </div>
                             <div class="col-md-6">
                                <div class="form-group mb-3">
                                     <label>select address type</label>
                                     <select class="form-select">
                                         <option value="Home">Home</option>
                                         <option value="Office">Office</option>
                                         <option value="Other">Other</option>
                                     </select>
                                 </div>
                             </div>
                         </div>
                        <div class="form-group text-center">
                            <a href="#" class="btn btn-primary addAddress_btn">Submit</a>
                        </div>
                     </div>
                     
                </div>
            </div>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?api-key=AIzaSyAxF9gaxeafYL_FCAgml8MnyPV5vsiWYQk&callback=initMap" async defer></script>

<!-- <script src="https://maps.googleapis.com/maps/api/js?&callback=initMap&v=weekly" defer></script> -->