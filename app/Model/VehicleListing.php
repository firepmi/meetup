<?php

class VehicleListing extends AppModel {
    public $belongsTo = array(
        'Driver' => array(
            'className' => 'Driver',
            'foreignKey' => 'driver_id',
			'counterCache' => true, 
        )
    );
	
	
	
	
}
