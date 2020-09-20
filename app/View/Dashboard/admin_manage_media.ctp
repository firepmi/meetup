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
                                            <th>Type</th>
                                            <th>Media</th>
                                            <th>Event</th>
                                            <th>User</th>
                                            <th>Total Likes</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php  if(isset($data) and !empty($data)){ $i=1; foreach($data as $key=>$value){
										if($value['Media']['media_type']=="1") {
										$type="Video";
										}
										 else{
										 $type="Image";
										 }
									?>
                                        <tr>
                                            <td class="text-center"><?php  echo $i;?></td>
											 <td><?php  echo $type;?></td>
											 <td><img width="64px"  height="64px"  src="<?php echo 'https://looklistenandfeel.online'.$this->webroot.'img/media/'.$value['Media']['image']; ?>" alt="avatar" class=""></td>
											  <td><?php  echo $value['Event']['event_name'];?></td>
											  <?php if(!empty($value['User']['first_name'])){?>
                                             <td><?php  echo $value['User']['first_name']." ".$value['User']['last_name'];?></td>
											 <?php } else {?>
											 <td><?php  echo $value['User']['full_name'];?></td>
											 <?php }?>
											 <td><?php  echo count($value['MediaLike']);?></td>
                                        </tr>
										<?php $i++;  } }?>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END Datatables Content -->
                    </div>
                    <!-- END Page Content -->