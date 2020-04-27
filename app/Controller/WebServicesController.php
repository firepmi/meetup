<?php 
Class WebServicesController extends AppController
{
	var $helpers = array('Form','Html','Js','Paginator','Time','Text','Number','Session');
	var $components = array('Cookie','Session','RequestHandler','Email');
	public $uses = array('User','Event','EventUser','Media','EventCategory','MediaLike','EventSetting','EventInvitation','EventInvitationContact','CakeEmail','Network/Email');
	
	public function test()
	{
		echo phpinfo();
		die("Stop");
	}
	
	//register user start
	public function register(){
	 if($this->request->is('post')){
		$data=$this->data;
		if(!empty($data)){
			$data['password'] =md5($data['password']);
			$check_email=$this->User->find('first',array('conditions'=>array('User.email'=>$data['email'])));
			if(empty($check_email)){
				if($this->User->save($data)){
					$id=$this->User->getLastInsertId();
					$user_info=$this->User->find('first',array('conditions'=>array('User.id'=>$id),'fields'=>array('id','device_token')));
					$new_arr['user_id'] = $user_info['User']['id'];
					if($user_info['User']['device_token'] == null){
						$token ="";
					}else{
						$token = $user_info['User']['device_token'];
					}
					
					if(isset($data['event_id'])){
						//add event user
						$event_user=array();
						$event_user['user_id'] = $id;
						$event_user['event_id'] = $data['event_id'];
						$event_user['is_admin'] = 0;
						//add event user
						$this->EventUser->save($event_user);
					}
					$new_arr['device_token'] =$token;
					$result=array('status'=>1,'message'=>'User Information Successfully saved','user_info'=>$new_arr);
				}
				else{
					$result=array('status'=>0,'message'=>'Something went wrong');
				}
			}else{
				$result = array('status'=>0,'message'=>'Email Id Already exist!');
			}
		}
		else{
			$result = array('status'=>0,'message'=>'Data is Empty!');
		}
	 }
		 echo json_encode($result);die;	
	}
	//register user end
	
	//login user start
	public function login(){	
		if($this->request->is('post')){
			$data=$this->data;
			if(!empty($data)){
				$user_info=$this->User->find('first',array('conditions'=>array('User.email'=>$data['email'],'User.password'=>md5($data['password']))));
				if($user_info){
					$new_arr['user_id'] = $user_info['User']['id'];
					if($user_info['User']['device_token'] == null){
						$token ="";
					}else{
						$token = $user_info['User']['device_token'];
					}
					$new_arr['device_token'] =$token;
					$result = array('status'=>1,'message'=>'Login successfully','info'=>$new_arr);
				}else{
					$result = array('status'=>0,'message'=>'Invalid user name or password!');
				}	
			}
			else{
				$result = array('status'=>0,'message'=>'Data is Empty!');
			}
		 }
		 else{
			$result = array('status'=>0,'message'=>'Method is mismatch'); 
		 }
		echo json_encode($result);die;
	}
	//login user end
	
	//social media login start
	public function socialLogin(){
		if($this->request->is('post')){
			$data=$this->data;
			if(!empty($data)){
				$check_user_exist=$this->User->find('first',array('conditions'=>array('User.social_id'=>$data['social_id'],'User.social_type'=>$data['social_type'])));
				if($check_user_exist){
					$new_arr['user_id'] = $check_user_exist['User']['id'];
					if($check_user_exist['User']['device_token'] == null){
						$token ="";
					}else{
						$token = $check_user_exist['User']['device_token'];
					}
					$new_arr['device_token'] =$token;
					$result = array('status'=>1,'message'=>'Login successfully','info'=>$new_arr);
				}	
				else{
					$check_email=$this->User->find('first',array('conditions'=>array('User.email'=>$data['email'])));
					if(empty($check_email)){
						if($this->User->save($data)){
							
							$id=$this->User->getLastInsertId();
							$user_info=$this->User->find('first',array('conditions'=>array('User.id'=>$id)));
							$new_arr['user_id'] = $user_info['User']['id'];
							if($user_info['User']['device_token'] == null){
								$token ="";
							}else{
								$token = $user_info['User']['device_token'];
							}
							$new_arr['device_token'] =$token;
							if(isset($data['event_id'])){
								//add event user
								$event_user=array();
								$event_user['user_id'] = $id;
								$event_user['event_id'] = $data['event_id'];
								$event_user['is_admin'] = 0;
								//add event user
								$this->EventUser->save($event_user);
							}
							$result = array('status'=>1,'message'=>'Login successfully','info'=>$new_arr);
						}else{
							$result=array('status'=>0,'message'=>'Something went wrong');
						}
					}else{
						$result = array('status'=>0,'message'=>'Email Id Already exist!');
					}
				}
			}
			else{
				$result = array('status'=>0,'message'=>'Data is Empty!');
			}
		 }
		 else{
			$result = array('status'=>0,'message'=>'Method is mismatch'); 
		 }
		echo json_encode($result);die;
	}	
	//social media login start	
	
	//add event start
	
	public function createEvent(){
		if($this->request->is('post')){
			$data=$this->data;
			
			if(!empty($data)){
				if(!empty($_FILES['image']['name'])){
				$ext_details = pathinfo($_FILES['image']['name']);
				$ext = strtolower($ext_details['extension']);
				$image = $this->getGUID();
				$guid = substr($image, 1, -1);
				$image_name=$guid.'.'.$ext;
				$file_path = basename($image_name);
				$destination = realpath('../webroot/img/media/'). '/';
				move_uploaded_file($_FILES['image']['tmp_name'], $destination.$file_path);
			}else{
				$image_name='';
			}
				$tokenSubStr=substr(str_replace(" ","",$data['event_name']),0,3);
				$data['image'] = $image_name;
				$data['event_token']=$tokenSubStr.$this->tokenGeneratorForEvent();
				if($this->Event->save($data)){
					$id=$this->Event->getLastInsertId();
					$event_info=$this->Event->find('first',array('conditions'=>array('Event.id'=>$id)));
					//add event user
					$event_user=array();
					$event_user['user_id'] = $event_info['Event']['created_by'];
					$event_user['event_id'] = $event_info['Event']['id'];
					$event_user['is_admin'] = 1;
					//add event user
					$this->EventUser->save($event_user);
					$result=array('status'=>1,'message'=>'Event Created successfully!','event_id'=>$id);
				}
				else{
					$result=array('status'=>0,'message'=>'Something went wrong to create events!');
				}
			}
			else{
				$result = array('status'=>0,'message'=>'Data is Empty!');
			}
		 }
		 else{
			$result = array('status'=>0,'message'=>'Method is mismatch'); 
		 }
		echo json_encode($result);die;
	}	
	//add event end
	
	//add media start
	public function addMedia(){
		
		if($this->request->is('post')){
			
			if(!empty($_FILES['video']['name'])){
				$ext_details = pathinfo($_FILES['video']['name']);
				$ext = strtolower($ext_details['extension']);
				$video = $this->getGUID();
				$guid = substr($video, 1, -1);
				$video_name=$guid.'.'.$ext;
				$file_path = basename($video_name);
				$destination = realpath('../webroot/video/'). '/';
				move_uploaded_file($_FILES['video']['tmp_name'], $destination.$file_path);
			}else{
				$video_name='';
			}
			if(!empty($_FILES['image']['name'])){
				$ext_details = pathinfo($_FILES['image']['name']);
				$ext = strtolower($ext_details['extension']);
				$image = $this->getGUID();
				$guid = substr($image, 1, -1);
				$image_name=$guid.'.'.$ext;
				$file_path = basename($image_name);
				$destination = realpath('../webroot/img/media/'). '/';
				move_uploaded_file($_FILES['image']['tmp_name'], $destination.$file_path);
			}else{
				$image_name='';
			}
			
			$new_arr=array();
			$new_arr['Media']['user_id'] = $this->data['user_id'];
			$new_arr['Media']['event_id'] = $this->data['event_id'];
			$new_arr['Media']['video'] = $video_name;
			$new_arr['Media']['image'] = $image_name;
			$new_arr['Media']['media_type'] = $this->data['media_type'];
			$new_arr['Media']['is_private'] = $this->data['is_private'];
			
			if($this->Media->save($new_arr)){
				$id=$this->Media->getLastInsertId();
				$mediaDetail=$this->Media->find('first',array('conditions'=>array('Media.id'=>$id),'fields'=>array('id','user_id','video','image','media_type','is_private')));
				$mediaDetailData['id']=$mediaDetail['Media']['id'];
				$mediaDetailData['user_id']=$mediaDetail['Media']['user_id'];
				if($mediaDetail['Media']['video'])
				{
				$mediaDetailData['video']='http://3.8.95.229'.$this->base.$this->webroot.'video/'.$mediaDetail['Media']['video'];
				}
				 else{
					 $mediaDetailData['video']="";
				 }
				 if($mediaDetail['Media']['image'])
				{
				$mediaDetailData['image']='http://3.8.95.229'.$this->webroot.'img/media/'.$mediaDetail['Media']['image'];
				}
				 else{
					$mediaDetailData['image']="";
				 }
				$mediaDetailData['media_type']=$mediaDetail['Media']['media_type'];
				$mediaDetailData['is_private']=$mediaDetail['Media']['is_private'];
				
				$result = array('status'=>1,'message'=>'You have successfully add media!','media_id'=>$id,'mediaDetail'=>$mediaDetailData); 
			}else{
				$result = array('status'=>0,'message'=>'Something went wrong'); 
			}				
		 }
		 else{
			$result = array('status'=>0,'message'=>'Method is mismatch'); 
		 }
		echo json_encode($result);die;
	}	
	//add media end
	
	public function getGUID()
	{
		if (function_exists('com_create_guid'))
		{
			return com_create_guid();
		}
		else
		{
			mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);// "-"
			$uuid = chr(123)// "{"
				.substr($charid, 0, 8)
				.substr($charid, 8, 4)
				.substr($charid,12, 4)
				.substr($charid,16, 4)
				.substr($charid,20,12)
				.chr(125);// "}"
			return $uuid;
		}
	}
	
	public function getMedia(){
		if($this->request->is('get')){
			$media_dtl=$this->Media->find('all',array('conditions'=>array('Media.event_id'=>$_GET['event_id']),'fields'=>array('id','user_id','video','image','media_type','is_private')));
			
			$push_arr=array();
			foreach($media_dtl as $media){
				//check if user had alreay liked that media
				$checkLiked=$this->MediaLike->find('first',array('conditions'=>array('MediaLike.media_id'=> $media['Media']['id'],'MediaLike.user_id'=> $_GET['user_id']),'fields'=>array('id','media_id','user_id')));
				 if($checkLiked)
				 {
					 $liked_status=1;
				 }
				  else{
					  $liked_status=0;
				  }
				 if($media['Media']['user_id'] == $_GET['user_id']){
					 $is_admin=1;
				 }else{
					 $is_admin=0;
				 }
				 $video_url=Router::url('/', true).'video/'.$media['Media']['video'];
				 $img_url=Router::url('/', true).'img/media/'.$media['Media']['image'];
				 $nw_arr=array(
				 'media_id' => $media['Media']['id'],
				 'user_id' => $media['Media']['user_id'],
				 'video_url' => $video_url,
				 'img_url' => $img_url,
				 'media_type' => $media['Media']['media_type'],
				 'is_private' => $media['Media']['is_private'], 
				 'is_admin' => $is_admin,
				 'like_count' => count($media['MediaLike']),
				 'is_user_like' => $liked_status,
				 );
				 array_push($push_arr,$nw_arr); 
			}
			$result = array('status'=>1,'value'=>$push_arr);
		 }
		 else{
			$result = array('status'=>0,'message'=>'Method is mismatch'); 
		 }
		echo json_encode($result);die;
		
	}
	
	//======================== April 25th onwards =====================================================

	// to get the list of all event categories  name 
		public function getCategoryList(){
		if($this->request->is('get')){
			$getCategoryList=$this->EventCategory->find('all', array('fields' => array('EventCategory.name', '(EventCategory.id ) AS category_id')));
			
			 if($getCategoryList)
			 {    foreach($getCategoryList as $key=>$values)
				  {
				   $finalListArray[$key]=$values['EventCategory'];
				  }
				$result = array('status'=>1,'categoryList'=>$finalListArray); 
				
			 }
			 else{
			$result = array('status'=>0,'message'=>'No category list found'); 
		 }
		}
		echo json_encode($result);die;
		}
	
	// to get the list of all events 
		public function getEventList(){
		if($this->request->is('get')){
			//$getEventsList=$this->Event->find('all',array('conditions'=>array('Event.created_by'=>$_GET['created_by']),'fields'=>array('Event.id,Event.event_token,Event.created_by,Event.event_name,Event.event_type,Event.event_date')));
			$getEventsList=$this->Event->find('all',array('conditions'=>array('Event.created_by'=>$_GET['created_by']),'recursive'=>1));
			/*  echo "<pre>"; 
			 print_r($getEventsList);
			  die("stop"); */
			
			 if($getEventsList)
			 {    
				  foreach($getEventsList as $key=>$values)
				  {
					
					
				   $finalListArray[$key]=$values['Event'];
				   $finalListArray[$key]["event_type"]=$values['EventCategory']['name'];
				   if($values['Event']['image']!="")
				   {
				   $finalListArray[$key]['image']='http://3.8.95.229'.$this->webroot.'img/media/'.$values['Event']['image'];
				   }
				   else  
				   {
				   $finalListArray[$key]['image']=""; 
				   }
                    if($values['User']['full_name']!="")
					{
					$finalListArray[$key]['user_name']=$values['User']['full_name'];  
					}
					else
					{
					$finalListArray[$key]['user_name']=$values['User']['first_name']." ".$values['User']['last_name'];  	
					} 
				   $finalListArray[$key]['expiry_time']=$values['Event']['event_date'];
				   $finalListArray[$key]['total_friends']=0;
				   $finalListArray[$key]['total_medias']=count($values['Media']); 
				   //check is admin
					$getUserEvent=$this->EventUser->find('first',array('conditions'=>array('EventUser.user_id'=>$_GET['created_by'],'EventUser.event_id'=>$values['Event']['id'])));
					if($getUserEvent)
					{
					 $finalListArray[$key]['is_admin']=$getUserEvent['EventUser']['is_admin'];
					}
				   
				   
				   
				  }
				$result = array('status'=>1,'eventsList'=>$finalListArray); 
				
			 }
			 else{
			$result = array('status'=>0,'message'=>'No events found'); 
		 }
		}
		echo json_encode($result);die;
		}
		
    
		// to get the list of all the users except the one who logged in_array
		public function getUsersList(){
		if($this->request->is('get')){
			$getUsersList=$this->User->find('all',array('conditions'=>array('User.id !='=>$_GET['created_by']),'fields'=>array('User.id,User.	first_name,User.last_name,User.full_name,User.profile_image')));
			 if($getUsersList)   
			 {   
				  foreach($getUsersList as $key=>$values)
				  {
					  $finalListArray[$key]['id']=$values['User']['id'];
					  if($values['User']['full_name']!="")
					  {
						$finalListArray[$key]['user_name']=$values['User']['full_name'];  
					  }
					  else
					  {
						$finalListArray[$key]['user_name']=$values['User']['first_name']." ".$values['User']['last_name'];   
					  }
					  if($values['User']['profile_image'])
					  {
						$finalListArray[$key]['profile_image'] ='http://3.8.95.229'.$this->webroot.'img/user_profile_pics/'.$values['User']['profile_image'];
					 }
				     else
					 {
						$finalListArray[$key]['profile_image']="";  
				     }
				  
				  }
				  $result = array('status'=>1,'usersList'=>$finalListArray); 
				  
			 }
			 else{
			$result = array('status'=>0,'message'=>'No events found'); 
		 }
		}
		echo json_encode($result);die;
		}
		
		public function getEventUsers(){ 
		if($this->request->is('get')){
			//$getUsersList=$this->User->find('all',array('conditions'=>array('User.id !='=>$_GET['created_by']),'fields'=>array('User.id,User.	first_name,User.last_name,User.full_name'),'recursive'=>1));
			
			$getUsersList=$this->EventUser->find('all',array('conditions'=>array('EventUser.user_id !='=>$_GET['created_by'],'EventUser.event_id'=>$_GET['event_id']),'recursive'=>1));
			
			 if($getUsersList)   
			 {   
				  foreach($getUsersList as $key=>$values)
				  {
					
					  $finalListArray[$key]['id']=$values['EventUser']['user_id'];
					  $finalListArray[$key]['is_admin']=$values['EventUser']['is_admin'];
					  if($values['User']['full_name']!="")
					  {
						$finalListArray[$key]['user_name']=$values['User']['full_name'];  
					  }
					  else
					  {
						$finalListArray[$key]['user_name']=$values['User']['first_name']." ".$values['User']['last_name'];   
					  }
					  if($values['User']['profile_image'])
					  {
						$finalListArray[$key]['profile_image'] ='http://3.8.95.229'.$this->webroot.'img/user_profile_pics/'.$values['User']['profile_image'];
					 }
				     else
					 {
						$finalListArray[$key]['profile_image']="";  
				     }
					  
				  
				  }
				  $result = array('status'=>1,'usersList'=>$finalListArray); 
				  
			 }
			 else{
			$result = array('status'=>0,'message'=>'No events found'); 
		 }
		}
		echo json_encode($result);die;
		}
		
	// to get the details of event based on event id
	 
	public function getEventDetails()
	{
		if($this->request->is('get')){
			$anyTable = $this->loadModel('Event');
			$getUsersList=$this->Event->find('first',array('conditions'=>array('Event.id'=>$_GET['event_id']),'recursive'=>1));
			if($getUsersList)
			{
				
				$finalDataArray['event_token']=$getUsersList['Event']['event_token'];
				$finalDataArray['event_name']=$getUsersList['Event']['event_name'];
				$finalDataArray['event_type']=$getUsersList['EventCategory']['name'];
				$finalDataArray['gender']=$getUsersList['Event']['gender'];
				
				if($getUsersList['Event']['image']!="")
				{
				
				$finalDataArray['image']='http://3.8.95.229'.$this->webroot.'img/media/'.$getUsersList['Event']['image'];
				}
				else{
					$finalDataArray['image']=""; 
				}
				$finalDataArray['expiry_time']=$getUsersList['Event']['event_date'];
				$finalDataArray['total_friends']=0;
				if($getUsersList['User']['full_name']!="")
				{
				$finalDataArray['user_name']=$getUsersList['User']['full_name'];  
				}
			    else
				{
				$finalDataArray['user_name']=$getUsersList['User']['first_name']." ".$getUsersList['User']['last_name'];  	
				} 
				//$finalDataArray['image']=$getUsersList['User']['profile_image'];
				$finalDataArray['total_medias']=count($getUsersList['Media']); 
				if(isset($_GET['get_notification']) && $_GET['get_notification']=="1")
				{
				//get the joined users
				$notificationsData=$this->EventUser->find('all',array('conditions'=>array('EventUser.event_id'=>$_GET['event_id']),'fields'=>array('EventUser.user_id')));
				foreach($notificationsData as $key=>$value)
				{
					$joinedUser[]=$value['EventUser']['user_id'];
				}
				
				$getMediaList=$this->Media->find('all', array('order'=>array('Media.id'=>'desc'), 'conditions' => array( "Media.user_id" => $joinedUser , "Media.event_id" =>$_GET['event_id'])));
				$finalNoti=array();
				foreach($getMediaList as $key=>$value)
				{
				 $finalNoti[$key]['media_id']=$value['Media']['id'];
				 $finalNoti[$key]['time']=strtotime($value['Media']['created']);
				 if($value['User']['profile_image'])
				 {
				 $finalNoti[$key]['profile_image'] ='http://3.8.95.229'.$this->webroot.'img/user_profile_pics/'.$value['User']['profile_image'];
				 }
				 else{
				 $finalNoti[$key]['profile_image']="";  
				 }
				 $finalNoti[$key]['user_name']=$value['User']['full_name'];
				 $finalNoti[$key]['message']=" Uploaded new";
				 if($value['Media']['media_type']==1){
				 $finalNoti[$key]['mdeia_type']=" Video.";
				 }
				 else{
				 $finalNoti[$key]['mdeia_type']=" Image.";  
				  }
				}
				$result = array('status'=>1,'eventDetails'=>$finalDataArray,'notificationsData'=>$finalNoti); 
				}
				else{
				$result = array('status'=>1,'eventDetails'=>$finalDataArray); 	
				}
			}
			else
			{
			$result = array('status'=>0,'message'=>'No event details found'); 
			}
			
		}
		 echo json_encode($result);die;
		
	} 
	
	
	//to check the event user based on user id and return the event id from event_users
	public function getTheEventUserEvent(){
		if($this->request->is('get')){ 
		$getEventBasedOnToken=$this->Event->find('first',array('conditions'=>array('Event.event_token'=>$_GET['token']),'fields'=>array('Event.id','Event.event_token','Event.created_by'),'recursive'=>0));
		if($getEventBasedOnToken)
		{
		 $getUserEvent=$this->EventUser->find('first',array('conditions'=>array('EventUser.user_id'=>$_GET['created_by'],'EventUser.event_id'=>$getEventBasedOnToken['Event']['id'])));
		
		 if($getUserEvent)
		 {
			 $result = array('status'=>1,'message'=>'success','event_id'=>$getUserEvent['EventUser']['event_id'],'is_admin'=>$getUserEvent['EventUser']['is_admin']); 
		 }
		  else{
			  $result = array('status'=>0,'message'=>'No event found'); 
		  }
		
		}
		 else{
			 $result = array('status'=>0,'message'=>'Invalid event code'); 
		 }
		 
		}
		echo json_encode($result);die;
	}
	
	//like any media based on user and media id
	 public function likeUnlikeTheMedia()
	 {
		  if($this->request->is('get')){ 
			$getMedia=$this->Media->find('first',array('conditions'=>array('Media.id'=>$_GET['media_id']),'fields'=>array('Media.id'),'recursive'=>0));
			if($getMedia)
			{
			
			$checkIfAlready=$this->MediaLike->find('first',array('conditions'=>array('MediaLike.media_id'=>$_GET['media_id'],'MediaLike.user_id'=>$_GET['user_id']),'fields'=>array('MediaLike.id'),'recursive'=>0));
			
			if($checkIfAlready)
			{
				//delete/ unlike
				if($this->MediaLike->deleteAll(array('MediaLike.id' => $checkIfAlready['MediaLike']['id']), false))
				{
					$getMedia=$this->Media->find('first',array('conditions'=>array('Media.id'=>$_GET['media_id']),'fields'=>array('Media.id')));
					$result = array('status'=>1,'like_count'=>count($getMedia['MediaLike']),'message'=>'Media Un-liked!'); 
				}
				
			}
			else
			{
				//add a like
				$likeArray=array();
				$likeArray['MediaLike']['media_id'] = $_GET['media_id'];
				$likeArray['MediaLike']['user_id'] = $_GET['user_id'];
				if($this->MediaLike->save($likeArray)){
				$getMedia=$this->Media->find('first',array('conditions'=>array('Media.id'=>$_GET['media_id']),'fields'=>array('Media.id')));	
				$result = array('status'=>1,'like_count'=>count($getMedia['MediaLike']),'message'=>'Media liked!'); 
				}
				 
			}
			
			}
		   else{
			   $result = array('status'=>0,'message'=>'No Media found'); 
		   } 
		 }
		 echo json_encode($result);die; 
	 }
	 
	 //get profile info based on user id:
	  public function getProfileInfo(){
		  if($this->request->is('get')){ 
		  $getUsersData=$this->User->find('first',array('conditions'=>array('User.id'=>$_GET['user_id']),'fields'=>array('User.id','User.first_name','User.last_name','User.full_name','User.email','User.profile_image')));
		   
		     if($getUsersData['User']['profile_image'])
			  {
				 $getUsersData['User']['profile_image'] ='http://3.8.95.229'.$this->webroot.'img/user_profile_pics/'.$getUsersData['User']['profile_image'];
			  }
			   else{
				   $getUsersData['User']['profile_image'] ="";
			   }
			   if($getUsersData['User']['full_name']!="") 
				{
				$getUsersData['User']['user_name']=$getUsersData['User']['full_name'];  
				}
				else
				{
				$getUsersData['User']['user_name']=$getUsersData['User']['first_name']." ".$getUsersData['User']['last_name'];  	
				} 
				unset($getUsersData['User']['first_name']);
				unset($getUsersData['User']['last_name']);
				unset($getUsersData['User']['full_name']);
			    
		   if($getUsersData)  
		   {
			   $result = array('status'=>1,'message'=>'success','user_details'=>$getUsersData['User']);  
		   }
		    else{
			   $result = array('status'=>0,'message'=>'No user record found'); 
		  
		  }
		  
	  }
	   echo json_encode($result);die; 
	  }
	  
	  //update user profile
	   public function updateuserProfile(){
        if($this->request->is('post')){
			$data=$this->data;
			 $getUsersData=$this->User->find('first',array('conditions'=>array('User.id'=>$data['user_id']),'fields'=>array('User.id','User.first_name','User.last_name','User.full_name','User.email','User.profile_image')));
			if($getUsersData)
			{	

		 
			if(!empty($_FILES['image']['name'])){
				$ext_details = pathinfo($_FILES['image']['name']);
				$ext = strtolower($ext_details['extension']);
				$image = $this->getGUID();
				$guid = substr($image, 1, -1);
				if($getUsersData['User']['profile_image'])
				{
				$image_name=$getUsersData['User']['profile_image'];	
				}
				else{
				$image_name=$guid.'.'.$ext;	
				}
				$file_path = basename($image_name);
				$destination = realpath('../webroot/img/user_profile_pics/'). '/';
				move_uploaded_file($_FILES['image']['tmp_name'], $destination.$file_path);
				
			}else{
				$image_name=$getUsersData['User']['profile_image'];
			}
			 
			$data['profile_image'] = $image_name;
			$this->User->id = $data['user_id'];
			if($this->User->save($data))
			{
			$result = array('status'=>1,'message'=>'Profile updated.'); 
			}
			 else{
				$result = array('status'=>1,'message'=>'Profile not updated.');  
			 }
			}
			else{
			$result = array('status'=>0,'message'=>'No user record found'); 
			}
			
		}
		 
		   echo json_encode($result);die;  
	   }
	   
	   // to get the basic info of an event
		 public function getEventData()
		{
			if($this->request->is('get')){
				
				$getEventInfo=$this->Event->find('first',array('conditions'=>array('Event.id'=>$_GET['event_id']),'fields'=>array('Event.id as event_id','Event.event_token','Event.event_name','Event.event_date'),'recursive'=>0));
				if($getEventInfo)
				{
					
					$result = array('status'=>1,'eventBasicInfo'=>$getEventInfo['Event']); 
				}
				else
				{
				$result = array('status'=>0,'message'=>'No event details found'); 
				}
				
			}
			 echo json_encode($result);die;
			
		} 
	    
		 // edit an event
		 public function updateEvent(){
		if($this->request->is('post')){
			$data=$this->data;
			if(!empty($data)){
				
				$getEventInfo=$this->Event->find('first',array('conditions'=>array('Event.id'=>$data['event_id']),'fields'=>array('Event.id as event_id','Event.event_token','Event.event_name','Event.event_date','Event.image'),'recursive'=>0));
				if(!empty($_FILES['image']['name'])){
				$ext_details = pathinfo($_FILES['image']['name']);
				$ext = strtolower($ext_details['extension']);
				$image = $this->getGUID();
				$guid = substr($image, 1, -1);
				$image_name=$guid.'.'.$ext;
				$file_path = basename($image_name);
				$destination = realpath('../webroot/img/media/'). '/';
				move_uploaded_file($_FILES['image']['tmp_name'], $destination.$file_path);
				if($destination.$getEventInfo['Event']['image'])
				{
				@unlink($destination.$getEventInfo['Event']['image']);  //unlink the old image
				}

			}else{
				$image_name=$getEventInfo['Event']['image'];
			}
				$data['image'] = $image_name;
				$this->Event->id = $data['event_id'];
				if($this->Event->save($data)){
					
					$result=array('status'=>1,'message'=>'Event information updated successfully!');
				}
				else{
					$result=array('status'=>0,'message'=>'Something went wrong to update event!');
				}
			}
			else{
				$result = array('status'=>0,'message'=>'Data is Empty!');
			}
		 }
		 else{
			$result = array('status'=>0,'message'=>'Method is mismatch'); 
		 }
		echo json_encode($result);die;
	}
	
	//save the event settings based 
	public function saveEventSettings(){
		if($this->request->is('post')){
			$data=$this->data;
			if(!empty($data)){
				//get if already there then update otherwise save
				$getSettings=$this->EventSetting->find('first',array('conditions'=>array('EventSetting.event_id'=>$data['event_id'],'EventSetting.user_id'=>$data['user_id']),'fields'=>array('EventSetting.id')));
				if(!empty($getSettings['EventSetting']['id']))
				{
					 $this->EventSetting->id=$getSettings['EventSetting']['id'];
				}
			if($this->EventSetting->save($data)){
			$result=array('status'=>1,'message'=>'Event settings saved successfully!');
			}
			else
			{
					$result=array('status'=>0,'message'=>'Something went wrong to update event settings!');
			}
			}
			else{
				$result = array('status'=>0,'message'=>'Data is Empty!');
			}
		}
		else{
			$result = array('status'=>0,'message'=>'Method is mismatch'); 
		 }
		 echo json_encode($result);die;
	}
	
	 //get event settings based on event id
	 public function getEventSettingsInfo(){
		  if($this->request->is('get')){ 
		  $getSettingsData=$this->EventSetting->find('first',array('conditions'=>array('EventSetting.event_id'=>$_GET['event_id']),'fields'=>array('EventSetting.id,EventSetting.event_id,EventSetting.user_id,EventSetting.invite_settings,EventSetting.invite_settings_time,EventSetting.media_reminder_settings,EventSetting.media_reminder_time')));
		  	    
		   if($getSettingsData)  
		   {
			   $result = array('status'=>1,'message'=>'success','settingsDetails'=>$getSettingsData['EventSetting']);  
		   }
		    else{
			   $result = array('status'=>0,'message'=>'No settings saved'); 
		  
		  }
		  
	  }
	   echo json_encode($result);die; 
	  }
	  
	  
	 //set the event admin
	public function setAsAdminsOld(){
		if($this->request->is('post')){
			$data=$this->data;
			if(!empty($data)){
			
				$ids_array = explode(",",$data['user_data']);
				foreach($ids_array as $key=>$user_id)
				{
				
				$getEventUserData=$this->EventUser->find('all',array('conditions'=>array('EventUser.event_id'=>$data['event_id'],'EventUser.user_id'=>$user_id),'fields'=>array('EventUser.id')));
				$event_user=array();
				$event_user['user_id'] = $user_id;
				$event_user['event_id'] = $data['event_id'];
				$event_user['is_admin'] = 1;
				if($getEventUserData)
				{
				$this->EventUser->id=$getEventUserData[0]['EventUser']['id'];
				$this->EventUser->save($event_user); 
				//$this->EventUser->deleteAll(array('EventUser.id' => true), false);				
				}
				else
				{
				$this->EventUser->save($event_user);
				}
				$result = array('status'=>1,'message'=>'Events Admin added successfully.'); 
			}
		}
			else{
				$result = array('status'=>0,'message'=>'Data is Empty!');
			}
		}
		else{
			$result = array('status'=>0,'message'=>'Method is mismatch'); 
		 }
		 echo json_encode($result);die;
	
	}
	
	public function setAsAdmins(){
		if($this->request->is('post')){
			$data=$this->data;
			if(!empty($data)){
			$userAre = trim($data['user_data']);  
            $users= json_decode($userAre,true);
			 foreach($users as $key=>$value)
			 {
				$getEventUserData=$this->EventUser->find('all',array('conditions'=>array('EventUser.event_id'=>$data['event_id'],'EventUser.user_id'=>$value['id']),'fields'=>array('EventUser.id')));
				$event_user=array();
				$event_user['user_id'] = $value['id'];
				$event_user['event_id'] = $data['event_id'];
				$event_user['is_admin'] = $value['is_admin'];
				if($getEventUserData)
				{
				$this->EventUser->id=$getEventUserData[0]['EventUser']['id'];
				$this->EventUser->save($event_user); 
							
				}
				else
				{
				$this->EventUser->create();
				$this->EventUser->save($event_user);
				} 
			 }
			 
				$result = array('status'=>1,'message'=>'Events Admin updated successfully.'); 
			} 
		
			else{
				$result = array('status'=>0,'message'=>'Data is Empty!');
			}
		}
		else{
			$result = array('status'=>0,'message'=>'Method is mismatch'); 
		 }
		 echo json_encode($result);die;
	
	}
	
	//to send the invitation from contact list
	public function sendInvitation(){
		if($this->request->is('post')){
			$data=$this->data;
			if(!empty($data)){
				$url=$data['url'];
				$contactsList = trim($data['contacts']);  
                $contacts= json_decode($contactsList,true);
				//save the event invitations
				$invitations['user_id'] = $data['user_id'];
				$invitations['event_id'] = $data['event_id'];
				$invitations['url'] = $url;
				if($this->EventInvitation->save($invitations)){
					 $invitations_id=$this->EventInvitation->getLastInsertId();
				}
				
				if($invitations_id) 
				{
				//save the event invitations contacts
				 foreach($contacts as $key=>$value)
				 {
					$EventInvitationContact['event_invitations_id'] = $invitations_id;
					$EventInvitationContact['name'] = $value['name'];
					$EventInvitationContact['email'] = $value['email'];
					$EventInvitationContact['phone'] = $value['phone'];
					$EventInvitationContact['token'] = $this->tokenGeneratorForInvitation();
					$this->EventInvitationContact->create();
					$this->EventInvitationContact->save($EventInvitationContact); 
					$this->sendInviteEmail($value['email'],$url);
				 }
				}
				 $result = array('status'=>1,'message'=>'Invitations sent!');
				
				}
				
			
			else{
				$result = array('status'=>0,'message'=>'Data is Empty!');
			}
		}
		else{
			$result = array('status'=>0,'message'=>'Method is mismatch'); 
		 }
		 echo json_encode($result);die;
		
	}
	
	
	  
	
	 //function get the expiry time of events
	 public function getExpiryTimeInfo($epiryDate){ 
  
	$start  = date_create($epiryDate);
	$end 	= date_create(); // Current time and date
	$diff  	= date_diff( $start, $end );
	  
	return $timeData=array('days'=>$diff->d,'hours'=>$diff->h,'minutes'=>$diff->i);
	 }
	 
	 // unique token generator for events
   public function tokenGeneratorForEvent()
  { 
    
	   $random_number= substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 4);
	   //if already exist generate again
	     $getToken=$this->Event->find('first',array('conditions'=>array('Event.event_token'=>$random_number)));
	     if($getToken){
		$this->tokenGeneratorForEvent();
		}  
		return $random_number;  
  } 
  
  // unique token generator for events
   public function tokenGeneratorForInvitation()
  { 
    
	   $token= substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8);
	   //if already exist generate again
	     $getToken=$this->EventInvitationContact->find('first',array('conditions'=>array('EventInvitationContact.token'=>$token)));
	     if($getToken){
		$this->tokenGeneratorForInvitation();
		}  
		return $token;  
  } 
  
  //upload chat media
  public function uploadChatMedia()
  {  
	if($this->request->is('post')){
		$data=$this->data;
		$type=$data['type'];
		$dataInfo=array();
		
			if($type=="1"){
			if(!empty($_FILES['video']['name'])){
				$ext_details = pathinfo($_FILES['video']['name']);
				$ext = strtolower($ext_details['extension']);
				$video = $this->getGUID();
				$guid = substr($video, 1, -1);
				$video_name=$guid.'.'.$ext;
				$file_path = basename($video_name);
				$destination = realpath('../webroot/video/chats/'). '/';
				move_uploaded_file($_FILES['video']['tmp_name'], $destination.$file_path);
				$videoPath='http://3.8.95.229'.$this->webroot.'video/chats/'.$video_name;	
			}
			else{
				$video_name='';
				$videoPath='';
			}
			
			$dataInfo['video']=$videoPath;
			}
			
			if(!empty($_FILES['image']['name'])){
				$ext_details = pathinfo($_FILES['image']['name']);
				$ext = strtolower($ext_details['extension']);
				$image = $this->getGUID();
				$guid = substr($image, 1, -1);
				$image_name=$guid.'.'.$ext;
				$file_path = basename($image_name);
				$destination = realpath('../webroot/img/chat_images/'). '/';
				move_uploaded_file($_FILES['image']['tmp_name'], $destination.$file_path);
			   $imagePath='http://3.8.95.229'.$this->webroot.'img/chat_images/'.$image_name;	
			   
			}else{
				$image_name='';
				$imagePath='';
			}
			$dataInfo['image']=$imagePath;
			
					
			
			$result = array('status'=>1,'dataInfo'=>$dataInfo); 
	}
	 else
		{
			$result = array('status'=>0,'message'=>'Method is mismatch'); 
		 }
		 echo json_encode($result);die;
  } 
  
	  //common function for sending the mail
	 public function sendInviteEmail($to,$url)
	 {
	$to = 'developmentweb10@gmail.com';
	//$to = $to;
	$subject = "Rilyo-Event Invitation";   
	$message = 'Hey,';
	$message .= "<br>";
	$message .= "<br>";
	$message .= "I have been using Rilyo app to create Event. I want you to try this app and join this Event.";
	$message .= "<br>";
	$message .= "Download app from here: <a href=".$url.">Click Here</a>"; 
	$message .= "<br>";
	$message .= "<br>";
	$message .= "Thanks";
	

	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	// More headers
	$headers .= 'From: <admin@meetup.com>' . "\r\n";
	//$headers .= 'Cc: myboss@example.com' . "\r\n";

	$mail = mail($to,$subject,$message,$headers);
	 }
	 
	 
	 // notification sending common function
	public function pushNotificationTs(){
		
	
		$deviceToken = '7b10345bfb3acb0cea72bc603a3c8f38d4a14c338e593fdaeaab354511711bf0';
		$cert_file = 'Rilyo_dev.pem';
		$ctx = stream_context_create(); 
		// ck.pem is your certificate file
		stream_context_set_option($ctx, 'ssl', 'local_cert', $cert_file);
		stream_context_set_option($ctx, 'ssl', 'passphrase', 'rilyodev1234');
		// Open a connection to the APNS server
		$fp = stream_socket_client(
			'ssl://gateway.sandbox.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		if (!$fp)
			exit("Failed to connect: $err $errstr" . PHP_EOL);
		// Create the payload body
		$body['aps'] = array(
			'alert' => array(
			    'title' => 'tittle here',
                'body' => 'description here',
			 ),
			'sound' => 'default'
		);
		// Encode the payload as JSON
		$payload = json_encode($body);
		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));
		
		// Close the connection to the server
		fclose($fp);
		if (!$result)
			echo 'Message not delivered,please check' . PHP_EOL;
		else
			echo 'Message successfully delivered.....' . PHP_EOL;
		 die("stop 123");
	}
	
	public function notificationFromCron(){
		
	
		$deviceToken = '7b10345bfb3acb0cea72bc603a3c8f38d4a14c338e593fdaeaab354511711bf0';
		$cert_file = 'Rilyo_dev.pem';
		$ctx = stream_context_create(); 
		// ck.pem is your certificate file
		stream_context_set_option($ctx, 'ssl', 'local_cert', $cert_file);
		stream_context_set_option($ctx, 'ssl', 'passphrase', 'rilyodev1234');
		// Open a connection to the APNS server
		$fp = stream_socket_client(
			'ssl://gateway.sandbox.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		if (!$fp)
			exit("Failed to connect: $err $errstr" . PHP_EOL);
		// Create the payload body
		$body['aps'] = array(
			'alert' => array(
			    'title' => 'tittle here',
                'body' => 'description here',
			 ),
			'sound' => 'default'
		);
		// Encode the payload as JSON
		$payload = json_encode($body);
		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));
		
		// Close the connection to the server
		fclose($fp);
		if (!$result)
			echo 'Message not delivered,please check' . PHP_EOL;
		else
			echo 'Message successfully delivered.....' . PHP_EOL;
		die;
		 
	} 
	

 
}
