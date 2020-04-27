<?php

class MediaLike extends AppModel {
    public $belongsTo = array(
        'Media' => array(
            'className' => 'Media',
            'foreignKey' => 'media_id', 
			'counterCache' => true, 
        )
    );
	
	
}
