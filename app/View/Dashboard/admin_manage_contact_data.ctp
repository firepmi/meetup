 <!-- Page content -->
                    <div id="page-content">
                        <!-- Datatables Header -->
                        <div class="content-header">
                        
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Contact Data List</li>
                            <!--li><a href="<?php echo $this->html->url('/admin/dashboard/add_body_type/', true);?>">Add</a></li-->
                        </ul>
                        <!-- END Datatables Header -->

                        <!-- Datatables Content -->
                        <div class="block full">
                            <div class="block-title">
                                <h2><strong>Manage Contact Data</strong></h2>
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
											<th>User Name</th>
											<th>User Email</th>
                                            <th>Message</th>
											<th class="text-center">Actions</th>
											      
                                        </tr>
                                    </thead>
                                     <tbody>
									<?php  if(isset($data) and !empty($data)){ $i=1; foreach($data as $key=>$value){ ?> 
                                        <tr>
                                            <td class="text-center"><?php  echo $i;?></td>
											<td><a href="javascript:void(0)"><?php  echo $value['User']['username'];?></a></td>
											<td><a href="mailto:<?php  echo $value['User']['email'];?>"><?php  echo $value['User']['email'];?></a></td>
											<td><?php  echo $value['ContactUsersData']['message'];?></a></td>
											<td class="text-center">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" id="<?php echo $value['ContactUsersData']['id'];?>" modelName="ContactUsersData" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger deleteMe"><i class="fa fa-times"></i></a>
                                                </div>
                                            </td>
											
                                            
                                        </tr>
										<?php $i++; } }?>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END Datatables Content -->
                    </div>
                    <!-- END Page Content -->