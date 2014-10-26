<?php

class UserIdentity extends CUserIdentity
{    
    protected $_id;
    
    public function authenticate()
    {
        $user = User::model()->findByAttributes(array('login'=>$this->username));
        if ( $user===null )
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if( !CPasswordHelper::verifyPassword($this->password, $user->password) )
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id = $user->id;
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }
 
    public function getId()
    {
        return $this->_id;
    }
}