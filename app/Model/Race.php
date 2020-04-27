<?php

class Race extends AppModel {
	var $name = 'Race';
   // var $useTable = false;
	
	var $validate = array(
        'race_name' => array(
            'rule' => 'notBlank',
            'required' => true,
            'message' => 'Please enter race name.',
        )
    );
}