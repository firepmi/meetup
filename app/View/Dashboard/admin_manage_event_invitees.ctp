<style>
.label-expired {
    background-color: red;
}
</style>
<!-- Page content -->
                    <div id="page-content">
                        <!-- Datatables Header -->
                        
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Users</li>
                            <li><a href="<?php echo $this->html->url('/admin/dashboard/manage_invitations/', true);?>">Manage Invitations</a></li>
                        </ul>
                        <!-- END Datatables Header -->

                        <!-- Datatables Content -->
                        <div class="block full">
                            <div class="block-title">
                                <h2><strong>Manage Invitees</strong></h2>
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
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
										
                                            
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php  if(isset($data) and !empty($data)){ $i=1; foreach($data as $key=>$value){ 
									if($value['EventInvitationContact']['status']=="0")
									{
									$class="label label-expired";
									$text="Un-attended";
									}
									 else{
									 $class="label label-success";
									 $text="Attended";
									 }
									?>
                                        <tr>
                                            <td class="text-center"><?php  echo $i;?></td>
											 <td><?php  echo $value['EventInvitationContact']['name'];?></td>
											 <td><?php  echo $value['EventInvitationContact']['email'];?></td>
											 <td><?php  echo $value['EventInvitationContact']['phone'];?></td>
											 <td><span class="<?php  echo $class;?>"><?php echo $text;?></span></td>
                                            
                                        </tr>
										<?php $i++;  } }?>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END Datatables Content -->
                    </div>
                    <!-- END Page Content -->