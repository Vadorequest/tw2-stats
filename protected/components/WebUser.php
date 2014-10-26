<?php

class WebUser extends CWebUser {
    private $_model = null;
 
    function getRole() {
        if( $user = $this->getModel() ){
            return $user->type;
        }
    }
    
    function get_role() {
        if( $user = $this->getModel() ){
            return $user->_type;
        }
    }
 
    private function getModel(){
        if (!$this->isGuest && $this->_model === null){
            $this->_model = User::model()->findByPk($this->id, array('select' => 'type'));
        }
        return $this->_model;
    }
}