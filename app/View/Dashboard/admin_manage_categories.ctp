 <!-- Page content -->
                    <div id="page-content">
                        <!-- Datatables Header -->
                        <div class="content-header">
                        
                        </div>
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Event Catrgories</li>
                            <li><a href="<?php echo $this->html->url('/admin/dashboard/add_category/', true);?>">Add</a></li>
                        </ul>
                        <!-- END Datatables Header -->

                        <!-- Datatables Content -->
                        <div class="block full">
                            <div class="block-title">
                                <h2><strong>Manage Event Categories</strong></h2>
                            </div>
                            <div class="table-responsive">
                                <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th>Name</th>
                                            <th>Added on</th>
											<th class="text-center">Actions</th>
											      
                                        </tr>
                                    </thead>
                                     <tbody>
									<?php  if(isset($data) and !empty($data)){ $i=1; foreach($data as $key=>$value){ ?> 
                                        <tr>
                                            <td class="text-center"><?php  echo $i;?></td>
											<td><a href="javascript:void(0)"><?php  echo $value['EventCategory']['name'];?></a></td>
										    <td><?php  echo $value['EventCategory']['created'];?></td>
											<td class="text-center">
                                                <div class="btn-group">
                                                    <a href="<?php echo $this->html->url('/admin/dashboard/edit_categories/'.$value['EventCategory']['id'], true);?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0)" id="<?php echo $value['EventCategory']['id'];?>" modelName="EventCategory" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger deleteMe"><i class="fa fa-times"></i></a>
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