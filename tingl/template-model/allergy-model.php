<?php
/*--------------------------------------------Allergy model------------------------------------- */
?>
<div class="modal fade" id="allergiesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-allergie border-radius-modal">
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
                         <img src="assets/images/leaf.png">
                     </div>
                     <div class="shape-2">
                         <img src="assets/images/leaf-1.png">
                     </div>
                     <div class="close" data-bs-dismiss="modal" aria-label="Close">
                         <img src="assets/images/fi-rr-cross.png">
                     </div>
                     <div class="w-100 text-start">
                         <h3 class="text-start"><?php esc_html_e( 'Add allergies', 'woocommerce' ); ?></h3>
                         <div class="allergies-list mt-3">
                             <div class="select-money">
                            <div class="text-checkbox">
                              <input id="dollar1" name="money" type="checkbox" class="carfilter">
                              <label for="dollar1">
                                chicken
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar2" name="money" type="checkbox" checked="" class="carfilter">
                              <label for="dollar2">
                                egg
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar3" name="money" type="checkbox" class="carfilter">
                              <label for="dollar3">
                                fish
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar4" name="money" type="checkbox" class="carfilter">
                              <label for="dollar4">
                                shelfish
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar5" name="money" type="checkbox" class="carfilter">
                              <label for="dollar5">
                                Nuts
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar6" name="money" type="checkbox" checked="" class="carfilter">
                              <label for="dollar6">
                                Peanuts
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar7" name="money" type="checkbox" class="carfilter">
                              <label for="dollar7">
                                Sauce
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar8" name="money" type="checkbox" class="carfilter">
                              <label for="dollar8">
                                Milk
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar9" name="money" type="checkbox" class="carfilter">
                              <label for="dollar9">
                                Seeds
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar10" name="money" type="checkbox" checked="" class="carfilter">
                              <label for="dollar10">
                                Gluten
                              </label>
                            </div>
                            <div class="text-checkbox">
                              <input id="dollar11" name="money" type="checkbox" class="carfilter">
                              <label for="dollar11">
                                Other
                              </label>
                            </div>
                            
                          </div>
                         </div>
                         <div class="form-group col-6 mb-3">
                            <label>other allergies</label>
                             <input type="text" name="" class="form-control" placeholder="Enter allergies">
                         </div>
                        <div class="form-group text-center">
                            <a href="#" class="btn btn-primary w-100">Save</a>
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