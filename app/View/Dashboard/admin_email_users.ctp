<!-- Page content -->
                    <div id="page-content">
                        <!-- Forms General Header -->
                         <ul class="breadcrumb breadcrumb-top">
                            <li>Pages</li>
                            <li><a href="">Email Users</a></li>
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
                                        <h2><strong>Send Email To Users</h2>
                                    </div>
                                    <!-- END Horizontal Form Title -->

                                    <!-- Horizontal Form Content -->
                                    
									<?php  echo $this->Form->create('BodyTypes', array('type' => 'post', 'id'=>'form-login','class'=>'form-horizontal form-bordered','url' => array('controller' => 'Dashboard', 'action' => 'email_users'))); ?>
									    <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-hf-email">Send to</label>
                                            <div class="col-md-9">
                                                <input type="radio" name="emailTo" id="all-user" class="emailTo" checked value='1'><label for="all-user"> &nbsp;&nbsp;All Users&nbsp;&nbsp;&nbsp;&nbsp;</label><br/>
                                                <input type="radio" name="emailTo" id="specific-user" class="emailTo" value='0'><label for="specific-user"> &nbsp;&nbsp;Specific Person</label><br/>
                                                <input list="users" name="mailUsers" id="mailUsers" style="margin-top:10px" disabled />
                                                <datalist id="users">
                                                <?php  if(isset($data) and !empty($data)){ $i=1; foreach($data as $key=>$value){ ?>                                                
                                                    <option value="<?php  echo $value['User']['email'];?>">
                                                <?php $i++;  } }?>
                                                </datalist>
                                            </div>
                                            <div class="col-md-9">
                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-hf-email">Title</label>
                                            <div class="col-md-9">
                                                <input type="text" id="example-hf-email" name="page_title" class="form-control" placeholder="Enter Email Title">
                                                <span><?php  if(isset($errors)){ echo $this->Form->error('page_title');}?></span>
                                            </div>
                                        </div>
										<div class="form-group">
											<label class="col-md-3 control-label" for="example-hf-email">Content</label>
											<div class="col-md-9">
												<textarea id="textarea-ckeditor" placeholder="Enter the page content.." name="page_content" class="ckeditor"></textarea>
												<span><?php  if(isset($errors)){ echo $this->Form->error('page_content');}?></span>
											</div>
                                       </div>
										                                        
                                        <div class="form-group form-actions">
                                            <div class="col-md-9 col-md-offset-3">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-user"></i> Send</button>
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