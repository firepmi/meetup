<!-- Page content -->
                    <div id="page-content">
                        <!-- Datatables Header -->
                        
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Users</li>
                            <li><a href="">Manage Invitations</a></li>
                        </ul>
                        <!-- END Datatables Header -->

                        <!-- Datatables Content -->
                        <div class="block full">
                            <div class="block-title">
                                <h2><strong>Manage Invitations</strong></h2>
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
                                            <th class="text-center">ID</th>
                                             <th class="text-center"><i class="gi gi-user"></i></th>
                                            <th>User Name</th>
                                            <th>Event Name</th>
                                            <th>Total Invitees </th>
                                            <th>Details </th>
											
                                            
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php  if(isset($data) and !empty($data)){ $i=1; foreach($data as $key=>$value){ ?>
                                        <tr>
                                            <td class="text-center"><?php  echo $i;?></td>
											<?php if($value['User']['profile_image']){?>
											<td class="text-center"><img width="64px" height="64px"  src="<?php echo 'http://3.8.95.229'.$this->webroot.'img/user_profile_pics/'.$value['User']['profile_image']; ?>" alt="avatar" class="img-circle"></td>
											<?php } else {?>
											<td class="text-center"><img src="<?php  echo $this->webroot;?>img/placeholders/avatars/avatar2.jpg" alt="avatar" class="img-circle"></td>
											<?php }?>
											<?php if(!empty($value['User']['first_name'])){?>
                                             <td><a href="javascript:void(0)"><?php  echo $value['User']['first_name']." ".$value['User']['last_name'];?></a></td>
											 <?php } else {?>
											 <td><a href="javascript:void(0)"><?php  echo $value['User']['full_name'];?></a></td>
											 <?php }?>
                                            <td><?php  echo $value['Event']['event_name'];?></td>
                                            <td><?php  echo count($value['EventInvitationContact']);?></td>
											<?php if(count($value['EventInvitationContact']) >0){ ?>
											<td><a href="<?php echo $this->html->url('/admin/dashboard/manage_event_invitees/'.$value['EventInvitation']['id'], true);?>">Get Details</a></td>
											<?php } else{?> 
											<td>N/A</td>
											<?php  }?>
											
											
                                           
                                            
                                        </tr>
										<?php $i++;  } }?>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END Datatables Content -->
                    </div>
                    <!-- END Page Content -->