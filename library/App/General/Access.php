<?php

abstract class App_General_Access
{
    /**
     *
     * @param string $nivel
     * @param int $id
     * @return boolean 
     */
    public static function isAuth( $nivel = 'U', $id = null )
    {
	$auth = Zend_Auth::getInstance();
	
	if ( !$auth->hasIdentity() )
	    return false;
	
	if ( $auth->getIdentity()->nivel == $nivel && !$id )
	    return $auth->getIdentity()->id;
	
	if ( $auth->getIdentity()->nivel == $nivel && 
	     $auth->getIdentity()->id == $id )
	     return true;
	     
	     
	return false;
	    
    }
}