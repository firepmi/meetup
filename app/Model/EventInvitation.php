<?php


class EventInvitation extends AppModel {
	
	  public $hasMany = array( 
        'EventInvitationContact' => array(
            'className' => 'EventInvitationContact',
            'foreignKey' => 'event_invitations_id',
			
        )
    );

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
	
	
}
