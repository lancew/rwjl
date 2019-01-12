<?php
class Fight extends AppModel {
   var $name = 'Fight';

   var $belongsTo = array('Challenger' => array(
											'className' => 'User',
											'foreignKey' => 'challenger_user_id'),
					   'Challenged' => array(
											'className' => 'User',
											'foreignKey' => 'challenged_user_id')						
                       );


   
  }
?>