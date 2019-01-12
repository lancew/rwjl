<?php
class User extends AppModel {
   var $name = 'User';
   
   
   var $validate = array(
        'username'  => VALID_NOT_EMPTY,
        'fname'  => VALID_NOT_EMPTY,
        'lname'  => VALID_NOT_EMPTY,
        'email_address'  => VALID_EMAIL,
        'password'   => VALID_NOT_EMPTY
        );
   
	
}
?>