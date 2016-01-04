<?php

class Default_Bootstrap extends Zend_Application_Module_Bootstrap
{
   /**
     * 
     * @access protected
     * @return void
     */
    protected function _initConfig()
    {
	$config = new Zend_Config_Ini( APPLICATION_PATH . '/configs/config.ini' );

	Zend_Registry::set( 'config', $config );
    }
}