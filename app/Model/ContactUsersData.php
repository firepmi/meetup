<?php

class ContactUsersData extends AppModel {
	public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
			'fields'=>array('User.username,User.email'),
        )
		
    );
}