<?php 
Class ApiController extends AppController
{
	var $helpers = array('Form','Html','Js','Paginator','Time','Text','Number','Session');
	var $components = array('Cookie','Session','RequestHandler','Email');
	public $uses = array('User','Ride','Driver','VehicleListing','Rating','PromoCode','CakeEmail','Network/Email','Like','Comment','CommentReply','CommentLike','UserSetting','CommentReplyLike','Race','BodyTypes','ContactUsersData','Image');
	
	public function test()
	{
		$this->autoRender = false;
		$lat1='30.7333'; 
		$lon1='76.7794';
		$lat2='0.0';
		$lon2='0.0';
		$unit="M";
		
		$theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
	 die("Stop");
		
		
		echo $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving";
		 die;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true); 
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

   // return array('distance' => $dist, 'time' => $time);
		
	//	echo phpinfo();
		die("Stop");
	}
	//calculate the time difference
	
	 public function getTheTimeDifference($timestamp)
	 {
					//$timestamp='1556978915';
					$current_time = time();  
      				$time_difference = $current_time - $timestamp;  
      				$seconds = $time_difference;  
      				$minutes = round($seconds / 60 ); // value 60 is seconds  
      				$hours   = round($seconds / 3600);//value 3600 is 60 minutes * 60 sec  
      				$days    = round($seconds / 86400);//86400 = 24 * 60 * 60;  
      				$weeks   = round($seconds / 604800);// 7*24*60*60;  
      				$months  = round($seconds / 2629440);//((365+365+365+365+366)/5/12)*24*60*60  
      				$years   = round($seconds / 31553280);//(365+365+365+365+366)/5 * 24 * 60 * 60  
     
      				if($seconds <= 60){  
     					$time= "Just Now";  
   					}else if($minutes <=60){  
      					if($minutes==1){  
       						$time= "one minute ago";  
						}else{  
       						$time= "$minutes minutes ago";  
       					}  
   					}  
      				else if($hours <=24){  
     					if($hours==1){  
       						$time= "an hour ago";  
       					}else{  
       						$time= "$hours hrs ago";  
     					}  
   					}else if($days <= 7){  
     					if($days==1){  
       						$time= "yesterday";  
     					}else{  
       						$time= "$days days ago";  
						}  
   					}  
      				else if($weeks <= 4.3) //4.3 == 52/12 
					{  
     					if($weeks==1){  
       						$time= "a week ago";  
     					}else{  
       						$time= "$weeks weeks ago";  
						}  
   					}  
       				else if($months <=12)  
      				{  
     					if($months==1)  
           				{  
       						$time= "a month ago";  
     					}  
           				else  
           				{  
      						$time= "$months months ago";  
     					}  
   					}  
      				else  
      				{  
     					if($years==1)  
          	 			{  
      						$time= "one year ago";  
     					}  
           				else  
          				{  
       						$time= "$years years ago";  
     					}
     				}	
					return $time;
					 die;
                    //code end
					
	 }
	
	
	//register user start
	
	public function register(){
		if($this->request->is('post')){
			$data=$this->data;
			 
			if(!empty($data)){

				$check_email=$this->User->find('first',array('conditions'=>array('User.email'=>$data['email'])));
				
				if(empty($check_email)){
					
						//upload image
						if(!empty($_FILES['profilePic']['name'])){
							$ext_details = pathinfo($_FILES['profilePic']['name']);
							$ext = strtolower($ext_details['extension']);
							$image = $this->getGUID();
							$guid = substr($image, 1, -1);
							$image_name=$guid.'.'.$ext;	
							$file_path = basename($image_name);
							$destination = realpath('../webroot/img/user_profile_pics/'). '/';
							move_uploaded_file($_FILES['profilePic']['tmp_name'], $destination.$file_path);
						} else {
							$image_name=''; 
					 	}
						
						$data['username'] =$data['Username'];
						$data['email'] =$data['email'];
						$data['password'] =md5($data['Password']);
						$data['gender'] =$data['Gender'];
						$data['date_of_birth'] =$data['DateofBirth'];
						$data['profilePic'] =$image_name;
						$data['latitude'] =$data['latitude'];
						$data['longitude'] =$data['longitude'];

						if($this->User->save($data)){
								$id=$this->User->getLastInsertId();
								//send mail for account verification
								$this->sendVerificationEmail($id,$data['email']);
								unset($data['password']);
								$data['profilePic']=BASE_URL_USER_IMAGES.$image_name;
								$result=array('status'=>1,'message'=>'Successfully registered,please check your email for further instructions.','user_info'=>$data);
						}else{

							$result=array('status'=>0,'message'=>'Something went wrong,try again!');
						}
				}else{

					$result = array('status'=>0,'message'=>'The email you have entered already exist!');
				}
			}else{

				$result = array('status'=>0,'message'=>'Data is Empty!');
			}
		}else{
				$result = array('status'=>0,'message'=>'Method Mismatch!');
			}
		echo json_encode($result);die;	
	}
	
	
	//login user

	public function login(){	
		if($this->request->is('post')){
			$data=$this->data;
			if(!empty($data)){				
				$user_info=$this->User->find('first',array('conditions'=>array('User.username'=>$data['userName'],'User.password'=>md5($data['Password']))));
				if($user_info){
					$new_arr['user_id'] = $user_info['User']['id'];
					$new_arr['userName'] = $user_info['User']['username'];
					$new_arr['paymentStatus'] = $user_info['User']['PaymentStatus'];
					if(!empty($user_info['User']['profilePic'])){
					$new_arr['profilePic']=BASE_URL_USER_IMAGES.$user_info['User']['profilePic'];
					}
					else
					{
					$new_arr['profilePic']='';
					}
					$result = array('status'=>1,'message'=>'Login successfully.','data'=>$new_arr);

				} else {

					$result = array('status'=>0,'message'=>'Invalid email or password!');
				}
			}				
			// } else {

			// 	$result = array('status'=>0,'message'=>'Data is Empty!');
			// }
		// } else {

		// 	$result = array('status'=>0,'message'=>'Method is mismatch'); 
		 }

		echo json_encode($result);die;
	}
	

	//social media login start

	public function socialLogin(){
		if($this->request->is('post')){
			$data=$this->data;
			if(!empty($data)){
				$check_user_exist=$this->User->find('first',array('conditions'=>array('User.email'=>$data['email'])));
				
				if($check_user_exist){
					$new_arr['socialid'] =$data['socialid'];
					$new_arr['user_id'] =$check_user_exist['User']['id'];
					$responseData['user_id'] =$check_user_exist['User']['id'];
					$responseData['userName'] =$check_user_exist['User']['username'];
					$responseData['paymentStatus'] = $check_user_exist['User']['PaymentStatus'];
					if(!empty($check_user_exist['User']['profilePic'])){
						$responseData['profilePic']=BASE_URL_USER_IMAGES.$check_user_exist['User']['profilePic'];
					}
					else
					{
						$responseData['profilePic']='';
					}					
					$this->User->id = $check_user_exist['User']['id'];
					$this->User->save($new_arr);
										
					//$result = array('status'=>1,'message'=>'Login successfully','data'=>$new_arr);
					$result = array('status'=>1,'message'=>'Login successfully','data'=>$responseData);
				}
				else{
					
						if(!empty($_FILES['image']['name'])){
							$ext_details = pathinfo($_FILES['image']['name']);
						    $ext = strtolower($ext_details['extension']);
						    $image = $this->getGUID();
						    $guid = substr($image, 1, -1);
						    $image_name=$guid.'.'.$ext;	
						    $file_path = basename($image_name);
						    $destination = realpath('../webroot/img/user_profile_pics/'). '/';
						    move_uploaded_file($_FILES['image']['tmp_name'], $destination.$file_path);
						    }
				 	        else{
						      $image_name=''; 
				 	        } 
				        $data['social_id'] =$data['socialid'];
				        $data['profilePic'] =$image_name;
					    $this->User->save($data);
						$lastUser=$this->User->getLastInsertId();
					    $data['user_id'] =$this->User->getLastInsertId();
						$userData=$this->User->find('first',array('conditions'=>array('User.id'=>$lastUser)));
					    $dataResponse['user_id'] =$lastUser;
					    $dataResponse['userName'] =@$userData['User']['username'];
						$dataResponse['paymentStatus'] = $userData['User']['PaymentStatus'];
						if($image_name)
						{
					    $dataResponse['profilePic']=BASE_URL_USER_IMAGES.$image_name;
						}
						else{
						$dataResponse['profilePic']='';
						}
					    $result = array('status'=>1,'message'=>'Login successfully','data'=>$dataResponse);
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

	//forgot password
	public function forgotPassword(){
		if($this->request->is('post')){
			$data=$this->data;
			if(empty($data['email']))
			{
				$result = array('status'=>0,'message'=>'Please enter the email'); 
			}
			else
			{
				$user_info = $this->User->find('first',array('conditions'=>array('User.email'=>$data['email']),'fields'=>array('User.id','User.email'))); 	
				
				if(!empty($user_info)){
					$password= substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 8)), 0, 8);
					$userdata['password'] =md5($password);
					//$to = 'developmentweb10@gmail.com';
					$to = $data['email'];
					$subject = "Forgot Password Request";   
					$message  = '<p>Hello, </p>'; 
					$message .= '<p>We have sent you this email in response to your request to reset your password on for account with email '.$data['email']. ' from Parking App. </p>';
					$message .= '<br>'; 
					$message .= '<p>Your new password is: '. $password.' </p>';
					$message .= '<br>';
					$message .= '<p>Thanks,</p>';
					$message .= '<p>Team MeetUp App</p>'; 

					// Always set content-type when sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

					// More headers
					$headers .= 'From: MeetUp App<admin@meetup.com>' . "\r\n"; 
					//$headers .= 'Cc: myboss@example.com' . "\r\n";
					$this->User->id = $user_info['User']['id'];
					$userUpdatedData['password'] =md5($password);
					$saved=$this->User->save($userUpdatedData);
					$mail = mail($to,$subject,$message,$headers);
					$result = array('status'=>1,'message'=>"Password has been sent to the your email!");
				}else{

					$result = array('status'=>0,'message'=>'No matching record found related to this email id!'); 
				}
			} 
		}
		else{

			$result = array('status'=>0,'message'=>'Method is mismatch'); 
		}
			 
		echo json_encode($result);die; 
	}
	
	
	
	//Get profile (USER)
	public function getuserProfile(){
        if($this->request->is('post')){
			$data=$this->data;
			if(!empty($data)){
				$user = $data['userID']; 
				$check_user_exist=$this->User->find('first',array('conditions'=>array('User.id'=>$data['userID']),'fields'=>array('User.username','User.online_status', 'User.profilePic', 'User.address', 'User.date_of_birth', 'User.about_me' ,'User.body_type','User.longest_relationship','User.kids','User.hobbies','User.like_percentage','User.favourite_percentage','User.unlike_percentage','User.vedio_url','User.height','User.last_activity','User.videoImage'),'recursive'=>0));
				 
				if(!empty($check_user_exist)){

					//To calculate offline time
					if($check_user_exist['User']['last_activity']!=0){
						$timestamp = $check_user_exist['User']['last_activity']; 
					} else {
			 			$timestamp=1556978915;	
			        }	
              		$current_time = time();  
      				$time_difference = $current_time - $timestamp;  
      				$seconds = $time_difference;  
      				$minutes = round($seconds / 60 ); // value 60 is seconds  
      				$hours   = round($seconds / 3600);//value 3600 is 60 minutes * 60 sec  
      				$days    = round($seconds / 86400);//86400 = 24 * 60 * 60;  
      				$weeks   = round($seconds / 604800);// 7*24*60*60;  
      				$months  = round($seconds / 2629440);//((365+365+365+365+366)/5/12)*24*60*60  
      				$years   = round($seconds / 31553280);//(365+365+365+365+366)/5 * 24 * 60 * 60  
     
      				if($seconds <= 60){  
     					$time= "Just Now";  
   					}else if($minutes <=60){  
      					if($minutes==1){  
       						$time= "one minute ago";  
						}else{  
       						$time= "$minutes minutes ago";  
       					}  
   					}  
      				else if($hours <=24){  
     					if($hours==1){  
       						$time= "an hour ago";  
       					}else{  
       						$time= "$hours hrs ago";  
     					}  
   					}else if($days <= 7){  
     					if($days==1){  
       						$time= "yesterday";  
     					}else{  
       						$time= "$days days ago";  
						}  
   					}  
      				else if($weeks <= 4.3) //4.3 == 52/12  
					{  
     					if($weeks==1){  
       						$time= "a week ago";  
     					}else{  
       						$time= "$weeks weeks ago";  
						}  
   					}  
       				else if($months <=12)  
      				{  
     					if($months==1)  
           				{  
       						$time= "a month ago";  
     					}  
           				else  
           				{  
      						$time= "$months months ago";  
     					}  
   					}  
      				else  
      				{  
     					if($years==1)  
          	 			{  
      						$time= "one year ago";  
     					}  
           				else  
          				{  
       						$time= "$years years ago";  
     					}
     				}	 
                    //code end

			        $percentaeData = $this->User->query("select likess, dislikes, favorite from likes where UserId='$user' order by id");
			        foreach($percentaeData as $key=>$value){
				    	if($value['likes']['likess']==1){
				        	$likes1[] = $value['likes']['likess'];
				        }  
				        if($value['likes']['dislikes']==1){
				        	$dislikes1[] = $value['likes']['dislikes'];
				        } 
				        if($value['likes']['favorite']==1){
				        	$favorite[] = $value['likes']['favorite'];
				        } 
			        }

                    if(!empty($likes1)){
			            $Like =  count($likes1);
			    	} else{
               		 	$Like =  0;
			    	}
			     	if(!empty($dislikes1)){	
                		$DisLike = count($dislikes1);
                 	}else{
                		$DisLike = 0;
			    	}
               		if(!empty($favorite)){
                		$favorite = count($favorite);
                	}
                	else{
               		 	$favorite =  0;
			    	}
			    	if(!empty($likes1) || !empty($dislikes1)) {
						$total= $Like + $DisLike;
						$like_percent = round($Like / $total * 100);
						$dislike_percent = round($DisLike / $total * 100);
                	}else{
						$like_percent = 0;
						$dislike_percent = 0;
               		}

					foreach($check_user_exist as $key=>$value) {
						
						//check the last activity
						$check_user_exist=$this->User->find('first',array('conditions'=>array('User.id'=>$value['id']),'fields'=>array('User.id','User.last_activity')));
						
						if(!empty($check_user_exist)){
							$lastTimeStamp=$check_user_exist['User']['last_activity']; 
							
							$lastActivetime=$this->getTheTimeDifference($lastTimeStamp);
						}
						else{
							$lastActivetime='N/a';
						}
							
						$data[$key]['user name']=@$value['username'];
						$data[$key]['online status']=@$value['online_status'];
						if(!empty($value['profilePic'])){
							$data[$key]['user image']=BASE_URL_USER_IMAGES.$value['profilePic'];
						}else{
							$data[$key]['user image']=@$value['profilePic'];
						}
						$data[$key]['address']=@$value['address'];
						$data[$key]['date of birth'] = date("Y") - @$value['date_of_birth'];
						$data[$key]['Body Type']=@$value['body_type'];		
						$data[$key]['Longest Relationship']=@$value['longest_relationship'];
						$data[$key]['kids']=@$value['kids'];
						$data[$key]['height']=@$value['height'];
						$data[$key]['Hobbies']=@$value['hobbies'];
						$data[$key]['Like Percentage']= "$Like";
						$data[$key]['Favourite']= "$favorite";
						$data[$key]['Unlike Percentage']= "$DisLike";
						if($value['vedio_url'])
						{
							$data[$key]['Vedio url']=BASE_URL_USER_IMAGES.$value['vedio_url'];
						}
						else
						{
							$data[$key]['Vedio url']='';
						}
						// $data[$key]['facebook url']=$value['facebook_url'];
						// $data[$key]['instagram url']=$value['instagram_url'];
						// $data[$key]['youtube url']=$value['youtube_url'];
						// $data[$key]['googleplus url']=$value['googleplus_url'];
						$data[$key]['Aboutme']=$value['about_me'];
						//$data[$key]['Online Status']="$time";
						$data[$key]['Online_Status']=$lastActivetime;
						$data[$key]['videoImage'] =  $value['videoImage']?BASE_URL_USER_IMAGES.$value['videoImage']:'';
					}				
					$result = array('status'=>1,'message'=>'User Profile data.','data'=>$data); 
				}
				else {				 
					$result = array('status'=>0,'message'=>'Profile not found.');
				}
			}
			else {
				$result = array('status'=>0,'message'=>'No user record found'); 
			}			
		}		 
		echo json_encode($result);die;  
	}
		
		
	//update profile (USER)
	public function updateuserProfile(){
        if($this->request->is('post')){
			$data=$this->data;
	        $getUsersData=$this->User->find('first',array('conditions'=>array('User.id'=>$data['userID']),'fields'=>array('User.username','User.online_status', 'User.profilePic','User.videoImage', 'User.address', 'User.date_of_birth', 'User.user_age', 'User.about_me' ,'User.body_type','User.longest_relationship','User.kids','User.hobbies','User.like_percentage','User.favourite_percentage','User.unlike_percentage','User.vedio_url','User.height','User.latitude','User.longitude')));
	     	if($getUsersData){
				//profile pic
				if(!empty($_FILES['profilePic']['name'])){
					$ext_details = pathinfo($_FILES['profilePic']['name']);
					$ext = strtolower($ext_details['extension']);
					$image = $this->getGUID();
					$guid = substr($image, 1, -1);
					$image_name=$guid.'.'.$ext;	
					$file_path = basename($image_name);	
					$destination = realpath('../webroot/img/user_profile_pics/'). '/';
					move_uploaded_file($_FILES['profilePic']['tmp_name'], $destination.$file_path);
					if($destination.$getUsersData['User']['profilePic'])
					{
					@unlink($destination.$getUsersData['User']['profilePic']);  //unlink the old image
					} 
					
				}else{
					$image_name=$getUsersData['User']['profilePic'];
				}
				
				//video Image
				
				if(!empty($_FILES['videoImage']['name'])){
					$ext_details = pathinfo($_FILES['videoImage']['name']);
					$ext = strtolower($ext_details['extension']);
					$image = $this->getGUID();
					$guid = substr($image, 1, -1);
					$video_image_name=$guid.'.'.$ext;	
					$file_path = basename($video_image_name);	
					$destination = realpath('../webroot/img/user_profile_pics/'). '/';
					move_uploaded_file($_FILES['videoImage']['tmp_name'], $destination.$file_path);
					if($destination.$getUsersData['User']['videoImage'])
					{
					@unlink($destination.$getUsersData['User']['videoImage']);  //unlink the old image
					} 
					
				}else{
					$video_image_name=$getUsersData['User']['videoImage'];
				}
				
	            if(!empty($data['UserName'])){
					$username = $data['UserName'];
			    }else{
	            	$username = $getUsersData['User']['username'];
			    }

	            if(!empty($data['OnlineStatus'])){
					$OnlineStatus = $data['OnlineStatus'];
			    }else{
	            	$OnlineStatus = $getUsersData['User']['online_status'];
			    }
				
	            if(!empty($data['Address'])){
					$Address = $data['Address'];
			    }else{
	            	$Address = $getUsersData['User']['address'];
			    }

			    if(!empty($data['AboutMe'])){
					$AboutMe = $data['AboutMe'];
			    }else{
	           		$AboutMe = $getUsersData['User']['about_me'];
			    }

	            if(!empty($data['BodyType'])){
					$BodyType = $data['BodyType'];
			    }else{
	           		$BodyType = $getUsersData['User']['body_type'];
			    }

	            if(!empty($data['DOB'])){
					$year = date("Y"); 
					$DOB = $year - $data['DOB'];
			    }else{
	            	$DOB = $getUsersData['User']['date_of_birth'];
			    }

			    if(!empty($data['UserAge'])){
					$UserAge = $data['UserAge'];
			    }else{
	            	$UserAge = $getUsersData['User']['user_age'];
			    }

	            if(!empty($data['height'])){
					$Height = $data['height'];
			    }else{
	            	$Height = $getUsersData['User']['height'];
			    }

	            if(!empty($data['LongestRelationship'])){
					$LongestRelationship = $data['LongestRelationship'];
			    }else{
	            	$LongestRelationship = $getUsersData['User']['longest_relationship'];
			    }

			    if(!empty($data['Kids'])){
					$Kids = $data['Kids'];
			    }else{
	            	$Kids = $getUsersData['User']['kids'];
			    }

			    if(!empty($data['Hobbies'])){
					$Hobbies = $data['Hobbies'];
			    }else{
	            	$Hobbies = $getUsersData['User']['hobbies'];
			    }

			    if(!empty($data['LikePercentage'])){
					$LikePercentage = $data['LikePercentage'];
			    }else{
	            	$LikePercentage = $getUsersData['User']['like_percentage'];
			    }

			    if(!empty($data['FavouritePercentage'])){
					$FavouritePercentage = $data['FavouritePercentage'];
			    }else{
	            	$FavouritePercentage = $getUsersData['User']['favourite_percentage'];
			    }

	            if(!empty($data['UnlikePercentage'])){
					$UnlikePercentage = $data['UnlikePercentage'];
			    }else{
	            	$UnlikePercentage = $getUsersData['User']['unlike_percentage'];
			    }

			    if(!empty($data['VedioUrl'])){
					$VedioUrl = $data['VedioUrl'];
			    }else{
	            	$VedioUrl = $getUsersData['User']['vedio_url'];
			    }

				if(!empty($data['latitude'])){
					$latitude = $data['latitude'];
			    }else{
	            	$latitude = $getUsersData['User']['latitude'];
			    }
				if(!empty($data['longitude'])){
					$longitude = $data['longitude'];
			    }else{
	            	$longitude = $getUsersData['User']['longitude'];
			    }

	            $new_arr['username'] =$username;
				$new_arr['online_status'] =$OnlineStatus;
				$new_arr['address'] =$Address;
				$new_arr['about_me'] =$AboutMe;
				$new_arr['body_type'] =$BodyType;
				$new_arr['date_of_birth'] =$DOB;
				$new_arr['user_age'] =$UserAge;
				$new_arr['longest_relationship'] =$LongestRelationship;
				$new_arr['kids'] =$Kids;
				$new_arr['hobbies'] =$Hobbies;
				$new_arr['height'] =$Height;
				$new_arr['like_percentage'] =$LikePercentage;
				$new_arr['favourite_percentage'] =$FavouritePercentage;
				$new_arr['unlike_percentage'] =$UnlikePercentage;
				$new_arr['vedio_url'] =$VedioUrl;
				$new_arr['latitude'] =$latitude;
				$new_arr['longitude'] =$longitude;
				$new_arr['profilePic'] = $image_name;
				$new_arr['videoImage'] = $video_image_name;
				$this->User->id = $data['userID'];
				if($this->User->save($new_arr))
				{
					$getUpdatedUsersData=$this->User->find('first',array('conditions'=>array('User.id'=>$data['userID']),'fields'=>array('User.username','User.online_status', 'User.profilePic', 'User.videoImage','User.address', 'User.date_of_birth', 'User.user_age', 'User.about_me' ,'User.body_type','User.longest_relationship','User.kids','User.hobbies','User.like_percentage','User.favourite_percentage','User.unlike_percentage','User.vedio_url','User.facebook_url','User.instagram_url','User.youtube_url','User.googleplus_url','User.latitude','User.longitude')));
					$dataUpdated=$getUpdatedUsersData['User'];
					$dataUpdated['profilePic']=BASE_URL_USER_IMAGES.$image_name;
					$dataUpdated['videoImage']=BASE_URL_USER_IMAGES.$video_image_name;
					$result = array('status'=>1,'message'=>'User Profile updated.', 'data'=>$dataUpdated); 
				}
				else{
					$result = array('status'=>0,'message'=>'Profile not updated.');  
				}
			}
			else{
				$result = array('status'=>0,'message'=>'No user record found'); 
			}
				
		}
		 
		echo json_encode($result);die;  
	}

	public function uploadImage(){
        if($this->request->is('post')){
			$data=$this->data;
	        $getUsersData=$this->User->find('first',array('conditions'=>array('User.id'=>$data['user_id']),'fields'=>array('User.username', 'User.profilePic','User.videoImage')));
	     	if($getUsersData){
				//profile pic
				$image_name = '';
				if(!empty($_FILES['profilePic']['name'])){
					$ext_details = pathinfo($_FILES['profilePic']['name']);
					$ext = strtolower($ext_details['extension']);
					$image = $this->getGUID();
					$guid = substr($image, 1, -1);
					$image_name=$guid.'.'.$ext;	
					$file_path = basename($image_name);	
					$destination = realpath('../webroot/img/user_profile_pics/'). '/';
					move_uploaded_file($_FILES['profilePic']['tmp_name'], $destination.$file_path);
				}
				$user_id = $data['user_id'];	
	            
	            $new_arr['user_id'] =$user_id;				
				$new_arr['image'] = $image_name;
				
				if($this->Image->set($new_arr))
				{					
					$result = array('status'=>1,'message'=>'image uploaded.'); 
					$this->Image->save($new_arr);
				}
				else{
					$result = array('status'=>0,'message'=>'image not uploaded.');  
				}
			}
				else{
					$result = array('status'=>0,'message'=>'No user record found'); 
				}
				
		}
		 
		echo json_encode($result);die;  
	}

	public function getImages(){
        if($this->request->is('post')){
			$data=$this->data;
			$getImages=$this->Image->find('all',array('conditions'=>array('Image.user_id'=>$data['user_id']),'fields'=>array('Image.id','Image.image')));
			$images = Array();
			for($i = 0; $i < count($getImages); $i++) {
				$images[] = $getImages[$i]["Image"];
			}
	     	if($images){
				$result = array('status'=>1,'res'=>$images, ); 	
			}
			else{
				$result = array('status'=>0,'message'=>'No user record found'); 
			}
				
		}
		 
		echo json_encode($result);die;  
	}
	public function deleteImage(){		
		if($this->request->is('post')){
		    $data= $this->data;
		    $getImages=$this->Image->find('first',array('conditions'=>array('Image.id'=>$data['image_id'])));

			if($getImages){
				$this->Image->delete($getImages['Image']['id']);
             	$result = array('status'=>1,'message'=>'Image deleted succesfully.'); 
			}
			else {
				$result = array('status'=>0,'message'=>'No image record found'); 
			}
		}
		echo json_encode($result);die; 
	}
	//Home api
	public function Allprofile(){
        if($this->request->is('post')){
			$data= $this->data;
			//user details
			$userID=$data['userID'];
			$getUsersData=$this->User->find('first',array('conditions'=>array('User.id'=>$userID),'fields'=>array('User.id','User.latitude','User.longitude'),'recursive'=>0));
			//check if show distance settings saved
			$getUsersSettingData=$this->UserSetting->find('first',array('conditions'=>array('UserSetting.userID'=>$data['userID']),'recursive'=>0));
			  if($getUsersSettingData){
				$showDistance=$getUsersSettingData['UserSetting']['ShowUserDistance'];
				$filterData['id']=$getUsersSettingData['UserSetting']['id'];
				$filterData['userID']=$getUsersSettingData['UserSetting']['userID'];
				$filterData['LookingFor']=$getUsersSettingData['UserSetting']['LookingFor'];
				$filterData['ShowUserDistance']=$getUsersSettingData['UserSetting']['ShowUserDistance'];
				$filterData['LocationName']=$getUsersSettingData['UserSetting']['LocationName'];
				$filterData['LocationLatitude']=$getUsersSettingData['UserSetting']['LocationLatitude'];
				$filterData['LocationLongitude']=$getUsersSettingData['UserSetting']['LocationLongitude'];
				$filterData['MaxDistance']=$getUsersSettingData['UserSetting']['MaxDistance'];
				$filterData['MinDistance']=$getUsersSettingData['UserSetting']['MinDistance'];
				$filterData['MinAge']=$getUsersSettingData['UserSetting']['MinAge'];
				$filterData['MaxAge']=$getUsersSettingData['UserSetting']['MaxAge'];
				$filterData['RaceType']=$getUsersSettingData['UserSetting']['RaceType'];
				$filterData['BodyType']=$getUsersSettingData['UserSetting']['BodyType'];
			  }
			  else{
				   $showDistance=1;
				   $filterData=[];
			  }

           // $results = $this->User->query("SELECT DISTINCT * from users order by id"); 
			$results = $this->User->query("SELECT DISTINCT * from users  where id!='".$data['userID']."' order by id"); 
            if(!empty($data['userID'])){
	            foreach($results as $key=>$result) {
					
					//check the last activity
					$check_user_exist=$this->User->find('first',array('conditions'=>array('User.id'=>$result['users']['id']),'fields'=>array('User.id','User.last_activity')));
					
					 if(!empty($check_user_exist)){
						$lastTimeStamp=$check_user_exist['User']['last_activity']; 
						
						$lastActivetime=$this->getTheTimeDifference($lastTimeStamp);
					}
					else{
						$lastActivetime='N/a';
					} 
					//check the status from likes table
					$check_user_status=$this->Like->find('first',array('conditions'=>array('Like.likedby'=>$result['users']['id'],'Like.UserId'=>$data['userID'])));
					 
					
					  if($check_user_status)
					  {
						   $likeRecordId=$check_user_status['Like']['id'];
						   $Liked=$check_user_status['Like']['likess']>0 ? "1":"0";
						   $Unlike=$check_user_status['Like']['dislikes']>0 ? "1":"0";
						   $setFavourite=$check_user_status['Like']['favorite']>0 ? "1":"0";
						   $Report=$check_user_status['Like']['report']>0 ? "1":"0";
						  
					  }
					   else{
						   $likeRecordId='';
						   $Liked="0";
						   $Unlike="0";
						   $setFavourite="0";
						   $Report="0";
						   
					   }
					//get the distance
					   $lat1=$getUsersData['User']['latitude']?$getUsersData['User']['latitude']:'0.0';
					  $lon1=$getUsersData['User']['longitude']?$getUsersData['User']['longitude']:'0.0';
					  $lat1=$result['users']['latitude']?$result['users']['latitude']:'0.0';
					  $lon2=$result['users']['longitude']?$result['users']['longitude']:'0.0';
					  $result['users']['id'];
					  $theDistance=$this->getDistanceBetweenPoints($lat1, $lon1, $lat1, $lon2, 'M'); 
	
                    if($result['users']['id']!=$data['userID']) {
	                    $newdata['userID']   =  $result['users']['id'];
	                    $newdata['videoUrl'] =  $result['users']['vedio_url']?$result['users']['vedio_url']:'';
	                    $newdata['videoImage'] =  $result['users']['videoImage']?BASE_URL_USER_IMAGES.$result['users']['videoImage']:'';
	                    $newdata['userName'] =  $result['users']['username'];
	                    $newdata['OnlineStatus'] = $result['users']['status'];
						$newdata['ShowDistance'] = $result['users']['status'];
						$newdata['Distance'] =  number_format($theDistance,2);
						$newdata['Liked'] =  $Liked;
	                    $newdata['Unlike'] =  $Unlike;
	                    $newdata['setFavourite'] =  $setFavourite;
	                    $newdata['Report'] =  $Report;
	                    $newdata['likeRecordId'] =  $likeRecordId;
	                    $newdata['last_active'] =  $lastActivetime;
						$newdata1[]=$newdata;
				    }
			    }
				$result = array('status'=>1,'message'=>'User Profile data.','show_distance'=>$showDistance,'filterData'=>$filterData,'data'=>$newdata1); 
	        }
			else{
				$result = array('status'=>0,'message'=>'Profile not found.');  
			}
		}
			
		echo json_encode($result);die;  
	}
			 
			
	//home page-like dilike report and favorite api
	public function status(){
        if($this->request->is('post')){
			$data= $this->data;
			if(!empty($data))
			{
			$status= $data['status'];
            $userID= $data['userID'];
            $likedID= $data['likedID'];
			if(!empty($data['status'])){
			$data['status']==1 ? $liked='1' :'0';
			$data['status']==2 ? $dislikes='1' :'0';
			$data['status']==3 ? $favorite='1' :'0';
			$data['status']==4 ? $report='1' :'0';
			//check user payment status
			$check_user_exist=$this->User->find('first',array('conditions'=>array('User.id'=>$data['userID']),'fields'=>array('User.id','User.PaymentStatus')));
			if(!$check_user_exist)
			{
				$result = array('status'=>0,'message'=>'No user record found'); 
			}
			else
			{
			
			$checkAlready=$this->Like->find('first',array('conditions'=>array('Like.UserId'=>$userID,'Like.likedby'=>$likedID)));
			if(!$checkAlready) 
			{
			$insertData['UserId']=$userID;
			$insertData['likedby']=$likedID;
			$insertData['likess']=@$liked?$liked:0;
			$insertData['dislikes']=@$dislikes?$dislikes:0;
			$insertData['favorite']=@$favorite?$favorite:0;
			$insertData['report']=@$report?$report:0;
			$saved=$this->Like->save($insertData);
			$result = array('status'=>1,'message'=>'Success!'); 
				
			}	
			else
			{
			//like
			if($data['status']==1)
			{
		    //check payment status:
			$paymentStatus=$check_user_exist['User']['PaymentStatus'];
			$totalLikesOneDay = $this->Like->find('all', array('conditions' => array('Like.updated_at BETWEEN NOW() -INTERVAL 20 DAY AND NOW()','Like.UserID'=>$data['userID'],'Like.likess'=>1)));
		 	 $totalCount=count($totalLikesOneDay);
			  
			if($paymentStatus==0 && $totalCount>=3) 
			{
				  $result = array('status'=>0,'message'=>'Your limit to like other profiles in a day exceeded,please purchase the plan to continue.'); 
				  echo json_encode($result);die; 
			}	
				
				
				
			$report=$checkAlready['Like']['report'];	
			$favorite=$checkAlready['Like']['favorite'];
			if($checkAlready['Like']['likess']==0 && $data['status']==1) //like
			{
				$liked=1;
				$dislikes=0;
				$message='Liked successfully.'; 
			}
			elseif($checkAlready['Like']['likess']==1 && $data['status']==1)
			{
				$liked=0;
				$message='Liked removed successfully.';
			}
			else
			{
				$liked=$checkAlready['Like']['likess'];
				$message='Liked successfully..';
			}
			}
			
			//dislike
			if($data['status']==2)
			{
			$report=$checkAlready['Like']['report'];	
			$favorite=$checkAlready['Like']['favorite'];	
			if($checkAlready['Like']['dislikes']==0 && $data['status']==2) //like
			{
				$dislikes=1;
				$liked=0;
				$message='Disliked successfully.';
			}
			elseif($checkAlready['Like']['dislikes']==1 && $data['status']==2)
			{
				$dislikes=0;
				$message='Disliked removed successfully.';
			}
			else
			{
				$dislikes=$checkAlready['Like']['dislikes'];
				$message='Disliked successfully.';
			}
			}
			
			//fav
			if($data['status']==3)
			{
			$liked=$checkAlready['Like']['likess'];
			$dislikes=$checkAlready['Like']['dislikes'];
			$report=$checkAlready['Like']['report'];
			if($checkAlready['Like']['favorite']==0 && $data['status']==3) //like
			{
				
				$favorite=1;
				$message='Added to favorites successfully.';
			}
			elseif($checkAlready['Like']['favorite']==1 && $data['status']==3)
			{
				$favorite=0;
				$message='Removed from favorites successfully.';
			}
			else
			{
				$favorite=$checkAlready['Like']['favorite'];
				$message='Added to favorites successfully.';
			}
			}
			
			//report
			if($data['status']==4)
			{
			$liked=$checkAlready['Like']['likess'];
			$dislikes=$checkAlready['Like']['dislikes'];
			$favorite=$checkAlready['Like']['favorite'];	
			if($checkAlready['Like']['report']==0 && $data['status']==4) //like
			{
				$report=1;
				$message='Reported successfully.';
			}
			elseif($checkAlready['Like']['report']==1 && $data['status']==4)
			{
				$report=0;
				$message='Reported removed successfully.';
			}
			else
			{
				$report=$checkAlready['Like']['report'];
				$message='Reported successfully.';
			}
			}
			
				
			$updateData['likess']=@$liked;
			$updateData['dislikes']=@$dislikes;
			$updateData['favorite']=@$favorite;
			$updateData['report']=@$report;
			$this->Like->id=$checkAlready['Like']['id'];
			$updated=$this->Like->save($updateData);
			$result = array('status'=>1,'message'=>$message);
				
			}	
			}			
				
		    }
			else{
				$result = array('status'=>0,'message'=>'No action added.'); 	
			}
			}
			else{
				$result = array('status'=>0,'message'=>'Data is empty.'); 
			}
			
        }	
		else
		{
				$result = array('status'=>0,'message'=>'Method is mismatch.'); 
		}		
		echo json_encode($result);die;   
	}
	
	public function status_backup(){
        if($this->request->is('post')){
			$data= $this->data;
			$status= $data['status'];
            $userID= $data['userID'];
            $likedID= $data['likedID'];
			if(!empty($data['status'])){
	            $likes = ($data['status']==1) ? 1 : "";
	            $dislikes = ($data['status']==2) ? 2 : "";
	            $favorite = ($data['status']==3) ? 3 : "";
	            $report = ($data['status']==4) ? 4 : "";
		    }
          //  $check = $this->User->query("select * from likes order by id"); 
		    $selectQuery="select * from likes where UserId =".$userID." and likedby =".$likedID." order by id desc limit 1";
            $check = $this->User->query($selectQuery);   
			
			if(!$check)
			{
		     $query="INSERT INTO likes (UserId, likedby, likess, dislikes, report, favorite)VALUES ('$userID', '$likedID', '$likes', '$dislikes', '$report', '$favorite')";
			$message="inserted";
				
			}	
			else{
			$query= "UPDATE `likes` SET `UserId`='$userID', `likedby`='$likedID',";
			//likes
			if($likes){
			$query .=	"`likess`='$likes',";
			}
			else
			{
			$query .=	"`likess`="."'".$check[0]['likes']['likess']."',";	
			}
			
			
			//dislikes
			if($dislikes){
			$query .=	"`dislikes`='$dislikes',";
			}
			else
			{	
			$query .=	"`dislikes`="."'".$check[0]['likes']['dislikes']."',";				
			}
			//report
			if($report){
			$query .=	"`report`='$report',";
			}
			else
			{
			$query .=	"`report`="."'".$check[0]['likes']['report']."',";
			}
			//favorite
			if($favorite){
			$query .=	"`favorite`='$favorite'";
			}
			else
			{	
			$query .=	"`favorite`="."'".$check[0]['likes']['favorite']."'";
			}
			
			$query .=" WHERE `id`="."'".$check[0]['likes']['id']."'";
			$message="updated";
				
			}
			
			$result = $this->User->query($query);
			$recorded=$this->User->getAffectedRows();
			if($recorded || $result)
			{
			$result = array('status'=>$data['status'],'message'=>'Success');	
			}
			else{
				$result = array('status'=>0,'message'=>'Something went wrong.');  
			} 
			/*  
			
            if($value['likes']['UserId']!=$userID || $value['likes']['likedby']!=$likedID){                  
             	$result = $this->User->query("INSERT INTO likes (UserId, likedby, likess, dislikes, report, favorite)
                  VALUES ('$userID', '$likedID', '$likes', '$dislikes', '$report', '$favorite')");
				$result = array('status'=>$data['status'],'message'=>'success'); 
	        }
			else{
				$result = array('status'=>0,'message'=>'Something went wrong.');  
			}  */
        }			
		echo json_encode($result);die;  
	}

	//vedio  api
	public function UploadVideo(){
        if($this->request->is('post')){
	        $data= $this->data;
			$getUsersData=$this->User->find('first',array('conditions'=>array('User.id'=>$data['userID']),'fields'=>array('User.id', 'User.vedio_url')));
	        if($getUsersData){
	            if(!empty($_FILES['vedio']['name'])){
					$ext_details = pathinfo($_FILES['vedio']['name']);
					$ext = strtolower($ext_details['extension']);
					$image = $this->getGUID();
					$guid = substr($image, 1, -1);
					//$guid = strtolower($ext_details['filename']);
					$image_name=$guid.'.'.$ext;
					$file_path = basename($image_name);
					$destination = realpath('../webroot/img/user_profile_pics/'). '/';
					
					if (!move_uploaded_file($_FILES['vedio']['tmp_name'], $destination.$file_path)) {
						$result = array('status'=>0,'message'=>'User vedio not uploaded.');
						echo json_encode($result);die;  
					}
				}
				else{
				    $image_name = $getUsersData['User']['vedio_url']; 
				}
	 			$newdata['vedio_url'] =$image_name;
	            $this->User->id = $data['userID'];
				if($this->User->save($newdata) && !empty($_FILES['vedio']['name']))
				{
					$getUpdatedUsersData=$this->User->find('first',array('conditions'=>array('User.id'=>$data['userID']),'fields'=>array('User.vedio_url')));
					$dataUpdated['userID'] = $getUsersData['User']['id'];
					$dataUpdated['vedio']=BASE_URL_USER_IMAGES.$image_name;
					$result = array('status'=>1,'message'=>'User vedio uploaded.','data'=>$dataUpdated); 
				}
				 else{
					$result = array('status'=>0,'message'=>'User vedio not uploaded.');
				 }
			}
			else{
				$result = array('status'=>0,'message'=>'No user record found'); 
		    }
	    }
		echo json_encode($result);die;  
	}


    // My Match list 

	public function MyMatchList(){
        if($this->request->is('post')){
		    $data= $this->data;
			if(!empty($data))
			{
			//$getUsersId = $this->User->query("select DISTINCT likedby from likes where userID=".$data['userID']." AND likess=1 AND report!=1 order by id");
			 
			 $allLikedUsers=$this->Like->find('all',array('conditions'=>array('Like.userID'=>$data['userID'],'Like.report !='=>1),'fields'=>array('Like.id','Like.likedby')));
			  $finalUserData=array();
				if($allLikedUsers) {
				 $i=0;
                foreach($allLikedUsers as $key=>$result) {
	             $check_user_exist=$this->User->find('first',array('conditions'=>array('User.id'=>$result['Like']['likedby']),'fields'=>array('User.id', 'User.username','User.profilePic', 'User.about_me'),'recursive'=>0));
				  if(!empty($check_user_exist)){
						$finalUserData['userID']=$check_user_exist['User']['id'];
						$finalUserData['userName']=$check_user_exist['User']['username'];
						$finalUserData['Aboutme']=$check_user_exist['User']['about_me'];
						if($check_user_exist['User']['profilePic'])
						{
						$finalUserData['profilePic']=BASE_URL_USER_IMAGES.$check_user_exist['User']['profilePic'];
						}
						else{
						$finalUserData['profilePic']='';
						}
 
		            } 
					$i++;
					$finalUserDataNew[]=$finalUserData;
		        }
           		$result = array('status'=>1,'message'=>'success.','data'=>$finalUserDataNew); 
			}
			else{
				$result = array('status'=>0,'message'=>'No matches found.'); 
			}
			}
			else
			{
			$result = array('status'=>0,'message'=>'Method mismatch.'); 
			}
		}
		else{
			$result = array('status'=>0,'message'=>'Method mismatch.'); 
		}
       	echo json_encode($result);die; 
    }


    // Search Filter 

    public function SearchFilter_backup15052019(){

        if($this->request->is('post')){
			$data= $this->data; 
			if($data['LookingFor']== 0){
			 $gender='male';
			}
			else{
	         $gender='female';
			}
	        $BodyType = $data['BodyType'];
	        $MinAge = $data['MinAge'];
	        $MaxAge = $data['MaxAge'];
	        $userID = $data['userID'];
	        $filterDetails = array('LookingFor'=>$data['LookingFor'], 'BodyType'=>$BodyType, 'MinAge'=>$MinAge, 'MaxAge'=>$MaxAge);
	        $getData= $this->User->query("select * from users where gender='$gender' AND body_type='ethletic' AND user_age BETWEEN $MinAge and $MaxAge order by id");

	        if($getData){
	        	$string = serialize($filterDetails);
	        	$uerID= $this->User->query("select userID from user_settings where userID='$userID' order by id");
	        	if(empty($uerID)){
                $this->User->query("INSERT INTO user_settings (userID, filterSetting) VALUES ('$userID','$string')");    
	        	}
	        	else {
                $this->User->query("UPDATE user_settings SET filterSetting='$string' WHERE userID='$userID'"); 
	        	}
	            foreach($getData as $key=>$result) {

                    $newdata['userID']   =  $result['users']['id'];
	                $newdata['videoUrl'] =  BASE_URL_USER_IMAGES.$result['users']['vedio_url'];
	                $newdata['userName'] =  $result['users']['username'];
	                $newdata['OnlineStatus'] = $result['users']['status'];
	                $newdata['Distance'] =  $result['users']['status'];
	                $newdata['Liked'] =  $result['users']['status'];
	                $newdata['Unlike'] =  $result['users']['status'];
	                $newdata['setFavourite'] =  $result['users']['status'];
	                $newdata['Report'] =  $result['users']['status'];
	                $newdata1[]=$newdata;
	            }

	        	$result = array('status'=>1,'message'=>'success.','data'=>$newdata1); 
			}
			else{

				$result = array('status'=>0,'message'=>'No user record found'); 
			}

		}

 		echo json_encode($result);die; 
	}
	
	public function SearchFilter(){

        if($this->request->is('post')){
			$data= $this->data; 
			if(!empty($data)){
				$userID = $data['userID'];
				$getUsersData=$this->User->find('first',array('conditions'=>array('User.id'=>$userID),'fields'=>array('User.id','User.latitude','User.longitude'),'recursive'=>0));
				
				if($getUsersData){
					$getUsersSettingData=$this->UserSetting->find('first',array('conditions'=>array('UserSetting.userID'=>$getUsersData['User']['id']),'recursive'=>0));
					
					if($getUsersSettingData){
						$showDistance=$getUsersSettingData['UserSetting']['ShowUserDistance'];	
						$filterData['id']=$getUsersSettingData['UserSetting']['id'];
						$filterData['userID']=$getUsersSettingData['UserSetting']['userID'];
						$filterData['LookingFor']=$getUsersSettingData['UserSetting']['LookingFor'];
						$filterData['ShowUserDistance']=$getUsersSettingData['UserSetting']['ShowUserDistance'];
						$filterData['LocationName']=$getUsersSettingData['UserSetting']['LocationName'];
						$filterData['LocationLatitude']=$getUsersSettingData['UserSetting']['LocationLatitude'];
						$filterData['LocationLongitude']=$getUsersSettingData['UserSetting']['LocationLongitude'];
						$filterData['MaxDistance']=$getUsersSettingData['UserSetting']['MaxDistance'];
						$filterData['MinDistance']=$getUsersSettingData['UserSetting']['MinDistance'];
						$filterData['MinAge']=$getUsersSettingData['UserSetting']['MinAge'];
						$filterData['MaxAge']=$getUsersSettingData['UserSetting']['MaxAge'];
						$filterData['RaceType']=$getUsersSettingData['UserSetting']['RaceType'];
						$filterData['BodyType']=$getUsersSettingData['UserSetting']['BodyType'];
					}	
					else{
						$showDistance=1;
						$filterData=[];
					}
					
					
					if($data['LookingFor']== 0)
					{
						$gender='male';
					}
					else
					{
						$gender='female';
					}
					$LookingFor=$gender;
					$ShowUserDistance=$data['ShowUserDistance'];
					$LocationName=$data['LocationName'];
					$LocationName=$data['LocationName'];
					$LocationLatitude=$data['LocationLatitude'];
					$LocationLongitude=$data['LocationLongitude'];
					$MaxDistance=$data['MaxDistance'];
					$MinDistance=$data['MinDistance'];
					$MinAge = $data['MinAge'];
					$MaxAge = $data['MaxAge'];
					$RaceType = $data['RaceType'];
					$BodyType = $data['BodyType'];
					$filterDetails = array('LookingFor'=>$data['LookingFor'], 'ShowUserDistance'=>$ShowUserDistance,'LocationName'=>$LocationName,'LocationLatitude'=>$LocationLatitude,'LocationLongitude'=>$LocationLongitude,'MaxDistance'=>$MaxDistance,'MinDistance'=>$MinDistance,'MinAge'=>$MinAge, 'MaxAge'=>$MaxAge,'RaceType'=>$RaceType,'BodyType'=>$BodyType);
					$recordExist= $this->UserSetting->find('first',array('conditions'=>array('UserSetting.UserId'=>$userID)));
					if(empty($recordExist))
					{
						//save the filter
						$filterString = serialize($filterDetails);
						$filterData['userID'] =$userID;
						$filterData['LookingFor'] =$LookingFor;
						$filterData['ShowUserDistance'] =$ShowUserDistance;
						$filterData['LocationName'] =$LocationName;
						$filterData['LocationLatitude'] =$LocationLatitude;
						$filterData['LocationLongitude'] =$LocationLongitude;
						$filterData['MaxDistance'] =$MaxDistance;
						$filterData['MinDistance'] =$MinDistance;
						$filterData['MinAge'] =$MinAge;
						$filterData['MaxAge'] =$MaxAge;
						$filterData['RaceType'] =$RaceType;
						$filterData['BodyType'] =$BodyType;
						$filterData['filterSetting'] =$filterString;
						$filterDataSaved= $this->UserSetting->save($filterData);				
					}
					else
					{
						//update the record
						$filterString = serialize($filterDetails);
						$filterData['userID'] =$userID;
						$filterData['LookingFor'] =$LookingFor;
						$filterData['ShowUserDistance'] =$ShowUserDistance;
						$filterData['LocationName'] =$LocationName;
						$filterData['LocationLatitude'] =$LocationLatitude;
						$filterData['LocationLongitude'] =$LocationLongitude;
						$filterData['MinDistance'] =$MinDistance;
						$filterData['MaxDistance'] =$MaxDistance;
						$filterData['MinAge'] =$MinAge;
						$filterData['MaxAge'] =$MaxAge;
						$filterData['RaceType'] =$RaceType;
						$filterData['BodyType'] =$BodyType;
						$filterData['filterSetting'] =$filterString;
						$this->UserSetting->id=$recordExist['UserSetting']['id'];
						
						$filterDataUpdated= $this->UserSetting->save($filterData);
					}
					
					unset($filterData['filterSetting']);
					//get the filter users id
					$filterUsers= $this->UserSetting->find('all',array('conditions'=>array('OR' => array('UserSetting.LookingFor'=>$LookingFor,'UserSetting.LocationName'=>$LocationName,'UserSetting.MinDistance >='=>$MinDistance,'UserSetting.MaxDistance <='=>$MaxDistance,'UserSetting.MinAge >='=>$MinAge,'UserSetting.MaxAge <='=>$MaxAge,'UserSetting.RaceType'=>$RaceType,'UserSetting.BodyType'=>$BodyType),'UserSetting.userID !='=>$data['userID']),'fields'=>array('UserSetting.id','UserSetting.userID')));
					$logs = $this->UserSetting->getDataSource()->getLog(false, false);
				
					$lastLog = end($logs['log']);
					// echo $lastLog['query'];
					// echo "<pre>";
					// print_r($filterUsers); 
					if($filterUsers)
					{
						foreach($filterUsers as $key=>$value)
						{
							//  print_r($value);
							$userIDS[]=  $value['UserSetting']['userID'];
						}
						$tags = implode(', ', $userIDS);
					}
					else{
						$tags = '0'; 
					}
				
					//$results = $this->User->query("SELECT  * from users where id!='".$data['userID']."'"); 
					$selectStatement="SELECT DISTINCT * from users  where `id` IN ($tags) order by id";
					//$results = $this->User->query("SELECT DISTINCT * from users  where id!='".$data['userID']."' order by id"); 
					$results = $this->User->query($selectStatement); 
				
					if($results)
					{
						foreach($results as $key=>$result) {
							
							//check the last activity
							$check_user_exist=$this->User->find('first',array('conditions'=>array('User.id'=>$result['users']['id']),'fields'=>array('User.id','User.last_activity')));
							
							 if(!empty($check_user_exist)){
								$lastTimeStamp=$check_user_exist['User']['last_activity']; 
								
								$lastActivetime=$this->getTheTimeDifference($lastTimeStamp);
							}
							else{
								$lastActivetime='N/a';
							} 
							//check the status from likes table
							$check_user_status=$this->Like->find('first',array('conditions'=>array('Like.likedby'=>$result['users']['id'],'Like.UserId'=>$data['userID'])));
							
							  if($check_user_status)
							  {
								   $Liked=$check_user_status['Like']['likess']>0 ? "1":"0";
								   $Unlike=$check_user_status['Like']['dislikes']>0 ? "1":"0";
								   $setFavourite=$check_user_status['Like']['favorite']>0 ? "1":"0";
								   $Report=$check_user_status['Like']['report']>0 ? "1":"0";
								  
							  }
							   else{
								   $Liked="0";
								   $Unlike="0";
								   $setFavourite="0";
								   $Report="0";
								   
							   }
							   
							  //get the distance
							  $lat1=$getUsersData['User']['latitude']?$getUsersData['User']['latitude']:'0.0';
							  $lon1=$getUsersData['User']['longitude']?$getUsersData['User']['longitude']:'0.0';
							  $lat1=$result['users']['latitude']?$result['users']['latitude']:'0.0';
							  $lon2=$result['users']['longitude']?$result['users']['longitude']:'0.0';
							  $theDistance=$this->getDistanceBetweenPoints($lat1, $lon1, $lat1, $lon2, 'M'); 
							
							 if($result['users']['id']!=$data['userID']) {
								$newdata['userID']   =  $result['users']['id'];
								$newdata['videoUrl'] =  $result['users']['vedio_url']?BASE_URL_USER_IMAGES.$result['users']['vedio_url']:'';
								$newdata['videoImage'] =  $result['users']['videoImage']?BASE_URL_USER_IMAGES.$result['users']['videoImage']:'';
								$newdata['userName'] =  $result['users']['username'];
								$newdata['OnlineStatus'] = $result['users']['status'];
								$newdata['Distance'] =  number_format($theDistance,2);
								$newdata['Liked'] =  $Liked;
								$newdata['Unlike'] =  $Unlike;
								$newdata['setFavourite'] =  $setFavourite;
								$newdata['Report'] =  $Report;
								$newdata['last_active'] =  $lastActivetime;
								$newdata1[]=$newdata;
							}
						}
						$result = array('status'=>1,'message'=>'Success.','show_distance'=>$showDistance,'filterSettings'=>	$filterData,'data'=>$newdata1); 
					}
					else{
						$newdata1=array();
						$result = array('status'=>1,'message'=>'Success.','show_distance'=>$showDistance,'filterSettings'=>$filterData,'data'=>$newdata1);  
					}
				

				}
				else{
					$result = array('status'=>0,'message'=>'No user record found'); 
				}
			}
			else
			{
				$result = array('status'=>0,'message'=>'Data is empty!'); 
			}
		}
		else
		{
			$result = array('status'=>0,'message'=>'Method mismatch!'); 
		}

 		echo json_encode($result);die; 
	}



// Fetch Users Setting Api

	public function UsersSetting_backup(){

        if($this->request->is('post')){

			$data= $this->data;   
	        $userID= $data['userID'];
			$getUsersData= $this->User->query("select * from user_settings where userID='$userID' order by id");
            if($getUsersData){
	            foreach($getUsersData as $key=>$result) {
                    $data = $result['user_settings']['filterSetting'];
                    $filterData =  unserialize($data);
	            }

	               $result = array('status'=>1,'message'=>'success.','data'=>$filterData); 
			}
			else{

				$result = array('status'=>0,'message'=>'No user record found'); 
			}
	    }

 	    echo json_encode($result);die; 
	}
	
	public function UsersSetting(){

        if($this->request->is('post')){
			$data=$this->data;
			if(!empty($data)){
				$userID= $data['userID'];
				$getUsersData=$this->User->find('first',array('conditions'=>array('User.id'=>$userID),'fields'=>array('User.id'),'recursive'=>0));
				
				if($getUsersData){
					$getUsersSettingData=$this->UserSetting->find('first',array('conditions'=>array('UserSetting.userID'=>$getUsersData['User']['id']),'recursive'=>0));
			
					if($getUsersSettingData){
						$filterData['id']=$getUsersSettingData['UserSetting']['id'];
						$filterData['userID']=$getUsersSettingData['UserSetting']['userID'];
						$filterData['LookingFor']=$getUsersSettingData['UserSetting']['LookingFor'];
						$filterData['ShowUserDistance']=$getUsersSettingData['UserSetting']['ShowUserDistance'];
						$filterData['LocationName']=$getUsersSettingData['UserSetting']['LocationName'];
						$filterData['LocationLatitude']=$getUsersSettingData['UserSetting']['LocationLatitude'];
						$filterData['LocationLongitude']=$getUsersSettingData['UserSetting']['LocationLongitude'];
						$filterData['MaxDistance']=$getUsersSettingData['UserSetting']['MaxDistance'];
						$filterData['MinDistance']=$getUsersSettingData['UserSetting']['MinDistance'];
						$filterData['MinAge']=$getUsersSettingData['UserSetting']['MinAge'];
						$filterData['MaxAge']=$getUsersSettingData['UserSetting']['MaxAge'];
						$filterData['RaceType']=$getUsersSettingData['UserSetting']['RaceType'];
						$filterData['BodyType']=$getUsersSettingData['UserSetting']['BodyType'];
						$result = array('status'=>1,'message'=>'success.','data'=>$filterData); 
					}
					else{
						$result = array('status'=>0,'message'=>'No settings saved!'); 
					}
				}
				else{

					$result = array('status'=>0,'message'=>'No user record found'); 
				}
			}
			else
			{
				$result = array('status'=>0,'message'=>'Data is missing!'); 	
			}
	    }
		else
		{
			$result = array('status'=>0,'message'=>'Data is empty');	
		}
		

 	    echo json_encode($result);die; 
	}


 // Delete account
	public function DeleteAccount(){

        if($this->request->is('post')){

		    $data= $this->data; 

		    $getUsersData=$this->User->find('first',array('conditions'=>array('User.id'=>$data['userID'])));

                if($getUsersData){

                 $this->User->delete($getUsersData['User']['id']);

             $result = array('status'=>1,'message'=>'Account deleted succesfully.'); 
			}
			else{

				$result = array('status'=>0,'message'=>'No user record found'); 
			}

		}

        echo json_encode($result);die; 
	}

	//setAvailabilityStatus

	public function setAvailabilityStatus(){
		if($this->request->is('post')){
			$data=$this->data;
			$id=$data['userID'];
			$date= strtotime($data['Date']);
			$status=$data['avail_status'];
			$getUsersData=$this->User->find('first',array('conditions'=>array('User.id'=>$id)));
			if($getUsersData){
			$this->User->id=$id;
			$setstatus=$this->User->saveField("online_status",$status);
			
			if($status==1){

				$message="You Are Online";
			}else{

				$message="You Are Offline";
			}
			if($setstatus){
				$result=array('status'=>1,'message'=>$message);
			}else{
				$result=array('status'=>0,'message'=>'Please Try Again! ERROR!!');
			}

			}else{
				$result=array('status'=>0,'message'=>'User Not Found');
			}

		}else{	
			$result=array('status'=>0,'message'=>"Invalid Request");
		}
		echo json_encode($result);die;
	}

	

// PaymentStatus

	public function PaymentStatus(){
		if($this->request->is('post')){
			$data=$this->data;
			$id=$data['userID'];
			$status=$data['PaymentStatus'];

			$getUsersData=$this->User->find('first',array('conditions'=>array('User.id'=>$id)));
			if($getUsersData){

				//print_r($getUsersData); die(); exit();
            $this->User->id=$id;
            $this->User->saveField("PaymentStatus",$status);

			 $result = array('status'=>1,'message'=>'Payment Status updated successfully.'); 
			}
			else{

				$result = array('status'=>0,'message'=>'No user record found'); 
			}

		}

		echo json_encode($result);die;
	}

// Post Comment

	public function PostComment(){
		if($this->request->is('post')){
			$data=$this->data;
			$reciverID=$data['reciverID'];
			$senderID=$data['senderID'];
			$message=$data['comment'];
			$rating=$data['rating'];

			if(!empty($reciverID) && !empty($senderID)) {

                $this->User->query("INSERT INTO comment (reciverID, senderID, message, rating) VALUES ('$reciverID','$senderID','$message', '$rating')");    

                $result = array('status'=>1,'message'=>'Comment posted succesfully'); 
			}
			else{

				$result = array('status'=>0,'message'=>'No user record found'); 
			}

		}
		echo json_encode($result);die;
	}


//Fetch Comment 
		public function FetchComment(){
		if($this->request->is('post')){
			$data=$this->data;
			$my_id= $data['my_id'];
			$id= $data['userID'];
			//$getUsersData= $this->User->query("select * from comment where reciverID=$id order by id");
			
			$getCommentData =$this->User->find('all',array('conditions'=>array('User.id'=>$id)));
			
	            $check_user_exist = $this->User->find('first',array('conditions'=>array('User.id'=>$id),'fields'=>array('User.id', 'User.username','User.profilePic', 'User.about_me')));
				
				$finalData=array();
				//user profile data
				 if($getCommentData)
				{
					
						$userdata['userID'] =  $getCommentData[0]['User']['id'];
						$userdata['userName'] =  $getCommentData[0]['User']['username'];
	                    $userdata['aboutMe'] = $getCommentData[0]['User']['about_me'];
						
						//get rating
						$sumRarting = 0;
					 	$commentCount=count($getCommentData[0]['Comment']);
						if($commentCount>0)
						{
						foreach ($getCommentData[0]['Comment'] as $item) {
							$sumRarting += $item['rating'];
						}
						$averageRate=$sumRarting /$commentCount;
						$userdata['Rating'] =ceil($averageRate);  
						}
						else{
						$userdata['Rating'] =  0;
						}
	                    
	                    $userdata['total_comments'] =  $commentCount>0?$commentCount:0;
	                    if(!empty($getCommentData[0]['User']['profilePic']))
						{
	                    $userdata['profile_image'] = BASE_URL_USER_IMAGES.$getCommentData[0]['User']['profilePic'];
	                    } 
						else 
						{
	                	$userdata['profile_image'] = '';
	                    }
						$finalData['profile'] = $userdata;
				}
				//comments
				if(!empty($getCommentData[0]['Comment']))
				{
					$i=0;
					$commentData=array();
				foreach($getCommentData[0]['Comment'] as $key=>$comment)
				{
					//get user data
					$getCommentUserData =$this->User->find('all',array('conditions'=>array('User.id'=>$comment['senderID']),'recursive'=>0));
					
					//get the total likes of a comment
					$sum = $this->CommentLike->find('all', array('conditions' => array('CommentLike.comment_id' => $comment['id'],'CommentLike.liked' => 1),'fields' => array('sum(CommentLike.liked) as total_likes')));
					$commentData['comment_id']=$comment['id'];
					$commentData['comment_user_id']=$comment['senderID'];
					$commentData['userName']=@$getCommentUserData[0]['User']['username']?$getCommentUserData[0]['User']['username']:"";
					$commentData['CreateDate']=date("M d Y",strtotime($comment['created_at']));
					$commentData['Rating']=$comment['rating']?$comment['rating']:0;
					$commentData['likes']=$sum[0][0]['total_likes']?$sum[0][0]['total_likes']:0;
					$commentData['Comment']=$comment['message'];
					if(!empty($getCommentUserData[0]['User']['profilePic']))
					{
					$commentData['ProfilePic'] = BASE_URL_USER_IMAGES.$getCommentUserData[0]['User']['profilePic'];
					} 
					else 
					{
					$commentData['ProfilePic'] = '';
	                }
					//liked by me or not
					$CommentLike = $this->CommentLike->find('first', array('conditions' => array('CommentLike.comment_id' => $comment['id'],'CommentLike.liker_id' => $my_id,'CommentLike.liked' => 1),'fields' => array('CommentLike.id')));
					 
					  if(!empty($CommentLike))
					  {
						$commentData['liked'] = "1";
					  }
					  else{
						  $commentData['liked'] = "0";
					  }
					
					
					$finalData['comment'][$i] = $commentData;
					$i++;
				}				
				}
				else
				{
				$finalData['comment']=[];	
				}
            	$result = array('status'=>1,'message'=>'success','data'=>$finalData); 
			
        }
		echo json_encode($result);die;
	}
	
    public function FetchComment_backup14052019(){
		if($this->request->is('post')){
			$data=$this->data;
			$id= $data['userID'];
			$getUsersData= $this->User->query("select * from comment where reciverID=$id order by id");
			if($getUsersData){	
	            $getCommentData = $this->User->query("select u.username, u.id, u.profilePic, c.message,c.rating,i.commentID,i.likes,c.created_at from users as u join comment as c on u.id = c.senderID left join  comment_info i on c.id = i.commentID where c.reciverID ='$id'");
	            $check_user_exist = $this->User->find('first',array('conditions'=>array('User.id'=>$id),'fields'=>array('User.id', 'User.username','User.profilePic', 'User.about_me')));

	            foreach($check_user_exist as $key=>$result) {
	           	        $userdata['userName'] =  $result['username'];
	                    $userdata['userID'] =  $result['id'];
	                    $userdata['aboutMe'] = $result['about_me'];
	                    $userdata['Rating'] =  '';
	                    if(!empty($result['profilePic'])){
	                    $userdata['profile_image'] = BASE_URL_USER_IMAGES.$result['profilePic'];
	                    } else {
	                	$userdata['profile_image'] = $result['profilePic'];
	                    }

	                  $userdata1['profile'] = $userdata;
	            }

		        $i=0;
		        foreach($getCommentData as $key=>$result) {

		         	$s =  $result['c']['created_at'];
		         	$dt = new DateTime($s);
	                $date = $dt->format('m/d/Y');
	                $newdata['userName'] =  $result['u']['username'];
                    if(!empty($result['u']['profilePic'])){
	                    $newdata['ProfilePic'] =  BASE_URL_USER_IMAGES.$result['u']['profilePic'];
	                }else{
	                    $newdata['ProfilePic'] = $result['u']['profilePic'];
	                    }
	                $newdata['Comment'] =  $result['c']['message'];
	                $newdata['Rating'] =  $result['c']['rating'];
	                $newdata['CreateDate'] =  $date;
                    if(!empty($result['i']['commentID'])){
	                    $newdata['commentID'] =  $result['i']['commentID'];
	                }else{
	                    $newdata['commentID'] = "";
	                }
	                if(!empty($result['i']['likes'])){
	                    $newdata['likes'] =  $result['i']['likes'];
	                    }else{
	                        $newdata['likes'] ="";
	                    }
	                    $newdata1[] = $newdata;
	                    $userdata1['comment'][$i]=$newdata;
	                    $i++;
	                }

	            	$result = array('status'=>1,'message'=>'success','data'=>$userdata1); 
			}
			else{
					$result = array('status'=>0,'message'=>'No comment found'); 
				}
        }
		echo json_encode($result);die;
	}

// Comment Like API --*Pending*--

	public function CommentLike(){
		if($this->request->is('post')){
			$data=$this->data;
			$id=$data['commentID'];

			$UsersData= $this->User->query("select commentID from comment_info where commentID=$id order by id");

           if($UsersData){	
			 
            	$result = array('status'=>1,'message'=>'success','data'=>$UsersData); 
			}
			else{

				$result = array('status'=>0,'message'=>'No comment found'); 
			}

		}
		echo json_encode($result);die;
	}

//=============May 13,2019============================

 public function ReplyAComment(){
		if($this->request->is('post')){
			$data=$this->data;
			if(!empty($data)){
				$comment_id=$data['comment_id'];
				$user_id=$data['user_id'];
				$commenter_id=$data['commenter_id'];
				$comment_reply=$data['comment_reply'];
				if(empty($comment_id))
				{
				$result = array('status'=>0,'message'=>'Missing comment ID.');	
				}
				elseif(empty($comment_reply))
				{
				$result = array('status'=>0,'message'=>'Please post some comment first.');	
				}
				else
				{
				$commentReplyData=array();
				$commentReplyData['comment_id'] = $comment_id;
				$commentReplyData['user_id'] = $user_id;
				$commentReplyData['commenter_id'] = $commenter_id;
				$commentReplyData['comment_reply'] = $comment_reply;
				$saved=$this->CommentReply->save($commentReplyData);
				if($saved)
				{
				$result = array('status'=>1,'message'=>'Comment posted succesfully!');	
				}
				else
				{
				$result = array('status'=>0,'message'=>'Something went wrong,please try again!');	
				}	
				}
			
			}	
			else
			{
				$result = array('status'=>0,'message'=>'Data is Empty!');
			}
		
		}
		else
		{
			$result = array('status'=>0,'message'=>'Method is mismatch!');
		}
		echo json_encode($result);die;
 }
 
 
  //like/unlike the comment
	public function LikeUnlikeAComment(){
		if($this->request->is('post')){
			$data=$this->data;
			if(!empty($data)){
				$comment_id=$data['comment_id'];
				$user_id=$data['user_id'];
				$liker_id=$data['liker_id'];
				if(empty($comment_id))
				{
				$result = array('status'=>0,'message'=>'Missing comment ID.');	
				}
				else
				{
				//check if already liked
				$getAlreadyLike=$this->CommentLike->find('first',array('conditions'=>array('CommentLike.comment_id'=>$comment_id,'CommentLike.liker_id'=>$liker_id)));
				
				if(empty($getAlreadyLike))
				{
				//like	
				$commentLikeData=array();
				$commentLikeData['comment_id'] = $comment_id;
				$commentLikeData['user_id'] = $user_id;
				$commentLikeData['liker_id'] = $liker_id;
				$commentLikeData['liked'] = 1;
				$saved=$this->CommentLike->save($commentLikeData);
				if($saved)
				{
				$message="Liked Successfully.";
				$result = array('status'=>1,'message'=>'Success,'.$message);	
				}
				else
				{
				$result = array('status'=>0,'message'=>'Something went wrong,please try again!');	
				}
				}
				else
				{
				//unlike-update the record
				$this->CommentLike->id = $getAlreadyLike['CommentLike']['id'];
				if($getAlreadyLike['CommentLike']['liked']==1)
				{
					$likeStatus=0;
					$message="Unliked Successfully.";
				}
				else{
					$likeStatus=1;
					$message="Liked Successfully.";
				}
			    $updateLikeStatus=$this->CommentLike->saveField("liked",$likeStatus);
				$result = array('status'=>1,'message'=>'Success,'.$message);
				} 
				}
			
			}	
			else
			{
				$result = array('status'=>0,'message'=>'Data is Empty!');
			}
		
		}
		else
		{
			$result = array('status'=>0,'message'=>'Method is mismatch!');
		}
		echo json_encode($result);die;
 }
 
  //Fetch Comment's replies
		public function FetchCommentReplies(){
		if($this->request->is('post')){
			$data=$this->data;
			if($data)
			{
			$UserID= $data['UserID'];
			$comment_id= $data['comment_id'];
			$getCommentData =$this->Comment->find('first',array('conditions'=>array('Comment.id'=>$comment_id)));
			
				$finalData=array();
				//main comment data found
				 if($getCommentData)
				{
						//main comment data
						$mainComment['id'] =  $getCommentData['Comment']['id'];
						$mainComment['user_id'] =  $getCommentData['Comment']['senderID'];
						$mainComment['user_name'] =  $getCommentData['User']['username'];
						$mainComment['dated'] =   date("M d Y",strtotime($getCommentData['Comment']['created_at']));
						$mainComment['message'] =   $getCommentData['Comment']['message'];
						//likes sum
						$likesum = $this->CommentLike->find('all', array('conditions' => array('CommentLike.comment_id' => $getCommentData['Comment']['id'],'CommentLike.liked' => 1),'fields' => array('sum(CommentLike.liked) as total_comment_likes')));
						$mainComment['likes'] =$likesum[0][0]['total_comment_likes']?$likesum[0][0]['total_comment_likes']:0;
	                    if(!empty($getCommentData['User']['profilePic']))
						{
	                    $mainComment['user_profile_pic'] = BASE_URL_USER_IMAGES.$getCommentData['User']['profilePic'];
	                    } 
						else 
						{
	                	$mainComment['user_profile_pic'] = '';
	                    }
						//liked by me or not
						$CommentLike = $this->CommentLike->find('first', array('conditions' => array('CommentLike.comment_id' => $getCommentData['Comment']['id'],'CommentLike.liker_id' => $data['UserID'],'CommentLike.liked' => 1),'fields' => array('CommentLike.id')));
						
						  if(!empty($CommentLike))
						  {
							$mainComment['liked'] = "1";
						  }
						  else{
							  $mainComment['liked'] = "0";
						  }
						
						$finalData['main_comment'] = $mainComment;
					
				//comment's comments data found
				if(!empty($getCommentData['CommentReply']))
				{ 
				$i=0;
				$commentData=array();
				foreach($getCommentData['CommentReply'] as $key=>$comment)
				{
					//get user data
					$getCommentUserData =$this->User->find('all',array('conditions'=>array('User.id'=>$comment['commenter_id']),'recursive'=>0));
					
					//get the total likes of a comment
					$sum = $this->CommentReplyLike->find('all', array('conditions' => array('CommentReplyLike.comment_reply_id' => $comment['id'],'CommentReplyLike.liked' => 1),'fields' => array('sum(CommentReplyLike.liked) as total_reply_likes')));
					
					$commentData['id']=$comment['id'];
					$commentData['comment_id']=$comment['comment_id'];
					$commentData['comment_user_id']=$comment['user_id'];
					$commentData['comment_user_name']=@$getCommentUserData[0]['User']['username']?$getCommentUserData[0]['User']['username']:"";
					$commentData['CreateDate']=date("M d Y",strtotime($comment['created_at']));
					$commentData['likes']=$sum[0][0]['total_reply_likes']?$sum[0][0]['total_reply_likes']:0;
					//$commentData['likes']=5;
					$commentData['comment_reply']=$comment['comment_reply'];
					if(!empty($getCommentUserData[0]['User']['profilePic']))
					{
					$commentData['ProfilePic'] = BASE_URL_USER_IMAGES.$getCommentUserData[0]['User']['profilePic'];
					} 
					else 
					{
					$commentData['ProfilePic'] = '';
	                }
					//liked by me or not
					$CommentReplyLike = $this->CommentReplyLike->find('first', array('conditions' => array('CommentReplyLike.comment_reply_id' => $comment['id'],'CommentReplyLike.liker_id' => $UserID,'CommentReplyLike.liked' => 1),'fields' => array('CommentReplyLike.id')));
					 
					  if(!empty($CommentReplyLike))
					  {
						$commentData['liked'] = "1";
					  }
					  else{
						  $commentData['liked'] = "0";
					  }
					
					$finalData['comment_replies'][$i] = $commentData;
					$i++;
				} 
				}
				else
				{
				$finalData['comment_replies']=[];	
				//$result = array('status'=>0,'message'=>'No further comments found!');	
				} 				
				}
				else
				{
				$result = array('status'=>0,'message'=>'No comment found!');
				}
			
        }
		else{
			 $result = array('status'=>0,'message'=>'Data is empty!');
		}
		}
		 else{
			 $result = array('status'=>0,'message'=>'Method mismatch!');
		 }
		 $result = array('status'=>1,'message'=>'success','data'=>$finalData); 
		echo json_encode($result);die;
	}
	
	//like/unlike the comment reply
	public function LikeUnlikeACommentReply(){
		if($this->request->is('post')){ 
			$data=$this->data;
			if(!empty($data)){
				$comment_reply_id=$data['comment_reply_id'];
				$user_id=$data['user_id'];
				$liker_id=$data['liker_id'];
				if(empty($comment_reply_id))
				{
				$result = array('status'=>0,'message'=>'Missing comment reply ID.');	
				}
				else
				{
				//check if already liked
				$getAlreadyLike=$this->CommentReplyLike->find('first',array('conditions'=>array('CommentReplyLike.comment_reply_id'=>$comment_reply_id,'CommentReplyLike.liker_id'=>$liker_id)));
				
				if(empty($getAlreadyLike))
				{
				//like	
				$commentReplyLikeData=array();
				$commentReplyLikeData['comment_reply_id'] = $comment_reply_id;
				$commentReplyLikeData['user_id'] = $user_id;
				$commentReplyLikeData['liker_id'] = $liker_id;
				$commentReplyLikeData['liked'] = 1;
				$saved=$this->CommentReplyLike->save($commentReplyLikeData);
				if($saved)
				{
				$message="Liked Successfully.";
				$result = array('status'=>1,'message'=>'Success,'.$message);	
				}
				else
				{
				$result = array('status'=>0,'message'=>'Something went wrong,please try again!');	
				}
				}
				else
				{
				//unlike-update the record
				$this->CommentReplyLike->id = $getAlreadyLike['CommentReplyLike']['id'];
				if($getAlreadyLike['CommentReplyLike']['liked']==1)
				{
					$likeStatus=0;
					$message="Un liked Successfully.";
				}
				else{
					$likeStatus=1;
					$message="Liked Successfully.";
				}
			    $updateLikeStatus=$this->CommentReplyLike->saveField("liked",$likeStatus);
				$result = array('status'=>1,'message'=>'Success,'.$message);
				} 
				}
			
			}	
			else
			{
				$result = array('status'=>0,'message'=>'Data is Empty!');
			}
		
		}
		else
		{
			$result = array('status'=>0,'message'=>'Method is mismatch!');
		}
		echo json_encode($result);die;
 }
 
 

/************ distance calculator **************/

public function getDistanceBetweenPoints($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}
	 
/************ end distance calculator **************/
	//distance calculator
	 public function distanceCalculator()
	 {
		 $result=array();
		 if($this->request->is('post')){
			 $lat1=$this->data['lat1'];
			 $long1=$this->data['long1'];
			 $lat2=$this->data['lat2'];
			 $long2=$this->data['long2'];
			 /* These are two points in New York City */
		$point1 = array('lat' => $lat1, 'long' => $long1);
		$point2 = array('lat' => $lat2, 'long' => $long2);

		$distance = $this->getDistanceBetweenPoints($point1['lat'], $point1['long'], $point2['lat'], $point2['long'],"K");
		$result = array('status'=>1,'distance'=>$distance );
		 }
		  else{
			$result = array('status'=>0,'message'=>'Method Mismatch!');
		}
		 echo json_encode($result);die;	
	 }
	 

	
	public function GetDrivingDistance($lat1, $lat2, $long1, $long2)
{

    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true); 
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

    return array('distance' => $dist, 'time' => $time);
}
public function rideTest()
	 {
		 $baseFare = 2.50;
  $costPerMile = 2.00;

		 $result=array();
		 if($this->request->is('post')){
			
				 
			 $lat1=$this->data['lat1'];
			 $long1=$this->data['long1'];
			 $lat2=$this->data['lat2'];
			 $long2=$this->data['long2'];
			 /* These are two points in New York City */
		$point1 = array('lat' => $lat1, 'long' => $long1);
		$point2 = array('lat' => $lat2, 'long' => $long2);

		$distance = $this->GetDrivingDistance($point1['lat'], $point2['lat'],$point1['long'], $point2['long']);
		$distance_km=explode(" ",$distance['distance']);
		 $travel=$distance_km[0];
		 $cost = $baseFare + ($costPerMile * $travel);
		
		 $result = array('status'=>1,'price'=>$cost); 
	 echo json_encode($result);die;  
	 }
	 }
/****************11 .RIDE NOTIFICATION API *************/	 
	 public function rideRequest()
	 {
		if($this->request->is('post')){
			 $data=$this->data;
			//$rideData=array();
			$rideData['user_id']=$data['user_id'];
			$rideData['latitude']=$data['lat'];
			$rideData['longitude']=$data['long'];
			$this->Ride->save($rideData);
			$ride_id=$this->Ride->getLastInsertId();
			
			//$getUsersData=$this->Driver->find('all');
			 $sql='SELECT * , (3956 * 2 * ASIN(SQRT( POWER(SIN(( '.$data['lat'].' - latitude) *  pi()/180 / 2), 2) +COS( '.$data['lat'].' * pi()/180) * COS(latitude * pi()/180) * POWER(SIN(( '.$data['long'].' - longitude) * pi()/180 / 2), 2) ))) as distance  
from drivers  
having  distance <= 10 
order by distance limit 1';
			$nearestlocation=$this->Driver->query($sql);
			
			if($nearestlocation)
			{
				
			define( 'API_ACCESS_KEY', 'AIzaSyAz0Lfze9XrTQ3Tal07avtJ2-xPvOoeOnM');
			
	//$deviceToken = 
      // $registrationIds = $nearestlocation['0']['drivers']['device_token'] ; 
    #prep the bundle
	$deviceToken = 'c98Twa5MRMw:APA91bHICEi_hYBWKs3bqbhtzbny2v7QKdwZq1OoXMDDD250r7OhojdQApZ4HMst2v9QrySQcdlAkC5KTwvkbukmy_coyvzx1lCXAlby2N-ex2J2bezS-y_iQ45XmS4DSOGpCJeQmvi4phmJ8TDYbxk1zDcm5kiPug';
    $registrationIds = $deviceToken ;
     $msg = array(
				'body' 	=> 'Ride request has been received for location LOCATIONNAME',
				'title'	=> 'Ride request received',
				"ride_id" => $ride_id,
				"latitude" => $data['lat'],
				"longitude" => $data['long'],
             	'icon'	=> 'myicon',/*Default Icon*/
              	'sound' => 'mySound',/*Default sound*/
          );
	$fields = array
			(
				'to'		=> $registrationIds,
				'notification'	=> $msg
			);
	
	
	$headers = array
			(
				'Authorization: key=' .API_ACCESS_KEY,
				'Content-Type: application/json'
			);
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		//curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$response = curl_exec($ch );
		if(curl_errno($ch)){
    echo 'Request Error:' . curl_error($ch);die;
}
		curl_close( $ch );
		$responseArray = json_decode($response, true); 
		$notificationStatus=$responseArray['success'];
		if($notificationStatus=='1')
		{
	$result = array('status'=>1,'message'=>'booking request has been received'); 
		}
		else
		{
		$result = array('status'=>0,'message'=>'There is some error, please retry'); 
		}
			
			}
			else{
			$result = array('status'=>0,'message'=>'No driver found in nearest location'); 
			}
			  
		}
		else
		{
			$result = array('status'=>0,'message'=>'Method mismatch');
		}
	
	 echo json_encode($result);die;

	 }
	 
	 /****************12 .SAVE USER TOKEN API *************/
	 public function saveUserToken()
	{
		if($this->request->is('post')){
			 $data=$this->data;
			 if($data['user_type']=='1')
			{
				$this->Driver->id = $data['user_id'];
				$device_token=$data['device_token'];
				$saved=$this->Driver->saveField("device_token",$device_token);
				if($saved)
				{ 
				$result = array('status'=>1,'message'=>'Device token updated for driver'); 
				}
				else{
				$result = array('status'=>0,'message'=>'Device token not updated for driver');  
				}
			}
			 if($data['user_type']=='0')
			{
				$this->User->id = $data['user_id'];
				$device_token=$data['device_token'];
				$saved=$this->User->saveField("device_token",$device_token);
				if($saved)
				{ 
				$result = array('status'=>1,'message'=>'Device token updated for user'); 
				}
				else{
				$result = array('status'=>0,'message'=>'Device token not updated for user');  
				}
			}
			
			
		}
		else{
			$result = array('status'=>0,'message'=>'Method Mismatch!');
		}
		 echo json_encode($result);die;	
		
	}
	 
//================common functions==============================
	public function testnot()
	{
					define( 'API_ACCESS_KEY', 'AIzaSyAz0Lfze9XrTQ3Tal07avtJ2-xPvOoeOnM');
	$deviceToken = 'fIdmyS0dkD4:APA91bGM4iC7phPyTyggwlbcjAGNAPIWiK7bvyET8MBEaH4Mjmhfemh8enQ5X1QkhxUT_Q9hJNjz2o7wZppa8YGz51ISncSdkmMvuP97duBGjJU9v51DtVGSETcIilbvYZNjYr7wJcGUqH0S4rkuDUNZE95aOxi0Gg';
    $registrationIds = $deviceToken ;
    #prep the bundle
     $msg = array(
				'body' 	=> 'Body  Of Notification',
				'title'	=> 'Title Of Notification',
             	'icon'	=> 'myicon',/*Default Icon*/
              	'sound' => 'mySound',/*Default sound*/
          );
	$fields = array
			(
				'to'		=> $deviceToken,
				'notification'	=> $msg
			);
	
	
	$headers = array
			(
				'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
			);
#Send Reponse To FireBase Server	
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
#Echo Result Of FireBase Server
echo $result;
die;
	}
	//verify account from mail
	 public function verifyAccount(){
		 $id=$this->params['pass'][0];
         if($id){
			$getUsersData=$this->User->find('first',array('conditions'=>array('User.id'=>$id),'fields'=>array('User.id')));
			if($getUsersData)
			{	
			$this->User->id = $id;
			$updateStatus=$this->User->saveField("status","1");
			if($updateStatus)
			{
			$result = array('status'=>1,'message'=>'Account Verified successfully.'); 
			}
			 else{
				$result = array('status'=>0,'message'=>'Account Verification still pending.');  
			 }
			}
			else{
			$result = array('status'=>0,'message'=>'No user record found'); 
			}
			
		}
		else{
			$result = array('status'=>0,'message'=>'No user  found'); 
		}
		 
		   echo json_encode($result);die;  
	   }
	//for email verification
	 public function sendVerificationEmail($id,$to)
	 {
	$to = 'developmentweb10@gmail.com';
	$urlForVerification = BASE_URL_API.'verifyAccount/'.$id;
	$subject = "Taxi App-Account Registration";   
	$message  = '<p>Hello, </p>'; 
	$message .= '<p>Thank you for successfully register with Taxi App. </p>';
	$message .= '<p><a href="'.$urlForVerification.'">Click Here</a>  for verify your account and then login to services.</p>';
	$message .= '<br>';
	$message .= '<p>Thanks,</p>';
	$message .= '<p>Team Taxi App</p>';
	

	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	// More headers
	$headers .= 'From: <admin@meetup.com>' . "\r\n"; 
	//$headers .= 'Cc: myboss@example.com' . "\r\n";

	$mail = mail($to,$subject,$message,$headers);
	
	 } 
	 
	 //uplaod image
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
	
	
	public function testVideo()
	{
		 phpinfo();
		 die;
		include('../Lib/stripe/init.php');
		echo include('../Lib/ffmpeg/bin/ffmpeg.exe');
		$ffmpeg = 'C:\ffmpeg\bin\ffmpeg.exe'; //Path where ffmpeg is installed
$video = 'http://totalbhakti.s3.amazonaws.com/home-page-video/Totalbhakti.com%20-%20About%20Us.mp4'; //video path
//$image = md5('Image101').'.jpg'; //thumbnail name
$image = 'Image101.jpg'; //thumbnail name
$interval = 60; //video interval on which thumbnail should generate
$size = "900x900"; //image size
$cmd = "$ffmpeg -ss $interval -i $video -t 1 -s $size $image";   // command responsible for generate  thumbnail   
exec($cmd); //executing the command
	}

	
	//Fetch races 
	public function fetchRaces(){
		$getRacesData =$this->Race->find('all',array('conditions'=>array('Race.race_status'=>'1')));
		$getRacesData = Set::extract('/Race/.', $getRacesData);
		//user profile data
		if($getRacesData)
		{
			$result = array('status'=>1,'message'=>'success','data'=>$getRacesData); 
		}else{
			$result = array('status'=>1,'message'=>'success','data'=>array()); 
		}		
		echo json_encode($result);die;
	}
	
	//Fetch bo 
	public function fetchBodyTypes(){
		$getBodyTypesData =$this->BodyTypes->find('all',array('conditions'=>array('BodyTypes.body_type_status'=>'1')));
		$getBodyTypesData = Set::extract('/BodyTypes/.', $getBodyTypesData);
		//user profile data
		if($getBodyTypesData)
		{
			$result = array('status'=>1,'message'=>'success','data'=>$getBodyTypesData); 
		}else{
			$result = array('status'=>1,'message'=>'success','data'=>array()); 
		}		
		echo json_encode($result);die;
	}
	
	//contact us api
	
	public function contact_us(){
		if($this->request->is('post')){
			$data=$this->data;
			$data1 = array();
			 
			if(!empty($data) && isset($data['userId'])){

				$check_user_data=$this->User->find('first',array('conditions'=>array('User.id'=>$data['userId'])));
				
				if(!empty($check_user_data)){
						
						$data1['user_id'] =$data['userId'];
						$data1['message'] =$data['message'];

						if($this->ContactUsersData->save($data1)){
							$id=$this->ContactUsersData->getLastInsertId();
							//send mail for account verification
							//$this->sendVerificationEmail($id,$data['email']);
							$result=array('status'=>1,'message'=>'Information send to the admin');
						}else{

							$result=array('status'=>0,'message'=>'Something went wrong,try again!');
						}
				}else{

					$result = array('status'=>0,'message'=>'User not found');
				}
			}else{

				$result = array('status'=>0,'message'=>'Data is Empty!');
			}
		}else{
				$result = array('status'=>0,'message'=>'Method Mismatch!');
			}
		echo json_encode($result);die;	
	}
 
}
