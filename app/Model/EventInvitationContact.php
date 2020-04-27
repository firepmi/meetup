<?php

class EventInvitationContact extends AppModel {
	public $belongsTo = array(
	 
        'EventInvitation' => array(
            'className' => 'EventInvitation',
            'foreignKey' => 'id',
			'counterCache' => true, 
        ),
		
    );

}
