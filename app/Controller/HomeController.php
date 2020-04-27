<?php
Class HomeController extends AppController
{
	var $helpers = array('Form','Html','Js','Paginator','Time','Text','Number','Session');
	var $components = array('Cookie','Session','RequestHandler','Email');
	public $uses = array('User','Driver','Race','BodyTypes','ContactUsersData','Page');
	
	public function termsofservices(){
		$this->layout="pages";
		$getPage=$this->Page->find('first',array('conditions'=>array('Page.id'=>1)));
		$this->set('title', $getPage['Page']['page_title']);
		$this->set('data', $getPage);
	}

	public function privacypolicy(){
		$this->layout="pages";
		$getPage=$this->Page->find('first',array('conditions'=>array('Page.id'=>2)));
		$this->set('title', $getPage['Page']['page_title']);
		$this->set('data', $getPage);
	}
}
?>	