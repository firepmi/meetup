<?php 
Class AdminController extends AppController
{
	var $helpers = array('Form','Html','Js','Paginator','Time','Text','Number','Session');
	var $components = array('Cookie','Session','RequestHandler','Email');
	public $uses = array('Admin');
	
	public function admin_login(){	
		$this->layout="admin";
		if($this->request->is('post')){
		$data=$this->data;
		if(!empty($data))
		{
			$password=md5($data['login-password']);
			$check_account=$this->Admin->find('first',array('conditions'=>array('Admin.email'=>$data['login-email'],'Admin.password'=>$password)));
			if($check_account)
			{
				 session_start();
				$_SESSION['UserData'] =array('id'=>$check_account['Admin']['id'],'name'=>$check_account['Admin']['name'],'email'=>$check_account['Admin']['email']);
				$this->Session->setFlash('Successful!','success');
				$this->redirect(array('controller'=>'Dashboard','action'=>'index','admin' => true));
			}
			else{
				
				$this->Session->setFlash('The information you entered is wrong!','error');
				$this->redirect(array('controller'=>'Admin','action'=>'login','admin' => true));
			}
		}
		 else{
			
			$this->Session->setFlash('Please fill up the required info.','error');
			$this->redirect(array('controller'=>'Admin','action'=>'login','admin' => true));
		}
		}
	}
	
	public function admin_register(){
		$data=$this->data;
		if(!empty($data))
		{
			 
			$password =md5($data['register-password']);
			$check_email=$this->User->find('first',array('conditions'=>array('User.email'=>$data['register-email'])));
			unset($data['register-password-verify']);
			if(empty($check_email)){
				$new_dta['role'] = 1;
				$new_dta['first_name'] = $data['register-firstname'];
				$new_dta['last_name'] = $data['register-lastname'];
				$new_dta['email'] = $data['register-email'];
				$new_dta['password'] = $password;
				if($this->User->save($new_dta)){
					$this->Session->setFlash('You have successfully saved!','success');
					$this->redirect(array('controller'=>'Admin','action'=>'login','admin' => true));
				}else{
					$this->Session->setFlash('Error to save data!','error');
					$this->redirect(array('controller'=>'Admin','action'=>'login','admin' => true));
				}
			}else{
				$this->Session->setFlash('Email already exists!','error');
				$this->redirect(array('controller'=>'Admin','action'=>'login','admin' => true));
			}
		}else{
			$this->Session->setFlash('Data is empty','error');
			$this->redirect(array('controller'=>'Admin','action'=>'login','admin' => true));
		}
	}
	
	public function admin_logout(){
		$this->render='false';
		
		session_start();
		
		if(isset($_SESSION['UserData']))
		{
			unset($_SESSION['UserData']);
			$this->redirect(array('controller'=>'Admin','action'=>'login','admin' => true));
		}
		else{
			$this->redirect(array('controller'=>'Dashboard','action'=>'dashboard','admin' => true));
		}			
		
	}
}