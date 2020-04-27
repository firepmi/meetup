<?php

class Page extends AppModel {
	var $name = 'Page';
   // var $useTable = false;
	
	var $validate = array(
        'page_title' => array(
            'rule' => 'notBlank',
            'required' => true,
            'message' => 'Please enter page title.',
        ),
		'page_content' => array(
            'rule' => 'notBlank',
            'required' => true,
            'message' => 'Please enter page content.',
        )
    );
}