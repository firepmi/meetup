<!-- Page content -->
                    <div id="page-content">
                        <!-- Forms General Header -->
                         <ul class="breadcrumb breadcrumb-top">
                            <li>Drivers</li>
                            <li><a href="">Add</a></li>
                        </ul>
                        <!-- END Forms General Header -->

                        <div class="row">
                            
                            <div class="col-md-12">
                                <!-- Horizontal Form Block -->
                                <div class="block">
                                    <!-- Horizontal Form Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                            <!--<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class">Manage</a> -->
                                        </div>
                                        <h2><strong>Add Driver</h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    
									<?php  echo $this->Form->create('Drivers', array('type' => 'post', 'id'=>'form-login','class'=>'form-horizontal form-bordered','url' => array('controller' => 'Dashboard', 'action' => 'add_driver'))); ?>
									
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-hf-email">First Name</label>
                                            <div class="col-md-9">
                                                <input type="text" id="example-hf-email" name="first_name" class="form-control" placeholder="Enter Driver First Name">
                                                <span><?php  if(isset($errors)){ echo $errors['first_name'][0];}?></span>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="col-md-3 control-label" for="example-hf-email">Last Name</label>
                                            <div class="col-md-9">
                                                <input type="text" id="example-hf-email" name="last_name" class="form-control" placeholder="Enter Driver Last Name">
                                                <span><?php  if(isset($errors)){ echo $errors['last_name'][0];}?></span>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="col-md-3 control-label" for="example-hf-email">Email</label>
                                            <div class="col-md-9">
                                                <input type="email" id="example-hf-email" name="email" class="form-control" placeholder="Enter Email">
                                                <span><?php  if(isset($errors)){ echo $errors['email'][0];}?></span>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="col-md-3 control-label" for="example-hf-email">Phone Number</label>
                                            <div class="col-md-9">
                                                <input type="text" id="example-hf-email" name="phone_number" class="form-control" placeholder="Enter Phone Number">
                                                <span><?php  if(isset($errors)){ echo $errors['phone_number'][0];}?></span>
                                            </div>
                                        </div>
										<div class="form-group">
                                                <label class="col-md-3 control-label" for="example-datepicker">Date Of Birth</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="example-datepicker" name="dob" class="form-control input-datepicker" data-date-format="mm/dd/yy" placeholder="mm/dd/yy">
													 <span><?php  if(isset($errors)){ echo $errors['dob'][0];}?></span>
                                                </div>
                                            </div>

										<div class="form-group">
                                            <label class="col-md-3 control-label" for="example-hf-email">Vehicle Number</label>
                                            <div class="col-md-9">
                                                <input type="text" id="example-hf-email" name="vehicle_number" class="form-control" placeholder="Enter Vehicle Number">
                                                <span><?php  if(isset($errors)){ echo $errors['vehicle_number'][0];}?></span>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="col-md-3 control-label" for="example-hf-email">Licence Number</label>
                                            <div class="col-md-9">
                                                <input type="text" id="example-hf-email" name="license_number" class="form-control" placeholder="Enter License Number">
                                                <span><?php  if(isset($errors)){ echo $errors['license_number'][0];}?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group form-actions">
                                            <div class="col-md-9 col-md-offset-3">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-user"></i> Add</button>
                                                <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Cancel</button>
                                            </div>
                                        </div>
                                    <?php echo $this->Form->end(); ?>
                                    <!-- END Horizontal Form Content -->
                                </div>
                                <!-- END Horizontal Form Block -->

                                <!-- END Input Sizes Block -->
                            </div>
                        </div>

                        <!-- END Form Example with Blocks in the Grid -->
                    </div>
                    <!-- END Page Content -->