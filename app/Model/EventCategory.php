<?php

class EventCategory extends AppModel {
	
	var $name = 'EventCategory';
   // var $useTable = false;
	
	var $validate = array(
        'name' => array(
            'rule' => 'notBlank',
            'required' => true,
            'message' => 'Please enter category name.',
        ),
        
    );
	
	
	 public $hasMany = array( 
        'Event' => array(
            'className' => 'Event',
            'foreignKey' => 'event_type',
			'counterCache' => true, 
        )
    ); 
	
	
}
