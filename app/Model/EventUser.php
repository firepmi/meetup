<?php

class EventUser extends AppModel {
    public $belongsTo = array(
        
		'Event' => array(
            'className' => 'Event',
            'foreignKey' => 'id',
			'fields'=>array('EventUser.is_admin'), 
        ),
		 'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
			'fields'=>array('User.first_name,User.last_name,User.full_name,User.profile_image'),  
        ) 
		
    );
	
	
}
