 <!-- Page content -->
                    <div id="page-content">
                        <!-- Datatables Header -->
                        <div class="content-header">
                        
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Pages</li>
                            <li><a href="<?php echo $this->html->url('/admin/dashboard/add_page/', true);?>">Add</a></li>
                        </ul>
                        <!-- END Datatables Header -->

                        <!-- Datatables Content -->
                        <div class="block full">
                            <div class="block-title">
                                <h2><strong>Manage pages</strong></h2>
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
                                            <th>Title</th>
                                            <th>Contect</th>
                                            <th>Status</th>
											<th class="text-center">Actions</th>
											      
                                        </tr>
                                    </thead>
                                     <tbody>
									<?php  if(isset($data) and !empty($data)){ $i=1; foreach($data as $key=>$value){ ?> 
                                        <tr>
                                            <td class="text-center"><?php  echo $i;?></td>
											<td><a href="javascript:void(0)"><?php  echo $value['Page']['page_title'];?></a></td>
											<td><?php  echo $value['Page']['page_content'];?></td>
											<td>
											<?php if($value['Page']['page_status']=="1"){?>
											<span class="label label-success">ACTIVE</span>
											<?php } else {?>
											<span class="label label-warning">DEACTIVE</span>
											<?php }?>
											</td>
											<td class="text-center">
                                                <div class="btn-group">
                                                    <a href="<?php echo $this->html->url('/admin/dashboard/edit_page/'.$value['Page']['id'], true);?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0)" id="<?php echo $value['Page']['id'];?>" modelName="Page" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger deleteMe"><i class="fa fa-times"></i></a>
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