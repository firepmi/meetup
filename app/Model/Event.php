<?php

class Event extends AppModel {
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'created_by',
			'fields'=>array('User.first_name,User.last_name,User.full_name,User.profile_image'),
        ),
		'EventCategory' => array(
            'className' => 'EventCategory',
            'foreignKey' => 'event_type',
			'fields'=>array('EventCategory.name'), 
        ),
		'EventCategory' => array(
            'className' => 'EventCategory',
            'foreignKey' => 'event_type',
			'fields'=>array('EventCategory.name'), 
        ),
		
    );
	
	
	
	 public $hasMany = array( 
        'Media' => array(
            'className' => 'Media',
            'foreignKey' => 'event_id',
			'counterCache' => true, 
			//'fields'=>array('User.first_name,User.last_name,User.full_name,User.profile_image'),  
        )
    ); 
	//public $hasMany = array('Media'=>array('counterCache'=>'true'));
	
}
