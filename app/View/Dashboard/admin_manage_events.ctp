<style>
.label-expired {
    background-color: red;
}
</style>
<!-- Page content -->
                    <div id="page-content">
                        <!-- Datatables Header -->
                        <ul class="breadcrumb breadcrumb-top">
                            <li>Events</li>
                            <li><a href="">Manage Events</a></li>
                        </ul>
                        <!-- END Datatables Header -->

                        <!-- Datatables Content -->
                        <div class="block full">
                            <div class="block-title">
                                <h2><strong>Manage Events</strong></h2>
                            </div> 
							<div class="alert alert-success forSuccess hide">
							<button data-dismiss="alert" class="close" type="button">×</button>
							<strong><i class="fa fa-lg fa-check"></i> Success :</strong><span class="message"></span>
							</div>
							<div class="alert alert-danger forError hide">
							<button data-dismiss="alert" class="close" type="button">×</button>
							<strong><i class="fa fa-lg fa-times"></i> Oops :</strong> <span class="message"></span>
							</div>
                            <p class="hide"><a href="https://datatables.net/" target="_blank">DataTables</a> is a plug-in for the Jquery Javascript library. It is a highly flexible tool, based upon the foundations of progressive enhancement, which will add advanced interaction controls to any HTML table. It is integrated with template's design and it offers many features such as on-the-fly filtering and variable length pagination.</p>

                            <div class="table-responsive">
                                <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th>Token</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th>Created By</th>
                                            <th>Category</th>
                                            <th>Total Media</th>
											<th>Status</th>
											<!--<th class="text-center">Actions</th>-->
                                            
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php if(isset($data) and !empty($data)){ $i=1; foreach($data as $key=>$value){
									$expiryTime=intval($value['Event']['event_date']/1000);
									$currentTime=time();
									if($currentTime>$expiryTime)
									{
									$class="label label-expired";
									$text="Expired";
									}
									 else{
									 $class="label label-success";
									 $text="Active";
									 }
									?>
                                        <tr>
                                            <td class="text-center"><?php  echo $i;?></td>
											 <td><?php  echo $value['Event']['event_token'];?></td>
											 <td><?php  echo $value['Event']['event_name'];?></td>
											 <td><?php  if($value['Event']['event_type']=="1") { echo "Video"; } else { echo "Image";};?></td>
											 <td><?php  echo date("Y-m-d h:i:s",$expiryTime);?></td>
											 <?php if(!empty($value['User']['first_name'])){?>
                                             <td><?php  echo $value['User']['first_name']." ".$value['User']['last_name'];?></td>
											 <?php } else {?>
											 <td><?php  echo $value['User']['full_name'];?></td>
											 <?php }?>
											 <td><?php  echo $value['EventCategory']['name'];?></td>
											 <td><?php  echo count($value['Media']);?></a></td>
											 <td><span class="<?php  echo $class;?>"><?php echo $text;?></span></td>
											<!-- <td class="text-center"> 
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a> 
                                                    <a href="javascript:void(0)" id="<?php echo $value['Event']['id'];?>" modelName="User" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger deleteMe"><i class="fa fa-times"></i></a>
                                                </div>
                                            </td> -->
                                        </tr>
										<?php $i++;  } }?>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END Datatables Content -->
                    </div>
                    <!-- END Page Content -->