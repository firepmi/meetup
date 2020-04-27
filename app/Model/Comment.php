<?php

class Comment extends AppModel {
	public $useTable = 'comment'; 
     public $belongsTo = array(
		 'User' => array(
            'className' => 'User',
            'foreignKey' => 'senderID',
			//'fields'=>array('User.first_name,User.last_name,User.full_name,User.profile_image'),  
        )
    ); 
	public $hasMany = array( 
        'CommentReply' => array(
            'className' => 'CommentReply',
            'foreignKey' => 'comment_id',
			'counterCache' => true, 
        ),
		
    ); 
	
	
}
