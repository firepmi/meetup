<?php 

Class DashboardController extends AppController
{
	var $helpers = array('Form','Html','Js','Paginator','Time','Text','Number','Session');
	var $components = array('Cookie','Session','RequestHandler','Email');
	public $uses = array('User','Driver','Race','BodyTypes','ContactUsersData','Page');
	
	//to check for admin session
	public function checkIsLoggedIn()
	{
	ob_start();
	session_start();
	if(!isset($_SESSION['UserData']))
	{
		$this->redirect(array('controller'=>'Admin','action'=>'login'));
	}
	}
	// unique password generator for driver
   public function passwordGenerator()
  { 
    
	   $random_number= substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 4);
	   //if already exist generate again
	   $random_number='TAXI-'.$random_number;
	   return $random_number;  
  } 
 
  //for driver register email
public function sendDriverAdditionEmail($name,$email,$password)
{
	$urlForVerification = BASE_URL_API.'verifyAccount/'.$id;
	$subject = "Gllyd-Driver Account Registration";   
	$message  = '<p>Hello '.$name.',</p>'; 
	$message .= '<p>Your account has been created has Driver for Gllyd. </p>';
	$message .= '<p>Your login details are as below:</p>';
	$message .= '<p><strong>Email:</strong>'.$email.'</p>';
	$message .= '<p><strong>Password:</strong>'.$password.'</p>';
	$message .= "*Note:You can change your password later on.";
	$message .= '<br>';
	$message .= '<p>Thanks,</p>';
	$message .= '<p>Team Gllyd</p>';
	
	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	// More headers
	$headers .= 'From: <admin@meetup.com>' . "\r\n"; 
	//$headers .= 'Cc: myboss@example.com' . "\r\n";

	$mail = mail($email,$subject,$message,$headers);
	
} 
	
	
	//to load the dashboard
	public function admin_index() {
	$this->checkIsLoggedIn();
	$this->layout="dashboard";
	$data['usersCount']=count($this->User->find('all'));
	$this->set('data',$data );
	}
	
	//for users section
	public function admin_manage_users() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		$getUsersList=$this->User->find('all',array('fields'=>array('User.id','User.username','User.email','User.profilePic','User.status','User.PaymentStatus','User.date_of_birth'),'recursive'=>-1));
		$this->set('data', $getUsersList);
		

	}
	//add driver
	public function admin_add_driver() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		if($this->request->is('post')){ 
		$this->Driver->set($this->request->data);
		if ($this->Driver->validates()) {
		// it validated logic
		$this->request->data['full_name']=$this->request->data['first_name']." ".$this->request->data['last_name'];
		$password=$this->passwordGenerator();
		$this->request->data['password']=md5($password);
		$saved=$this->Driver->save($this->request->data);
		if($saved){
		//send email to driver
		$this->sendDriverAdditionEmail($this->request->data['first_name'],$this->request->data['email'],$password);
		$this->Session->setFlash('Driver added','success');
		$this->redirect(array('controller'=>'Dashboard','action'=>'manage_drivers','admin' => true));
		}
		} 
		else {
		// didn't validate logic
		$errors = $this->Driver->validationErrors;
		$this->set('errors',$errors); 
		return $errors;  
		} 
	  }

	}
	//manage drivers
	public function admin_manage_drivers() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		$getDriverList=$this->Driver->find('all');
		$this->set('data', $getDriverList);

	}

	
	//for add event category
	public function admin_add_category() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		if($this->request->is('post')){ 
		$this->EventCategory->set($this->request->data);
		if ($this->EventCategory->validates()) {
		// it validated logic
		$this->EventCategory->save($this->request->data);
		$this->Session->setFlash('Added','success');
		$this->redirect(array('controller'=>'Dashboard','action'=>'manage_categories','admin' => true));
		} 
		else {
		// didn't validate logic
		$errors = $this->EventCategory->validationErrors;
		 $this->set('errors',$errors); 
		return $errors;  
		} 
	  }
		
	}
	
	public function admin_edit_categories() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		$id= $this->params['pass'][0];
		$getEventCatList=$this->EventCategory->find('first',array('conditions'=>array('EventCategory.id'=>$id),'recursive'=>0));
		$data=$getEventCatList;
		
		if($this->request->is('post')){ 
		$this->EventCategory->set($this->request->data);
		if ($this->EventCategory->validates()) {
		// it validated logic
		$this->EventCategory->id=$id;
		$this->EventCategory->save($this->request->data);
		$this->Session->setFlash('Updated','success');
		$this->redirect(array('controller'=>'Dashboard','action'=>'manage_categories','admin' => true));
		} 
		else {
		// didn't validate logic
		$errors = $this->EventCategory->validationErrors;
		 $this->set('errors',$errors); 
		return $errors;  
		} 
	  }
	   
		$this->set('data', $data);
			 
		
		  
	}
	
	
	//for manage categories 
	public function admin_manage_categories() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		$getEventCatList=$this->EventCategory->find('all');
		$this->set('data', $getEventCatList);
		

	}
	//for manage events 
	public function admin_manage_events() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		$getEventsList=$this->Event->find('all',array('order'=>array('Event.id'=>'desc')));
		$this->set('data', $getEventsList);
		

	}
	//for manage events 
	public function admin_manage_media() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		$getMediaList=$this->Media->find('all',array('order'=>array('Media.id'=>'desc')));
		$this->set('data', $getMediaList);

	}
	//for manage invitations 
	public function admin_manage_invitations() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		$getEventInvitationList=$this->EventInvitation->find('all',array('order'=>array('EventInvitation.id'=>'desc'),'recursive'=>1));
		 /* echo "<pre>";
		 print_r($getEventInvitationList);
		 die("stop"); */
		$this->set('data', $getEventInvitationList);

	}
	//for manage event invitees 
	public function admin_manage_event_invitees() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		$invitation_id= $this->params['pass'][0];
		$getEventInviteesList=$this->EventInvitationContact->find('all',array('order'=>array('EventInvitationContact.id'=>'desc'),'conditions'=>array('EventInvitationContact.event_invitations_id'=>$invitation_id),'recursive'=>-1));
		/*   echo "<pre>";
		 print_r($getEventInviteesList);
		 die("stop");  */
		$this->set('data', $getEventInviteesList);

	}
	
	
	//delete the record
	public function admin_delete_data(){
		
		 if($this->request->is('post')){
			// echo "<pre>";
			 
			  $id=$this->request->data['id'];
			  $modelName=$this->request->data['modelName'];
			  $this->$modelName->id = $id;
			 if($this->$modelName->delete())
			 {
				 echo json_encode(array('status'=>'1','message'=>'Deleted!'));
				  die;
			 }
			  else{
				  echo json_encode(array('status'=>'0','message'=>'Error!'));
				  die;
			  } 
			
		  
		 }
		  
	}
	
	//for manage races 
	public function admin_manage_races() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		$getRaceList =$this->Race->find('all');
		$this->set('data', $getRaceList);
		

	}
	
	//for add races
	public function admin_add_race() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		if($this->request->is('post')){ 
		$this->Race->set($this->request->data);
		if ($this->Race->validates()) {
		// it validated logic
		$this->Race->save($this->request->data);
		$this->Session->setFlash('Added','success');
		$this->redirect(array('controller'=>'Dashboard','action'=>'manage_races','admin' => true));
		} 
		else {
		// didn't validate logic
		$errors = $this->Race->validationErrors;
		 $this->set('errors',$errors); 
		return $errors;  
		} 
	  }
		
	}
	
	//for edit races
	public function admin_edit_race() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		$id= $this->params['pass'][0];
		$getEventCatList=$this->Race->find('first',array('conditions'=>array('Race.id'=>$id),'recursive'=>0));
		$data=$getEventCatList;
		
		if($this->request->is('post')){ 
		
			$this->Race->set($this->request->data);
			if ($this->Race->validates()) {
				// it validated logic
				$this->Race->id=$id;
				$this->Race->save($this->request->data);
				$this->Session->setFlash('Updated','success');
				$this->redirect(array('controller'=>'Dashboard','action'=>'manage_races','admin' => true));
			} 
			else {
				// didn't validate logic
				$errors = $this->Race->validationErrors;
				$this->set('errors',$errors); 
				return $errors;  
			} 
		}
	   
		$this->set('data', $data);
		  
	}
	
	
	//for manage body Types 
	public function admin_manage_body_types() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		$getBodyTypesList =$this->BodyTypes->find('all');
		$this->set('data', $getBodyTypesList);
		

	}
	
	//for add body Types
	public function admin_add_body_type() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		if($this->request->is('post')){ 
		$this->BodyTypes->set($this->request->data);
		if ($this->BodyTypes->validates()) {
		// it validated logic
		$this->BodyTypes->save($this->request->data);
		$this->Session->setFlash('Added','success');
		$this->redirect(array('controller'=>'Dashboard','action'=>'manage_body_types','admin' => true));
		} 
		else {
		// didn't validate logic
		$errors = $this->Race->validationErrors;
		 $this->set('errors',$errors); 
		return $errors;  
		} 
	  }
		
	}
	
	//for edit body Types
	public function admin_edit_body_type() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		$id= $this->params['pass'][0];
		$getEventCatList=$this->BodyTypes->find('first',array('conditions'=>array('BodyTypes.id'=>$id),'recursive'=>0));
		$data=$getEventCatList;
		
		if($this->request->is('post')){ 
		
			$this->BodyTypes->set($this->request->data);
			if ($this->BodyTypes->validates()) {
				// it validated logic
				$this->BodyTypes->id=$id;
				$this->BodyTypes->save($this->request->data);
				$this->Session->setFlash('Updated','success');
				$this->redirect(array('controller'=>'Dashboard','action'=>'manage_body_types','admin' => true));
			} 
			else {
				// didn't validate logic
				$errors = $this->Race->validationErrors;
				$this->set('errors',$errors); 
				return $errors;  
			} 
		}
	   
		$this->set('data', $data);
		  
	}
	
	
	//for manage contact data 
	public function admin_manage_contact_data() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		$getContactDataList =$this->ContactUsersData->find('all');
		$this->set('data', $getContactDataList);
		

	}
	
	//for manage pages 
	public function admin_manage_pages() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		$getBodyTypesList =$this->Page->find('all');
		if($getBodyTypesList){
			$this->set('data', $getBodyTypesList);
		}else{
			$this->set('data', '');
		}
		

	}
	
	//for add body Types
	public function admin_add_page() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		if($this->request->is('post')){ 
			$this->Page->set($this->request->data);
			if ($this->Page->validates()) {
				// it validated logic
				$this->Page->save($this->request->data);
				$this->Session->setFlash('Added','success');
				$this->redirect(array('controller'=>'Dashboard','action'=>'manage_pages','admin' => true));
			} 
			else {
			// didn't validate logic
				$errors = $this->Race->validationErrors;
				$this->set('errors',$errors); 
				return $errors;  
			} 
		}
		
	}
	
	//for edit body Types
	public function admin_edit_page() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		$id= $this->params['pass'][0];
		$getEventCatList=$this->Page->find('first',array('conditions'=>array('Page.id'=>$id),'recursive'=>0));
		$data=$getEventCatList;
		
		if($this->request->is('post')){ 
		
			$this->Page->set($this->request->data);
			if ($this->Page->validates()) {
				// it validated logic
				$this->Page->id=$id;
				$this->Page->save($this->request->data);
				$this->Session->setFlash('Updated','success');
				$this->redirect(array('controller'=>'Dashboard','action'=>'manage_pages','admin' => true));
			} 
			else {
				// didn't validate logic
				$errors = $this->Race->validationErrors;
				$this->set('errors',$errors); 
				return $errors;  
			} 
		}
	   
		$this->set('data', $data);
	}

	//for manage pages 
	public function admin_email_users() {
		$this->layout="dashboard";
		$this->checkIsLoggedIn();
		if($this->request->is('post')){ 
			$this->Page->set($this->request->data);
			$this->sendEmail($this->request->data);
			
			$this->Session->setFlash('Email sent successfully!','success');
			// $this->redirect(array('controller'=>'Dashboard','action'=>'index','admin' => true));			
		}
	}
	public function sendEmail($data) {
		// var_dump($data);
		$subject = "Gllyd-Driver Account Registration";   
		$message  = '<p>Hello </p>'; 
		$message .= '<p>Your account has been created has Driver for Gllyd. </p>';
		$message .= '<p>Your login details are as below:</p>';
		$message .= '<p><strong>Email:</strong>asdfasdfa@sdfasdf.com</p>';
		$message .= '<p><strong>Password:</strong>sdfasdfsdf</p>';
		$message .= "*Note:You can change your password later on.";
		$message .= '<br>';
		$message .= '<p>Thanks,</p>';
		$message .= '<p>Team Gllyd</p>';
		
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: <admin@meetup.com>' . "\r\n"; 
		//$headers .= 'Cc: myboss@example.com' . "\r\n";

		$email = "firepmi320@gmail.com";
		$mail = mail($email,$subject,$message,$headers);
	}
}