<!-- Page content -->
                    <div id="page-content">
                        <!-- Forms General Header -->
                         <ul class="breadcrumb breadcrumb-top">
                            <li>Body Types</li>
                            <li><a href="#">Edit</a></li>
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
                                        <h2><strong>Edit Body Type</h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    
									<?php  echo $this->Form->create('Race', array('type' => 'post', 'id'=>'form-login','class'=>'form-horizontal form-bordered','url' => array('controller' => 'Dashboard', 'action' => 'edit_body_type/'.$data['BodyTypes']['id']))); ?>
									
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-hf-email">Body Type Name</label>
                                            <div class="col-md-9">
                                                <input type="text" id="example-hf-email" name="body_type_names" class="form-control" placeholder="Enter Body Type Name" value="<?php  echo $data['BodyTypes']['body_type_names'];?>">
                                                <span><?php  if(isset($errors)){ echo $this->Form->error('body_type_names');}?></span>
                                            </div>
                                        </div>
										
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-hf-email">Body Type Status</label>
                                            <div class="col-md-9">
                                                <input type="radio" name="body_type_status" <?php  if($data['BodyTypes']['body_type_status']=='1'): ?> checked <?php endif; ?>value='1'> Enabled&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="body_type_status" value='0' <?php  if($data['BodyTypes']['body_type_status']=='0'): ?> checked <?php endif; ?>> Disabled
                                            </div>
                                        </div>
                                        <div class="form-group form-actions">
                                            <div class="col-md-9 col-md-offset-3">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-user"></i> Update</button>
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