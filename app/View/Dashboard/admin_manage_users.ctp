<!-- Page content -->
                    <div id="page-content">
                        <!-- Datatables Header -->
                        <div class="content-header hide">
                            <div class="header-section">
                                <h1>
                                    <i class="fa fa-table"></i>Datatables<br><small>HTML tables can become fully dynamic with cool features!</small>
                                </h1>
                            </div>
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Users</li>
                            <li><a href="">Manage Users</a></li>
                        </ul>
                        <!-- END Datatables Header -->

                        <!-- Datatables Content -->
                        <div class="block full">
                            <div class="block-title">
                                <h2><strong>Manage App Users</strong></h2>
                            </div> 
							<div class="alert alert-success forSuccess hide">
							<button data-dismiss="alert" class="close" type="button">×</button>
							<strong><i class="fa fa-lg fa-check"></i> Success :</strong><span class="message"></span>
							</div>
							<div class="alert alert-danger forError hide">
							<button data-dismiss="alert" class="close" type="button">×</button>
							<strong><i class="fa fa-lg fa-times"></i> Oops :</strong> <span class="message"></span>
							</div>
                            <div class="table-responsive">
                                <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Sr.No.</th>
                                             <th class="text-center"><i class="gi gi-user"></i></th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Birth Day</th>
                                            <th>Profile Video</th>
                                            <th>Status</th>
                                            <th>Member Type</th>
											<th class="text-center">Actions</th>
                                            
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php  if(isset($data) and !empty($data)){ $i=1; foreach($data as $key=>$value){ ?>
                                        <tr>
                                            <td class="text-center"><?php  echo $i;?></td>
											<?php if(!empty($value['User']['profilePic'])){?>   
											<td class="text-center"><img width="64px" height="64px"  src="<?php echo $this->webroot.'img/user_profile_pics/'.$value['User']['profilePic']; ?>" alt="avatar" class="img-circle"></td>
											<?php } else {?>
											<td class="text-center"><img src="<?php  echo $this->webroot;?>img/placeholders/avatars/avatar2.jpg" alt="avatar" class="img-circle"></td>
											<?php }?>
											 <td><a href="javascript:void(0)"><?php  echo $value['User']['username'];?></a></td>
                                            <td><?php  echo $value['User']['email'];?></td>
                                            <td><?php  echo $value['User']['date_of_birth'];?></td>                                                                                        
                                            <?php if(!empty($value['User']['videoImage'])){?>                                                
											<td class="text-center">
                                            <a href="<?php echo $this->webroot.'img/user_profile_pics/'.$value['User']['vedio_url']; ?>">
                                                <img width="64px" height="64px" src="<?php echo $this->webroot.'img/user_profile_pics/'.$value['User']['videoImage']; ?>" alt="video">
                                            </a>
                                            </td>
											<?php } else {?>
											<td class="text-center">
                                            <a href="<?php echo $this->webroot.'img/user_profile_pics/'.$value['User']['vedio_url']; ?>">
                                                <img width="64px" height="64px" src="<?php  echo $this->webroot;?>img/media/default.jpg" alt="video">
                                            </a>
                                            </td>
                                            <?php }?>                                            
											<td>
											<?php if($value['User']['status']=="0"){?>
											<span class="label label-success">ACTIVE</span>
											<?php } else {?>
											<span class="label label-warning">DEACTIVE</span>
											<?php }?>
											</td>
											<td>
											<?php if($value['User']['PaymentStatus']=="1"){?>
											<span class="label label-success">PAID</span>
											<?php } else {?>
											<span class="label label-info">FREE</span> 
											<?php }?>
											</td>
											<td class="text-center">
                                                <div class="btn-group">
                                                    <!--<a href="javascript:void(0)" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a> -->
                                                    <a href="javascript:void(0)" id="<?php echo $value['User']['id'];?>" modelName="User" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger deleteMe"><i class="fa fa-times"></i></a>
                                                </div>
                                            </td>
                                            
                                        </tr>
										<?php $i++;  } }?>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END Datatables Content -->
                    </div>
                    <!-- END Page Content -->