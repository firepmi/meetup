<?php

class Media extends AppModel {
    public $belongsTo = array(
        'Event' => array(
            'className' => 'Event',
            'foreignKey' => 'event_id',
			'counterCache' => true, 
        ),
		'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
			'counterCache' => true, 
			'fields'=>array('User.first_name,User.last_name,User.full_name,User.profile_image'),
        )
    );
	
	 public $hasMany = array( 
        'MediaLike' => array(
            'className' => 'MediaLike',
            'foreignKey' => 'media_id',
			'counterCache' => true, 
        )
    ); 
	
	
}
