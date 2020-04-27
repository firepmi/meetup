<?php

class Driver extends AppModel {
	
	var $name = 'Driver';
   // var $useTable = false;
	
	var $validate = array(
        'first_name' => array(
            'rule' => 'notBlank',
            'required' => true,
            'message' => 'Please enter driver first name.',
        ),
		'last_name' => array(
            'rule' => 'notBlank',
            'required' => true,
            'message' => 'Please enter driver last name.',
        ),
		/* 'email' => array(
            'rule' => 'notBlank',
            'required' => true,
            'message' => 'Please enter driver email.',
        ), */
		'email' => array(
			'required' => array(
				'rule' => array('email'),
				'message' => 'Please enter driver email.'
			),
			
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'Provided Email already exists.'
			)
		),
		'phone_number' => array(
            'rule' => 'notBlank',
            'required' => true,
            'message' => 'Please enter phone number.',
        ),
		'dob' => array(
            'rule' => 'notBlank',
            'required' => true,
            'message' => 'Please select the date of birth.',
        ),
		'vehicle_number' => array(
            'rule' => 'notBlank',
            'required' => true,
            'message' => 'Please enter vehicle number.',
        ),
		'license_number' => array(
            'rule' => 'notBlank',
            'required' => true,
            'message' => 'Please enter license number.',
        ),
        
    );
	
	
	 
	
}
